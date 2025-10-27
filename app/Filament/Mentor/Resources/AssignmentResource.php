<?php

namespace App\Filament\Mentor\Resources;

use App\Filament\Mentor\Resources\AssignmentResource\Pages\EditAssignment;
use App\Filament\Mentor\Resources\AssignmentResource\Pages\ListAssignments;
use App\Filament\Mentor\Resources\AssignmentResource\Pages\CreateAssignment;
use App\Filament\Mentor\Resources\AssignmentResource\RelationManagers\SubmissionsRelationManager;
use App\Models\Assignment;
use Filament\Forms;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AssignmentResource extends Resource
{
    protected static ?string $model = Assignment::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;
    protected static string|\UnitEnum|null $navigationGroup = 'Pembelajaran';
    protected static ?string $navigationLabel = 'Tugas';
    protected static ?string $pluralModelLabel = 'Tugas';
    protected static ?string $modelLabel = 'Tugas';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\Select::make('lesson_id')
                ->relationship('lesson', 'title')
                ->label('Materi')
                ->required()
                ->options(fn() => \App\Models\Lesson::whereHas('course', fn($q) => $q->where('user_id', auth()->id()))->pluck('title', 'id')),
            Forms\Components\TextInput::make('title')->label('Judul')->required(),
            Forms\Components\Textarea::make('description')->label('Instruksi'),
            Forms\Components\DateTimePicker::make('due_date')->label('Batas Waktu'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lesson.title')->label('Materi')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('title')->label('Judul')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('due_date')->dateTime('d M Y H:i')->label('Batas Waktu'),
            ])
            ->recordActions([
                Actions\EditAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('lesson.course', function ($q) {
            $q->where('user_id', auth()->id());
        });
    }

    public static function getRelations(): array
    {
        return [
            SubmissionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssignments::route('/'),
            'create' => CreateAssignment::route('/create'),
            'edit' => EditAssignment::route('/{record}/edit'),
        ];
    }
}

