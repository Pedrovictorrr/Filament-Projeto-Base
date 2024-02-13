<?php

namespace App\Filament\AvatarProviders;

use Filament\AvatarProviders\UiAvatarsProvider;
use Filament\Facades\Filament;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class AvatarProvider extends UiAvatarsProvider
{
    public function get(Model|Authenticatable $record): string
    {
        $userPicture = Auth()->user()->foto;

        if ($userPicture != null) {

            $novaString = str_replace('public', 'storage', $userPicture);

            return $novaString;
        } else {
            $name = str(Filament::getNameForDefaultAvatar($record))
                ->trim()
                ->explode(' ')
                ->map(fn (string $segment): string => filled($segment) ? mb_substr($segment, 0, 1) : '')
                ->join(' ');

            return 'https://source.boringavatars.com/beam/120/'.urlencode($name);
        }

    }
}
