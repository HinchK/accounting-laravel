<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('liberu_platform_compositions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('team_id')->nullable()->constrained()->nullOnDelete();
            $table->string('key');
            $table->string('display_name');
            $table->string('application');
            $table->string('state')->index();
            $table->json('manifest');
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->unique(['team_id', 'key']);
            $table->index(['team_id', 'state']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('liberu_platform_compositions');
    }
};
