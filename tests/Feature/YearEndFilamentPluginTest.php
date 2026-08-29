<?php

use Liberu\Accounting\YearEndFilament\YearEndFilamentPlugin;

it('exposes the year-end Filament plugin', function (): void {
    expect(YearEndFilamentPlugin::make()->getId())->toBe('module-accounting-year-end-filament');
});
