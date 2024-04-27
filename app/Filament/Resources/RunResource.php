<?php

namespace App\Filament\Resources;

use App\Enums\Run\Status;
use App\Filament\Resources\RunResource\Pages;
use App\Filament\Resources\RunResource\RelationManagers\ResultsRelationManager;
use App\Models\Run;
use App\Traits\Filament\WithCountBadge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Riodwanto\FilamentAceEditor\AceEditor;

class RunResource extends Resource
{
    use WithCountBadge;

    protected static ?string $navigationGroup = 'Data';

    protected static ?string $model = Run::class;

    protected static ?string $navigationIcon = 'heroicon-o-rocket-launch';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('scraper_id')
                    ->relationship('scraper', 'name')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->required()
                    ->searchable()
                    ->options(Status::class)
                    ->default('pending'),
                AceEditor::make('request')
                    ->formatStateUsing(fn($record) => prettyJson($record->request))
                    ->json()
                    ->autosize()
                    ->theme('dracula'),
                AceEditor::make('response')
                    ->formatStateUsing(fn($record) => prettyJson($record->response))
                    ->json()
                    ->autosize()
                    ->theme('dracula'),
                Forms\Components\DateTimePicker::make('started_at'),
                Forms\Components\DateTimePicker::make('ended_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('scraper.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->color(fn($record) => $record->status->getColor())
                    ->searchable(),
                Tables\Columns\IconColumn::make('extraction_exists')
                    ->sortable()
                    ->boolean()
                    ->exists('extraction'),
                Tables\Columns\TextColumn::make('results_count')
                    ->sortable()
                    ->badge()
                    ->counts('results'),
                Tables\Columns\TextColumn::make('started_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ended_at')
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
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('Abort')
                    ->visible(fn(Run $run) => $run->canBeAbort())
                    ->button()
                    ->color('danger')
                    ->requiresConfirmation()
                    ->icon('heroicon-o-no-symbol')
                    ->action(fn(Run $run) => $run->abort()),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            ResultsRelationManager::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'view'  => Pages\ViewRun::route('/{record}'),
            'index' => Pages\ListRuns::route('/'),
            'edit'  => Pages\EditRun::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
