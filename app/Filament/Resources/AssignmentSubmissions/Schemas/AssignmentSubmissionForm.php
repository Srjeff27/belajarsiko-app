<?php

namespace App\Filament\Resources\AssignmentSubmissions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class AssignmentSubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('assignment_id')->relationship('assignment', 'title')->label('Tugas')->disabled(),
                Select::make('user_id')->relationship('user', 'name')->label('Mahasiswa')->disabled(),
                TextInput::make('google_drive_link')->label('Link Google Drive')->url()->required(),
                TextInput::make('grade')->label('Nilai')->numeric()->minValue(0)->maxValue(100),
                Textarea::make('feedback_comment')->label('Komentar/Feedback'),
            ]);
    }
}

