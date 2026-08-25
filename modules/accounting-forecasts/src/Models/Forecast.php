<?php

declare(strict_types=1);

namespace Liberu\Accounting\Forecasts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Liberu\Accounting\Forecasts\Enums\{ForecastMethod, ForecastStatus};

/**
 * @property ForecastStatus $status
 * @property ForecastMethod $method
 * @property string $currency
 */
final class Forecast extends Model
{
    protected $table = 'accounting_forecasts';
    protected $fillable = ['team_id', 'forecast_ref', 'name', 'currency', 'method', 'status', 'base_period', 'horizon_periods', 'scenario_ref', 'metadata'];
    protected $casts = ['method' => ForecastMethod::class, 'status' => ForecastStatus::class, 'horizon_periods' => 'integer', 'metadata' => 'array'];
    /** @return HasMany<ForecastLine, $this> */ public function lines(): HasMany { return $this->hasMany(ForecastLine::class, 'forecast_id'); }
    public function assumptions(): HasMany { return $this->hasMany(ForecastAssumption::class, 'forecast_id'); }
    public function approvals(): HasMany { return $this->hasMany(ForecastApproval::class, 'forecast_id'); }
    public function periods(): HasMany { return $this->hasMany(ForecastPeriod::class, 'forecast_id'); }
    public function actuals(): HasMany { return $this->hasMany(ForecastActual::class, 'forecast_id'); }
}
