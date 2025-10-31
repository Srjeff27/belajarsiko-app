<?php

namespace App\Filament\Mentor\Resources\Certificates\Pages;

use App\Filament\Mentor\Resources\Certificates\CertificateResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCertificates extends ManageRecords
{
    protected static string $resource = CertificateResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
