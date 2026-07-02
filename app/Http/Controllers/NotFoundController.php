<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class NotFoundController extends Controller
{
    public function __invoke(?string $path = null, bool $isShortLink = false): Response
    {
        $path = $path ?? trim(request()->path(), '/');

        return response()->view('errors.not-found', [
            'path' => $path !== '' ? $path : 'unknown',
            'isShortLink' => $isShortLink,
        ], 404);
    }
}
