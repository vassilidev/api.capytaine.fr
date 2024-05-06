<?php

namespace App\Filament\Resources;

use App\Console\Commands\ExtractRssNewsFromSources;
use App\Filament\Resources\ConnectorResource\RelationManagers\TagsRelationManager;
use App\Filament\Resources\SourceResource\Pages;
use App\Filament\Resources\SourceResource\RelationManagers;
use App\Models\Source;
use App\Traits\Filament\WithCountBadge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Artisan;

class SourceResource extends Resource
{
    use WithCountBadge;

    protected static ?string $navigationGroup = 'RSS';

    protected static ?string $model = Source::class;

    protected static ?string $navigationIcon = 'heroicon-o-rss';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('logo')
                    ->url()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('url')
                    ->url()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('rss')
                    ->url()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('url')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\ImageColumn::make('logo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rss')
                    ->formatStateUsing(fn() => 'RSS')
                    ->badge()
                    ->url(fn($record) => 'https://' . $record->rss, shouldOpenInNewTab: true)
                    ->icon('heroicon-o-rss')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_extracted_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->headerActions([
                Tables\Actions\Action::make('Extract')
                    ->button()
                    ->icon('heroicon-o-arrow-down-tray')
                    ->requiresConfirmation()
                    ->color('info')
                    ->action(fn() => Artisan::call(ExtractRssNewsFromSources::class)),
            ])
            ->actions([
                Tables\Actions\Action::make('Extract')
                    ->button()
                    ->icon('heroicon-o-arrow-down-tray')
                    ->requiresConfirmation()
                    ->color('info')
                    ->action(fn(Source $source) => $source->extract(withNotification: true)),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('Extract')
                    ->requiresConfirmation()
                    ->color('success')
                    ->action(function (Collection $records) {
                        $records->each->extract(sync: false);

                        Notification::make()
                            ->success()
                            ->title($records->count() . ' sources extracted')
                            ->send();
                    }),
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TagsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSources::route('/'),
            'create' => Pages\CreateSource::route('/create'),
            'edit'   => Pages\EditSource::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])->latest('created_at');
    }
}
