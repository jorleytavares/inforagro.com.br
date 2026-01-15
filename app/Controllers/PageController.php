<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 * Controlador de Páginas Estáticas
 */
class PageController extends Controller
{
    /**
     * Página Sobre
     */
    public function about(): void
    {
        $breadcrumbs = [
            ['name' => 'Início', 'url' => '/'],
            ['name' => 'Sobre', 'url' => '/sobre'],
        ];
        
        $this->view('pages.about', [
            'pageTitle' => 'Sobre o InfoRagro | Portal do Agronegócio Brasileiro',
            'pageDescription' => 'Conheça o InfoRagro, portal de notícias e referências sobre o agronegócio brasileiro, com foco em agricultura, pecuária e sustentabilidade.',
            'canonical' => 'https://www.inforagro.com.br/sobre',
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
    
    /**
     * Página de Contato
     */
    public function contact(): void
    {
        $breadcrumbs = [
            ['name' => 'Início', 'url' => '/'],
            ['name' => 'Contato', 'url' => '/contato'],
        ];
        
        $this->view('pages.contact', [
            'pageTitle' => 'Contato | InfoRagro',
            'pageDescription' => 'Entre em contato com a equipe do InfoRagro. Sugestões, parcerias e dúvidas.',
            'canonical' => 'https://www.inforagro.com.br/contato',
            'breadcrumbs' => $breadcrumbs,
            'success' => $this->query('success'),
        ]);
    }
    
    /**
     * Enviar formulário de contato
     */
    public function sendContact(): void
    {
        $name = $this->input('name');
        $email = $this->input('email');
        $subject = $this->input('subject');
        $message = $this->input('message');
        
        // Validação básica
        if (empty($name) || empty($email) || empty($message)) {
            $this->redirect('/contato?error=campos');
            return;
        }
        
        // Aqui você implementaria o envio de email
        // Por enquanto, apenas redireciona com sucesso
        
        $this->redirect('/contato?success=1');
    }
    
    /**
     * Política de Privacidade
     */
    public function privacy(): void
    {
        $breadcrumbs = [
            ['name' => 'Início', 'url' => '/'],
            ['name' => 'Política de Privacidade', 'url' => '/politica-de-privacidade'],
        ];
        
        $this->view('pages.privacy', [
            'pageTitle' => 'Política de Privacidade | InfoRagro',
            'pageDescription' => 'Política de privacidade e proteção de dados do portal InfoRagro.',
            'canonical' => 'https://www.inforagro.com.br/politica-de-privacidade',
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
    
    /**
     * Termos de Uso
     */
    public function terms(): void
    {
        $breadcrumbs = [
            ['name' => 'Início', 'url' => '/'],
            ['name' => 'Termos de Uso', 'url' => '/termos-de-uso'],
        ];
        
        $this->view('pages.terms', [
            'pageTitle' => 'Termos de Uso | InfoRagro',
            'pageDescription' => 'Termos de uso e condições de navegação do portal InfoRagro.',
            'canonical' => 'https://www.inforagro.com.br/termos-de-uso',
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}
