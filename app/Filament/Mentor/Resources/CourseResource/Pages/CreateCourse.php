<?php

namespace App\Filament\Mentor\Resources\CourseResource\Pages;

use App\Filament\Mentor\Resources\CourseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCourse extends CreateRecord
{
    protected static string $resource = CourseResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['status'] = $data['status'] ?? 'draft';
        return $data;
    }
}

