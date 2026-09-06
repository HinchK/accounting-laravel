<?php

declare(strict_types=1);

namespace Liberu\Accounting\CopilotLivewire\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use Liberu\Accounting\Copilot\Models\CopilotRequest;

final class Requests extends Component
{
    public function render(): View
    {
        return view('accounting-copilot-livewire::requests', ['requests' => CopilotRequest::query()->where('team_id', (int) (auth()->user()?->current_team_id ?? -1))->latest()->get()]);
    }
}
