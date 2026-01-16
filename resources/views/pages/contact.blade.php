<x-layout>
    <x-slot:title>{{ $pageTitle ?? 'Contato | InfoRagro' }}</x-slot>

    <section class="page-content py-12">
        <div class="container mx-auto px-4 max-w-4xl">
            <header class="page-header mb-8 text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Contato</h1>
                <p class="text-xl text-gray-600">Entre em contato com a equipe do InfoRagro</p>
            </header>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Informações de Contato -->
                <div class="contact-info md:col-span-1">
                    <h2 class="text-xl font-bold mb-4">Fale Conosco</h2>
                    <p class="mb-4 text-gray-700">Estamos sempre abertos para ouvir você. Entre em contato para:</p>
                    <ul class="list-disc pl-5 mb-6 text-gray-700 space-y-1">
                        <li>Sugestões de pautas</li>
                        <li>Parcerias comerciais</li>
                        <li>Dúvidas sobre nosso conteúdo</li>
                        <li>Reportar erros ou correções</li>
                    </ul>
                    
                    <div class="contact-channels space-y-4">
                        <div class="flex items-start">
                            <span class="text-2xl mr-3">📧</span>
                            <div>
                                <strong class="block text-gray-900">E-mail</strong>
                                <a href="mailto:contato@inforagro.com.br" class="text-primary hover:underline">contato@inforagro.com.br</a>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <span class="text-2xl mr-3">📍</span>
                            <div>
                                <strong class="block text-gray-900">Localização</strong>
                                <p class="text-gray-700">São Paulo, Brasil</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Formulário -->
                <div class="contact-form-wrapper md:col-span-2 bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    @if($success)
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                        <strong>Mensagem enviada!</strong> Obrigado pelo contato. Responderemos em breve.
                    </div>
                    @endif
                    
                    <form action="{{ route('page.contact.send') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome *</label>
                            <input type="text" id="name" name="name" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail *</label>
                            <input type="email" id="email" name="email" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Assunto</label>
                            <select id="subject" name="subject" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                <option value="geral">Dúvida Geral</option>
                                <option value="pauta">Sugestão de Pauta</option>
                                <option value="parceria">Parceria Comercial</option>
                                <option value="correcao">Correção de Conteúdo</option>
                                <option value="outro">Outro</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Mensagem *</label>
                            <textarea id="message" name="message" rows="5" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"></textarea>
                        </div>
                        
                        <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-3 px-4 rounded transition duration-150">
                            Enviar Mensagem
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-layout>
