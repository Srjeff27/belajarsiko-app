<?php

namespace App\Filament\Resources\CertificateSettings;

use App\Models\CertificateSetting;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;

class CertificateSettingResource extends Resource
{
    protected static ?string $model = CertificateSetting::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedFingerPrint;
    protected static string|\UnitEnum|null $navigationGroup = 'Sertifikat';
    protected static ?string $navigationLabel = 'Pengaturan Sertifikat';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\TextInput::make('director_name')->label('Director of BelajarSiko')->required(),
            Forms\Components\FileUpload::make('director_signature')->label('Tanda Tangan Director (PNG/JPG)')->image()->directory('signatures')->disk('public')->visibility('public'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('director_name')->label('Director'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime('d M Y H:i')->label('Diubah'),
            ])
            ->recordActions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCertificateSettings::route('/'),
        ];
    }
}
