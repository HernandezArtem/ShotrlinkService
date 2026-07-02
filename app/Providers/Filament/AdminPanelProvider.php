<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Auth\Register;
use App\Http\Controllers\Filament\SyncTimezoneController;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->registration(Register::class)
            ->colors([
                'primary' => [
                    50 => '#edfcf9',
                    100 => '#d1faf3',
                    200 => '#a7f3e9',
                    300 => '#6ee9d6',
                    400 => '#2ee6c5',
                    500 => '#14c9ab',
                    600 => '#0da28a',
                    700 => '#0f8270',
                    800 => '#11675b',
                    900 => '#12554c',
                    950 => '#04332f',
                ],
                'danger' => Color::Rose,
                'gray' => Color::Slate,
            ])
            ->font('Outfit', 'https://fonts.bunny.net/css?family=outfit:400,500,600,700&display=swap')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                \App\Filament\Widgets\LinksOverview::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->brandName('ShortLink')
            ->brandLogo(fn (): Htmlable => new HtmlString(
                view('components.shortlink-logo', ['theme' => 'filament', 'size' => 'md'])->render()
            ))
            ->brandLogoHeight('2.25rem')
            ->navigationItems([
                NavigationItem::make('Сократить ссылку')
                    ->url('/')
                    ->icon('heroicon-o-plus-circle')
                    ->sort(0),
            ])
            ->authenticatedRoutes(function () {
                Route::post('/sync-timezone', SyncTimezoneController::class)->name('sync-timezone');
            })
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => view('filament.hooks.brand-styles'),
            )
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn () => view('filament.hooks.sync-timezone'),
            );
    }
}
