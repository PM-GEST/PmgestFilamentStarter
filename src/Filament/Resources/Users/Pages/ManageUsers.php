<?php


namespace PmGest\FilamentStarter\Filament\Resources\Users\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use PmGest\FilamentStarter\Filament\Resources\Users\UserResource;

class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label("+ Ajouter un utilisateur")
                ->createAnother(false),
        ];
    }
}
