<?php

namespace App\Filament\Resources\CourseCertificates;

use App\Models\Course;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\EditAction;

class CourseCertificateResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;
    protected static string|\UnitEnum|null $navigationGroup = 'Sertifikat';
    protected static ?string $navigationLabel = 'Pengaturan Sertifikat Kelas';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Sertifikat (Default)')->schema([
                \Filament\Forms\Components\Select::make('certificate_type')->label('Jenis Sertifikat (default)')
                    ->options([
                        'KELULUSAN' => 'SERTIFIKAT KELULUSAN',
                        'KOMPETENSI' => 'SERTIFIKAT KOMPETENSI',
                    ])->native(false),
                TextInput::make('certificate_number_prefix')->label('Nomor Sertifikat (prefix/format)')
                    ->placeholder('SK/BelajarSiko/[Nama Kelas]')
                    ->helperText('Gunakan [Nama Kelas] / {course} sebagai placeholder judul kelas'),
                TextInput::make('certificate_course_subtitle')->label('Sub-judul Kursus (default)'),
                TextInput::make('certificate_total_jp')->label('Total JP (default)')->numeric()->minValue(0),
                \Filament\Forms\Components\DatePicker::make('certificate_assessed_at')->label('Tanggal Penilaian (default)')->native(false),
            ]),
            Section::make('Pengaturan Sertifikat Kelas')->columnSpanFull()
                ->schema([
                    Repeater::make('certificate_competencies')->columnSpanFull()
                        ->schema([
                            TextInput::make('kompetensi')->label('Kompetensi')->required()->columnSpan(3),
                            Textarea::make('butir')->label('Indikator / Butir')->rows(2)->columnSpan(5),
                            TextInput::make('jp')->label('JP')->numeric()->minValue(0)->columnSpan(2),
                            TextInput::make('keterangan')->label('Keterangan')->columnSpan(2),
                        ])->columns(12)->addActionLabel('Tambah Kompetensi'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->label('Kelas')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('certificate_total_jp')->label('Total JP')->sortable(),
        ])->recordActions([
            EditAction::make()->modalWidth('7xl'),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCourseCertificates::route('/'),
        ];
    }
}




