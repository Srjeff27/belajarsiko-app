<?php

namespace App\Filament\Resources\CourseCertificates\Pages;

use App\Filament\Resources\CourseCertificates\CourseCertificateResource;
use Filament\Resources\Pages\ManageRecords;

class ManageCourseCertificates extends ManageRecords
{
    protected static string $resource = CourseCertificateResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

