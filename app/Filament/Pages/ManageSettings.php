<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.manage-settings';

    protected static ?string $navigationLabel = 'Configurações';
    protected static ?string $navigationGroup = 'Sistema';
    protected static ?int $navigationSort = 2;

    protected static ?string $title = 'Configurações do Site';
    
    protected static ?string $slug = 'settings';

    public ?array $data = [];

    public function mount(): void
    {
        // Load settings into the form data
        $this->form->fill([
            'site_name' => Setting::get('site_name', 'InforAgro'),
            'gtm_id' => Setting::get('gtm_id'),
            'adsense_code' => Setting::get('adsense_code'),
            'custom_head_code' => Setting::get('custom_head_code'),
            'custom_body_code' => Setting::get('custom_body_code'),
            'social_instagram' => Setting::get('social_instagram'),
            'social_x' => Setting::get('social_x'),
            'social_linkedin' => Setting::get('social_linkedin'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Geral')
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Nome do Site')
                            ->required(),
                    ]),
                
                Section::make('Códigos Externos (Scripts)')
                    ->schema([
                        TextInput::make('gtm_id')
                            ->label('Google Tag Manager (GTM ID)')
                            ->placeholder('GTM-XXXXXX')
                            ->helperText('Apenas o ID.'),
                        
                        Textarea::make('adsense_code')
                            ->label('Código do AdSense')
                            ->rows(3)
                            ->helperText('Script completo fornecido pelo Google.'),

                        Textarea::make('custom_head_code')
                            ->label('HTML Personalizado (HEAD)')
                            ->rows(4)
                            ->helperText('Scripts adicionais para serem inseridos antes do fechamento de </head>.'),

                        Textarea::make('custom_body_code')
                            ->label('HTML Personalizado (BODY)')
                            ->rows(4)
                            ->helperText('Scripts adicionais para serem inseridos antes do fechamento de </body>.'),
                    ]),

                Section::make('Redes Sociais')
                    ->schema([
                        TextInput::make('social_instagram')->label('Instagram URL')->url(),
                        TextInput::make('social_x')->label('X (Twitter) URL')->url(),
                        TextInput::make('social_linkedin')->label('LinkedIn URL')->url(),
                    ])->columns(3),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        // "Save" action
        $state = $this->form->getState();

        foreach ($state as $key => $value) {
            Setting::set($key, $value);
        }

        Notification::make()
            ->title('Configurações salvas com sucesso!')
            ->success()
            ->send();
    }
}
