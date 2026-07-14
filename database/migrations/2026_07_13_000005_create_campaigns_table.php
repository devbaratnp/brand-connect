<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('budget', 12, 2)->nullable();
            $table->date('deadline')->nullable();
            $table->text('requirements')->nullable();
            $table->string('status')->default('open');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
