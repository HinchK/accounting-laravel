<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\ValidationException;
use Liberu\ExecutiveInsights\Actions\RegisterMetric;
use Liberu\ExecutiveInsights\Events\MetricRegistered;
use Liberu\PlatformOrchestration\Actions\CreateComposition;
use Liberu\PlatformOrchestration\Actions\TransitionComposition;
use Liberu\PlatformOrchestration\Enums\CompositionState;
use Liberu\PlatformOrchestration\Events\CompositionCreated;
use Liberu\PlatformOrchestration\Events\CompositionStateChanged;
use Liberu\PlatformOrchestration\Exceptions\InvalidCompositionTransition;

uses(RefreshDatabase::class);

it('registers a draft composition and emits a domain event', function (): void {
    Event::fake();

    $composition = app(CreateComposition::class)->handle([
        'team_id' => null,
        'key' => 'accounting-erp',
        'display_name' => 'Accounting ERP',
        'application' => 'accounting',
        'manifest' => [
            'applications' => ['accounting'],
            'modules' => ['accounting-core'],
        ],
    ]);

    expect($composition->state)->toBe(CompositionState::Draft)
        ->and($composition->manifest['modules'])->toContain('accounting-core');

    Event::assertDispatched(CompositionCreated::class);
});

it('enforces lifecycle transitions and emits the transition event', function (): void {
    Event::fake();

    $composition = app(CreateComposition::class)->handle([
        'key' => 'platform',
        'display_name' => 'Liberu Platform',
        'application' => 'liberu',
        'manifest' => ['applications' => ['liberu'], 'modules' => []],
    ]);

    $composition = app(TransitionComposition::class)->handle($composition, CompositionState::Installed);

    expect($composition->state)->toBe(CompositionState::Installed);
    Event::assertDispatched(CompositionStateChanged::class);
});

it('rejects invalid manifests and illegal transitions', function (): void {
    expect(fn () => app(CreateComposition::class)->handle([
        'key' => 'invalid',
        'display_name' => 'Invalid',
        'application' => 'liberu',
        'manifest' => ['applications' => [], 'modules' => []],
    ]))->toThrow(ValidationException::class);

    $composition = app(CreateComposition::class)->handle([
        'key' => 'platform',
        'display_name' => 'Liberu Platform',
        'application' => 'liberu',
        'manifest' => ['applications' => ['liberu'], 'modules' => []],
    ]);

    expect(fn () => app(TransitionComposition::class)->handle($composition, CompositionState::Active))
        ->toThrow(InvalidCompositionTransition::class);
});

it('registers versioned executive metrics with governed currency and freshness', function (): void {
    Event::fake();

    $metric = app(RegisterMetric::class)->handle([
        'key' => 'monthly-recurring-revenue',
        'name' => 'Monthly recurring revenue',
        'formula' => 'sum(active_contracts.value)',
        'version' => '1.0.0',
        'currency' => 'USD',
        'timezone' => 'UTC',
        'freshness_seconds' => 3600,
        'dimensions' => ['team', 'month'],
    ]);

    expect($metric->currency)->toBe('USD')
        ->and($metric->dimensions)->toEqual(['team', 'month']);
    Event::assertDispatched(MetricRegistered::class);
});
