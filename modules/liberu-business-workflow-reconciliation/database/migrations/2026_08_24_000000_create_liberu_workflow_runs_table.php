<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('liberu_workflow_runs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('team_id')->nullable()->constrained()->nullOnDelete();
            $table->uuid('correlation_id')->unique();
            $table->string('workflow_key');
            $table->string('contract_version');
            $table->string('state')->index();
            $table->json('steps');
            $table->text('last_error')->nullable();
            $table->timestamps();
            $table->index(['team_id', 'state']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('liberu_workflow_runs');
    }
};
