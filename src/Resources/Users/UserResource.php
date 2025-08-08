<?php

namespace TimotheMillot\FilamentPmgest\Resources\Users;

use App\Filament\Resources\Users\BackedEnum;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;
use TimotheMillot\FilamentPmgest\Resources\Users\Pages\ManageUsers;
use function filled;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    protected static ?string $label = "Utilisateur";
    protected static ?string $pluralLabel = "Utilisateurs";

    protected static string|null|\UnitEnum $navigationGroup = "Administration";

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label("Nom"),
                TextInput::make('email')
                    ->label("Email"),
                // Mot de passe non pris en compte si laissé vide
                TextInput::make('password')
                    ->label("Mot de passe")
                    ->belowContent("Minimun 8 caractères, une majuscule, une minuscule, un chiffre, un caractère spécial.")
                    ->confirmed()
                    ->dehydrated(fn ($state) => filled($state))
                    // Règles de validation pour le mot de passe
                    ->rules([
                        'nullable',
                        'min:8',
                        'string',
                        'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
                    ])
                    ->password(),
                // Confirmation du mot de passe
                TextInput::make('password_confirmation')
                    ->label("Confirmation du mot de passe")
                    ->password()
                    ->dehydrated(false)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nom'),
                TextColumn::make('email')
                    ->label('Email'),
            ])
            ->recordActions([
                EditAction::make()
                    ->label(""),
                DeleteAction::make()
                    ->label(''),
            ])
            ->recordUrl(null)
            ->recordAction(null);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageUsers::route('/'),
        ];
    }
}
