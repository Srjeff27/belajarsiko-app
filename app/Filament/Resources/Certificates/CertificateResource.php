<?php

namespace App\Filament\Resources\Certificates;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Forms;
use Filament\Actions;
use Filament\Support\Icons\Heroicon;

class CertificateResource extends Resource
{
    protected static ?string $model = Certificate::class;

    // Show as list-only menu
    protected static bool $shouldRegisterNavigation = true;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;
    protected static string|UnitEnum|null $navigationGroup = 'Sertifikat';
    protected static ?string $navigationLabel = 'List Sertifikat';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\Select::make('user_id')->label('Siswa')->options(
                fn () => User::query()->where('role','student')->orderBy('name')->pluck('name','id')->toArray()
            )->searchable()->required(),
            Forms\Components\Select::make('course_id')->label('Kelas')->options(
                fn () => Course::query()->orderBy('title')->pluck('title','id')->toArray()
            )->searchable()->required(),
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
            ->filters([])
            ->recordActions([
                Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
