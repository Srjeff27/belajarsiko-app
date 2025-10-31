<?php

namespace App\Filament\Resources\CertificateRequests\Pages;

use App\Filament\Resources\CertificateRequests\CertificateRequestResource;
use Filament\Resources\Pages\ListRecords;

class ListCertificateRequests extends ListRecords
{
    protected static string $resource = CertificateRequestResource::class;
}

