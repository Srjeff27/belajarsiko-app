<?php

namespace App\Filament\Mentor\Resources\AssignmentSubmissionResource\Pages;

use App\Filament\Mentor\Resources\AssignmentSubmissionResource;
use Filament\Resources\Pages\ListRecords;

class ListAssignmentSubmissions extends ListRecords
{
    protected static string $resource = AssignmentSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        // Mentor tidak membuat pengumpulan; hanya melihat/menilai
        return [];
    }
}

