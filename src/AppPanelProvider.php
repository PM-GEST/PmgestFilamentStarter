<?php

namespace PmGest\FilamentStarter;

use Filament\Support\Colors\Color;
use PmGest\FilamentStarter\Pages\Auth\ProfilePage;
use PmGest\FilamentStarter\Pages\Dashboard;
use Filament\PanelProvider;
use Filament\Panel;
use function app_path;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('app')
            ->path('app')
            ->default()
            ->viteTheme('resources/css/filament/app/theme.css')
            ->spa()
            ->darkMode(false)

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->profile(ProfilePage::class, isSimple: false)
            ->colors([
                'primary' => Color::Blue,
            ])
            ->navigationGroups([
                // ...
            ])
            ->resources([
                // ...
            ])
            ->pages([
                Dashboard::class
            ])
            ->widgets([
                // ...
            ])
            ->middleware([
                // ...
            ])
            ->authMiddleware([
                // ...
            ]);
    }
}