<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientEventsRelationManager extends RelationManager
{
    protected static string $relationship = 'client_events';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
                    ->integer(),
                Forms\Components\TextInput::make('url')
                    ->label('URL')
                    ->url(),
                Forms\Components\DatePicker::make('start_on')
                    ->label('開始日')
                    ->required()
                    ->date(),
                Forms\Components\DatePicker::make('end_on')
                    ->label('終了日')
                    ->required()
                    ->date()
                    ->after('start_on'),
          ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('イベント')
            ->recordTitleAttribute('liver_name')
            ->defaultSort('start_on', 'desc')
             ->columns([
                Tables\Columns\TextColumn::make('liver_name')
                    ->label('ライバー名')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event_name')
                    ->label('イベント名')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('account_count')
                    ->label('相互アカウント数')
                    ->searchable()
                    ->sortable(),
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
