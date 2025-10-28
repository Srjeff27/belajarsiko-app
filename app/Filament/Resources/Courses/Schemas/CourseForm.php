<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use App\Models\CourseCategory;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_category_id')
                    ->label('Kategori')
                    ->options(fn () => CourseCategory::query()->orderBy('name')->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(5),
                FileUpload::make('thumbnail')
                    ->label('Thumbnail')
                    ->image()
                    ->directory('thumbnails')
                    ->disk('public')
                    ->visibility('public'),
                TextInput::make('price')
                    ->label('Harga')
                    ->numeric()
                    ->required()
                    ->default(0),
                Toggle::make('is_premium')
                    ->label('Premium')
                    ->default(false),
            ]);
    }
}
