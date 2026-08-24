<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            if (! Schema::hasColumn('users', 'locale')) {
                $table->string('locale', 5)->default('en')->after('email');
            }
            if (! Schema::hasColumn('users', 'theme_preference')) {
                $table->string('theme_preference')->nullable()->default('default')->after('email');
            }
            if (! Schema::hasColumn('users', 'timezone')) {
                $table->string('timezone', 64)->nullable();
            }
            if (! Schema::hasColumn('users', 'two_factor_secret')) {
                $table->text('two_factor_secret')->nullable();
            }
            if (! Schema::hasColumn('users', 'two_factor_recovery_codes')) {
                $table->text('two_factor_recovery_codes')->nullable();
            }
            if (! Schema::hasColumn('users', 'two_factor_confirmed_at')) {
                $table->timestamp('two_factor_confirmed_at')->nullable();
            }
        });

        foreach (['model_has_roles', 'model_has_permissions'] as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'team_id')) {
                Schema::table($tableName, function (Blueprint $table): void {
                    $table->unsignedBigInteger('team_id')->nullable()->change();
                });
            }
        }
    }

    public function down(): void
    {
        // Identity columns are intentionally retained for safe rollback across
        // installations where the foundation migrations own their lifecycle.
    }
};
