# Registro de Alterações e Correções - 16/01/2026

Este documento detalha as correções técnicas realizadas no sistema para garantir estabilidade, segurança e conformidade com boas práticas (sem "gambiarras").

## 1. Banco de Dados (Schema)

Foram identificadas colunas faltantes na tabela `posts` que impediam o salvamento de novos artigos. As seguintes colunas foram adicionadas oficialmente ao schema:

```sql
ALTER TABLE posts ADD COLUMN meta_title VARCHAR(255) NULL AFTER status;
ALTER TABLE posts ADD COLUMN meta_description TEXT NULL AFTER meta_title;
ALTER TABLE posts ADD COLUMN focus_keyword VARCHAR(255) NULL AFTER meta_description;
ALTER TABLE posts ADD COLUMN featured_image_caption VARCHAR(255) NULL AFTER featured_image;
ALTER TABLE posts ADD COLUMN read_time INT DEFAULT 0 AFTER content;
ALTER TABLE posts ADD COLUMN word_count INT DEFAULT 0 AFTER read_time;
ALTER TABLE posts ADD COLUMN custom_schema TEXT NULL AFTER content;
ALTER TABLE posts ADD COLUMN content_type VARCHAR(50) DEFAULT 'article' AFTER status;
ALTER TABLE posts ADD COLUMN subtitle VARCHAR(255) NULL AFTER title;
ALTER TABLE posts ADD COLUMN published_at DATETIME NULL AFTER status;
```

**Nota:** Uma ferramenta de correção (`SettingsController::fixDb`) foi temporariamente criada para aplicar essas mudanças em produção.

## 2. Interface do Editor de Posts

O formulário de edição (`admin/posts/form.php`) foi atualizado para restaurar funcionalidades nativas que estavam ausentes:

- **Seleção de Autor:** Implementado via `<select>` nativo, substituindo inputs ocultos hardcoded.
- **Tags:** Implementado campo de texto com `<datalist>` para sugestões automáticas baseadas em tags existentes.
- **CSRF:** Todos os formulários (criação, edição e exclusão) agora utilizam tokens CSRF validados via controlador.

## 3. Upload de Mídia e Picker

- **Processamento de Imagem:** Restaurada a conversão automática para formatos modernos (AVIF/WebP) e redimensionamento para otimização de performance.
- **Modo Picker (Seleção):** Implementada uma solução limpa via classe CSS (`.picker-mode`) no `layouts/main.php` para ocultar Sidebar e Header quando a biblioteca de mídia é aberta em popup.
  - *Correção:* Substituída a tentativa anterior de uso de estilos inline (bad practice) por classes CSS semânticas.

## 4. Listagem de Posts

- **Thumbnails:** Adicionada coluna de visualização de imagem destacada com classes CSS dedicadas (`.post-thumb`, `.empty-thumb`).
- **Segurança:** O botão de "Excluir" agora inclui corretamente o token CSRF gerado pelo `Csrf::field()`, eliminando o erro de segurança ao tentar deletar itens.

---
*Documentação gerada automaticamente após sessão de debugging e refatoração.*
