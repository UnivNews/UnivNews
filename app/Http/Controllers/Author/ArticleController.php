<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Mail\AdminNewArticleSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $query = Article::where('user_id', auth()->id())->with('category')->latest();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $articles = $query->paginate(15)->withQueryString();

        return view('author.articles.index', compact('articles'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('author.articles.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,pending_review',
            'featured_image' => 'nullable|image|max:4096',
            'tags' => 'nullable|array',
        ]);

        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $count = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        $article = new Article();
        $article->title = $validated['title'];
        $article->slug = $slug;
        $article->excerpt = $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160);
        $article->content = $validated['content'];
        $article->category_id = $validated['category_id'];
        $article->user_id = auth()->id();
        $article->status = $validated['status'];

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('articles', 'public');
            $article->featured_image_path = 'storage/' . $path;
        }

        $article->save();

        if (!empty($validated['tags'])) {
            $tagIds = [];
            foreach ($validated['tags'] as $tagName) {
                $trimmed = trim(str_replace('#', '', $tagName));
                if ($trimmed) {
                    $tag = Tag::firstOrCreate(['name' => $trimmed]);
                    $tagIds[] = $tag->id;
                }
            }
            $article->tags()->sync($tagIds);
        }

        if ($validated['status'] === Article::STATUS_PENDING_REVIEW) {
            try {
                $adminEmails = User::where('role', User::ROLE_ADMIN)->pluck('email')->toArray();
                $fallbackAdminEmail = env('ADMIN_EMAIL');

                if ($fallbackAdminEmail && !in_array($fallbackAdminEmail, $adminEmails)) {
                    $adminEmails[] = $fallbackAdminEmail;
                }

                foreach ($adminEmails as $email) {
                    Mail::to($email)->send(new AdminNewArticleSubmission($article->fresh()));
                }
            } catch (\Exception $e) {
                // Log but don't block
            }
        }

        $message = $validated['status'] === Article::STATUS_PENDING_REVIEW
            ? 'Article submitted for editorial review.'
            : 'Draft saved successfully.';

        return redirect()->route('author.articles.index')->with('success', $message);
    }

    public function edit(Article $article): View
    {
        if ($article->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this article.');
        }

        if ($article->isPendingReview() || $article->isPublished()) {
            abort(403, 'Articles currently under review or published cannot be edited directly.');
        }

        $categories = Category::orderBy('name')->get();
        return view('author.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        if ($article->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this article.');
        }

        if ($article->isPendingReview() || $article->isPublished()) {
            abort(403, 'Articles currently under review or published cannot be edited directly.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,pending_review',
            'featured_image' => 'nullable|image|max:4096',
            'tags' => 'nullable|array',
        ]);

        if ($validated['title'] !== $article->title) {
            $slug = Str::slug($validated['title']);
            $originalSlug = $slug;
            $count = 1;
            while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
                $slug = "{$originalSlug}-{$count}";
                $count++;
            }
            $article->slug = $slug;
        }

        $oldStatus = $article->status;

        $article->title = $validated['title'];
        $article->excerpt = $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160);
        $article->content = $validated['content'];
        $article->category_id = $validated['category_id'];
        $article->status = $validated['status'];

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('articles', 'public');
            $article->featured_image_path = 'storage/' . $path;
        }

        $article->save();

        if (isset($validated['tags'])) {
            $tagIds = [];
            foreach ($validated['tags'] as $tagName) {
                $trimmed = trim(str_replace('#', '', $tagName));
                if ($trimmed) {
                    $tag = Tag::firstOrCreate(['name' => $trimmed]);
                    $tagIds[] = $tag->id;
                }
            }
            $article->tags()->sync($tagIds);
        }

        if ($oldStatus === Article::STATUS_DRAFT && $validated['status'] === Article::STATUS_PENDING_REVIEW) {
            try {
                $adminEmails = User::where('role', User::ROLE_ADMIN)->pluck('email')->toArray();
                $fallbackAdminEmail = env('ADMIN_EMAIL');

                if ($fallbackAdminEmail && !in_array($fallbackAdminEmail, $adminEmails)) {
                    $adminEmails[] = $fallbackAdminEmail;
                }

                foreach ($adminEmails as $email) {
                    Mail::to($email)->send(new AdminNewArticleSubmission($article->fresh()));
                }
            } catch (\Exception $e) {
                // Log but don't block
            }
        }

        $message = $validated['status'] === Article::STATUS_PENDING_REVIEW
            ? 'Article updated and submitted for editorial review.'
            : 'Draft changes saved.';

        return redirect()->route('author.articles.index')->with('success', $message);
    }

    public function destroy(Article $article): RedirectResponse
    {
        if ($article->user_id !== auth()->id()) {
            abort(403, 'Unauthorized.');
        }

        if ($article->isPublished()) {
            abort(403, 'Published articles cannot be deleted directly by authors.');
        }

        $article->delete();

        return redirect()->route('author.articles.index')->with('success', 'Article deleted.');
    }
}
