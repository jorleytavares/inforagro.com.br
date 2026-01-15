# 🌿 Design System Reference: Organic Blog

**Versão:** 1.0 (Acessibilidade Focada)  
**Estilo:** Minimalista, Natural, Alto Contraste  
**Projeto:** inforagro.com.br

---

## 1. Tipografia (Typography)

Focada em legibilidade extrema e conforto cognitivo.

### Famílias de Fontes

| Tipo | Fonte | Uso | Pesos |
|------|-------|-----|-------|
| **Títulos (Headings)** | Lexend | Títulos, Menus, Botões | Medium (500), Bold (700), ExtraBold (800) |
| **Corpo (Body)** | Atkinson Hyperlegible | Parágrafos, Legendas, Metadados | Regular (400), Bold (700) |

### Escala & Hierarquia

| Elemento | Tamanho | Fonte/Peso | Observação |
|----------|---------|------------|------------|
| **H1** | 2.5rem | Lexend Bold | Títulos de Posts |
| **H2** | 2.0rem | Lexend SemiBold | Subtítulos |
| **H3** | 1.5rem | Lexend Medium | Cabeçalhos de seção |
| **Body** | 1.125rem (18px) | Atkinson Regular | Altura de linha: 1.6 |
| **Small** | 0.875rem | Atkinson Regular | Datas e Tags |

---

## 2. Paleta de Cores (Design Tokens)

### Semântica das Cores

| Token | Descrição |
|-------|-----------|
| **Background** | Cor de fundo principal da página |
| **Surface** | Cor para cards, sidebars e áreas destacadas |
| **Primary** | Cor principal da marca (Botões, Links, Ações) |
| **Secondary** | Detalhes visuais, bordas, ícones |
| **Text Main** | Cor do texto principal (títulos e corpo) |
| **Text Inverse** | Cor do texto quando está sobre um fundo colorido (botões) |

### Tokens de Cor

| Token Semântico | ☀️ Light Mode | 🌙 Dark Mode | Uso Recomendado |
|-----------------|---------------|--------------|-----------------|
| `--color-bg` | `#E3E8D6` (Sage Cream) | `#151F12` (Night Forest) | Fundo geral `<body>` |
| `--color-surface` | `#C5D1B5` (Pale Leaf) | `#243020` (Dark Moss) | Cards, Header, Footer |
| `--color-surface-high` | `#FFFFFF` (White) | `#243020` (Dark Moss) | Apenas Fundo de Posts (Light) |
| `--color-primary` | `#5F7D4E` (Moss Green) | `#A4B88E` (Light Sage) | Botões, Links, Destaques |
| `--color-secondary` | `#3E5232` (Deep Olive) | `#5F7D4E` (Moss Green) | Bordas, Ícones, Meta |
| `--color-text-main` | `#151F12` (Night Forest) | `#E3E8D6` (Sage Cream) | Todo texto legível |
| `--color-text-inv` | `#FFFFFF` (White) | `#151F12` (Night Forest) | Texto DENTRO de botões |

---

## 3. Implementação CSS (Copy & Paste)

Adicione isto ao topo do seu arquivo CSS global (`style.css` ou `global.css`).

```css
/* Importação das Fontes */
@import url('https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400&family=Lexend:wght@400;500;700;800&display=swap');

:root {
    /* ☀️ LIGHT MODE (Padrão) */
    --color-bg: #E3E8D6;
    --color-surface: #C5D1B5;
    --color-surface-high: #FFFFFF; /* Destaque maior para cards no light */
    --color-primary: #5F7D4E;
    --color-secondary: #3E5232;
    --color-text-main: #151F12;
    --color-text-inverse: #FFFFFF;
    
    /* Variáveis de Tipografia */
    --font-heading: 'Lexend', sans-serif;
    --font-body: 'Atkinson Hyperlegible', sans-serif;
}

/* 🌙 DARK MODE (Automático via Sistema) */
@media (prefers-color-scheme: dark) {
    :root {
        --color-bg: #151F12;
        --color-surface: #243020;
        --color-surface-high: #243020; /* No dark, cards mantêm cor da superfície */
        --color-primary: #A4B88E;      /* Verde mais claro para contraste */
        --color-secondary: #5F7D4E;
        --color-text-main: #E3E8D6;    /* Creme claro para leitura */
        --color-text-inverse: #151F12; /* Texto escuro dentro do botão claro */
    }
}

/* Reset Básico de Estilos */
body {
    background-color: var(--color-bg);
    color: var(--color-text-main);
    font-family: var(--font-body);
    line-height: 1.6;
    font-size: 18px; /* Base acessível */
}

h1, h2, h3, button {
    font-family: var(--font-heading);
    color: var(--color-text-main);
}
```

---

## 4. Regras de Componentes (UI Guidelines)

### Botões (CTAs)

| Propriedade | Valor |
|-------------|-------|
| **Background** | `var(--color-primary)` |
| **Texto do Botão** | `var(--color-text-inverse)` |
| **Forma** | Bordas levemente arredondadas (`border-radius: 6px` ou `8px`) |
| **Estado Hover** | Escurecer 10% no Light Mode; Clarear 10% no Dark Mode |

### Cards de Posts (Listagem)

| Modo | Configuração |
|------|--------------|
| **☀️ Light Mode** | Fundo `var(--color-surface-high)` (Branco) para "saltar" do fundo creme. Borda fina de `1px` sólida com `var(--color-surface)` |
| **🌙 Dark Mode** | Fundo `var(--color-surface)` (Verde escuro). Sem borda ou borda muito sutil |

---

## 5. Acessibilidade (WCAG Checklist)

### ❌ NUNCA faça isso:

- **NUNCA** coloque texto branco sobre o fundo verde claro (`#E3E8D6`)
- **NUNCA** coloque texto verde escuro sobre o fundo verde escuro (`#151F12`)

### ✅ SEMPRE faça isso:

- Links no meio do texto devem ser **sublinhados** ou ter `font-weight: 700` além da cor
- Mantenha contraste mínimo de 4.5:1 para texto normal
- Mantenha contraste mínimo de 3:1 para texto grande (18px+ ou 14px bold)

---

## 6. Referência Rápida de Cores

### Light Mode 🌞

```
Background:     #E3E8D6  ████████  Sage Cream
Surface:        #C5D1B5  ████████  Pale Leaf
Surface High:   #FFFFFF  ████████  White
Primary:        #5F7D4E  ████████  Moss Green
Secondary:      #3E5232  ████████  Deep Olive
Text Main:      #151F12  ████████  Night Forest
Text Inverse:   #FFFFFF  ████████  White
```

### Dark Mode 🌙

```
Background:     #151F12  ████████  Night Forest
Surface:        #243020  ████████  Dark Moss
Surface High:   #243020  ████████  Dark Moss
Primary:        #A4B88E  ████████  Light Sage
Secondary:      #5F7D4E  ████████  Moss Green
Text Main:      #E3E8D6  ████████  Sage Cream
Text Inverse:   #151F12  ████████  Night Forest
```

---

*Documento criado em: 14/01/2026*  
*Última atualização: 14/01/2026*
