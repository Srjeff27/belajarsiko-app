<?php

namespace App\Filament\Mentor\Resources;

use App\Filament\Mentor\Resources\StudentResource\Pages\ListStudents;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;
    protected static string|\UnitEnum|null $navigationGroup = 'Pembelajaran';
    protected static ?string $navigationLabel = 'Siswa';
    protected static ?string $pluralModelLabel = 'Siswa';
    protected static ?string $modelLabel = 'Siswa';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
                Tables\Columns\TextColumn::make('universitas')->label('Universitas')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('program_studi')->label('Prodi')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('kelas')->label('Kelas')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('enrolled_count')
                    ->label('Kelas Saya Diikuti')
                    ->state(function (User $record) {
                        return $record->enrollments()
                            ->whereHas('course', fn($q) => $q->where('user_id', auth()->id()))
                            ->count();
                    }),
            ])
            ->filters([])
            ->recordActions([])
            ->toolbarActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('role', 'student')
            ->whereHas('enrollments.course', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->with(['enrollments' => function ($q) {
                $q->whereHas('course', fn($q) => $q->where('user_id', auth()->id()));
            }]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudents::route('/'),
        ];
    }
}

