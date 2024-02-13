<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Auth\ResetPassword;
use BezhanSalleh\FilamentExceptions\FilamentExceptionsPlugin;
use BezhanSalleh\FilamentExceptions\Resources\ExceptionResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use pxlrbt\FilamentEnvironmentIndicator\EnvironmentIndicatorPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->globalSearch(true)
            ->id('admin')
            ->favicon(asset('images/favicon.png'))
            ->path('')
            ->databaseNotifications()
            ->login(Login::class)
            ->profile(EditProfile::class)
            ->sidebarCollapsibleOnDesktop()
            ->passwordReset(ResetPassword::class)
            ->maxContentWidth('full')
            ->colors([
                'primary' => Color::Emerald,
                'danger' => Color::Red,
                'gray' => Color::Zinc,
                'info' => Color::Blue,
                'success' => Color::Green,
                'teal' => Color::Teal,
                'slate' => Color::Slate,
                'warning' => Color::Amber,
                'sky' => Color::Sky,
                'fuchsia' => Color::Fuchsia,
                'purple' => Color::Purple,
                'pink' => Color::Pink,
                'rose' => Color::Rose,
                'indigo' => Color::Indigo,
                'yellow' => Color::Yellow,
                'orange' => Color::Orange,
                'cyan' => Color::Cyan,
                'neutral' => Color::Neutral,
                'stone' => Color::Stone,
                'lime' => Color::Lime,
                'violet' => Color::Violet,
            ])
            ->plugins([
                EnvironmentIndicatorPlugin::make()
                    ->visible(fn() => app()->environment(['local', 'testing', 'hml', 'homologacao', 'staging', 'development']))
                    ->showBorder(false)
                    ->visible(true),
                FilamentExceptionsPlugin::make()
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
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
            ->authGuard('web')
            ->authPasswordBroker('users')
            ->navigationGroups([
                'Usuários',
                'Admin',
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label('Release')
                    ->url('/release-public')
                    ->icon('heroicon-o-rocket-launch'),
                // ...
            ]);
    }

    public function getFooter(): ?View
    {
        return view('filament.pages.footer');
    }
}
