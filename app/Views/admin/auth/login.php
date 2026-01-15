<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Login | Admin InforAgro</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            background-image: 
                radial-gradient(at 0% 0%, hsla(108, 47%, 95%, 1) 0px, transparent 50%),
                radial-gradient(at 50% 100%, hsla(192, 63%, 94%, 1) 0px, transparent 50%),
                radial-gradient(at 80% 0%, hsla(38, 100%, 96%, 1) 0px, transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 24px;
            padding: 3rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
        }
        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        .login-logo {
            font-size: 3.5rem;
            margin-bottom: 0.5rem;
        }
        .login-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: -1px;
        }
        .login-subtitle {
            color: #64748b;
            font-size: 0.95rem;
            margin-top: 0.5rem;
        }
        .form-group { margin-bottom: 1.5rem; }
        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.5rem;
        }
        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(203, 213, 225, 0.6);
            border-radius: 12px;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.2s;
            color: #0f172a;
        }
        .form-control:focus {
            outline: none;
            background: #fff;
            border-color: #5F7D4E;
            box-shadow: 0 0 0 4px rgba(95, 125, 78, 0.1);
        }
        .btn-login {
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
            box-shadow: 0 4px 12px rgba(95, 125, 78, 0.3);
        }
        .btn-login:hover {
            background: #4a633d;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(95, 125, 78, 0.4);
        }
        .alert-error {
            background: rgba(254, 226, 226, 0.8);
            backdrop-filter: blur(4px);
            color: #991b1b;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            border: 1px solid #fecaca;
            text-align: center;
        }
        .login-footer {
            text-align: center;
            margin-top: 2rem;
        }
        .login-footer a {
            color: #5F7D4E;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <div class="login-logo">🌿</div>
            <h1 class="login-title">InforAgro Admin</h1>
            <p class="login-subtitle">Acesse o painel administrativo</p>
        </div>
        
        <?php if (!empty($error)): ?>
        <div class="alert-error">
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>
        
        <form action="/admin/login" method="POST">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken ?? '') ?>">
            
            <div class="form-group">
                <label class="form-label" for="username">E-mail</label>
                <input type="email" id="username" name="username" class="form-control" required autofocus autocomplete="email">
            </div>
            
            <div class="form-group">
                <label class="form-label" for="password">Senha</label>
                <input type="password" id="password" name="password" class="form-control" required autocomplete="current-password">
            </div>
            
            <button type="submit" class="btn-login">Entrar</button>
        </form>
        
        <div class="login-footer">
            <a href="/admin/forgot-password" style="display: block; margin-bottom: 1rem;">Esqueci minha senha</a>
            <a href="/">← Voltar para o site</a>
        </div>
    </div>
</body>
</html>
