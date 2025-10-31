<?php

namespace App\Filament\Mentor\Resources\CertificateRequests\Pages;

use App\Filament\Mentor\Resources\CertificateRequests\CertificateRequestResource;
use Filament\Resources\Pages\ListRecords;

class ListCertificateRequests extends ListRecords
{
    protected static string $resource = CertificateRequestResource::class;
}

