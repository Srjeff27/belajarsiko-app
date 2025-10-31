<?php

namespace App\Filament\Resources\DiscussionResource\RelationManagers;

use Filament\Actions;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';
    protected static ?string $title = 'Komentar';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\Textarea::make('content')->label('Komentar')->required()->rows(3),
            Forms\Components\TextInput::make('google_drive_link')->label('Link Google Drive')->url()->nullable(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('User')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('content')->label('Komentar')->limit(80),
                Tables\Columns\TextColumn::make('google_drive_link')->label('Lampiran')->url(fn($record) => $record->google_drive_link, true)->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y H:i')->label('Dibuat'),
            ])
            ->headerActions([
                Actions\CreateAction::make()
                    ->label('Balas')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['user_id'] = auth()->id();
                        return $data;
                    }),
            ])
            ->recordActions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ]);
    }
}

