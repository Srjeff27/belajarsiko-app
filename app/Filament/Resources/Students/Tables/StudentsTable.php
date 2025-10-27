<?php

namespace App\Filament\Resources\Students\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StudentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('npm')->label('NPM')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('semester')->label('Semester')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('kelas')->label('Kelas')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('program_studi')->label('Prodi')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('fakultas')->label('Fakultas')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('universitas')->label('Universitas')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('wa_number')->label('Nomor WA')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([])
            ->toolbarActions([]);
    }
}

