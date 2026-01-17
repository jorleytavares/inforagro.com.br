<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaResource\Pages;
use App\Models\Media;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $modelLabel = 'Mídia';
    protected static ?string $pluralModelLabel = 'Biblioteca de Mídias';
    protected static ?string $navigationLabel = 'Mídia';
    protected static ?string $navigationGroup = 'Conteúdo';
    protected static ?int $navigationSort = 4;
    protected static ?string $slug = 'midia';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Arquivo')
                    ->schema([
                        Forms\Components\FileUpload::make('file_path')
                            ->label('Arquivo')
                            ->directory('media')
                            ->openable()
                            ->downloadable()
                            ->preserveFilenames(false)
                            ->required(),
                    ]),

                Forms\Components\Section::make('Metadados')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Título')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('alt_text')
                            ->label('Texto alternativo (ALT)')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('file_path')
                    ->label('Prévia')
                    ->disk(fn (Media $record) => $record->disk ?: config('filesystems.default'))
                    ->size(64),
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('mime_type')
                    ->label('Tipo')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('size')
                    ->label('Tamanho (KB)')
                    ->formatStateUsing(fn (?int $state): ?string => $state ? number_format($state / 1024, 1, ',', '.') : null)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Enviado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('only_images')
                    ->label('Apenas imagens')
                    ->queries(
                        true: fn (Builder $query) => $query->where('mime_type', 'like', 'image/%'),
                        false: fn (Builder $query) => $query->where('mime_type', 'not like', 'image/%'),
                        blank: fn (Builder $query) => $query,
                    ),
                Tables\Filters\Filter::make('created_at')
                    ->label('Data de envio')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('De'),
                        Forms\Components\DatePicker::make('until')->label('Até'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['until'] ?? null, fn (Builder $q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'edit' => Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}
