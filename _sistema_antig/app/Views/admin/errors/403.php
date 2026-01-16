<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Acesso Negado | Admin InforAgro</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .error-card {
            background: white;
            border-radius: 24px;
            padding: 3rem;
            text-align: center;
            max-width: 500px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        .error-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        .error-code {
            font-size: 5rem;
            font-weight: 800;
            color: #dc2626;
            line-height: 1;
            margin-bottom: 0.5rem;
        }
        .error-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1rem;
        }
        .error-message {
            color: #64748b;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        .btn-back {
            display: inline-block;
            padding: 0.875rem 2rem;
            background: #5F7D4E;
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-back:hover {
            background: #4a633d;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-icon">🚫</div>
        <div class="error-code">403</div>
        <h1 class="error-title">Acesso Negado</h1>
        <p class="error-message">
            <?= htmlspecialchars($message ?? 'Você não tem permissão para acessar esta página.') ?>
        </p>
        <a href="/admin" class="btn-back">← Voltar ao Dashboard</a>
    </div>
</body>
</html>
