# 🌿 Design System Reference: Admin Panel (Glassmorphism)

**Versão:** 1.0 (Aurora Glass)
**Estilo:** Moderno, Profissional, Translúcido
**Projeto:** InforAgro Admin

---

## 1. Filosofia de Design (Glassmorphism)

O painel administrativo utiliza o estilo Glassmorphism para criar uma interface leve, moderna e com senso de hierarquia visual através de camadas "flutuantes".

**Princípios Chave:**
1.  **Translucidez:** Elementos de UI (cards, sidebar, header) parecem vidro fosco, permitindo que o fundo brilhe sutilmente através deles.
2.  **Multicamadas:** O uso de sombras (`box-shadow`) e `z-index` define a profundidade. O fundo está mais longe, os painéis flutuam sobre ele.
3.  **Bordas Sutis:** Bordas semi-transparentes brancas simulam a espessura e reflexo do vidro.
4.  **Cores Vivas em Pastel:** O fundo utiliza gradientes "Aurora" (Verde, Azul, Rosa suaves) para vitalidade sem cansar a vista.

---

## 2. Paleta de Cores e Variáveis

As variáveis CSS são definidas em `:root` no layout principal.

### Cores Base
| Token | Cor Hex | Descrição |
|-------|---------|-----------|
| `--admin-primary` | `#5F7D4E` | Verde Musgo (Brand Color) |
| `--admin-primary-hover` | `#4a633d` | Verda mais escuro para interações |
| `--admin-secondary` | `#64748b` | Cinza Azulado para textos secundários |
| `--admin-danger` | `#ef4444` | Vermelho para ações destrutivas |
| `--admin-bg-base` | `#f0f2f5` | Cor sólida de fundo (fallback) |

### Variáveis de Vidro (Glass Tokens)
| Token | Valor | Propósito |
|-------|-------|-----------|
| `--glass-bg` | `rgba(255, 255, 255, 0.75)` | Fundo base para painéis de vidro |
| `--glass-border` | `1px solid rgba(255, 255, 255, 0.6)` | Borda simulando reflexo de vidro |
| `--glass-shadow` | `0 8px 32px 0 rgba(31, 38, 135, 0.05)` | Sombra difusa colorida para profundidade |
| `--glass-blur` | `blur(12px)` | Filtro de desfoque para o fundo (Backdrop) |

---

## 3. Tipografia

A tipografia é focada em clareza funcional para densidade de dados.

**Família:** `Inter`, sans-serif (Google Fonts)

| Uso | Peso | Tamanho | Cor |
|-----|------|---------|-----|
| **Page Titles (H1)** | Bold (700) | `1.35rem` | `#1e293b` (Slate 800) |
| **Section Titles (H2)** | Bold (700) | `1.25rem` | `#0f172a` (Slate 900) |
| **Labels** | SemiBold (600) | `0.9rem` | `#334155` (Slate 700) |
| **Body Text** | Regular (400) | `1rem` | `#334155` (Slate 700) |

---

## 4. Componentes CSS (Snippets)

### Fundo Aurora (Body)
O fundo que dá vida ao efeito de vidro.
```css
body {
    background-color: #f0f2f5;
    background-image: 
        radial-gradient(at 0% 0%, hsla(108, 47%, 95%, 1) 0px, transparent 50%),
        radial-gradient(at 50% 100%, hsla(192, 63%, 94%, 1) 0px, transparent 50%),
        radial-gradient(at 80% 0%, hsla(38, 100%, 96%, 1) 0px, transparent 50%);
    background-attachment: fixed; /* Importante para scroll suave */
}
```

### Painel de Vidro (.glass-panel)
Para widgets e áreas decorativas.
```css
.glass-panel {
    background: var(--glass-bg); /* 0.75 Opacidade */
    backdrop-filter: var(--glass-blur);
    border: var(--glass-border);
    box-shadow: var(--glass-shadow);
}
```

### Cards de Conteúdo (.card)
Para formulários e tabelas, usamos um fundo ligeiramente mais opaco para garantir a legibilidade do texto.
```css
.card {
    background: rgba(255, 255, 255, 0.85); /* Mais opaco (0.85) */
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.8);
    border-radius: 20px;
}
```

### Botões (.btn-primary)
Botões com sombras suaves para combinar com a profundidade.
```css
.btn-primary {
    background: var(--admin-primary);
    color: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(95, 125, 78, 0.3);
    transition: all 0.2s;
}
.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(95, 125, 78, 0.4);
}
```

### Inputs de Formulário
Campos de entrada que parecem "cortados" no vidro.
```css
.form-control {
    background: rgba(255, 255, 255, 0.5); /* Mais transparente que o card */
    border: 1px solid rgba(203, 213, 225, 0.6);
    border-radius: 10px;
}
.form-control:focus {
    background: #fff; /* Fica sólido ao focar */
    border-color: var(--admin-primary);
    box-shadow: 0 0 0 4px rgba(95, 125, 78, 0.1);
}
```

---

## 5. Estrutura de Layout (Dashboard)

O Dashboard utiliza um Grid CSS assíncrono para destacar as informações mais importantes.

```css
.dashboard-grid {
    display: grid;
    grid-template-columns: 2fr 1fr; /* Coluna Principal (2/3) | Lateral (1/3) */
    gap: 1.5rem;
}
@media(max-width: 992px) {
    .dashboard-grid { grid-template-columns: 1fr; } /* Coluna única no mobile */
}
```

*Documento criado em: 15/01/2026*
