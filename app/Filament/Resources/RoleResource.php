<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Models\Role;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $modelLabel = 'Funções';

    protected static ?string $navigationGroup = 'Admin';


    #[Url]
    public bool $isTableReordering = false;

    /**
     * @var array<string, mixed> | null
     */
    #[Url]
    public ?array $tableFilters = null;

    #[Url]
    public ?string $tableGrouping = null;

    #[Url]
    public ?string $tableGroupingDirection = null;

    #[Url]
    public ?string $tableSortColumn = null;

    #[Url]
    public ?string $tableSortDirection = null;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                        ->label('Título')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull()
                        ->disabled(fn (Get $get) => $get('title') === 'Super' || $get('title') === 'Inativo'),

                Select::make('users')
                    ->label('Usuários')
                    ->native(false)
                    ->multiple()
                    ->preload()
                    ->columnSpanFull()
                    ->relationship(
                        name: 'users',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => Auth()->user()->hasRole('Super') ? null : $query->whereDoesntHave('roles', function ($query) {
                            $query->where('title', '=', 'Super');
                        })
                    )
                    ->disabled(fn (Get $get) => $get('title') === 'Super'),

                Select::make('Permissões')
                    ->label('Permissões')
                    ->native(false)
                    ->multiple()
                    ->preload()
                    ->columnSpanFull()
                    ->relationship(name: 'permissions', titleAttribute: 'description',
                        modifyQueryUsing: fn (Builder $query) => $query->whereIn('id', Auth()->user()->roles->flatMap->permissions->pluck('id'))
                    )
                    ->hidden(fn (Get $get) => $get('title') === 'Inativo')
                    ->disabled(fn (Get $get) => $get('title') === 'Super'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Role::where('title', '!=', 'Super'))
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                TextColumn::make('users_count')->counts('users')->label('Total de usuários'),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->color('primary'),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->persistSearchInSession()
            ->persistColumnSearchesInSession();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRoles::route('/'),
        ];
    }
}
