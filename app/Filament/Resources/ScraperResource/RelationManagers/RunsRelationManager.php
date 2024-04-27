<?php

namespace App\Filament\Resources\ScraperResource\RelationManagers;

use App\Enums\Run\Status;
use App\Filament\Resources\RunResource;
use App\Models\Run;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Riodwanto\FilamentAceEditor\AceEditor;

class RunsRelationManager extends RelationManager
{
    protected static string $relationship = 'runs';

    public function isReadOnly(): bool
    {
        return false;
    }

    protected function canCreate(): bool
    {
        return RunResource::canCreate();
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->required()
                    ->searchable()
                    ->columnSpanFull()
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->toggleable(isToggledHiddenByDefault: true)
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
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn(Run $record) => RunResource::getUrl('view', ['record' => $record])),
                Tables\Actions\Action::make('Abort')
                    ->visible(fn(Run $run) => $run->canBeAbort())
                    ->button()
                    ->color('danger')
                    ->requiresConfirmation()
                    ->icon('heroicon-o-no-symbol')
                    ->action(fn(Run $run) => $run->abort()),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
