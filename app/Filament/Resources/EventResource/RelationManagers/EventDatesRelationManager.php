<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventDatesRelationManager extends RelationManager
{
    protected static string $relationship = 'event_dates';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->label('日付')
                    ->required()
                    ->date(),
                Forms\Components\Select::make('event_type_id')
                    ->required()
                    ->relationship(name: 'event_type',  titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->where('editable', true)->orderBy('order', 'asc'))
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('日程')
            ->recordTitleAttribute('date')
            ->defaultSort('date', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('日付'),
                Tables\Columns\TextColumn::make('event_type.name')
                    ->label('イベント'),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->where('editable', true))
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
