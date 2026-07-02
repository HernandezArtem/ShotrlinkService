<?php

namespace App\Http\Controllers\Filament;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SyncTimezoneController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $validated = $request->validate([
            'timezone' => ['required', 'timezone:all'],
        ]);

        $user = $request->user();

        if ($user->timezone !== $validated['timezone']) {
            $user->update(['timezone' => $validated['timezone']]);
        }

        return response()->noContent();
    }
}
