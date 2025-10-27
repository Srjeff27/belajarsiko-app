<?php

namespace App\Filament\Mentor\Resources\CourseResource\Pages;

use App\Filament\Mentor\Resources\CourseResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCourse extends EditRecord
{
    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('submitForReview')
                ->label('Ajukan Review')
                ->visible(fn() => $this->record->status === 'draft')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update(['status' => 'pending_review']);
                    $this->notify('success', 'Kursus diajukan untuk review.');
                }),
            DeleteAction::make(),
        ];
    }
}

