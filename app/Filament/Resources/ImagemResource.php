<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImagemResource\Pages;
use App\Filament\Resources\ImagemResource\RelationManagers;
use App\Models\Imagem;
use App\Models\instrucao;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImagemResource extends Resource
{
    protected static ?string $model = Imagem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    FileUpload::make('imagem1')
                        ->multiple()
                        ->columnSpan(1)
                        ->label('Text')
                        ->disk('local')
                        ->directory('/public/teste')
                        ->visibility('public')
                        ->getUploadedFileNameForStorageUsing(
                            fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                ->prepend(Carbon::now()->format('v.u').' - '),
                        )
                        ->storeFileNamesIn('imagem1-nome')
                        ->downloadable(),

                    FileUpload::make('imagem2')
                        ->multiple()

                        ->columnSpan(1)
                        ->image()
                        ->imageEditor()->label('string')
                        ->disk('local')
                        ->directory('/public/teste')
                        ->downloadable()
                        ->visibility('public')
                        ->storeFileNamesIn('imagem2-nome')
                        ->imagePreviewHeight('250'),
                ])->columns(2)->columnSpanfull(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListImagems::route('/'),
            'create' => Pages\CreateImagem::route('/create'),
            'edit' => Pages\EditImagem::route('/{record}/edit'),
        ];
    }
}
