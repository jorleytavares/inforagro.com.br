<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Artigo';
    protected static ?string $pluralModelLabel = 'Artigos';
    protected static ?string $navigationLabel = 'Artigos';
    protected static ?string $slug = 'artigos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3) // Cria um grid de 3 colunas

                    ->schema([
                        // COLUNA PRINCIPAL (Esqueda via ocupar 2/3)
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make('Conteúdo Principal')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Título')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),

                                        Forms\Components\TextInput::make('slug')
                                            ->label('Slug (URL)')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true),
                                            
                                        Forms\Components\TextInput::make('subtitle')
                                            ->label('Subtítulo')
                                            ->maxLength(255),

                                        Forms\Components\RichEditor::make('content')
                                            ->label('Conteúdo')
                                            ->required()
                                            ->columnSpanFull(),
                                    ]),

                                    
                        Forms\Components\Section::make('SEO & Metadados')
                            ->collapsed()
                            ->schema([
                                Forms\Components\TextInput::make('meta_title')
                                    ->label('Meta Título')
                                    ->maxLength(60)
                                    ->helperText('Título que aparecerá nos resultados de busca (máx 60 caracteres)'),
                                
                                Forms\Components\Textarea::make('meta_description')
                                    ->label('Meta Descrição')
                                    ->maxLength(160)
                                    ->helperText('Resumo para motores de busca (máx 160 caracteres)'),

                                Forms\Components\TextInput::make('focus_keyword')
                                    ->label('Palavra-chave Foco')
                                    ->maxLength(255),

                                Forms\Components\Textarea::make('meta_schema')
                                    ->label('Schema (JSON-LD)')
                                    ->rows(5)
                                    ->helperText('Insira o JSON-LD customizado aqui, se necessário'),
                            ]),
                    ])
                            ->columnSpan(2), // Ocupa 2 colunas

                        // COLUNA LATERAL (Direita vai ocupar 1/3)
                        Forms\Components\Group::make()
                            ->schema([
                                // Seção de Publicação
                                Forms\Components\Section::make('Publicação')
                                    ->schema([
                                        Forms\Components\Select::make('status')
                                            ->label('Status')
                                            ->options([
                                                'draft' => 'Rascunho',
                                                'published' => 'Publicado',
                                            ])
                                            ->default('draft')
                                            ->required()
                                            ->native(false), // Estilo melhor para select

                                        Forms\Components\DateTimePicker::make('published_at')
                                            ->label('Data de Publicação')
                                            ->default(now()),

                                        Forms\Components\Select::make('author_id')
                                            ->label('Autor')
                                            ->relationship('author', 'name')
                                            ->default(fn () => auth()->id())
                                            ->required()
                                            ->searchable(),
                                    ]),

                                // Seção de Taxonomias (Categoria e Tags)
                                Forms\Components\Section::make('Associações')
                                    ->schema([
                                        Forms\Components\Select::make('category_id')
                                            ->label('Categoria')
                                            ->relationship('category', 'name')
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name')
                                                    ->required()
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                                                Forms\Components\TextInput::make('slug')->required(),
                                            ]),

                                        Forms\Components\Select::make('tags')
                                            ->label('Tags')
                                            ->relationship('tags', 'name')
                                            ->multiple()
                                            ->searchable()
                                            ->preload()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name')
                                                    ->required()
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn (Forms\Set $set, $state) => $set('slug', \Illuminate\Support\Str::slug($state))),
                                                Forms\Components\TextInput::make('slug')
                                                    ->required()
                                                    ->unique('tags', 'slug'),
                                            ])
                                            ->createOptionUsing(function (string $data) {
                                                return \App\Models\Tag::create([
                                                    'name' => $data,
                                                    'slug' => \Illuminate\Support\Str::slug($data),
                                                ])->getKey();
                                            }),
                                    ]),
                                
                                // Seção de Imagem Destacada
                                Forms\Components\Section::make('Mídia')
                                    ->schema([
                                        Forms\Components\FileUpload::make('featured_image')
                                            ->label('Imagem Destacada')
                                            ->image()
                                            ->directory('uploads')
                                            ->imageEditor(), // Adiciona editor de imagem simples

                                        Forms\Components\TextInput::make('featured_image_caption')
                                            ->label('Legenda da Imagem')
                                            ->maxLength(255),
                                    ]),
                            ])
                            ->columnSpan(1), // Ocupa 1 coluna
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Imagem'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->wrap(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoria')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Rascunho',
                        'published' => 'Publicado',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                    }),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publicado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
            ])
            ->actions([
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
