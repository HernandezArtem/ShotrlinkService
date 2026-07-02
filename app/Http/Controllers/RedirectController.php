<?php

namespace App\Http\Controllers;

use App\Models\Click;
use App\Models\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class RedirectController extends Controller
{
    public function __invoke(string $code): RedirectResponse|Response
    {
        $link = Link::where('code', $code)->first();

        if (! $link) {
            return app(NotFoundController::class)($code, true);
        }

        Click::create([
            'link_id' => $link->id,
            'ip_address' => request()->ip(),
            'clicked_at' => now(),
        ]);

        return redirect()->away($link->original_url);
    }
}
