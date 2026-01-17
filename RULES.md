# Regras de Ouro do Projeto (InforAgro)

Este arquivo define os padrões inegociáveis para o desenvolvimento deste projeto.

## 1. Zero Gambiarras (No Hacks)
**Proibido:** Soluções temporárias, hardcoded, injeções manuais de scripts/CSS que ignoram o build system, ou contornos de funcionalidades nativas do Framework.
**Obrigatório:**
- Utilizar os padrões nativos do **Laravel 12+** e **Filament**.
- Seguir as PSRs (PHP Standards Recommendations).
- Tipagem forte (Strict Mode) sempre que possível.
- Se o framework oferece uma solução (ex: Policy para auth, Vite para assets), ELA DEVE SER USADA.

## 2. Componentização Obsessiva (Front-end)
**Proibido:** Arquivos Blade monolíticos gigantes com HTML repetitivo.
**Obrigatório:**
- **UI Kit**: Todo elemento de interface reutilizável (botões, cards, inputs, modais) deve ser um `x-component`.
- **Layouts**: Headers, Footers e Sidebars devem ser componentes isolados.
- **Manutenção**: Se um bloco de código aparece mais de uma vez ou tem lógica própria complexa, ele merece ser extraído para `resources/views/components`.

## 3. Stack Limpa & Moderna
- **CSS**: Obrigatório uso de **Tailwind CSS v4** com arquitetura modernizada:
  - Usar `@theme` dentro do CSS em vez de `tailwind.config.js`.
  - Usar variáveis CSS nativas (`--color-name`) para tokens de design.
  - Aproveitar recursos de "CSS4" (Modern CSS) como aninhamento nativo e funções de cor OKLCH/HSL quando suportado.
- **JS**: **Alpine.js v3+** para interatividade leve. Evitar jQuery ou Vanilla JS verboso.
- **Assets**: Sempre via **Vite** (`npm run build`).

---
*Estas regras devem ser consultadas e seguidas em toda interação de desenvolvimento.*
