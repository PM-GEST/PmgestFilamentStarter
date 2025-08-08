<?php


namespace TimotheMillot\FilamentPmgest\Resources\Users\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use TimotheMillot\FilamentPmgest\Resources\Users\UserResource;

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
