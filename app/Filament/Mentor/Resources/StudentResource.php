<?php

namespace App\Filament\Mentor\Resources;

use App\Filament\Mentor\Resources\StudentResource\Pages\ListStudents;
use App\Filament\Mentor\Resources\StudentResource\Pages\ViewStudent;
use App\Filament\Resources\Students\Tables\StudentsTable;
use App\Models\User;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;
    protected static string|UnitEnum|null $navigationGroup = 'Siswa';

    protected static ?string $navigationLabel = 'Siswa';
    protected static ?string $pluralModelLabel = 'Siswa';
    protected static ?string $modelLabel = 'Siswa';

    public static function table(Table $table): Table
    {
        // Reuse the StudentsTable configured for admin; mentor-specific filtering is done in getEloquentQuery
        return StudentsTable::configure($table);
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
            'view' => ViewStudent::route('/{record}'),
        ];
    }
}
