<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Exception;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Facades\Filament;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Auth\ResetPassword as ResetPasswordNotification;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\PasswordReset\RequestPasswordReset;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Support\RawJs;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Password;

class ResetPassword extends RequestPasswordReset
{
    use InteractsWithFormActions;
    use WithRateLimiting;

    /**
     * @var view-string
     */
    protected static string $view = 'filament-panels::pages.auth.password-reset.request-password-reset';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->form->fill();
    }

    public function request(): void
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/password-reset/request-password-reset.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/password-reset/request-password-reset.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/password-reset/request-password-reset.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->color('danger')
                ->duration(50000)
                ->send();

            return;
        }

        $url = $_SERVER['HTTP_REFERER'];
        $data = $this->form->getState();
        $queryParams = parse_url($url, PHP_URL_QUERY);
        parse_str($queryParams, $params);

        if (isset($params['tab'])) {
            $resetTabsValue = $params['tab'];
            if ($resetTabsValue === '-email-tab') {
                $data['login'] = $data['email'];
            } elseif ($resetTabsValue === '-whatsapp-tab') {
                $data['login'] = $data['telefone'];
            }
        } else {
            Notification::make()
                ->title('Erro no server')
                ->danger()
                ->color('danger')
                ->duration(50000)
                ->send();
        }

        $data = $this->getCredentialsFromFormData($data); // Chama a função para manipular os dados

        $status = Password::broker(Filament::getAuthPasswordBroker())->sendResetLink(
            $data,
            function (CanResetPassword $user, string $token) use ($data) { // Usa os dados na função anônima
                if (!method_exists($user, 'notify')) {
                    $userClass = $user::class;

                    throw new Exception("Model [{$userClass}] does not have a [notify()] method.");
                }

                $notification = new ResetPasswordNotification($token);
                $notification->url = Filament::getResetPasswordUrl($token, $user);

                if (isset($data['email'])) {
                    $user->sendPasswordResetNotification($notification);
                }
            },
        );

        if ($status !== Password::RESET_LINK_SENT) {
            Notification::make()
                ->title(__($status))
                ->duration(50000)
                ->color('danger')
                ->danger()
                ->send();

            return;
        }

        Notification::make()
            ->title('Link de redefinição enviado com sucesso!')
            ->success()
            ->color('success')
            ->send();

        $this->form->fill();
    }



    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getTabsFormComponent(),
            ])
            ->statePath('data');
    }

    protected function getTabsFormComponent(): Component
    {
        return $this->getEmailFormComponent();
    }

    protected function getWhatsappFormComponent(): Component
    {
        return TextInput::make('telefone')
            ->label('Whatsapp')
            ->tel()
            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
            ->maxValue(14)
            ->maxLength(14)
            ->minValue(11)
            ->minLength(11)
            ->placeholder('(DDD) + Numero')
            ->mask(RawJs::make(<<<'JS'
            $input.startsWith('11') || $input.startsWith('11') ?  '(99)99999-9999' :  '(99)99999-9999'
        JS))
            ->autocomplete()
            ->autofocus();
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label(__('filament-panels::pages/auth/password-reset/request-password-reset.form.email.label'))
            ->email()
            ->autocomplete()
            ->placeholder('exemplo@email.com')
            ->autofocus();
    }

    public function loginAction(): Action
    {
        return Action::make('login')
            ->link()
            ->label(__('filament-panels::pages/auth/password-reset/request-password-reset.actions.login.label'))
            ->icon(match (__('filament-panels::layout.direction')) {
                'rtl' => 'heroicon-m-arrow-right',
                default => 'heroicon-m-arrow-left',
            })
            ->url(filament()->getLoginUrl());
    }

    public function getTitle(): string|Htmlable
    {
        return __('filament-panels::pages/auth/password-reset/request-password-reset.title');
    }

    public function getHeading(): string|Htmlable
    {
        return __('filament-panels::pages/auth/password-reset/request-password-reset.heading');
    }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getRequestFormAction(),
        ];
    }

    protected function getRequestFormAction(): Action
    {
        return Action::make('request')
            ->label('Enviar redefinição de senha')
            ->submit('request');
    }

    protected function hasFullWidthFormActions(): bool
    {
        return true;
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        $login_type = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'telefone';

        if (strpos($data['login'], '@') === false) {
            $data['login'] = preg_replace('/[^0-9]/', '', $data['login']);
            $user = User::where('telefone', $data['login'])->where('status', 'Ativo')->first();
            if (!$user) {
                return [
                    $login_type => 'erro',
                ]; // Usuário não encontrado ou não está ativo
            }
        } else {
            $user = User::where('email', $data['login'])->where('status', 'Ativo')->first();
            if (!$user) {
                return [
                    $login_type => 'erro',

                ]; // Usuário não encontrado ou não está ativo
            }
        }

        $login_type = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'telefone';

        return [
            $login_type => $data['login'],
        ];
    }
}
