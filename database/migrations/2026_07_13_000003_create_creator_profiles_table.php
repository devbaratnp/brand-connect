<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creator_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('niche')->nullable();
            $table->string('location')->nullable();
            $table->string('social_media_platform')->nullable();
            $table->string('social_media_link')->nullable();
            $table->integer('follower_count')->default(0);
            $table->decimal('engagement_rate', 5, 2)->nullable();
            $table->text('portfolio')->nullable();
            $table->decimal('price_per_post', 10, 2)->nullable();
            $table->text('audience_details')->nullable();
            $table->string('availability')->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creator_profiles');
    }
};
