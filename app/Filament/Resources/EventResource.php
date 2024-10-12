<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $modelLabel = 'イベント';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('mixch_id')
                    ->label('ミクチャID')
                    ->integer()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->label('イベント名')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('start_on')
                    ->label('開始日')
                    ->required()
                    ->date(),
                Forms\Components\DatePicker::make('end_on')
                    ->label('終了日')
                    ->required()
                    ->date()
                    ->afterOrEqual('start_on'),
                Forms\Components\ViewField::make('url')
                    ->label('URL')
                    ->view('forms.components.link-field'),
                Forms\Components\Select::make('livrtd')
                    ->label('参加ライバー')
                    ->relationship(name: 'livers', titleAttribute: 'name')
                    ->multiple(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('start_on', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('mixch_id')
                    ->label('ミクチャID')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('名前')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('url'),
                    Tables\Columns\TextColumn::make('start_on')
                    ->label('開始日')
                    ->dateTime('Y/m/d(D)')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_on')
                    ->label('終了日')
                    ->dateTime('Y/m/d(D)')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('作成日')
                    ->dateTime('Y/m/d H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('更新日')
                    ->dateTime('Y/m/d H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('in_session')
                    ->label('開催中')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('start_on', '<=', today())->where('end_on', '>=', today())),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\EventDatesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
