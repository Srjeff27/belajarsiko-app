<?php

namespace App\Filament\Resources;

use App\Models\CourseCategory;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class CourseCategoryResource extends Resource
{
    protected static ?string $model = CourseCategory::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;
    protected static string|\UnitEnum|null $navigationGroup = 'Kelas';
    protected static ?string $navigationLabel = 'Kategori Kelas';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\TextInput::make('name')->label('Nama')->required()->maxLength(100)
                ->live(true)
                ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state))),
            Forms\Components\TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('slug')->label('Slug')->copyable(),
            Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y')->label('Dibuat'),
        ])->actions([
            Actions\EditAction::make(),
        ])->bulkActions([
            Actions\BulkActionGroup::make([
                Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => CourseCategoryResource\Pages\ListCourseCategories::route('/'),
            'create' => CourseCategoryResource\Pages\CreateCourseCategory::route('/create'),
            'edit' => CourseCategoryResource\Pages\EditCourseCategory::route('/{record}/edit'),
        ];
    }
}
