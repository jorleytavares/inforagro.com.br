<footer class="bg-white border-t border-slate-200 mt-12 pt-16 pb-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <!-- Brand -->
            <div class="col-span-1 md:col-span-1">
                <a href="/" class="flex items-center gap-2 mb-4">
                    <span class="font-display font-bold text-xl text-slate-900">Infor<span class="text-agro-600">Agro</span></span>
                </a>
                <p class="text-slate-500 text-sm leading-relaxed">
                    O portal de referência para o produtor rural moderno. Informação, tecnologia e mercado na palma da sua mão.
                </p>
                <div class="flex gap-4 mt-6">
                    <a href="#" class="text-slate-400 hover:text-agro-600 transition-colors" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="3" width="18" height="18" rx="5" ry="5" stroke="currentColor" stroke-width="1.6" />
                            <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.6" />
                            <circle cx="17" cy="7" r="1.2" fill="currentColor" />
                        </svg>
                    </a>
                    <a href="#" class="text-slate-400 hover:text-agro-600 transition-colors" aria-label="X (Twitter)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                            <path d="M6 5l5.2 6.4L6 19h2.2L12 13.7 15.8 19H18l-5.2-7.6L18 5h-2.2L12 10.3 8.2 5H6z" fill="currentColor" />
                        </svg>
                    </a>
                    <a href="#" class="text-slate-400 hover:text-agro-600 transition-colors" aria-label="LinkedIn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2" stroke="currentColor" stroke-width="1.6" />
                            <rect x="7" y="10" width="2" height="7" fill="currentColor" />
                            <rect x="7" y="7" width="2" height="2" fill="currentColor" />
                            <path d="M13 10h1.6A2.4 2.4 0 0 1 17 12.4V17h-2v-4c0-.6-.4-1-1-1h-1v5h-2v-7h2z" fill="currentColor" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Links 1 -->
            <div>
                <h3 class="font-bold text-slate-900 mb-4">Editorias</h3>
                <ul class="space-y-3 text-sm text-slate-600 w-full">
                    @if(isset($globalCategories) && $globalCategories->count() > 0)
                        @foreach($globalCategories as $cat)
                        <li><a href="{{ url($cat->slug) }}" class="hover:text-agro-600 transition-colors">{{ $cat->name }}</a></li>
                        @endforeach
                    @else
                        <li><span class="text-slate-400">Sem categorias</span></li>
                    @endif
                </ul>
            </div>

            <!-- Links 2 -->
            <div>
                <h3 class="font-bold text-slate-900 mb-4">Institucional</h3>
                <ul class="space-y-3 text-sm text-slate-600 w-full">
                    <li><a href="{{ url('/sobre') }}" class="hover:text-agro-600 transition-colors">Sobre Nós</a></li>
                    <li><a href="{{ url('/contato') }}" class="hover:text-agro-600 transition-colors">Anuncie</a></li>
                    <li><a href="{{ url('/contato') }}" class="hover:text-agro-600 transition-colors">Contato</a></li>
                    <li><a href="{{ url('/privacidade') }}" class="hover:text-agro-600 transition-colors">Privacidade</a></li>
                </ul>
            </div>

            <!-- Newsletter Widget -->
            <div id="newsletter">
                <h3 class="font-bold text-slate-900 mb-4">Receba novidades</h3>
                <form action="{{ url('/newsletter') }}" method="POST" class="flex flex-col gap-3">
                    @csrf
                    <input type="email" name="email" placeholder="Seu melhor e-mail" class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-agro-500 focus:border-transparent text-sm w-full" required>
                    <button type="submit" class="px-4 py-2 bg-agro-600 hover:bg-agro-700 text-white font-medium rounded-lg text-sm w-full transition-colors shadow-sm">
                        Assinar Newsletter
                    </button>
                    <p class="text-xs text-slate-400">
                        Ao assinar, você concorda com nossa <a href="{{ url('/privacidade') }}" class="underline hover:text-slate-500">Política de Privacidade</a>.
                    </p>
                </form>
            </div>
        </div>

        <div class="border-t border-slate-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} InforAgro. Todos os direitos reservados.</p>
            <p>Desenvolvido com tecnologia de ponta.</p>
        </div>
    </div>
</footer>
