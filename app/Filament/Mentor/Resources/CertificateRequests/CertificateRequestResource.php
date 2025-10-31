<?php

namespace App\Filament\Mentor\Resources\CertificateRequests;

use App\Filament\Mentor\Resources\CertificateRequests\Pages\ListCertificateRequests;
use App\Models\Certificate;
use App\Models\CertificateRequest;
use App\Models\Course;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Actions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;

class CertificateRequestResource extends Resource
{
    protected static ?string $model = CertificateRequest::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedQueueList;
    protected static string|\UnitEnum|null $navigationGroup = 'Sertifikat';
    protected static ?string $navigationLabel = 'Permintaan Sertifikat';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Siswa')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('course.title')->label('Kelas')->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('status')->colors([
                    'warning' => 'pending',
                    'success' => 'approved',
                    'danger' => 'rejected',
                ])->label('Status'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y H:i')->label('Diajukan'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                ])->default('pending'),
            ])
            ->recordActions([
                Actions\Action::make('apply')
                    ->label('Apply Sertifikat')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->action(function (CertificateRequest $record) {
                        Certificate::firstOrCreate([
                            'user_id' => $record->user_id,
                            'course_id' => $record->course_id,
                        ], [
                            'generated_at' => now(),
                            'unique_code' => Str::upper(Str::random(10)),
                        ]);
                        $record->update(['status' => 'approved']);
                        Notification::make()->title('Sertifikat dibuat.')->success()->send();
                    }),
                Actions\DeleteAction::make()->label('Hapus'),
            ])
            ->toolbarActions([
                Actions\Action::make('apply_all')
                    ->label('Apply Semua')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->action(function () {
                        $courseIds = Course::where('user_id', auth()->id())->pluck('id');
                        $count = 0;
                        CertificateRequest::query()->where('status', 'pending')->whereIn('course_id', $courseIds)->each(function ($req) use (&$count) {
                            Certificate::firstOrCreate([
                                'user_id' => $req->user_id,
                                'course_id' => $req->course_id,
                            ], [
                                'generated_at' => now(),
                                'unique_code' => Str::upper(Str::random(10)),
                            ]);
                            $req->update(['status' => 'approved']);
                            $count++;
                        });
                        Notification::make()->title("$count sertifikat disetujui.")->success()->send();
                    }),
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
            'index' => ListCertificateRequests::route('/'),
        ];
    }
}
