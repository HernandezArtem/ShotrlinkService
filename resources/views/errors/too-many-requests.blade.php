@extends('layouts.public')

@section('title', 'Слишком много запросов — ' . config('app.name'))

@section('content')
<main class="center-page">
    <div class="container">
        <div class="card center-card">
            <div class="code-badge" style="font-size: 2.5rem; color: var(--warm);">429</div>
            <h1>Слишком много запросов</h1>
            <p>Подождите минуту и попробуйте снова. Лимит защищает сервис от перегрузки.</p>
            <a href="{{ url('/') }}" class="btn btn-primary" style="width: auto; margin-top: 0;">На главную</a>
        </div>
    </div>
</main>
@endsection
