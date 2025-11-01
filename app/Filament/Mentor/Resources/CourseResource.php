<?php

namespace App\Filament\Mentor\Resources;

use App\Filament\Mentor\Resources\CourseResource\Pages\CreateCourse;
use App\Filament\Mentor\Resources\CourseResource\Pages\EditCourse;
use App\Filament\Mentor\Resources\CourseResource\Pages\ListCourses;
use App\Filament\Mentor\Resources\CourseResource\RelationManagers\EnrollmentsRelationManager;
use App\Filament\Mentor\Resources\CourseResource\RelationManagers\LessonsRelationManager;
use App\Models\Course;
use Filament\Forms;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;
    protected static string|\UnitEnum|null $navigationGroup = 'Kelas';
    protected static ?string $navigationLabel = 'Kelas Saya';
    protected static ?string $pluralModelLabel = 'Kelas';
    protected static ?string $modelLabel = 'Kelas';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('course_category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->required(),
                Forms\Components\TextInput::make('title')->label('Judul')->required()->maxLength(255),
                Forms\Components\Textarea::make('description')->label('Deskripsi')->rows(5),
                Forms\Components\FileUpload::make('thumbnail')->label('Thumbnail')->image()->directory('thumbnails')->disk('public')->visibility('public'),
                Forms\Components\TextInput::make('original_price')->label('Harga Asli')->numeric()->default(0),
                Forms\Components\TextInput::make('price')->label('Harga Diskon')->numeric()->required()->default(0),
                Forms\Components\Toggle::make('is_premium')->label('Premium')->default(false),
                Forms\Components\Select::make('status')->label('Status')->options([
                    'draft' => 'Draft',
                    'pending_review' => 'Pending Review',
                    'published' => 'Published',
                ])->default('draft'),

                Section::make('Tanda Tangan Mentor')
                    ->schema([
                        Forms\Components\TextInput::make('mentor_signature_name')->label('Nama pada Sertifikat')->placeholder('Kosongkan untuk pakai nama akun mentor'),
                        Forms\Components\FileUpload::make('mentor_signature')->label('Tanda Tangan (PNG/JPG)')->image()->directory('signatures')->disk('public')->visibility('public'),
                    ]),

                Section::make('Informasi Sertifikat (Default)')
                    ->schema([
                        Forms\Components\Select::make('certificate_type')->label('Jenis Sertifikat (default)')->options([
                            'KELULUSAN' => 'SERTIFIKAT KELULUSAN',
                            'KOMPETENSI' => 'SERTIFIKAT KOMPETENSI',
                        ])->native(false),
                        Forms\Components\TextInput::make('certificate_number_prefix')->label('Nomor Sertifikat (prefix/format)')->placeholder('SK/BelajarSiko/[Nama Kelas]')->helperText('Gunakan [Nama Kelas] / {course} sebagai placeholder judul kelas'),
                        Forms\Components\TextInput::make('certificate_course_subtitle')->label('Sub-judul Kursus (default)'),
                        Forms\Components\TextInput::make('certificate_total_jp')->label('Total JP (default)')->numeric()->minValue(0),
                        Forms\Components\DatePicker::make('certificate_assessed_at')->label('Tanggal Penilaian (default)')->native(false),
                    ]),

                Section::make('Pengaturan Sertifikat Kelas')
                    ->schema([
                        Forms\Components\Repeater::make('certificate_competencies')
                            ->schema([
                                Forms\Components\TextInput::make('kompetensi')->label('Kompetensi')->required()->columnSpan(3),
                                Forms\Components\Textarea::make('butir')->label('Indikator / Butir')->rows(2)->columnSpan(5),
                                Forms\Components\TextInput::make('jp')->label('JP')->numeric()->minValue(0)->columnSpan(2),
                                Forms\Components\TextInput::make('keterangan')->label('Keterangan')->columnSpan(2),
                            ])->columns(12)->addActionLabel('Tambah Kompetensi'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Judul')->searchable()->sortable(),
                Tables\Columns\IconColumn::make('is_premium')->label('Premium')->boolean(),
                Tables\Columns\BadgeColumn::make('status')->label('Status')->colors([
                    'warning' => 'pending_review',
                    'success' => 'published',
                    'gray' => 'draft',
                ])->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y')->label('Dibuat'),
            ])
            ->filters([])
            ->recordActions([
                Actions\EditAction::make()->modalWidth('7xl'),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }

    public static function getRelations(): array
    {
        return [
            LessonsRelationManager::class,
            EnrollmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourses::route('/'),
            'create' => CreateCourse::route('/create'),
            'edit' => EditCourse::route('/{record}/edit'),
        ];
    }
}



