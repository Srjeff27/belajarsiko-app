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
            Forms\Components\Grid::make(12)->schema([
                Forms\Components\Select::make('user_id')->label('Siswa')
                    ->options(function () {
                        $courseIds = Course::where('user_id', auth()->id())->pluck('id');
                        return User::query()
                            ->where('role','student')
                            ->whereHas('enrollments', fn ($q) => $q->whereIn('course_id', $courseIds))
                            ->orderBy('name')->pluck('name','id')->toArray();
                    })->searchable()->required()->columnSpan(6),
                Forms\Components\Select::make('course_id')->label('Kelas')
                    ->options(fn () => Course::where('user_id', auth()->id())->orderBy('title')->pluck('title','id')->toArray())
                    ->searchable()->required()->columnSpan(6),
                Forms\Components\TextInput::make('google_drive_link')->label('Link Google Drive')->url()->nullable()->columnSpan(12),
            ]),

            Forms\Components\Section::make('Informasi Sertifikat')->schema([
                Forms\Components\Select::make('type')->label('Jenis Sertifikat')->options([
                    'KELULUSAN' => 'SERTIFIKAT KELULUSAN',
                    'KOMPETENSI' => 'SERTIFIKAT KOMPETENSI',
                ])->native(false),
                Forms\Components\TextInput::make('formal_number')->label('Nomor Sertifikat')->placeholder('123/SK/BelajarSiko/X/2025'),
                Forms\Components\TextInput::make('course_subtitle')->label('Sub-judul Kursus')->placeholder('Pemrograman Dasar: Logika, Algoritma, dan Struktur Data dengan Python'),
                Forms\Components\TextInput::make('total_jp')->label('Total JP')->numeric()->minValue(0),
                Forms\Components\DatePicker::make('assessed_at')->label('Tanggal Penilaian')->native(false),
            ]),

            Forms\Components\Section::make('Penilaian Kompetensi')->schema([
                Forms\Components\Repeater::make('competencies')
                    ->schema([
                        Forms\Components\TextInput::make('kompetensi')->label('Kompetensi')->required()->columnSpan(3),
                        Forms\Components\Textarea::make('butir')->label('Indikator / Butir Penilaian')->rows(2)->columnSpan(6),
                        Forms\Components\TextInput::make('jp')->label('JP')->numeric()->minValue(0)->columnSpan(2),
                        Forms\Components\TextInput::make('keterangan')->label('Keterangan')->columnSpan(2),
                    ])->columns(12)->collapsed(false)->addActionLabel('Tambah Butir'),
            ]),

            Forms\Components\Section::make('Tanda Tangan Mentor')->schema([
                Forms\Components\TextInput::make('mentor_signature_name')->label('Nama di Sertifikat')->placeholder('Kosongkan untuk pakai nama akun mentor'),
                Forms\Components\FileUpload::make('mentor_signature')->label('Tanda Tangan Mentor (PNG/JPG)')->image()->directory('signatures')->disk('public')->visibility('public'),
            ]),
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
                Actions\EditAction::make(),
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
