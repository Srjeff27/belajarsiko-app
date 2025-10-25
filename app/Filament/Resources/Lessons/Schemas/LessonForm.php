<?php

namespace App\Filament\Resources\Lessons\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class LessonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_id')
                    ->relationship('course', 'title')
                    ->label('Kelas')
                    ->required(),
                TextInput::make('title')->label('Judul')->required(),
                Select::make('lesson_type')
                    ->label('Tipe Materi')
                    ->options([
                        'video' => 'Video',
                        'ebook' => 'E-book',
                    ])->required(),
                TextInput::make('content_url')
                    ->label('URL Konten (YouTube/Google Drive)')
                    ->required(),
                TextInput::make('position')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
