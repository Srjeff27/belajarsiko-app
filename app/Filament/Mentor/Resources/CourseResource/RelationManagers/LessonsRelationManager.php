<?php

namespace App\Filament\Mentor\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Actions;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class LessonsRelationManager extends RelationManager
{
    protected static string $relationship = 'lessons';
    protected static ?string $title = 'Materi';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\TextInput::make('title')->label('Judul')->required(),
            Forms\Components\Select::make('lesson_type')->label('Tipe Materi')->options([
                'video' => 'Video',
                'ebook' => 'E-book',
            ])->required(),
            Forms\Components\TextInput::make('content_url')->label('URL Konten')->required(),
            Forms\Components\TextInput::make('position')->numeric()->default(0)->label('Urutan'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Judul')->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('lesson_type')->label('Tipe'),
                Tables\Columns\TextColumn::make('position')->label('Urutan')->sortable(),
            ])
            ->recordActions([
                Actions\EditAction::make(),
                Actions\Action::make('kelolaTugas')
                    ->label('Kelola Tugas')
                    ->url(fn($record) => \App\Filament\Mentor\Resources\LessonResource::getUrl('edit', ['record' => $record]))
                    ->openUrlInNewTab(),
                Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Actions\CreateAction::make(),
            ]);
    }
}

