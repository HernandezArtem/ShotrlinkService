<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation(): void
    {
        $url = trim((string) $this->input('original_url'));

        if ($url !== '' && ! preg_match('/^https?:\/\//i', $url)) {
            $url = 'https://'.$url;
        }

        $this->merge([
            'original_url' => $url,
        ]);
    }

    public function rules(): array
    {
        return [
            'original_url' => [
                'required',
                'string',
                'max:2048',
                'url',
                'regex:/^https?:\/\/.+/i',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    $host = parse_url((string) $value, PHP_URL_HOST);

                    if (! $host) {
                        $fail('Введите корректный URL, например: https://example.com/page');

                        return;
                    }

                    $isLocal = in_array($host, ['localhost', '127.0.0.1', '::1'], true);
                    $hasDomain = str_contains($host, '.');

                    if (! $isLocal && ! $hasDomain) {
                        $fail('Введите корректный URL, например: https://example.com/page');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'original_url.required' => 'Укажите URL, который нужно сократить.',
            'original_url.url' => 'Введите корректный URL, например: https://example.com/page',
            'original_url.regex' => 'URL должен начинаться с http:// или https://',
            'original_url.max' => 'URL слишком длинный (максимум :max символов).',
        ];
    }

    public function attributes(): array
    {
        return [
            'original_url' => 'URL',
        ];
    }
}
