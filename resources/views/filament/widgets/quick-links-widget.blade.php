<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex flex-col gap-4">
            <h2 class="text-lg font-bold tracking-tight text-gray-950 dark:text-white">
                Atalhos Rápidos
            </h2>
            
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                <a href="{{ \App\Filament\Resources\PostResource::getUrl('create') }}" 
                   class="flex items-center justify-center p-4 text-sm font-medium transition-all border rounded-xl hover:bg-primary-50 hover:border-primary-200 dark:hover:bg-primary-900/10 dark:hover:border-primary-800 border-gray-200 dark:border-gray-700 text-primary-600 dark:text-primary-400 gap-3 shadow-sm hover:shadow-md">
                   <x-heroicon-m-pencil-square class="w-6 h-6" />
                   <span>Escrever Novo Post</span>
                </a>

                <a href="{{ \App\Filament\Resources\PostResource::getUrl('index') }}" 
                   class="flex items-center justify-center p-4 text-sm font-medium transition-all border rounded-xl hover:bg-gray-50 hover:border-gray-300 dark:hover:bg-gray-800 dark:hover:border-gray-600 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 gap-3 shadow-sm hover:shadow-md">
                   <x-heroicon-m-document-text class="w-6 h-6" />
                   <span>Gerenciar Posts</span>
                </a>

                 <a href="{{ \App\Filament\Resources\UserResource::getUrl('create') }}" 
                   class="flex items-center justify-center p-4 text-sm font-medium transition-all border rounded-xl hover:bg-gray-50 hover:border-gray-300 dark:hover:bg-gray-800 dark:hover:border-gray-600 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 gap-3 shadow-sm hover:shadow-md">
                   <x-heroicon-m-user-plus class="w-6 h-6" />
                   <span>Adicionar Usuário</span>
                </a>
               
                 <a href="/" target="_blank"
                   class="flex items-center justify-center p-4 text-sm font-medium transition-all border rounded-xl hover:bg-gray-50 hover:border-gray-300 dark:hover:bg-gray-800 dark:hover:border-gray-600 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 gap-3 shadow-sm hover:shadow-md">
                   <x-heroicon-m-globe-alt class="w-6 h-6" />
                   <span>Ver Site</span>
                </a>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
