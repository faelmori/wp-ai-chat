<img src="https://github.com/suqicloud/wp-ai-chat/blob/main/ic_logo.png" width="60">

# Assistente IA WordPress Xiaoban

[![License](https://img.shields.io/badge/license-GPL-blue.svg)](LICENSE)
[![Version](https://img.shields.io/badge/version-4.0.5-green.svg)](https://github.com/suqicloud/wp-ai-chat/releases/tag/4.0.5)
[![WordPress](https://img.shields.io/badge/WordPress-6.7-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-8.0-orange.svg)](https://www.php.net/)
[![Nginx](https://img.shields.io/badge/Nginx-1.2-green.svg)](https://nginx.org/)

## 📌 Introdução do Projeto

Plugin assistente de IA para WordPress totalmente open source e gratuito, habilitando: chat conversacional com IA (geração de texto, imagem e vídeo), reprodução de voz conversacional com IA, geração de artigos com IA, análise SEO de artigos com IA, resumo de artigos com IA, tradução de artigos com IA, geração de PowerPoint com IA, análise de documentos com IA, aplicações de agentes inteligentes com IA e reprodução de voz do conteúdo de artigos.

Se você não sabe como usar, leia a documentação primeiro. Requer apenas configuração básica e integração de chaves de API, e este tipo de plugin não exige requisitos de alto nível.

Atualizações relacionadas ao código-fonte comercial da ferramenta Wuji AI: <https://www.wujiit.com>

## 🚀 Funcionalidades

1. Interface de texto Deepseek integrada
1. Interface de texto Ali Tongyi Qianwen integrada
1. Interface de texto Baidu Qianfan (Wenxin Yiyan) integrada
1. Interface de texto Doubao AI integrada
1. Interface de texto Kimi integrada
1. Interface de texto OpenAI integrada
1. Interface de texto Tencent Hunyuan integrada
1. Interface de texto Grok integrada
1. Interface de texto Gemini integrada
1. Interface de texto Claude integrada
1. Interface de texto iFlytek Spark integrada
1. Interface de modelo de texto IA personalizada integrada
1. Suporte à integração com aplicações de agentes inteligentes Alibaba
1. Suporte à integração com aplicações de agentes inteligentes Volcano Engine
1. Suporte à integração com aplicações de agentes inteligentes Tencent Yuanqi
1. Suporte à integração com aplicações de agentes inteligentes ByteButton
1. Suporte à geração de arquivos PPT usando a interface Wenduoduo AIPPT
1. Suporte ao modelo de texto para imagem com IA por polling
1. Suporte ao modelo de geração de imagens Tongyi Qianwen
1. Suporte ao modelo de geração de vídeos Tongyi Qianwen (texto para vídeo e imagem para vídeo)
1. Suporte à busca online para alguns modelos Tongyi Qianwen e iFlytek Spark
1. Parâmetros de modelo personalizáveis
1. O sistema armazena a primeira frase dos logs de conversação em uma tabela de dados separada
1. Usuários podem deletar seu próprio histórico de conversação
1. Logs de conversação de usuários podem ser deletados no backend
1. Conversações de aplicações de agentes de usuários podem ser deletadas no backend
1. Artigos podem ser gerados baseados em palavras-chave
1. Resumos de artigos podem ser criados usando a interface IA
1. Exibe o portal do assistente IA no frontend
1. Acesso limitado a usuários logados
1. Suporte à formatação Markdown
1. Informações de saldo DeepSeek
1. Tradução de artigos pode ser realizada usando a interface IA
1. Suporte à integração com serviços TTS Tencent Cloud e Baidu Cloud para reprodução de voz do conteúdo de artigos
1. Reprodução de voz das respostas da IA
1. Prompts personalizáveis
1. Link de tutorial de palavras de prompt personalizável
1. Carregamento automático do botão de cópia para conteúdo Markdown
1. Suporte à detecção de palavras-chave
1. PPTs gerados por IA podem verificar permissões de membros (pode não funcionar em alguns sites)
1. Perguntas de abertura de aplicações de agentes inteligentes
1. Personalização do nome do assistente IA frontend, etc.
1. Personalização do texto de prompt para usuários deslogados
1. Suporte à seleção de interface pelo usuário frontend
1. Suporte ao Kimi e Tongyi Qianwen qwen-long para upload de arquivos para análise de conteúdo de documentos
1. Suporte à seleção de parâmetros de modelo pelo usuário frontend
1. Suporte à análise SEO do conteúdo de artigos e detecção de erros tipográficos

## 📥 Instalação

1. Baixe a versão mais recente.

2. Acesse o backend de plugins do WordPress

3. Faça upload do pacote de arquivo local para instalação

Ou faça upload diretamente para o diretório de plugins do site /wp-content/plugins no servidor. Lembre-se de definir as permissões.

Base de Desenvolvimento: WordPress 6.7.1
Versão PHP: PHP 8.0

## 🛠️ Instruções

Uma página de chat frontend será criada automaticamente quando o plugin for habilitado. Se não for, adicione manualmente o shortcode: [deepseek_chat]

1 - A interface de tradução de artigos precisa ser configurada separadamente. Originalmente era parte de outro plugin, mas eu a integrei e uso diretamente sem mais complicações.

2 - A função de geração de PPT com IA também foi integrada de um plugin separado, e esta funcionalidade foi originalmente adaptada para meu próprio tema, então a compatibilidade pode ser ruim.

Se você não usar mais o plugin, delete as seguintes tabelas no seu banco de dados: deepseek_chat_logs e deepseek_agent_chat_logs.

Tutorial: <https://www.wujiit.com/wpaidocs>

Sua página de tema deve suportar modo de largura total ou tela cheia; caso contrário, aparecerá muito apertado. Se não suportar, verifique a folha de estilo do seu tema e habilite a exibição em tela cheia da página do Assistente Deepseek através de código.

Este plugin foi originalmente projetado para testar a capacidade do DeepSeek de escrever seu próprio código. Parte dele foi código do próprio DeepSeek (a interface de diálogo IA com DeepSeek e a versão mais antiga de geração de artigos). Outros plugins foram posteriormente integrados nele, então os nomes de funções e outras coisas no código podem parecer bagunçados, mas estão todos comentados.

## Descrição dos Arquivos

Arquivo Principal: wp-ai-chat.php
Arquivo de Áudio de Tradução: wpaitranslate.php
Arquivo de PowerPoint Gerado por IA: wpaippt.php
Arquivo de Aplicação de Agente: wpaidashscope.php
Arquivo JS Principal: wpai-chat.js
Arquivo CSS: wpai-style.css
Arquivo JS de Áudio de Tradução: wpai-script.js
Arquivo JS de Chamada PowerPoint: docmee-ui-sdk-iframe.min.js
Arquivo Analisador Markdown: marked.min.js

## Patrocínio

A aceleração CDN e proteção de segurança para este projeto são patrocinadas pelo Tencent EdgeOne. O EdgeOne oferece um plano gratuito de longo prazo com tráfego e solicitações ilimitados, cobrindo nós na China Continental, sem taxas de excesso. Partes interessadas podem clicar no link abaixo para reivindicar sua assinatura.

[Melhores Soluções CDN, Edge e Segurança Asiáticas - Tencent EdgeOne](https://edgeone.ai/zh?from=github)

[![EdgeOne](https://edgeone.ai/media/34fe3a45-492d-4ea4-ae5d-ea1087ca7b4b.png)](https://edgeone.ai/?from=github)
PowerPoint Calling JS File: docmee-ui-sdk-iframe.min.js
Markdown Parser File: marked.min.js

## Sponsorship

CDN acceleration and security protection for this project are sponsored by Tencent EdgeOne. EdgeOne offers a long-term free plan with unlimited traffic and requests, covering nodes in Mainland China, with no overage charges. Interested parties can click the link below to claim your subscription.

CDN acceleration and security protection for this project are sponsored by Tencent EdgeOne. EdgeOne offers a long-term free plan with unlimited traffic and requests, covering nodes in Mainland China, with no overage charges. charges. Interested parties can click the link below to claim it.

[Best Asian CDN, Edge, and Security Solutions - Tencent EdgeOne](https://edgeone.ai/zh?from=github)

[Best Asian CDN, Edge, and Secure Solutions - Tencent EdgeOne](https://edgeone.ai/zh?from=github)

[![EdgeOne](https://edgeone.ai/media/34fe3a45-492d-4ea4-ae5d-ea1087ca7b4b.png)](https://edgeone.ai/?from=github)
