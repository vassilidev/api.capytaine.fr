<?php

namespace App\Filament\Resources;

use App\Enums\Scraper\Method;
use App\Enums\Scraper\Type;
use App\Filament\Resources\ScraperResource\Pages;
use App\Filament\Resources\ScraperResource\RelationManagers\ExtractionsRelationManager;
use App\Filament\Resources\ScraperResource\RelationManagers\RunsRelationManager;
use App\Models\Scraper;
use App\Traits\Filament\WithCountBadge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Riodwanto\FilamentAceEditor\AceEditor;

class ScraperResource extends Resource
{
    use WithCountBadge;

    protected static ?string $navigationGroup = 'Data';

    protected static ?string $model = Scraper::class;

    protected static ?string $navigationIcon = 'heroicon-o-cloud';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('connector_id')
                    ->relationship('connector', 'name')
                    ->searchable()
                    ->required()
                    ->preload(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Select::make('method')
                    ->options(Method::class)
                    ->searchable()
                    ->required()
                    ->default(Method::GET),
                Forms\Components\Select::make('type')
                    ->options(Type::class)
                    ->required()
                    ->searchable()
                    ->default(Type::WEBHOOK),
                Forms\Components\TextInput::make('url')
                    ->url()
                    ->columnSpanFull()
                    ->required(),
                AceEditor::make('headers')
                    ->formatStateUsing(fn(?Scraper $record) => $record ? prettyJson($record->headers) : null)
                    ->json()
                    ->columnSpanFull()
                    ->autosize()
                    ->theme('github')
                    ->darkTheme('dracula'),
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('connector.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('runs_count')
                    ->toggleable()
                    ->sortable()
                    ->badge()
                    ->counts('runs'),
                Tables\Columns\TextColumn::make('extractions_count')
                    ->toggleable()
                    ->sortable()
                    ->badge()
                    ->counts('extractions'),
                Tables\Columns\TextColumn::make('method')
                    ->color(fn(Scraper $record) => $record->method->color())
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->searchable(),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Run')
                    ->button()
                    ->icon('heroicon-o-play')
                    ->requiresConfirmation()
                    ->color('info')
                    ->action(fn(Scraper $scraper) => $scraper->run()),
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
            RunsRelationManager::make(),
            ExtractionsRelationManager::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListScrapers::route('/'),
            'create' => Pages\CreateScraper::route('/create'),
            'view'   => Pages\ViewScraper::route('/{record}'),
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
