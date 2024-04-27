<?php

namespace App\Filament\Resources\RunResource\RelationManagers;

use App\Filament\Resources\ResultResource;
use App\Models\Result;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Riodwanto\FilamentAceEditor\AceEditor;

class ResultsRelationManager extends RelationManager
{
    protected static string $relationship = 'results';

    public function isReadOnly(): bool
    {
        return false;
    }

    protected function canCreate(): bool
    {
        return ResultResource::canCreate();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
                Tables\Columns\TextColumn::make('id'),
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
