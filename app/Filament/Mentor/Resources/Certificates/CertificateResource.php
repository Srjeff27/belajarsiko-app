<?php

namespace App\Filament\Mentor\Resources\Certificates;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Forms;
use Filament\Actions;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;

class CertificateResource extends Resource
{
    protected static ?string $model = Certificate::class;

    // Show as list-only menu
    protected static bool $shouldRegisterNavigation = true;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;
    protected static string|\UnitEnum|null $navigationGroup = 'Sertifikat';
    protected static ?string $navigationLabel = 'List Sertifikat';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\Select::make('user_id')->label('Siswa')
                ->options(function () {
                    $courseIds = Course::where('user_id', auth()->id())->pluck('id');
                    return User::query()
                        ->where('role','student')
                        ->whereHas('enrollments', fn ($q) => $q->whereIn('course_id', $courseIds))
                        ->orderBy('name')->pluck('name','id')->toArray();
                })->searchable()->required(),
            Forms\Components\Select::make('course_id')->label('Kelas')
                ->options(fn () => Course::where('user_id', auth()->id())->orderBy('title')->pluck('title','id')->toArray())
                ->searchable()->required(),
            Forms\Components\TextInput::make('google_drive_link')->label('Link Google Drive')->url()->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Siswa')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('course.title')->label('Kelas')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('generated_at')->dateTime('d M Y')->label('Dibuat'),
                Tables\Columns\TextColumn::make('google_drive_link')
                    ->label('Drive')
                    ->url(fn($record, $state) => $state ?: null, true)
                    ->openUrlInNewTab(),
            ])
            ->recordActions([
                Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('course', fn ($q) => $q->where('user_id', auth()->id()));
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCertificates::route('/'),
        ];
    }
}
