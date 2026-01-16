<x-layout>
    <x-slot:title>{{ $pageTitle ?? 'Política de Privacidade | InfoRagro' }}</x-slot>

    <section class="page-content py-12">
        <div class="container mx-auto px-4 max-w-4xl">
            <header class="page-header mb-8 text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Política de Privacidade</h1>
                <p class="text-xl text-gray-600">Última atualização: {{ date('d/m/Y') }}</p>
            </header>
            
            <div class="content-body prose prose-lg mx-auto text-gray-700">
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">1. Informações que Coletamos</h2>
                <p class="mb-4">O InfoRagro coleta informações para fornecer melhor experiência aos nossos usuários. As informações coletadas incluem:</p>
                <ul class="list-disc pl-6 mb-4 space-y-2">
                    <li><strong>Informações fornecidas por você:</strong> Nome e e-mail quando você se inscreve na newsletter ou entra em contato conosco.</li>
                    <li><strong>Informações de uso:</strong> Dados sobre como você acessa e usa nosso site, incluindo páginas visitadas e tempo de permanência.</li>
                    <li><strong>Cookies:</strong> Utilizamos cookies para melhorar sua experiência e exibir anúncios relevantes.</li>
                </ul>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">2. Como Usamos suas Informações</h2>
                <p class="mb-4">Utilizamos as informações coletadas para:</p>
                <ul class="list-disc pl-6 mb-4 space-y-2">
                    <li>Enviar nossa newsletter com notícias do agronegócio</li>
                    <li>Responder suas mensagens e solicitações</li>
                    <li>Melhorar nosso conteúdo e experiência do usuário</li>
                    <li>Exibir anúncios personalizados através do Google AdSense</li>
                    <li>Analisar o tráfego do site através do Google Analytics</li>
                </ul>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">3. Compartilhamento de Informações</h2>
                <p class="mb-4">Não vendemos, alugamos ou compartilhamos suas informações pessoais com terceiros, exceto:</p>
                <ul class="list-disc pl-6 mb-4 space-y-2">
                    <li>Quando necessário para cumprir obrigações legais</li>
                    <li>Com provedores de serviço que nos ajudam a operar o site (hosting, analytics, publicidade)</li>
                </ul>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">4. Cookies e Tecnologias Similares</h2>
                <p class="mb-4">Utilizamos cookies para:</p>
                <ul class="list-disc pl-6 mb-4 space-y-2">
                    <li>Lembrar suas preferências de navegação</li>
                    <li>Analisar o tráfego do site</li>
                    <li>Exibir anúncios relevantes através do Google AdSense</li>
                </ul>
                <p class="mb-4">Você pode gerenciar suas preferências de cookies nas configurações do seu navegador.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">5. Seus Direitos (LGPD)</h2>
                <p class="mb-4">De acordo com a Lei Geral de Proteção de Dados (LGPD), você tem direito a:</p>
                <ul class="list-disc pl-6 mb-4 space-y-2">
                    <li>Acessar seus dados pessoais</li>
                    <li>Corrigir dados incompletos ou desatualizados</li>
                    <li>Solicitar a exclusão de seus dados</li>
                    <li>Revogar o consentimento para uso de dados</li>
                </ul>
                <p class="mb-4">Para exercer esses direitos, entre em contato através da nossa <a href="{{ route('page.contact') }}" class="text-primary hover:underline">página de contato</a>.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">6. Segurança</h2>
                <p class="mb-4">Adotamos medidas de segurança para proteger suas informações pessoais contra acesso não autorizado, alteração, divulgação ou destruição.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">7. Alterações nesta Política</h2>
                <p class="mb-4">Podemos atualizar esta política periodicamente. Recomendamos que você revise esta página regularmente para se manter informado sobre como protegemos suas informações.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">8. Contato</h2>
                <p class="mb-4">Se você tiver dúvidas sobre esta política de privacidade, entre em contato conosco através do e-mail <strong>privacidade@inforagro.com.br</strong> ou pela nossa <a href="{{ route('page.contact') }}" class="text-primary hover:underline">página de contato</a>.</p>
            </div>
        </div>
    </section>
</x-layout>
