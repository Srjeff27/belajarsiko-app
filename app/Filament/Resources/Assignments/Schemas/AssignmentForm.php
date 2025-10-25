<?php

namespace App\Filament\Resources\Assignments\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;

class AssignmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('lesson_id')
                    ->relationship('lesson', 'title')
                    ->label('Materi')
                    ->required(),
                TextInput::make('title')->label('Judul')->required(),
                Textarea::make('description')->label('Instruksi'),
                DateTimePicker::make('due_date')->label('Batas Waktu'),
            ]);
    }
}
