<?php

namespace App\Filament\Resources\ClientEventResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientEventDatesRelationManager extends RelationManager
{
    protected static string $relationship = 'client_event_dates';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('date')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Checkbox::make('collected')
                    ->label('収集済'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('日付')
            ->recordTitleAttribute('date')
            ->defaultSort('date', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('日付')
                    ->dateTime('Y/m/d(D)')
                    ->sortable(),
                Tables\Columns\ViewColumn::make('screenshots')
                    ->label('スクリーンショット数')
                    ->view('tables.columns.screenshot-count'),
                Tables\Columns\ToggleColumn::make('collected')
                    ->label('収集済'),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_collected')
                    ->label('収集済を除く')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('collected', false)),
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
