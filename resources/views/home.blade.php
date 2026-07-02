@extends('layouts.public')

@section('title', config('app.name'))

@section('content')
<main class="main">
    <div class="container hero-grid">
        <div class="hero-side">
            <h1>Сокращайте ссылки <em>мгновенно</em></h1>
            <p>Длинный URL превращается в короткий код за секунду. Отслеживайте каждый переход в личном кабинете.</p>
            <div class="features">
                <div class="feature">
                    <div class="feature-icon">🔗</div>
                    Короткие ссылки из 6 символов
                </div>
                <div class="feature">
                    <div class="feature-icon">📊</div>
                    Статистика кликов с IP и временем
                </div>
                <div class="feature">
                    <div class="feature-icon">🔒</div>
                    Личный кабинет для ваших ссылок
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-brand">
                <x-shortlink-logo theme="dark" size="sm" />
            </div>
            <div class="card-title">Новая короткая ссылка</div>
            <div class="card-sub">Вставьте полный URL с http:// или https://</div>

            @auth
                @if ($errors->any())
                    <div class="alert alert-error" role="alert">
                        <strong>Не удалось создать ссылку</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('links.store') }}">
                    @csrf
                    <label for="original_url">Оригинальный URL</label>
                    <input
                        type="url"
                        id="original_url"
                        name="original_url"
                        placeholder="https://example.com/very/long/url"
                        value="{{ old('original_url') }}"
                        @class(['input-error' => $errors->has('original_url')])
                        required
                    >
                    @error('original_url')
                        <p class="error">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="btn btn-primary">Сократить →</button>
                </form>

                @if (session('success') && session('short_url'))
                    <div class="result">
                        <div class="result-label">{{ session('success') }}</div>
                        <div class="short-url">
                            <a href="{{ session('short_url') }}" target="_blank" id="short-url">{{ session('short_url') }}</a>
                            <button type="button" class="btn btn-sm" onclick="copyUrl()">Копировать</button>
                        </div>
                    </div>
                @endif
            @else
                <div class="alert alert-info">
                    <span class="shortlink-auth-subheading__muted">Войдите или</span>
                    <a href="{{ url('/admin/register') }}" class="shortlink-inline-link">зарегистрируйтесь</a>,
                    чтобы создавать ссылки и смотреть статистику.
                </div>
                <div class="auth-actions">
                    <a href="{{ url('/admin/login') }}" class="btn btn-ghost">Войти</a>
                    <a href="{{ url('/admin/register') }}" class="btn btn-accent-outline">Регистрация</a>
                </div>
            @endauth
        </div>
    </div>
</main>
@endsection

@auth
@push('scripts')
<script>
    function copyUrl() {
        const url = document.getElementById('short-url').textContent;
        navigator.clipboard.writeText(url).then(() => {
            const btn = document.querySelector('.btn-sm');
            btn.textContent = 'Скопировано!';
            setTimeout(() => btn.textContent = 'Копировать', 2000);
        });
    }
</script>
@endpush
@endauth
