<?php

namespace App\Services;

use App\Models\Link;
use Illuminate\Support\Str;

class ShortCodeGenerator
{
    private const CODE_LENGTH = 6;

    public function generate(): string
    {
        do {
            $code = Str::lower(Str::random(self::CODE_LENGTH));
        } while (Link::where('code', $code)->exists());

        return $code;
    }
}
