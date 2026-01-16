<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // Future use

class PageController extends Controller
{
    /**
     * Página Sobre
     */
    public function about()
    {
        return view('pages.about', [
            'pageTitle' => 'Sobre o InfoRagro | Portal do Agronegócio Brasileiro',
            'canonical' => url('/sobre'),
        ]);
    }

    /**
     * Página de Contato
     */
    public function contact()
    {
        return view('pages.contact', [
            'pageTitle' => 'Contato | InfoRagro',
            'canonical' => url('/contato'),
            'success' => request()->query('success'),
        ]);
    }

    /**
     * Processar formulário de contato
     */
    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        // Aqui implementaria o envio de e-mail real
        // Mail::to('contato@inforagro.com.br')->send(new ContactForm($validated));

        return redirect()->route('page.contact', ['success' => 1])
            ->with('message', 'Mensagem enviada com sucesso!');
    }

    /**
     * Política de Privacidade
     */
    public function privacy()
    {
        return view('pages.privacy', [
            'pageTitle' => 'Política de Privacidade | InfoRagro',
            'canonical' => url('/politica-de-privacidade'),
        ]);
    }

    /**
     * Termos de Uso
     */
    public function terms()
    {
        return view('pages.terms', [
            'pageTitle' => 'Termos de Uso | InfoRagro',
            'canonical' => url('/termos-de-uso'),
        ]);
    }
}
