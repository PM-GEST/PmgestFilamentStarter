<?php

namespace PmGest\FilamentStarter;


use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use PmGest\FilamentStarter\Commands\InstallPackage;
use Illuminate\Support\ServiceProvider;

class PmgestFilamentStarterProvider  extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Permet de désactiver la protection des modèles Eloquent, ce qui est nécessaire pour les opérations de masse dans Filament.
        Model::unguard();

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallPackage::class,
                Resfresh::class
            ]);
        }
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views/components', 'pm-gest-component');

        $this->publishes([
            __DIR__ . '/../stubs/AppPanelProvider.stub' => app_path('Providers/Filament/AppPanelProvider.php'),
        ], 'filament-panel-provider');

        $this->publishes([
            __DIR__ . '/Filament/Pages/Dashboard.php' => app_path('Filament/Pages/Dashboard.php'),
        ], 'filament-panel-provider');
        $this->publishes([
            __DIR__ . '/Filament/Pages/Auth/ProfilePage.php' => app_path('Filament/Pages/Auth/ProfilePage.php'),
        ], 'filament-panel-provider');

        $this->publishes([
            __DIR__ . '/Commands/Refresh.php' => app_path('Commands/Refresh.php'),
        ], 'filament-panel-provider');
        $this->publishes([
            __DIR__ . '/../resources/css/filament/app/theme.css' => $this->app->basePath('resources/css/filament/app/theme.css'),
        ], 'filament-panel-provider');

        $this->publishes([
            __DIR__ . '/../routes/web.php' => $this->app->basePath('routes/web.php'),
        ], 'filament-panel-provider');

        $this->publishes([
            __DIR__ . '/../database/seeders/DatabaseSeeder.php' => $this->app->basePath('database/seeders/DatabaseSeeder.php'),
        ], 'routes');




        // Génère le logo PM-GEST en bas de la sidebar grace aux hooks Filament, voir composant blade components.pm-gest-component
        FilamentView::registerRenderHook(
            PanelsRenderHook::SIDEBAR_FOOTER,
            fn (): string => Blade::render('components.pm-gest-component'),
        );

    }

}