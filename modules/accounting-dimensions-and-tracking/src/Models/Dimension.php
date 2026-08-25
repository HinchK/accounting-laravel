<?php
declare(strict_types=1);
namespace Liberu\Accounting\Dimensions\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Relations\HasMany; use Liberu\Accounting\Dimensions\Enums\DimensionKind;
class Dimension extends Model { protected $table='accounting_dimensions'; protected $fillable=['code','name','kind','description','is_required','is_active','metadata']; protected $casts=['kind'=>DimensionKind::class,'is_required'=>'bool','is_active'=>'bool','metadata'=>'array']; public function values():HasMany{return $this->hasMany(DimensionValue::class);} }
