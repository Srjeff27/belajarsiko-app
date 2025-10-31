<?php

namespace App\Filament\Mentor\Resources;

use App\Filament\Mentor\Resources\DiscussionResource\Pages;
use App\Filament\Mentor\Resources\DiscussionResource\RelationManagers\CommentsRelationManager;
use App\Models\Course;
use App\Models\Discussion;
use App\Models\Lesson;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DiscussionResource extends Resource
{
    protected static ?string $model = Discussion::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;
    protected static string|\UnitEnum|null $navigationGroup = 'Diskusi';
    protected static ?string $navigationLabel = 'Diskusi';
    protected static ?string $pluralModelLabel = 'Diskusi';
    protected static ?string $modelLabel = 'Diskusi';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\Select::make('lesson_id')->label('Materi')->relationship('lesson', 'title')->required(),
            Forms\Components\Textarea::make('content')->label('Isi')->required()->rows(4),
            Forms\Components\TextInput::make('google_drive_link')->label('Link Google Drive')->url()->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lesson.course.title')->label('Kelas')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('lesson.title')->label('Materi')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('user.name')->label('Pengirim')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('content')->label('Isi')->limit(80),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y H:i')->label('Dibuat'),
            ])
            ->filters([
                Tables\Filters\Filter::make('kelas_materi')
                    ->form([
                        Forms\Components\Select::make('course_id')
                            ->label('Kelas')
                            ->options(fn () => Course::query()->where('user_id', auth()->id())->orderBy('title')->pluck('title', 'id')->toArray())
                            ->searchable()->preload()->reactive(),
                        Forms\Components\Select::make('lesson_id')
                            ->label('Materi')
                            ->options(function ($get) {
                                $courseId = $get('course_id');
                                if (! $courseId) return [];
                                return Lesson::query()->where('course_id', $courseId)->orderBy('title')->pluck('title', 'id')->toArray();
                            })
                            ->disabled(fn ($get) => ! $get('course_id'))
                            ->searchable()->preload()->reactive(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['course_id'])) {
                            $query->whereHas('lesson.course', fn ($q) => $q->where('id', $data['course_id']));
                        }
                        if (!empty($data['lesson_id'])) {
                            $query->whereHas('lesson', fn ($q) => $q->where('id', $data['lesson_id']));
                        }
                    }),
            ])
            ->recordActions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\Action::make('reply')
                    ->label('Balas')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->form([
                        Forms\Components\Textarea::make('content')->label('Komentar')->required()->rows(3),
                        Forms\Components\TextInput::make('google_drive_link')->label('Link Google Drive')->url()->nullable(),
                    ])
                    ->action(function ($record, array $data) {
                        \App\Models\DiscussionComment::create([
                            'discussion_id' => $record->id,
                            'user_id' => auth()->id(),
                            'content' => $data['content'],
                            'google_drive_link' => $data['google_drive_link'] ?? null,
                        ]);
                    }),
                Actions\DeleteAction::make(),
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
            CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDiscussions::route('/'),
            'view' => Pages\ViewDiscussion::route('/{record}'),
        ];
    }
}
