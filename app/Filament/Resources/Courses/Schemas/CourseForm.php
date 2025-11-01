<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Repeater;
use App\Models\CourseCategory;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Sertifikat (Default)')->schema([
                    Select::make('certificate_type')->label('Jenis Sertifikat (default)')->options([
                        'KELULUSAN' => 'SERTIFIKAT KELULUSAN',
                        'KOMPETENSI' => 'SERTIFIKAT KOMPETENSI',
                    ])->native(false),
                    TextInput::make('certificate_number_prefix')->label('Nomor Sertifikat (prefix/format)')
                        ->placeholder('SK/BelajarSiko/[Nama Kelas]')
                        ->helperText('Gunakan [Nama Kelas] / {course} sebagai placeholder judul kelas'),
                    TextInput::make('certificate_course_subtitle')->label('Sub-judul Kursus (default)'),
                    TextInput::make('certificate_total_jp')->label('Total JP (default)')->numeric()->minValue(0),
                    DatePicker::make('certificate_assessed_at')->label('Tanggal Penilaian (default)')->native(false),
                ]),
                Select::make('course_category_id')
                    ->label('Kategori')
                    ->options(fn () => CourseCategory::query()->orderBy('name')->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(5),
                FileUpload::make('thumbnail')
                    ->label('Thumbnail')
                    ->image()
                    ->directory('thumbnails')
                    ->disk('public')
                    ->visibility('public'),
                TextInput::make('price')
                    ->label('Harga')
                    ->numeric()
                    ->required()
                    ->default(0),
                Toggle::make('is_premium')
                    ->label('Premium')
                    ->default(false),

                Section::make('Pengaturan Sertifikat Kelas')
                    ->schema([
                        Repeater::make('certificate_competencies')
                            ->schema([
                                TextInput::make('kompetensi')->label('Kompetensi')->required()->columnSpan(3),
                                Textarea::make('butir')->label('Indikator / Butir')->rows(2)->columnSpan(5),
                                TextInput::make('jp')->label('JP')->numeric()->minValue(0)->columnSpan(2),
                                TextInput::make('keterangan')->label('Keterangan')->columnSpan(2),
                            ])->columns(12)->addActionLabel('Tambah Kompetensi'),
                    ]),
            ]);
    }
}
