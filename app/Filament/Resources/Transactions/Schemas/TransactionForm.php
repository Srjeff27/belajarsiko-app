<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')->relationship('user', 'name')->label('Mahasiswa')->disabled(),
                Select::make('course_id')->relationship('course', 'title')->label('Kelas')->disabled(),
                TextInput::make('amount')->label('Jumlah')->numeric()->disabled(),
                TextInput::make('status')->label('Status')->disabled(),
                TextInput::make('payer_name')->label('Nama Pengirim')->disabled(),
                TextInput::make('payer_bank')->label('Bank/E-Wallet')->disabled(),
                Textarea::make('admin_notes')->label('Catatan Admin'),
                DateTimePicker::make('verified_at')->label('Diverifikasi Pada')->disabled(),
            ]);
    }
}

