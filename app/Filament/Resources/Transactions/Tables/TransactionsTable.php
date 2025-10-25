<?php

namespace App\Filament\Resources\Transactions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\Action;

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Mahasiswa')->sortable()->searchable(),
                TextColumn::make('course.title')->label('Kelas')->sortable()->searchable(),
                TextColumn::make('amount')->money('IDR', true)->label('Jumlah'),
                BadgeColumn::make('status')->colors([
                    'warning' => 'waiting_verification',
                    'success' => 'completed',
                    'danger' => 'failed',
                    'gray' => 'pending',
                ])->label('Status'),
                TextColumn::make('created_at')->dateTime('d M Y H:i')->label('Dibuat'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('view_proof')
                    ->label('Lihat Bukti')
                    ->icon('heroicon-o-photo')
                    ->visible(fn($record) => !empty($record->payment_proof_path))
                    ->url(fn($record) => route('admin.transactions.proof', $record), true),
                Action::make('approve')
                    ->label('Approve')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn($record) => $record->status === 'waiting_verification')
                    ->action(function ($record) {
                        \DB::transaction(function () use ($record) {
                            $record->update([
                                'status' => 'completed',
                                'verified_at' => now(),
                            ]);
                            if ($record->course_id && $record->user_id) {
                                \App\Models\Enrollment::firstOrCreate([
                                    'user_id' => $record->user_id,
                                    'course_id' => $record->course_id,
                                ]);
                            }
                        });
                    }),
                Action::make('reject')
                    ->label('Reject')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn($record) => $record->status === 'waiting_verification')
                    ->form([
                        \Filament\Forms\Components\Textarea::make('admin_notes')->label('Catatan Admin'),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'status' => 'failed',
                            'admin_notes' => $data['admin_notes'] ?? null,
                            'verified_at' => now(),
                        ]);
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

