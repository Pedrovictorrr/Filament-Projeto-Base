<?php

namespace App\Filament\Resources\ActivityLogResource\Pages;

use App\Filament\Resources\ActivityLogResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

class ListActivityLogs extends ListRecords
{
    protected static string $resource = ActivityLogResource::class;

 
}
