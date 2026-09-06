<?php
declare(strict_types=1);
namespace Liberu\Accounting\ReviewLivewire\Livewire;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Liberu\Accounting\Review\Queries\ReviewItemQuery;
final class ReviewItems extends Component { use WithPagination; #[Url] public string $status=''; public function render(): mixed { return view('accounting-review::review-items',['items'=>app(ReviewItemQuery::class)->paginate((int)(auth()->user()?->current_team_id ?? -1),$this->status ?: null)]); } }
