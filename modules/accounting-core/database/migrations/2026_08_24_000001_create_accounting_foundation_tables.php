<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('accounting_books', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('legal_entity_id')->constrained('accounting_legal_entities')->cascadeOnDelete();
            $table->string('name');
            $table->string('code', 32);
            $table->string('accounting_basis')->default('accrual');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['legal_entity_id', 'code']);
        });

        Schema::create('accounting_fiscal_calendars', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('book_id')->constrained('accounting_books')->cascadeOnDelete();
            $table->date('starts_on');
            $table->date('ends_on');
            $table->boolean('is_closed')->default(false);
            $table->timestamps();
            $table->unique(['book_id', 'starts_on', 'ends_on']);
        });

        Schema::create('accounting_numbering_sequences', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('book_id')->constrained('accounting_books')->cascadeOnDelete();
            $table->string('key', 64);
            $table->string('prefix', 16)->nullable();
            $table->unsignedBigInteger('next_number')->default(1);
            $table->unsignedTinyInteger('padding')->default(4);
            $table->timestamps();
            $table->unique(['book_id', 'key']);
        });

        foreach (['accounting_policies', 'accounting_defaults'] as $tableName) {
            Schema::create($tableName, function (Blueprint $table): void {
                $table->id();
                $table->foreignId('book_id')->constrained('accounting_books')->cascadeOnDelete();
                $table->string('key', 64);
                $table->json('value');
                $table->timestamps();
                $table->unique(['book_id', 'key']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('accounting_defaults');
        Schema::dropIfExists('accounting_policies');
        Schema::dropIfExists('accounting_numbering_sequences');
        Schema::dropIfExists('accounting_fiscal_calendars');
        Schema::dropIfExists('accounting_books');
    }
};
