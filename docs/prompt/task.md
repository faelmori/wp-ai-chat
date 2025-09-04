# Plano de PR em 4 frentes (incremental e visível)

## 1) Documentação & i18n (impacto imediato)

* **README em EN como padrão + links para PT/ES/ZH** (uma raiz clara ajuda SEO e onboarding).
* **Guia “Getting Started (DeepSeek)”** com exemplo mínimo (`curl`, JS, PHP) e parâmetros essenciais (modelo, stream, limites). Baseie nos docs oficiais da API e linke a página da plataforma. (\[DeepSeek API Docs][3], \[DeepSeek][4])
* **Internacionalização do plugin**: padronizar **text domain**, `load_plugin_textdomain()`, `__()/_e()` e gerar `.pot`. Referência oficial de i18n do Handbook. (\[WordPress Developer Resources][5], \[WordPress Codex][6])

💡 Benefício: resolve a barreira de entrada (inglês), profissionaliza o repo e abre portas para traduções da comunidade.

## 2) Segurança & qualidade (o que mais “ganha respeito”)

* **Sanitização e escape**: usar `sanitize_text_field()`, `esc_html()`, `wp_kses_post()` etc. (\[Learn WordPress][7], \[Krasen Slavov][8])
* **Nonces corretamente** para ações (forms/AJAX) e prevenção de CSRF. Linkar post oficial sobre nonces. (\[WordPress Developer Resources][9])
* **Padrões do Plugin Developer Handbook** para estrutura e headers (nome, versão, `Requires at least`, `Tested up to`). (\[WordPress Developer Resources][10])

💡 Benefício: reduz vetor de vulnerabilidade (XSS/CSRF) e dá “selo” de maturidade WordPress.

## 3) Integração DeepSeek (tutorial + exemplo real)

* **Exemplo PHP mínimo** chamando a API (server-side) e **exemplo JS (fetch)** para UI, com nota sobre **stream** quando suportado. Baseie nos trechos dos docs (Chat API). (\[DeepSeek API Docs][3])
* **Página “How to configure DeepSeek”**: onde colocar API key, como escolher modelo e limites, e troubleshooting. Link para a **lista de integrações** (mostrar alinhamento com o ecossistema deles). (\[GitHub][2])

💡 Benefício: cria trilha clara para quem usa DeepSeek e associa teu nome a esse fluxo.

## 4) DevEx & CI (pequeno, mas diz muito)

* **GitHub Actions** rodando **PHPCS** (WordPress Coding Standards) e um **lint** básico de JS.
* **Check de build/compatibilidade** simples.
* **Guia de contribuição** (`CONTRIBUTING.md`) com passos de como testar e traduzir.

💡 Benefício: PR “limpo”, com pipeline mínimo e regras claras — os maintainers adoram.
