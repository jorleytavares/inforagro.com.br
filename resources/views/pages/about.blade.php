<x-layout>
    <x-slot:title>{{ $pageTitle ?? 'Sobre | InfoRagro' }}</x-slot>

    <section class="page-content py-12">
        <div class="container mx-auto px-4 max-w-4xl">
            <header class="page-header mb-8 text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Sobre o InfoRagro</h1>
                <p class="text-xl text-gray-600">Portal de notícias e referências sobre o agronegócio brasileiro</p>
            </header>
            
            <div class="content-body prose prose-lg mx-auto text-gray-700">
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">Nossa Missão</h2>
                <p class="mb-4">O <strong>InfoRagro</strong> nasceu com a missão de democratizar o acesso à informação de qualidade sobre o agronegócio brasileiro. Acreditamos que produtores rurais, técnicos, investidores e todos os profissionais do setor merecem conteúdo confiável, atualizado e prático.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">O Que Cobrimos</h2>
                <p class="mb-4">Nossa cobertura abrange os principais temas do agronegócio:</p>
                <ul class="list-disc pl-6 mb-4 space-y-2">
                    <li><strong>Agricultura e Pecuária:</strong> Técnicas de plantio, manejo de rebanhos, sanidade animal e vegetal</li>
                    <li><strong>Mercado e Commodities:</strong> Cotações, análises de mercado, exportações e tendências</li>
                    <li><strong>Tecnologia no Agro:</strong> Inovações, máquinas agrícolas, agricultura de precisão</li>
                    <li><strong>Sustentabilidade:</strong> ESG, créditos de carbono, práticas regenerativas</li>
                    <li><strong>Mundo Pet:</strong> Saúde, alimentação e cuidados com animais de estimação</li>
                </ul>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">Nossas Fontes</h2>
                <p class="mb-4">Todo nosso conteúdo é baseado em fontes confiáveis e verificáveis:</p>
                <ul class="list-disc pl-6 mb-4 space-y-2">
                    <li><strong>Embrapa</strong> - Empresa Brasileira de Pesquisa Agropecuária</li>
                    <li><strong>MAPA</strong> - Ministério da Agricultura, Pecuária e Abastecimento</li>
                    <li><strong>IBGE</strong> - Instituto Brasileiro de Geografia e Estatística</li>
                    <li><strong>FAO</strong> - Organização das Nações Unidas para Alimentação e Agricultura</li>
                    <li><strong>USDA</strong> - Departamento de Agricultura dos Estados Unidos</li>
                </ul>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">Compromisso com a Qualidade</h2>
                <p class="mb-4">Cada artigo publicado no InfoRagro passa por um rigoroso processo de verificação. Nossa equipe de redação é composta por jornalistas especializados e profissionais do setor agrícola, garantindo conteúdo preciso e relevante.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">Contato</h2>
                <p class="mb-4">Quer entrar em contato conosco? Envie uma mensagem através da nossa <a href="{{ route('page.contact') }}" class="text-primary hover:underline">página de contato</a> ou escreva para <strong>contato@inforagro.com.br</strong>.</p>
            </div>
        </div>
    </section>
</x-layout>
