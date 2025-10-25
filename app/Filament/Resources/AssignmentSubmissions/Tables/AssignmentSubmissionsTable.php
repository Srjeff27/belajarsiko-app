<?php

namespace App\Filament\Resources\AssignmentSubmissions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class AssignmentSubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('assignment.title')->label('Tugas')->sortable()->searchable(),
                TextColumn::make('user.name')->label('Mahasiswa')->sortable()->searchable(),
                TextColumn::make('google_drive_link')->label('Link')->url(fn($record) => $record->google_drive_link, true)->openUrlInNewTab(),
                TextColumn::make('grade')->label('Nilai'),
                TextColumn::make('feedback_comment')->label('Feedback')->limit(50),
                TextColumn::make('created_at')->dateTime('d M Y H:i')->label('Dikirim'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
