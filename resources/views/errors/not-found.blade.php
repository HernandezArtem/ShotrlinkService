@extends('layouts.public')

@section('title', 'Страница не найдена — ' . config('app.name'))

@section('content')
<main class="center-page">
    <div class="container">
        <div class="card center-card">
            <div class="code-badge">404</div>
            <h1>Страница не найдена</h1>
            <p>
                @if ($isShortLink ?? false)
                    Короткая ссылка <code>/{{ $path }}</code> не существует или была удалена.
                @else
                    Адрес <code>/{{ $path }}</code> не найден на этом сервере.
                @endif
            </p>
            <a href="{{ url('/') }}" class="btn btn-primary" style="width: auto; margin-top: 0;">На главную</a>
        </div>
    </div>
</main>
@endsection
