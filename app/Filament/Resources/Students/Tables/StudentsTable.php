<?php

namespace App\Filament\Resources\Students\Tables;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

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
            ->recordActions([
                Action::make('export_csv')
                    ->label('Cetak (CSV)')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(function (User $record) {
                        return response()->streamDownload(function () use ($record) {
                            $csv = fopen('php://output', 'w');
                            fputcsv($csv, [
                                'Nama', 'Email', 'NPM', 'Semester', 'Kelas', 'Program Studi', 'Fakultas', 'Universitas', 'Nomor WA', 'Alamat'
                            ]);
                            fputcsv($csv, [
                                $record->name,
                                $record->email,
                                $record->npm,
                                $record->semester,
                                $record->kelas,
                                $record->program_studi,
                                $record->fakultas,
                                $record->universitas,
                                $record->wa_number,
                                $record->alamat,
                            ]);
                            fclose($csv);
                        }, 'siswa-' . $record->id . '.csv');
                    }),

                Action::make('print_pdf')
                    ->label('Cetak (PDF)')
                    ->icon('heroicon-o-printer')
                    ->action(function (User $record) {
                        $pdf = Pdf::loadView('filament.students.print', ['user' => $record]);
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'siswa-' . $record->id . '.pdf', [
                            'Content-Type' => 'application/pdf',
                        ]);
                    }),
            ])
            ->toolbarActions([
                Action::make('download_all_csv')
                    ->label('Download Semua (CSV)')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(function () {
                        $query = User::query()->where('role', 'student');
                        if (auth()->user() && auth()->user()->hasRole('mentor')) {
                            $query->whereHas('enrollments.course', function ($q) {
                                $q->where('user_id', auth()->id());
                            });
                        }
                        $students = $query->get();

                        return response()->streamDownload(function () use ($students) {
                            $csv = fopen('php://output', 'w');
                            fputcsv($csv, [
                                'Nama', 'Email', 'NPM', 'Semester', 'Kelas', 'Program Studi', 'Fakultas', 'Universitas', 'Nomor WA', 'Alamat'
                            ]);

                            foreach ($students as $record) {
                                fputcsv($csv, [
                                    $record->name,
                                    $record->email,
                                    $record->npm,
                                    $record->semester,
                                    $record->kelas,
                                    $record->program_studi,
                                    $record->fakultas,
                                    $record->universitas,
                                    $record->wa_number,
                                    $record->alamat,
                                ]);
                            }

                            fclose($csv);
                        }, 'data-siswa-all-' . now()->format('Ymd_His') . '.csv');
                    }),

                Action::make('download_all_pdf')
                    ->label('Download Semua (PDF)')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(function () {
                        $query = User::query()->where('role', 'student');
                        if (auth()->user() && auth()->user()->hasRole('mentor')) {
                            $query->whereHas('enrollments.course', function ($q) {
                                $q->where('user_id', auth()->id());
                            });
                        }
                        $students = $query->get();

                        $pdf = Pdf::loadView('filament.students.print_all', ['students' => $students]);
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'data-siswa-all-' . now()->format('Ymd_His') . '.pdf', [
                            'Content-Type' => 'application/pdf',
                        ]);
                    }),

                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('export')
                        ->label('Export CSV')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (Collection $records) {
                            return response()->streamDownload(function () use ($records) {
                                $csv = fopen('php://output', 'w');
                                fputcsv($csv, [
                                    'Nama', 'Email', 'NPM', 'Semester', 'Kelas', 'Program Studi', 'Fakultas', 'Universitas', 'Nomor WA', 'Alamat'
                                ]);

                                foreach ($records as $record) {
                                    fputcsv($csv, [
                                        $record->name,
                                        $record->email,
                                        $record->npm,
                                        $record->semester,
                                        $record->kelas,
                                        $record->program_studi,
                                        $record->fakultas,
                                        $record->universitas,
                                        $record->wa_number,
                                        $record->alamat,
                                    ]);
                                }

                                fclose($csv);
                            }, 'data-siswa-' . now()->format('Ymd_His') . '.csv');
                        }),
                ]),
            ]);
    }
}

