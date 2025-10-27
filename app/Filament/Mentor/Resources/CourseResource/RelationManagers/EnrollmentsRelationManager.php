<?php

namespace App\Filament\Mentor\Resources\CourseResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class EnrollmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'enrollments';
    protected static ?string $title = 'Siswa Terdaftar';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Nama'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y')->label('Tanggal Enroll'),
            ])
            ->recordActions([])
            ->headerActions([]);
    }
}

