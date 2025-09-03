<img src="https://github.com/suqicloud/wp-ai-chat/blob/main/ic_logo.png" width="60">

# Xiaoban WordPress ai assistant

[![License](https://img.shields.io/badge/license-GPL-blue.svg)](LICENSE)
[![Version](https://img.shields.io/badge/version-4.0.5-green.svg)](https://github.com/suqicloud/wp-ai-chat/releases/tag/4.0.5)
[![WordPress](https://img.shields.io/badge/WordPress-6.7-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-8.0-orange.svg)](https://www.php.net/)
[![Nginx](https://img.shields.io/badge/Nginx-1.2-green.svg)](https://nginx.org/)

## 📌 Project Introduction

Fully open source and free - WordPress AI assistant plugin, enabling: AI conversational chat (text, image, and video generation), AI conversational voice playback, AI article generation, AI article SEO analysis, AI article summarization, AI article translation, AI PowerPoint generation, AI document analysis, AI intelligent agent applications, and article content voice playback.

If you don't know how to use it, read the documentation first. It only requires basic configuration and API key integration, and this type of plugin doesn't require high-level requirements.

Updates related to the commercial source code Wuji AI tool: https://www.wujiit.com

## 🚀 Features

1. Built-in Deepseek text interface
1. Built-in Ali Tongyi Qianwen text interface
1. Built-in Baidu Qianfan (Wenxin Yiyan) text interface
1. Built-in Doubao AI text interface
1. Built-in Kimi text interface
1. Built-in OpenAI text interface
1. Built-in Tencent Hunyuan text interface
1. Built-in Grok text interface
1. Built-in Gemini text interface
1. Built-in Claude text interface
1. Built-in iFlytek Spark text interface
1. Built-in custom AI text model interface
1. Supports integration with Alibaba intelligent agent applications
1. Supports integration with Volcano Engine intelligent agent applications
1. Supports integration with Tencent Yuanqi intelligent agent applications
1. Supports integration with ByteButton intelligent agent applications
1. Supports PPT file generation using the Wenduoduo AIPPT interface
1. Supports polling AI-powered text-to-image model
1. Supports Tongyi Qianwen's image generation model
1. Supports Tongyi Qianwen's video generation model (text-to-video and image-to-video)
1. Supports online search for some Tongyi Qianwen and iFlytek Spark models
1. Model parameters are customizable
1. The system stores the first sentence of conversation logs in a separate data table
1. Users can delete their own conversation history
1. User conversation logs can be deleted in the backend
1. User agent application conversations can be deleted in the backend
1. Articles can be generated based on keywords
1. Article summaries can be created using the AI ​​interface
1. Displays the AI ​​assistant portal in the frontend
1. Access is limited to logged-in users
1. Supports Markdown formatting
1. DeepSeek balance information
1. Article translation can be performed using the AI ​​interface
1. Supports integration with Tencent Cloud and Baidu Cloud TTS services for voice playback of article content
1. Voice playback of AI responses
1. Customizable prompts
1. Customizable prompt word tutorial link

1. Automatically load the copy button for Markdown content

1. Supports keyword detection

1. AI-generated PPTs can verify member permissions (may not work on some websites)

1. Intelligent agent application opening questions

1. Customize the front-end AI assistant name, etc.

1. Customize the logged-out prompt text

1. Support front-end user selection interface

1. Support Kimi and Tongyi Qianwen qwen-long to upload files for document content analysis

1. Support front-end user selection of model parameters

1. Supports SEO analysis of article content and typo detection

## 📥 Installation

1. Download the latest version.

2. Access the WordPress plugin backend

3. Upload the local file package for installation

Or upload directly to the website plugin directory /wp-content/plugins on the server. Remember to set permissions.

Development Base: WordPress 6.7.1
PHP Version: PHP 8.0

## 🛠️ Instructions

A front-end chat page will automatically be created when the plugin is enabled. If not, manually add the shortcode: [deepseek_chat]

1 - The article translation interface needs to be set up separately. This was originally part of another plugin, but I merged it and used it directly without any further fuss.

2 - The AI-generated PPT function was also merged from a separate plugin, and this feature was originally adapted for my own theme, so compatibility may be poor.

If you no longer use the plugin, delete the following tables in your database: deepseek_chat_logs and deepseek_agent_chat_logs.

Tutorial: https://www.wujiit.com/wpaidocs

Your theme page must support full-width or full-screen mode; otherwise, it will appear too cramped. If not, check your theme's style sheet and enable full-screen display of the Deepseek Assistant page through code.

This plugin was originally designed to test DeepSeek's ability to write its own code. Part of it was DeepSeek's own code (the AI ​​dialogue interface with DeepSeek and the earliest version of article generation). Other plugins were later merged into it, so the function names and other things in the code may look messy, but they are all commented.

## File Description

Main File: wp-ai-chat.php
Translation Audio File: wpaitranslate.php
AI-Generated PowerPoint File: wpaippt.php
Agent Application File: wpaidashscope.php
Main JS File: wpai-chat.js
CSS File: wpai-style.css
Translation Audio JS File: wpai-script.js
PowerPoint Calling JS File: docmee-ui-sdk-iframe.min.js
Markdown Parser File: marked.min.js

## Sponsorship
CDN acceleration and security protection for this project are sponsored by Tencent EdgeOne. EdgeOne offers a long-term free plan with unlimited traffic and requests, covering nodes in Mainland China, with no overage charges. Interested parties can click the link below to claim your subscription.

CDN acceleration and security protection for this project are sponsored by Tencent EdgeOne. EdgeOne offers a long-term free plan with unlimited traffic and requests, covering nodes in Mainland China, with no overage charges. charges. Interested parties can click the link below to claim it.

[Best Asian CDN, Edge, and Security Solutions - Tencent EdgeOne](https://edgeone.ai/zh?from=github)

[Best Asian CDN, Edge, and Secure Solutions - Tencent EdgeOne](https://edgeone.ai/zh?from=github)

[![EdgeOne](https://edgeone.ai/media/34fe3a45-492d-4ea4-ae5d-ea1087ca7b4b.png)](https://edgeone.ai/?from=github)
