<?php

namespace App\Controllers\Admin;

use App\Models\NewsletterSubscriber;

class NewsletterAdminController extends DashboardController
{
    /**
     * Listar inscritos
     */
    public function index(): void
    {
        $this->requireRole('admin');
        
        $subscribers = [];
        try {
            $subscribers = NewsletterSubscriber::getAll();
        } catch (\Exception $e) {
            // Tabela pode não existir ainda
        }
        
        $this->adminView('newsletter.index', [
            'pageTitle' => 'Newsletter | Admin InforAgro',
            'subscribers' => $subscribers
        ]);
    }

    /**
     * Exportar para CSV
     */
    public function export(): void
    {
        $this->requireRole('admin');
        
        $filename = "inforagro_newsletter_" . date('Y-m-d') . ".csv";
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // Cabeçalho CSV
        fputcsv($output, ['ID', 'Email', 'IP', 'Status', 'Data Inscrição']);
        
        try {
            $subscribers = NewsletterSubscriber::getAll();
            foreach ($subscribers as $sub) {
                fputcsv($output, [
                    $sub['id'],
                    $sub['email'],
                    $sub['ip_address'],
                    $sub['status'],
                    $sub['created_at']
                ]);
            }
        } catch (\Exception $e) {}
        
        fclose($output);
        exit;
    }
}
