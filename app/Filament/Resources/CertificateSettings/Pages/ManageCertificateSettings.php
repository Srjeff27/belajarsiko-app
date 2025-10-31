<?php

namespace App\Filament\Resources\CertificateSettings\Pages;

use App\Filament\Resources\CertificateSettings\CertificateSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCertificateSettings extends ManageRecords
{
    protected static string $resource = CertificateSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

