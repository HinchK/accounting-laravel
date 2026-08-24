<?php
declare(strict_types=1);
namespace Liberu\Accounting\DimensionsLivewire\Livewire;
use Livewire\Component; use Liberu\Accounting\Dimensions\Models\Dimension;
final class Dimensions extends Component { public function render(){return view('accounting-dimensions-and-tracking-livewire::dimensions',['dimensions'=>Dimension::withCount('values')->where('is_active',true)->orderBy('kind')->paginate(25)]);} }
