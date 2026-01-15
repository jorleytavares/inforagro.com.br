<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= htmlspecialchars($pageTitle ?? 'Recuperar Senha') ?></title>
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
        .alert {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            text-align: center;
        }
        .alert-success { background: rgba(220, 252, 231, 0.8); color: #166534; border: 1px solid #86efac; }
        .alert-error { background: rgba(254, 226, 226, 0.8); color: #991b1b; border: 1px solid #fecaca; }
        .footer { text-align: center; margin-top: 2rem; }
        .footer a { color: #5F7D4E; text-decoration: none; font-size: 0.9rem; font-weight: 600; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <div class="logo">🔑</div>
            <h1 class="title">Recuperar Senha</h1>
            <p class="subtitle">Informe seu e-mail para receber o link de recuperação</p>
        </div>
        
        <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            Se o e-mail estiver cadastrado, você receberá um link de recuperação.
        </div>
        <?php endif; ?>
        
        <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <?php if (empty($success)): ?>
        <form action="/admin/forgot-password" method="POST">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken ?? '') ?>">
            
            <div class="form-group">
                <label class="form-label" for="email">E-mail</label>
                <input type="email" id="email" name="email" class="form-control" required autofocus autocomplete="email">
            </div>
            
            <button type="submit" class="btn">Enviar Link de Recuperação</button>
        </form>
        <?php endif; ?>
        
        <div class="footer">
            <a href="/admin/login">← Voltar ao Login</a>
        </div>
    </div>
</body>
</html>
