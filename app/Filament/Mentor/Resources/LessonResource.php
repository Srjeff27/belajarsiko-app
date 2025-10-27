<?php

namespace App\Filament\Mentor\Resources;

use App\Filament\Mentor\Resources\LessonResource\Pages\CreateLesson;
use App\Filament\Mentor\Resources\LessonResource\Pages\EditLesson;
use App\Filament\Mentor\Resources\LessonResource\Pages\ListLessons;
use App\Filament\Mentor\Resources\LessonResource\RelationManagers\AssignmentsRelationManager;
use App\Models\Lesson;
use Filament\Forms;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;
    protected static string|\UnitEnum|null $navigationGroup = 'Pembelajaran';
    protected static ?string $navigationLabel = 'Materi';
    protected static ?string $pluralModelLabel = 'Materi';
    protected static ?string $modelLabel = 'Materi';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\Select::make('course_id')
                ->relationship('course', 'title')
                ->label('Kelas')
                ->searchable()
                ->preload()
                ->required()
                ->options(fn() => \App\Models\Course::where('user_id', auth()->id())->pluck('title', 'id')),
            Forms\Components\TextInput::make('title')->label('Judul')->required(),
            Forms\Components\Select::make('lesson_type')->label('Tipe Materi')->options([
                'video' => 'Video',
                'ebook' => 'E-book',
            ])->required(),
            Forms\Components\TextInput::make('content_url')->label('URL Konten')->required(),
            Forms\Components\TextInput::make('position')->numeric()->default(0)->label('Urutan'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('course.title')->label('Kelas')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('title')->label('Judul')->sortable()->searchable(),
                Tables\Columns\BadgeColumn::make('lesson_type')->label('Tipe'),
                Tables\Columns\TextColumn::make('position')->label('Urutan')->sortable(),
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
        return parent::getEloquentQuery()->whereHas('course', function ($q) {
            $q->where('user_id', auth()->id());
        });
    }

    public static function getRelations(): array
    {
        return [
            AssignmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLessons::route('/'),
            'create' => CreateLesson::route('/create'),
            'edit' => EditLesson::route('/{record}/edit'),
        ];
    }
}

