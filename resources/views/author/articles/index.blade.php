@extends('layouts.cms')

@section('title', 'My Articles - University News')
@section('header_tagline', 'AUTHOR DESK - UNIVERSITY NEWS')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    
    <!-- Top Header & New Article CTA -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold font-heading text-[#00081e] tracking-tight">My Articles</h1>
            <p class="text-gray-500 font-sans text-sm mt-1">Manage, draft, and track your submitted campus stories.</p>
        </div>

        <a href="{{ route('author.articles.create') }}" class="px-5 py-2.5 bg-[#8b1528] hover:bg-[#721120] text-white text-xs font-bold uppercase tracking-wider flex items-center gap-2 shadow-sm transition-colors self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Write New Article
        </a>
    </div>

    <!-- Status Tabs Filter Bar -->
    <div class="flex items-center gap-2 border-b border-gray-200 pb-px overflow-x-auto text-xs font-semibold uppercase tracking-wider">
        @php
            $currentStatus = request('status');
        @endphp
        <a href="{{ route('author.articles.index') }}" 
           class="px-4 py-2.5 border-b-2 transition-colors {{ empty($currentStatus) ? 'border-[#8b1528] text-[#8b1528] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900' }}">
            All Stories
        </a>
        <a href="{{ route('author.articles.index', ['status' => 'pending_review']) }}" 
           class="px-4 py-2.5 border-b-2 transition-colors {{ $currentStatus === 'pending_review' ? 'border-[#8b1528] text-[#8b1528] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900' }}">
            Under Review
        </a>
        <a href="{{ route('author.articles.index', ['status' => 'published']) }}" 
           class="px-4 py-2.5 border-b-2 transition-colors {{ $currentStatus === 'published' ? 'border-[#8b1528] text-[#8b1528] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900' }}">
            Published
        </a>
        <a href="{{ route('author.articles.index', ['status' => 'draft']) }}" 
           class="px-4 py-2.5 border-b-2 transition-colors {{ $currentStatus === 'draft' ? 'border-[#8b1528] text-[#8b1528] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900' }}">
            Drafts
        </a>
        <a href="{{ route('author.articles.index', ['status' => 'rejected']) }}" 
           class="px-4 py-2.5 border-b-2 transition-colors {{ $currentStatus === 'rejected' ? 'border-[#8b1528] text-[#8b1528] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900' }}">
            Requires Revision
        </a>
    </div>

    <!-- Search Controls -->
    <div class="bg-white border border-gray-200 p-4 shadow-sm">
        <form method="GET" action="{{ route('author.articles.index') }}" class="flex items-center gap-3">
            @if($currentStatus)
                <input type="hidden" name="status" value="{{ $currentStatus }}">
            @endif

            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   placeholder="Search within my articles..." 
                   class="flex-1 bg-[#f8f9fa] border border-gray-300 px-3.5 py-2 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0">

            <button type="submit" class="px-5 py-2 bg-gray-800 hover:bg-black text-white text-xs font-bold uppercase tracking-wider transition-colors">
                Search
            </button>
            @if(request('search') || request('status'))
                <a href="{{ route('author.articles.index') }}" class="px-3 py-2 border border-gray-300 text-gray-500 hover:text-red-700 text-xs" title="Reset Search">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Articles Table Card -->
    <div class="bg-white border border-gray-200 shadow-sm overflow-hidden relative">
        @php
            $hasAnyBoosted = false;
        @endphp
        
        <div class="overflow-x-auto relative z-10">
            <table class="w-full text-left text-xs font-sans">
                <thead class="bg-[#f8f9fa] text-gray-500 uppercase tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3.5 font-bold">Story Title</th>
                        <th class="px-6 py-3.5 font-bold">Category</th>
                        <th class="px-6 py-3.5 font-bold">Status</th>
                        <th class="px-6 py-3.5 font-bold">Views</th>
                        <th class="px-6 py-3.5 font-bold">Created</th>
                        <th class="px-6 py-3.5 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($articles as $article)
                        @php
                            $isBoosted = $article->isBoosted();
                            if ($isBoosted) $hasAnyBoosted = true;
                        @endphp
                    <tr class="transition-colors {{ $isBoosted ? 'bg-transparent' : 'bg-white hover:bg-gray-50/80' }}">
                        <!-- Title & Excerpt -->
                        <td class="px-6 py-4 max-w-sm">
                            <div class="font-bold text-gray-900 text-sm line-clamp-1">
                                {{ $article->title }}
                            </div>
                            @if($article->isRejected() && $article->admin_notes)
                                <div class="text-[11px] text-red-600 mt-1 font-medium bg-red-50 p-2 border border-red-200">
                                    <strong>Revision Feedback:</strong> {{ $article->admin_notes }}
                                </div>
                            @else
                                <div class="text-[11px] text-gray-400 mt-0.5 line-clamp-1 font-serif-content">
                                    {{ $article->excerpt ?? 'No excerpt' }}
                                </div>
                            @endif
                        </td>

                        <!-- Category -->
                        <td class="px-6 py-4 text-gray-600">
                            <span class="px-2 py-0.5 bg-gray-100 border border-gray-200 text-gray-700 text-[11px] whitespace-nowrap">
                                {{ $article->category->name ?? '-' }}
                            </span>
                        </td>

                        <!-- Status Badge -->
                        <td class="px-6 py-4">
                            @if($article->status === 'published')
                                <span class="px-2.5 py-0.5 bg-green-100 text-green-800 font-semibold border border-green-200 text-[11px]">Published</span>
                            @elseif($article->status === 'pending_review')
                                <span class="px-2.5 py-0.5 bg-yellow-100 text-yellow-800 font-semibold border border-yellow-300 text-[11px]">Under Review</span>
                            @elseif($article->status === 'rejected')
                                <span class="px-2.5 py-0.5 bg-red-100 text-red-800 font-semibold border border-red-200 text-[11px]">Needs Revision</span>
                            @else
                                <span class="px-2.5 py-0.5 bg-gray-100 text-gray-700 font-semibold border border-gray-200 text-[11px]">Draft</span>
                            @endif
                        </td>

                        <!-- Views -->
                        <td class="px-6 py-4 text-gray-500 font-medium">
                            {{ number_format($article->views_count) }}
                        </td>

                        <!-- Date -->
                        <td class="px-6 py-4 text-gray-500">
                            {{ $article->created_at->format('M j, Y') }}
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right space-x-2">
                            @if($article->isDraft() || $article->isRejected())
                                <a href="{{ route('author.articles.edit', $article) }}" 
                                   class="text-blue-600 hover:text-blue-800 transition-colors inline-block" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>

                                <form action="{{ route('author.articles.destroy', $article) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Delete this draft?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            @elseif($article->isPublished())
                                @if($isBoosted)
                                    <span class="text-amber-600 font-bold mr-2 text-[11px] uppercase tracking-wider bg-amber-100 px-2 py-1 rounded">
                                        ⚡ Boosted
                                    </span>
                                @else
                                    <a href="{{ route('author.articles.boost', $article) }}" class="text-gray-600 hover:text-yellow-600 font-semibold mr-2 transition-colors">
                                        ⚡ Boost
                                    </a>
                                @endif

                                <a href="{{ route('article', $article->slug) }}" target="_blank" class="text-[#8b1528] font-semibold hover:underline border-l border-gray-300 pl-2">
                                    View Live
                                </a>
                            @else
                                <span class="text-gray-400 italic">Under Review</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">No articles found in this view.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($articles->hasPages())
        <div class="p-4 border-t border-gray-200 bg-[#f8f9fa] relative z-10">
            {{ $articles->links() }}
        </div>
        @endif
        
        @if($hasAnyBoosted)
            <!-- WebGL Gold Shader Script for Boosted Rows -->
            <div class="absolute inset-0 z-0 pointer-events-none opacity-40">
                <canvas id="shader-canvas-ANIMATION_21" style="display:block;width:100%;height:100%"></canvas>
            </div>
            <script>
            (function() {
              const canvas = document.getElementById('shader-canvas-ANIMATION_21');
              if (!canvas) return;

              function syncSize() {
                const rect = canvas.getBoundingClientRect();
                const w = Math.floor(rect.width || canvas.clientWidth || canvas.parentElement?.clientWidth || 800);
                const h = Math.floor(rect.height || canvas.clientHeight || canvas.parentElement?.clientHeight || 250);
                if (canvas.width !== w || canvas.height !== h) {
                  canvas.width  = w;
                  canvas.height = h;
                }
              }
              if (typeof ResizeObserver !== 'undefined') {
                new ResizeObserver(syncSize).observe(canvas);
              }
              syncSize();

              const gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
              if (!gl) return;
              const vs = `attribute vec2 a_position;
            varying vec2 v_texCoord;
            void main() {
              v_texCoord = a_position * 0.5 + 0.5;
              gl_Position = vec4(a_position, 0.0, 1.0);
            }`;
              const fs = `precision highp float;
            varying vec2 v_texCoord;
            uniform float u_time;
            uniform vec2 u_resolution;

            void main() {
                vec2 uv = v_texCoord;
                float slowTime = u_time * 0.35;
                float wave = sin(uv.x * 10.0 + slowTime * 2.0) * 0.05;
                vec3 baseGold = vec3(1.0, 0.84, 0.0);
                vec3 deepGold = vec3(0.85, 0.65, 0.13);
                vec3 highlight = vec3(1.0, 0.95, 0.8);
                float glow = smoothstep(0.4, 0.6, sin(uv.x * 3.0 + slowTime + wave) * 0.5 + 0.5);
                vec3 color = mix(deepGold, baseGold, uv.x + wave);
                color = mix(color, highlight, glow * 0.4);
                float sweep = smoothstep(0.0, 0.1, abs(sin(uv.x * 2.0 - slowTime * 3.0) - 0.5) - 0.45);
                color += highlight * sweep * 0.3;
                gl_FragColor = vec4(color, 1.0);
            }`;
              function cs(type, src) {
                const s = gl.createShader(type);
                gl.shaderSource(s, src);
                gl.compileShader(s);
                return s;
              }
              const prog = gl.createProgram();
              gl.attachShader(prog, cs(gl.VERTEX_SHADER, vs));
              gl.attachShader(prog, cs(gl.FRAGMENT_SHADER, fs));
              gl.linkProgram(prog);
              gl.useProgram(prog);
              const buf = gl.createBuffer();
              gl.bindBuffer(gl.ARRAY_BUFFER, buf);
              gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1,-1, 1,-1, -1,1, 1,1]), gl.STATIC_DRAW);
              const pos = gl.getAttribLocation(prog, 'a_position');
              gl.enableVertexAttribArray(pos);
              gl.vertexAttribPointer(pos, 2, gl.FLOAT, false, 0, 0);
              const uTime = gl.getUniformLocation(prog, 'u_time');
              const uRes = gl.getUniformLocation(prog, 'u_resolution');

              function render(t) {
                if (typeof ResizeObserver === 'undefined') syncSize();
                gl.viewport(0, 0, canvas.width, canvas.height);
                if (uTime) gl.uniform1f(uTime, t * 0.001);
                if (uRes) gl.uniform2f(uRes, canvas.width, canvas.height);
                gl.drawArrays(gl.TRIANGLE_STRIP, 0, 4);
                requestAnimationFrame(render);
              }
              render(0);
            })();
            </script>
        @endif
    </div>

</div>
@endsection
