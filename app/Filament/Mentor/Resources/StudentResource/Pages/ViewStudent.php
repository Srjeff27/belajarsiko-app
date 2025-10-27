<?php

namespace App\Filament\Mentor\Resources\StudentResource\Pages;

use App\Filament\Mentor\Resources\StudentResource;
use Filament\Resources\Pages\ViewRecord;

class ViewStudent extends ViewRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        // No edit/create from mentor view; read-only
        return [];
    }
}
