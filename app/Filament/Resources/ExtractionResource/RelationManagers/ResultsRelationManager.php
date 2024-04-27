<?php

namespace App\Filament\Resources\ExtractionResource\RelationManagers;

use App\Models\Result;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Riodwanto\FilamentAceEditor\AceEditor;

class ResultsRelationManager extends RelationManager
{
    protected static string $relationship = 'results';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->disabled()
                    ->readOnly(),
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
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
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('Validate')
                    ->requiresConfirmation()
                    ->color('success')
                    ->action(fn(Collection $records) => $records->each->validate()),
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
