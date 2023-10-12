<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Filament\Resources\EventResource\RelationManagers\LinksRelationManager;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = '活動';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('時間')
                    ->description('請輸入活動時間，結束時間可以空白')
                    ->schema([
                        Forms\Components\DateTimePicker::make('time_gather')
                            ->required(),
                        Forms\Components\DateTimePicker::make('time_end'),
                    ]),
                Forms\Components\Select::make('place_id')
                    ->relationship(name: 'place', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('team_id')
                    ->relationship(name: 'team', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\RichEditor::make('note')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('place.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('team.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('time_gather')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('time_end')
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
            ])
            ->filters([
                SelectFilter::make('Place')
                    ->label('地點')
                    ->relationship('place', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('Team')
                    ->label('團隊')
                    ->relationship('team', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\ReplicateAction::make()
                    ->after(function (Tables\Actions\ReplicateAction $action, Event $record) {
                        $newRecord = $action->getReplica();
                        foreach ($record->links as $link) {
                            $newRecord->links()->create([
                                'title' => $link->title,
                                'url' => $link->url,
                            ]);
                        }
                    })
                    ->successRedirectUrl(fn (Tables\Actions\ReplicateAction $action) => route('filament.admin.resources.events.edit', ['record' => $action->getReplica()])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('time_gather', 'desc');
    }

    public static function infolist(Infolists\Infolist $infolist): Infolists\Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('時間')
                    ->schema([
                        Infolists\Components\TextEntry::make('time_gather')
                            ->label('集合時間'),
                        Infolists\Components\TextEntry::make('time_end')
                            ->label('結束時間'),
                    ]),
                Infolists\Components\TextEntry::make('place.name')
                    ->label('地點'),
                Infolists\Components\TextEntry::make('team.name')
                    ->label('團隊'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            LinksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'view' => Pages\ViewEvent::route('/{record}'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}