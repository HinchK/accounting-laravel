<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounting_legal_entities', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('registration_number')->nullable();
            $table->char('currency_code', 3);
            $table->string('accounting_basis')->default('accrual');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['registration_number']);
            $table->index(['currency_code', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounting_legal_entities');
    }
};
