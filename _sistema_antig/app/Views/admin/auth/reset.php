<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= htmlspecialchars($pageTitle ?? 'Nova Senha') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            background-image: 
                radial-gradient(at 0% 0%, hsla(108, 47%, 95%, 1) 0px, transparent 50%),
                radial-gradient(at 50% 100%, hsla(192, 63%, 94%, 1) 0px, transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 24px;
            padding: 3rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
        }
        .header { text-align: center; margin-bottom: 2rem; }
        .logo { font-size: 3rem; margin-bottom: 0.5rem; }
        .title { font-size: 1.5rem; font-weight: 700; color: #1e293b; }
        .subtitle { color: #64748b; font-size: 0.9rem; margin-top: 0.5rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem; }
        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(203, 213, 225, 0.6);
            border-radius: 12px;
            font-size: 1rem;
            font-family: inherit;
            color: #0f172a;
        }
        .form-control:focus {
            outline: none;
            background: #fff;
            border-color: #5F7D4E;
            box-shadow: 0 0 0 4px rgba(95, 125, 78, 0.1);
        }
        .btn {
            width: 100%;
            padding: 1rem;
            background: #5F7D4E;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn:hover { background: #4a633d; transform: translateY(-2px); }
        .alert-error {
            background: rgba(254, 226, 226, 0.8);
            color: #991b1b;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            border: 1px solid #fecaca;
            text-align: center;
        }
        .password-hint {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <div class="logo">🔐</div>
            <h1 class="title">Nova Senha</h1>
            <p class="subtitle">Defina sua nova senha de acesso</p>
        </div>
        
        <?php if (!empty($error)): ?>
        <div class="alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form action="/admin/reset-password" method="POST">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken ?? '') ?>">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">
            
            <div class="form-group">
                <label class="form-label" for="password">Nova Senha</label>
                <input type="password" id="password" name="password" class="form-control" required autocomplete="new-password" minlength="8">
                <p class="password-hint">Mínimo 8 caracteres</p>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="password_confirm">Confirmar Senha</label>
                <input type="password" id="password_confirm" name="password_confirm" class="form-control" required autocomplete="new-password">
            </div>
            
            <button type="submit" class="btn">Alterar Senha</button>
        </form>
    </div>
</body>
</html>
