<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Models\Link;
use App\Services\ShortCodeGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home');
    }

    public function store(StoreLinkRequest $request, ShortCodeGenerator $generator): RedirectResponse
    {
        $validated = $request->validated();

        $link = Link::create([
            'user_id' => auth()->id(),
            'code' => $generator->generate(),
            'original_url' => $validated['original_url'],
        ]);

        return redirect()
            ->route('home')
            ->with('success', 'Короткая ссылка создана!')
            ->with('short_url', $link->short_url)
            ->with('original_url', $link->original_url);
    }
}
