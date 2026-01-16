<x-layout>
    <x-slot:title>{{ $pageTitle ?? 'Termos de Uso | InfoRagro' }}</x-slot>

    <section class="page-content py-12">
        <div class="container mx-auto px-4 max-w-4xl">
            <header class="page-header mb-8 text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Termos de Uso</h1>
                <p class="text-xl text-gray-600">Última atualização: {{ date('d/m/Y') }}</p>
            </header>
            
            <div class="content-body prose prose-lg mx-auto text-gray-700">
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">1. Aceitação dos Termos</h2>
                <p class="mb-4">Ao acessar e usar o portal InfoRagro (www.inforagro.com.br), você concorda em cumprir e estar vinculado a estes Termos de Uso. Se você não concordar com qualquer parte destes termos, não deverá utilizar nosso site.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">2. Uso do Conteúdo</h2>
                <p class="mb-4">Todo o conteúdo disponível no InfoRagro, incluindo textos, imagens, gráficos e logos, é propriedade do portal ou de seus parceiros e está protegido pelas leis de direitos autorais.</p>
                <p class="mb-4">Você pode:</p>
                <ul class="list-disc pl-6 mb-4 space-y-2">
                    <li>Ler e compartilhar nossos artigos nas redes sociais, desde que cite a fonte</li>
                    <li>Citar trechos de nosso conteúdo para fins educacionais ou jornalísticos, com atribuição</li>
                </ul>
                <p class="mb-4">Você NÃO pode:</p>
                <ul class="list-disc pl-6 mb-4 space-y-2">
                    <li>Reproduzir nosso conteúdo integralmente sem autorização prévia</li>
                    <li>Utilizar nosso conteúdo para fins comerciais sem permissão</li>
                    <li>Modificar ou criar obras derivadas sem autorização</li>
                </ul>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">3. Precisão das Informações</h2>
                <p class="mb-4">Nos esforçamos para fornecer informações precisas e atualizadas sobre o agronegócio brasileiro. No entanto:</p>
                <ul class="list-disc pl-6 mb-4 space-y-2">
                    <li>O conteúdo é fornecido "como está", sem garantias de qualquer tipo</li>
                    <li>Recomendamos sempre consultar profissionais qualificados antes de tomar decisões importantes</li>
                    <li>Não nos responsabilizamos por decisões tomadas com base em nosso conteúdo</li>
                </ul>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">4. Conteúdo de Terceiros</h2>
                <p class="mb-4">Nosso site pode conter links para sites de terceiros. Não somos responsáveis pelo conteúdo, políticas de privacidade ou práticas de sites externos.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">5. Publicidade</h2>
                <p class="mb-4">O InfoRagro exibe anúncios através do Google AdSense e outros parceiros de publicidade. Estes anúncios podem usar cookies para exibir conteúdo personalizado. Não endossamos necessariamente os produtos ou serviços anunciados.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">6. Conduta do Usuário</h2>
                <p class="mb-4">Ao usar nosso site, você concorda em não:</p>
                <ul class="list-disc pl-6 mb-4 space-y-2">
                    <li>Publicar conteúdo ofensivo, difamatório ou ilegal nos comentários</li>
                    <li>Tentar acessar áreas restritas do site</li>
                    <li>Utilizar bots ou scripts automatizados para acessar o conteúdo</li>
                    <li>Sobrecarregar nossos servidores com requisições excessivas</li>
                </ul>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">7. Limitação de Responsabilidade</h2>
                <p class="mb-4">O InfoRagro e seus colaboradores não serão responsáveis por quaisquer danos diretos, indiretos, incidentais ou consequentes resultantes do uso ou incapacidade de uso deste site.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">8. Modificações</h2>
                <p class="mb-4">Reservamo-nos o direito de modificar estes termos a qualquer momento. As alterações entram em vigor imediatamente após a publicação no site.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">9. Lei Aplicável</h2>
                <p class="mb-4">Estes termos são regidos pelas leis da República Federativa do Brasil. Qualquer disputa será resolvida nos tribunais competentes do Brasil.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">10. Contato</h2>
                <p class="mb-4">Para dúvidas sobre estes termos, entre em contato através da nossa <a href="{{ route('page.contact') }}" class="text-primary hover:underline">página de contato</a>.</p>
            </div>
        </div>
    </section>
</x-layout>
