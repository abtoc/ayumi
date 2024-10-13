<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientEventResource\Pages;
use App\Filament\Resources\ClientEventResource\RelationManagers;
use App\Models\Client;
use App\Models\ClientEvent;
use App\Rules\AlreadyRegisteredShotcutsRule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientEventResource extends Resource
{
    protected static ?string $model = ClientEvent::class;

    protected static ?string $modelLabel = '相互イベント';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('client_id')
                    ->label('依頼者')
                    ->required()
                    ->options(Client::all()->pluck('name', 'id'))
                    ->searchable()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('liver_name')
                    ->label('ライバー名')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('event_name')
                    ->label('イベント名')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('account_count')
                    ->label('相互アカウント数')
                    ->required()
                    ->integer()
                    ->gt(0),
                Forms\Components\TextInput::make('url')
                    ->label('URL')
                    ->url(),
                Forms\Components\DatePicker::make('start_on')
                    ->label('開始日')
                    ->required()
                    ->date()
                    ->afterOrEqual(today())
                    ->rules([new AlreadyRegisteredShotcutsRule($form->model)]),
                Forms\Components\DatePicker::make('end_on')
                    ->label('終了日')
                    ->required()
                    ->date()
                    ->afterOrEqual('start_on'),
                Forms\Components\Checkbox::make('locked')
                    ->label('納品済'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('start_on', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                     ->sortable(),
                Tables\Columns\TextColumn::make('client.name')
                     ->label('依頼者')
                     ->searchable()
                     ->sortable(),
                Tables\Columns\TextColumn::make('liver_name')
                     ->label('ライバー名')
                     ->searchable()
                     ->sortable(),
                Tables\Columns\TextColumn::make('event_name')
                     ->label('イベント名')
                     ->searchable()
                     ->sortable(),
                Tables\Columns\TextColumn::make('account_count')
                     ->label('相互数')
                     ->searchable()
                     ->sortable(),
                Tables\Columns\ToggleColumn::make('delivered')
                     ->label('納品済'),
                Tables\Columns\TextColumn::make('url')
                     ->label('URL')
                     ->searchable()
                     ->sortable(),
                 Tables\Columns\TextColumn::make('start_on')
                     ->label('開始日')
                     ->dateTime('Y/m/d(D)')
                     ->sortable(),
                 Tables\Columns\TextColumn::make('end_on')
                     ->label('終了日')
                     ->dateTime('Y/m/d(D)')
                     ->sortable(),
              ])
            ->filters([
                Tables\Filters\Filter::make('is_delivered')
                    ->label('納品済を除く')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('delivered', false)),
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
            RelationManagers\ClientEventDatesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientEvents::route('/'),
            'create' => Pages\CreateClientEvent::route('/create'),
            'edit' => Pages\EditClientEvent::route('/{record}/edit'),
        ];
    }
}
