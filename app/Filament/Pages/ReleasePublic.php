<?php

namespace App\Filament\Pages;

use App\Models\Releases;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;

class ReleasePublic extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.pages.release-public';

    public $model;

    protected static ?string $title = 'Releases';

    public function mount()
    {
        $this->model = Releases::get();
    }

    public function getFooter(): ?View
    {
        return view('filament.pages.footer');
    }
}
