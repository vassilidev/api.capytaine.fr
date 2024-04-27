<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResultResource\Pages;
use App\Models\Result;
use App\Traits\Filament\WithCountBadge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Riodwanto\FilamentAceEditor\AceEditor;

class ResultResource extends Resource
{
    use WithCountBadge;

    protected static ?string $navigationGroup = 'Data';

    protected static ?string $model = Result::class;

    protected static ?string $recordRouteKeyName = 'id';

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('extraction_id')
                    ->disabled()
                    ->readOnly(),
                AceEditor::make('data')
                    ->formatStateUsing(fn(Result $record) => prettyJson($record->data))
                    ->mode('json')
                    ->json()
                    ->columnSpanFull()
                    ->autosize()
                    ->theme('github')
                    ->darkTheme('dracula')
                    ->required(),
                Forms\Components\Toggle::make('is_valid'),
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
                Tables\Columns\TextColumn::make('extraction_id')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('data.name')
                    ->label('Event')
                    ->default(fn(Result $record) => $record->id)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_valid'),
                Tables\Columns\TextColumn::make('data.start_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('Validate')
                    ->requiresConfirmation()
                    ->color('success')
                    ->action(fn(Collection $records) => $records->each->validate()),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResults::route('/'),
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
