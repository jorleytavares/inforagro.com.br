<?php

namespace App\Controllers\Admin;

use App\Models\SearchLog;

class SearchTermsController extends DashboardController
{
    public function index(): void
    {
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
        
        $notFoundTerms = [];
        $stats = ['total_searches' => 0, 'no_results_count' => 0, 'avg_results' => 0];

        try {
            $notFoundTerms = SearchLog::getNotFoundTerms($limit);
            $stats = SearchLog::getStats();
        } catch (\Exception $e) {
            // Silencioso se tabela não existir ou model falhar
        }
        
        $this->adminView('search_terms.index', [
            'pageTitle' => 'Monitor de Buscas | Admin InforAgro',
            'notFoundTerms' => $notFoundTerms,
            'stats' => $stats
        ]);
    }
    public function clear(): void
    {
        try {
            SearchLog::clearLogs();
            header('Location: /admin/search-terms?success=cleared');
        } catch (\Exception $e) {
            header('Location: /admin/search-terms?error=failed');
        }
        exit;
    }
}
