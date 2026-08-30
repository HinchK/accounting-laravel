<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('liberu_metric_definitions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('team_id')->nullable()->constrained()->nullOnDelete();
            $table->string('key');
            $table->string('name');
            $table->text('formula');
            $table->string('version');
            $table->json('dimensions');
            $table->char('currency', 3);
            $table->string('timezone', 64);
            $table->unsignedInteger('freshness_seconds');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['team_id', 'key', 'version']);
            $table->index(['team_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('liberu_metric_definitions');
    }
};
