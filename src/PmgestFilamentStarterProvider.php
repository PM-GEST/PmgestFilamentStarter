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
            ]);
        }

        $this->publishes([
            __DIR__ . '/../stubs/AppPanelProvider.stub' => app_path('Providers/Filament/AppPanelProvider.php'),
        ], 'filament-panel-provider');


        $providerPath = app_path('Providers/Filament/AppPanelProvider.php');
        if (file_exists($providerPath)) {
            require_once $providerPath;
            $this->app->register(\App\Providers\Filament\AppPanelProvider::class);
        }

        // Génère le logo PM-GEST en bas de la sidebar grace aux hooks Filament, voir composant blade components.pm-gest-component
        FilamentView::registerRenderHook(
            PanelsRenderHook::SIDEBAR_FOOTER,
            fn (): string => Blade::render('components.pm-gest-component'),
        );

    }

}