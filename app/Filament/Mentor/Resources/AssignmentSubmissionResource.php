<?php

namespace App\Filament\Mentor\Resources;

use App\Models\AssignmentSubmission;
use App\Models\Course;
use App\Models\Lesson;
use App\Filament\Mentor\Resources\AssignmentSubmissionResource\Pages;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AssignmentSubmissionResource extends Resource
{
    protected static ?string $model = AssignmentSubmission::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;
    protected static string|\UnitEnum|null $navigationGroup = 'Tugas';
    protected static ?string $navigationLabel = 'Pengumpulan Tugas';
    protected static ?string $pluralModelLabel = 'Pengumpulan Tugas';
    protected static ?string $modelLabel = 'Pengumpulan Tugas';

    public static function form(Schema $schema): Schema
    {
        // Not used in mentor panel; grading handled via table action
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('assignment.lesson.course.title')->label('Kelas')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('assignment.lesson.title')->label('Materi')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('assignment.title')->label('Tugas')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('user.name')->label('Mahasiswa')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('google_drive_link')->label('Link')->url(fn($record) => $record->google_drive_link, true)->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('grade')->label('Nilai'),
                Tables\Columns\TextColumn::make('feedback_comment')->label('Feedback')->limit(50),
                Tables\Columns\TextColumn::make('submitted_at')->dateTime('d M Y H:i')->label('Dikirim'),
            ])
            ->filters([
                Tables\Filters\Filter::make('kelas_materi')
                    ->form([
                        Forms\Components\Select::make('course_id')
                            ->label('Kelas')
                            ->options(function () {
                                return Course::query()
                                    ->where('user_id', auth()->id())
                                    ->orderBy('title')
                                    ->pluck('title', 'id')
                                    ->toArray();
                            })
                            ->searchable()
                            ->preload()
                            ->reactive(),

                        Forms\Components\Select::make('lesson_id')
                            ->label('Materi')
                            ->options(function ($get) {
                                $courseId = $get('course_id');
                                if (!$courseId) {
                                    return [];
                                }
                                return Lesson::query()
                                    ->where('course_id', $courseId)
                                    ->orderBy('title')
                                    ->pluck('title', 'id')
                                    ->toArray();
                            })
                            ->searchable()
                            ->preload()
                            ->disabled(fn ($get) => ! $get('course_id'))
                            ->reactive(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        $courseId = $data['course_id'] ?? null;
                        $lessonId = $data['lesson_id'] ?? null;

                        if ($courseId) {
                            $query->whereHas('assignment.lesson.course', function ($q) use ($courseId) {
                                $q->where('id', $courseId);
                            });
                        }

                        if ($lessonId) {
                            $query->whereHas('assignment.lesson', function ($q) use ($lessonId) {
                                $q->where('id', $lessonId);
                            });
                        }
                    }),

                Tables\Filters\SelectFilter::make('grading_status')
                    ->label('Status Nilai')
                    ->options([
                        'graded' => 'Sudah dinilai',
                        'ungraded' => 'Belum dinilai',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (empty($data['value'])) {
                            return;
                        }
                        if ($data['value'] === 'graded') {
                            $query->whereNotNull('grade');
                        } elseif ($data['value'] === 'ungraded') {
                            $query->whereNull('grade');
                        }
                    }),
            ])
            ->recordActions([
                Actions\Action::make('nilai')
                    ->label('Nilai')
                    ->icon('heroicon-o-pencil-square')
                    ->form([
                        Forms\Components\TextInput::make('grade')->label('Nilai')->numeric()->minValue(0)->maxValue(100)->required(),
                        Forms\Components\Textarea::make('feedback_comment')->label('Komentar/Feedback'),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'grade' => $data['grade'],
                            'feedback_comment' => $data['feedback_comment'] ?? null,
                        ]);
                        \Filament\Notifications\Notification::make()
                            ->title('Nilai tersimpan.')
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('assignment.lesson.course', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->with(['assignment.lesson.course', 'user']);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        // Only index/listing for mentor; grading via row action
        return [
            'index' => Pages\ListAssignmentSubmissions::route('/'),
        ];
    }
}
