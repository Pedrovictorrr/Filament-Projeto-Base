<?php

namespace App\Filament\Resources\ActivityLogResource\Pages;

use App\Filament\Resources\ActivityLogResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\View\View;

class CreateActivityLog extends CreateRecord
{
    protected static string $resource = ActivityLogResource::class;


}
