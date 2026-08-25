<?php
declare(strict_types=1);
namespace Liberu\Accounting\DimensionsApi\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
final class DimensionResource extends JsonResource { public function toArray($request):array{return ['id'=>(string)$this->id,'type'=>'accounting-dimension','attributes'=>['code'=>$this->code,'name'=>$this->name,'kind'=>$this->kind->value,'description'=>$this->description,'is_required'=>$this->is_required,'is_active'=>$this->is_active,'values'=>$this->whenLoaded('values',fn()=> $this->values->map(fn($v)=>['id'=>(string)$v->id,'code'=>$v->code,'name'=>$v->name,'is_active'=>$v->is_active])->values())]];} }
