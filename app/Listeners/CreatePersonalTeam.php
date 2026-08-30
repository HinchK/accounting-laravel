<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Models\User;
use App\Services\TeamManagementService;
use Illuminate\Auth\Events\Registered;

class CreatePersonalTeam
{
    public function __construct(protected TeamManagementService $teamManagementService) {}

    public function handle(Registered $event): void
    {
        if ($event->user instanceof User) {
            $this->teamManagementService->assignUserToDefaultTeam($event->user);
        }
    }
}
