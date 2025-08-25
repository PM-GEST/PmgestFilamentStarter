<?php

namespace PmGest\FilamentStarter\Filament\Pages\Auth;

use Filament\Actions\Action;
use Filament\Actions\Concerns\HasInfolist;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use function __;
use function auth;
use function bcrypt;
use function filament;
use function filled;
use function session;

/**
 * Page de modification du profil utilisateur
 * Cette page permet à l'utilisateur de modifier son mot de passe.
 * La fonction save() est généré par Filament et permet de sauvegarder les modifications (accessible dans la classe parente BaseEditProfile).
 */
class ProfilePage extends BaseEditProfile implements HasSchemas, hasInfolists
{
    use InteractsWithSchemas;
    use InteractsWithInfolists;

    public ?array $data = [];
    protected string $view = 'filament.pages.profile-page';

    public function mount(): void
    {
        $this->form->fill();
    }



    // Formulaire de modification du mot de passe
    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make("Modifier le mot de passe")
                    ->schema([
                        // Voir fonctions plus bas
                        $this->getCurrentPasswordFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        ])
            ]);
    }


    // Généré par Filament
    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('filament-panels::auth/pages/edit-profile.form.password.label'))
            ->validationAttribute(__('filament-panels::auth/pages/edit-profile.form.password.validation_attribute'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/')
            ->minLength(8)
            ->different("currentPassword")
            ->showAllValidationMessages()
            ->autocomplete('new-password')
            ->dehydrated(fn ($state): bool => filled($state))
            ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
            ->same('passwordConfirmation');
    }

    // Généré par Filament
    protected function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('passwordConfirmation')
            ->label(__('filament-panels::auth/pages/edit-profile.form.password_confirmation.label'))
            ->validationAttribute(__('filament-panels::auth/pages/edit-profile.form.password_confirmation.validation_attribute'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->dehydrated(false);
    }

    // Généré par Filament
    protected function getCurrentPasswordFormComponent(): Component
    {
        return TextInput::make('currentPassword')
            ->label(__('filament-panels::auth/pages/edit-profile.form.current_password.label'))
            ->validationAttribute(__('filament-panels::auth/pages/edit-profile.form.current_password.validation_attribute'))
            ->belowContent(__('filament-panels::auth/pages/edit-profile.form.current_password.below_content'))
            ->password()
            ->currentPassword(guard: Filament::getAuthGuard())
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->dehydrated(false);
    }
    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label("Sauvegarder")
            ->submit('save')
            ->keyBindings(['mod+s']);
    }



}
