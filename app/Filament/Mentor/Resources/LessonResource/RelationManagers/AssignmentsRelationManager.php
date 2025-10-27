<?php

namespace App\Filament\Mentor\Resources\LessonResource\RelationManagers;

use Filament\Forms;
use Filament\Actions;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class AssignmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'assignments';
    protected static ?string $title = 'Tugas';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\TextInput::make('title')->label('Judul')->required(),
            Forms\Components\Textarea::make('description')->label('Instruksi'),
            Forms\Components\DateTimePicker::make('due_date')->label('Batas Waktu'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Judul')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('due_date')->dateTime('d M Y H:i')->label('Batas Waktu'),
            ])
            ->recordActions([
                Actions\EditAction::make(),
                Actions\Action::make('kelolaPengumpulan')
                    ->label('Lihat Pengumpulan')
                    ->url(fn($record) => \App\Filament\Mentor\Resources\AssignmentResource::getUrl('edit', ['record' => $record]))
                    ->openUrlInNewTab(),
                Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Actions\CreateAction::make(),
            ]);
    }
}

