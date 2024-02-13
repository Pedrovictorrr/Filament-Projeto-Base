<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Login as AuthLogin;
use Filament\Pages\Concerns\InteractsWithFormActions;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;
use Rawilk\FilamentPasswordInput\Password;

class Login extends AuthLogin
{
    use InteractsWithFormActions;
    use WithRateLimiting;

    /**
     * @var view-string
     */
    protected static string $view = 'filament.pages.auth.login';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public ?array $ResetPasswordData = [];

    public $ResetPassword = false;

    protected $listeners = [
        'getLatitudeForInput',
    ];

    public function getPassword($value): void
    {
        if (!is_null($value)) {
            $this->data['password'] = $value;
        }
    }

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->form->fill();
    }

    /**
     * @throws GuzzleException
     * @throws ValidationException
     */
    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/login.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/login.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/login.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->danger()
                ->send();

            return null;
        }
        $data = $this->form->getState();
        $user = User::where('email', $data['login'])->first();
        
        if ($user && Hash::check($data['password'], $user->password)) {
            // As credenciais estão corretas
            if ($user->change_password == 0) {
                $this->ResetPassword = true;
                return null;
            }
        }
        // Tentativa de autenticação normal no banco de dados principal
        if (Filament::auth()->attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
            Auth::login(Filament::auth()->user());
        } else {
            // Ambas as tentativas de autenticação falharam
            Notification::make()
                ->title('Erro de autenticação')
                ->icon('heroicon-o-x-circle')
                ->danger()
                ->color('danger')
                ->body('Verifique suas credenciais.')
                ->send();
            throw ValidationException::withMessages([
                'data.login' => __('filament-panels::pages/auth/login.messages.failed'),
            ]);
        }


        session()->regenerate();

        return app(LoginResponse::class);
    }

    public function PasswordResetRequest(): ?LoginResponse
    {

        $NewPasswordForm = $this->ResetPasswordForm->getState();
        $data = $this->form->getState();
        $user = User::where('email', $data['login'])->first();
        $user->update([
            'password' => bcrypt($NewPasswordForm['password']),
            'change_password' => 1
        ]);
        $data['password'] = $NewPasswordForm['password'];
        // Tentativa de autenticação normal no banco de dados principal
        if (Filament::auth()->attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
            Auth::login(Filament::auth()->user());
        } else {
            // Ambas as tentativas de autenticação falharam
            Notification::make()
                ->title('Erro de autenticação')
                ->icon('heroicon-o-x-circle')
                ->danger()
                ->color('danger')
                ->body('Verifique suas credenciais.')
                ->send();
            throw ValidationException::withMessages([
                'data.login' => __('filament-panels::pages/auth/login.messages.failed'),
            ]);
        }


        session()->regenerate();

        return app(LoginResponse::class);
    }

    protected function getForms(): array
    {
        return [
            'ResetPasswordForm',
            'form',
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getLoginFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),

            ])
            ->statePath('data');
    }

    public function ResetPasswordForm(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('password')
                    ->label('Nova Senha')
                    ->rules([
                        'min:8',
                        'string',
                        'confirmed', // Campo de confirmação da senha
                        'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
                    ])
                    ->password()
                    ->confirmed()
                    ->revealable(filament()->arePasswordsRevealable())
                    ->required()
                    ->extraInputAttributes(['tabindex' => 2]),
                TextInput::make('password_confirmation')
                    ->label('Nova Senha Confimação')
                    ->password()
                    ->revealable(filament()->arePasswordsRevealable())
                    ->required()
                    ->extraInputAttributes(['tabindex' => 2]),
                Checkbox::make('Confirmacao')->label('Confirmo que alterei minha senha com sucesso.')->required()
                    ->helperText('Ao marcar esta caixa, você confirma que realizou a alteração de senha na sua conta. Caso não tenha realizado essa ação ou se esta mudança de senha foi feita sem a sua autorização, entre em contato imediatamente com nosso suporte.')

            ])
            ->statePath('ResetPasswordData');
    }

    /**
     * @throws GuzzleException
     */


    public function getLoginFormComponent(): Component
    {
        return TextInput::make('login')
            ->label('Email ou Telefone')
            ->required()
            ->exists()
            ->autocomplete()
            ->autofocus()
            ->placeholder('exemplo@email.com ou  ddd+Numero');
    }
    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('filament-panels::pages/auth/login.form.password.label'))
            ->hint(filament()->hasPasswordReset() ? new HtmlString(Blade::render('<x-filament::link :href="filament()->getRequestPasswordResetUrl()"> {{ __(\'filament-panels::pages/auth/login.actions.request_password_reset.label\') }}</x-filament::link>')) : null)
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->autocomplete('current-password')
            ->required()
            ->extraInputAttributes(['tabindex' => 2]);
    }

    protected function getRememberFormComponent(): Component
    {
        return Checkbox::make('remember')
            ->label('Permanecer conectado');
    }

    public function registerAction(): Action
    {
        return Action::make('register')
            ->link()
            ->label(__('filament-panels::pages/auth/login.actions.register.label'))
            ->url(filament()->getRegistrationUrl());
    }

    public function getTitle(): string|Htmlable
    {
        return __('filament-panels::pages/auth/login.title');
    }

    public function getHeading(): string|Htmlable
    {
        return $this->ResetPassword ? 'Alterar Senha' : 'Login';
    }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getAuthenticateFormAction(),
        ];
    }

    protected function getAuthenticateFormAction(): Action
    {
        return Action::make('authenticate')
            ->label('Entrar')
            ->icon('heroicon-o-lock-closed')
            ->submit('authenticate');
    }

    protected function hasFullWidthFormActions(): bool
    {
        return true;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function getLoginTypeAndValue(array $data): array
    {
        $loginType = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'telefone';

        if ($loginType === 'telefone') {
            $data['login'] = preg_replace('/[^0-9]/', '', $data['login']);
        }

        return [
            'type' => $loginType,
            'value' => $data['login'],
        ];
    }

    protected function findUserByLogin(array $loginData): ?User
    {
        $user = User::where($loginData['type'], $loginData['value'])
            ->where('status', 'Ativo')
            ->first();

        return $user;
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        $loginData = $this->getLoginTypeAndValue($data);
        $user = $this->findUserByLogin($loginData);

        if (!$user) {
            return [
                $loginData['type'] => 'erro',
                'password' => $data['password'],
            ]; // Usuário não encontrado ou não está ativo
        }

        return [
            $loginData['type'] => $data['login'],
            'password' => $data['password'],
        ];
    }
    protected function onValidationError(ValidationException $exception): void
    {
        Notification::make()
            ->title($exception->getMessage())
            ->icon('heroicon-o-x-circle')
            ->color('danger')
            ->danger()
            ->send();
    }
}
