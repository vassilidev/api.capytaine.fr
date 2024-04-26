<?php

namespace App\Filament\Resources;

use App\Enums\Scraper\Method;
use App\Enums\Scraper\Type;
use App\Filament\Resources\ScraperResource\Pages;
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
                    ->required()
                    ->default(Method::GET),
                Forms\Components\Select::make('type')
                    ->options(Type::class)
                    ->required()
                    ->default(Type::WEBHOOK),
                Forms\Components\TextInput::make('url')
                    ->url()
                    ->columnSpanFull()
                    ->required(),
                AceEditor::make('headers')
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
                Tables\Columns\TextColumn::make('method')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('extractions_count')
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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListScrapers::route('/'),
            'create' => Pages\CreateScraper::route('/create'),
            'edit'   => Pages\EditScraper::route('/{record}/edit'),
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
