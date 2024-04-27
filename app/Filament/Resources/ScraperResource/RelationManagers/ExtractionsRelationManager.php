<?php

namespace App\Filament\Resources\ScraperResource\RelationManagers;

use App\Actions\PublishExtractionResults;
use App\Filament\Resources\ExtractionResource;
use App\Models\Extraction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ExtractionsRelationManager extends RelationManager
{
    protected static string $relationship = 'extractions';

    public function isReadOnly(): bool
    {
        return false;
    }

    protected function canEdit(Model $record): bool
    {
        return ExtractionResource::canEdit($record);
    }

    protected function canCreate(): bool
    {
        return ExtractionResource::canCreate();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
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
                Tables\Columns\TextColumn::make('run.id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('results_count')
                    ->label('Results')
                    ->counts('results')
                    ->badge()
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
                Tables\Actions\ViewAction::make()
                    ->url(fn(Extraction $record) => ExtractionResource::getUrl('view', ['record' => $record])),
                Tables\Actions\Action::make('Reset Results')
                    ->icon('heroicon-o-arrow-path')
                    ->action(fn(Extraction $record) => $record->resetResults(withNotification: true))
                    ->button()
                    ->color('danger')
                    ->requiresConfirmation(),
                Tables\Actions\Action::make('Publish')
                    ->action(fn(Extraction $record) => $record->publish(withNotification: true))
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->button()
                    ->requiresConfirmation(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
