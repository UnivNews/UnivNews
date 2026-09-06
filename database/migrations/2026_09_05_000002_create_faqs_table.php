<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable();
            $table->string('question');
            $table->text('answer');
            $table->integer('order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        // Seed default FAQs
        DB::table('faqs')->insert([
            [
                'category' => 'General',
                'question' => 'What is University News Portal?',
                'answer' => 'University News Portal is a central digital publication delivering academic achievements, research updates, campus events, and scholarly insights from verified authors and partner universities.',
                'order' => 1,
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'Authors',
                'question' => 'How can I apply to become an author?',
                'answer' => 'You can register an account, navigate to the header or profile menu, and click "Apply as Author". Fill out the required institution credentials and submit for admin approval.',
                'order' => 2,
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'Payments',
                'question' => 'How does article publishing fee work?',
                'answer' => 'Once your submitted article passes editorial review by our admin team, an invoice link is generated for the publishing fee. Upon successful payment verification, your article is published automatically.',
                'order' => 3,
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
