<?php

namespace App\Filament\Mentor\Resources\StudentResource\Pages;

use App\Filament\Mentor\Resources\StudentResource;
use Filament\Resources\Pages\ListRecords;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

