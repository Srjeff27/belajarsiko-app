<?php

namespace App\Filament\Mentor\Pages;

use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Filament\Forms;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class CertificateSettings extends Page implements HasForms
{
    use InteractsWithForms;
    use InteractsWithActions;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedFingerPrint;
    protected static ?string $navigationLabel = 'Pengaturan Sertifikat';
    protected static string|\UnitEnum|null $navigationGroup = 'Sertifikat';
    protected static ?string $title = 'Pengaturan Sertifikat';

    protected string $view = 'filament.mentor.pages.certificate-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();
        $this->form->fill([
            'certificate_signature_name' => $user->certificate_signature_name,
            'certificate_signature' => $user->certificate_signature,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('certificate_signature_name')
                    ->label('Nama pada Sertifikat')
                    ->placeholder('Kosongkan untuk pakai nama akun mentor'),
                Forms\Components\FileUpload::make('certificate_signature')
                    ->label('Tanda Tangan Mentor (PNG/JPG)')
                    ->image()
                    ->directory('signatures')
                    ->disk('public')
                    ->visibility('public'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $user = Auth::user();
        $user->fill($this->form->getState());
        $user->save();

        Notification::make()->title('Pengaturan tersimpan.')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan')
                ->submit('save')
                ->color('primary')
                ->icon('heroicon-o-check'),
        ];
    }
}
