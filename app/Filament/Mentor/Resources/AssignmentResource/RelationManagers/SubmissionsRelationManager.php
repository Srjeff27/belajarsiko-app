<?php

namespace App\Filament\Mentor\Resources\AssignmentResource\RelationManagers;

use Filament\Forms;
use Filament\Actions;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class SubmissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'submissions';
    protected static ?string $title = 'Pengumpulan';

    public function form(Schema $schema): Schema
    {
        // Not used; actions handled in table
        return $schema;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Mahasiswa')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('google_drive_link')->label('Link')->url(fn($record) => $record->google_drive_link, true)->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('grade')->label('Nilai'),
                Tables\Columns\TextColumn::make('feedback_comment')->label('Feedback')->limit(50),
                Tables\Columns\TextColumn::make('submitted_at')->dateTime('d M Y H:i')->label('Dikirim'),
            ])
            ->recordActions([
                Actions\Action::make('nilai')
                    ->label('Nilai')
                    ->form([
                        Forms\Components\TextInput::make('grade')->label('Nilai')->numeric()->minValue(0)->maxValue(100)->required(),
                        Forms\Components\Textarea::make('feedback_comment')->label('Komentar/Feedback'),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'grade' => $data['grade'],
                            'feedback_comment' => $data['feedback_comment'] ?? null,
                        ]);
                        $this->notify('success', 'Nilai tersimpan.');
                    }),
            ])
            ->headerActions([]);
    }
}

