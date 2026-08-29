<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Liberu\Accounting\YearEnd\Models\YearEndClose;
use Liberu\Foundation\Organizations\Models\Team;

uses(RefreshDatabase::class);

it('scopes year-end closes and supports close operations through the API', function (): void {
    $user = User::factory()->create();
    $team = Team::factory()->create(['user_id' => $user->id]);
    $user->forceFill(['current_team_id' => $team->id])->save();
    Sanctum::actingAs($user, ['accounting.year-end.read', 'accounting.year-end.write', 'accounting.year-end.lock']);

    $this->postJson('/api/v1/accounting/year-end', ['fiscal_year' => 2025, 'period_end' => '2025-12-31', 'retained_earnings_account_ref' => 'retained-earnings'])->assertCreated();
    $close = YearEndClose::query()->firstOrFail();
    $this->getJson('/api/v1/accounting/year-end')->assertOk()->assertJsonCount(1, 'data');
    $this->postJson('/api/v1/accounting/year-end/'.$close->id.'/close', ['closing_entry_ref' => 'closing-entry-1'])->assertOk();
    $this->postJson('/api/v1/accounting/year-end/'.$close->id.'/lock')->assertOk();
});

it('requires year-end abilities', function (): void {
    $user = User::factory()->create();
    $team = Team::factory()->create(['user_id' => $user->id]);
    $user->forceFill(['current_team_id' => $team->id])->save();
    Sanctum::actingAs($user, []);

    $this->getJson('/api/v1/accounting/year-end')->assertForbidden();
    $this->postJson('/api/v1/accounting/year-end', [])->assertForbidden();
});
