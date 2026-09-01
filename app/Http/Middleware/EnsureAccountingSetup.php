<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Sends a newly registered team to the first-use wizard before showing the
 * accounting workspace. The wizard itself is excluded to avoid a redirect
 * loop, and existing teams are never interrupted.
 */
final class EnsureAccountingSetup
{
    public function handle(Request $request, Closure $next): Response
    {
        $team = $request->user()?->currentTeam;

        if ($team !== null
            && $team->accounting_setup_completed_at === null
            && ! $request->routeIs('filament.app.pages.account-setup')) {
            return redirect('/app/account-setup');
        }

        return $next($request);
    }
}
