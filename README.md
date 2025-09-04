<img src="https://github.com/suqicloud/wp-ai-chat/blob/main/ic_logo.png" width="60">

# WordPress AI Chat Assistant

[![License](https://img.shields.io/badge/license-GPL-blue.svg)](LICENSE)
[![Version](https://img.shields.io/badge/version-4.0.5-green.svg)](https://github.com/suqicloud/wp-ai-chat/releases/tag/4.0.5)
[![WordPress](https://img.shields.io/badge/WordPress-6.7-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-8.0-orange.svg)](https://www.php.net/)
[![Nginx](https://img.shields.io/badge/Nginx-1.2-green.svg)](https://nginx.org/)

> **📖 Language / 语言版本**
> **English** (current) | [Português](docs/README.pt.md) | [Español](docs/README.es.md) | [中文](docs/README.zh.md)

## 📌 Overview

A comprehensive, open-source WordPress AI assistant plugin that brings advanced AI capabilities directly to your WordPress site. Features include conversational AI chat, content generation, SEO analysis, translation services, PowerPoint creation, document analysis, and intelligent agent applications.

**Perfect for DeepSeek integrations** - includes native support for DeepSeek models with optimized configuration and streaming responses.

> **🔗 Official DeepSeek Integration**: This plugin is optimized for [DeepSeek API](https://platform.deepseek.com/api-docs/) with specialized configuration options and streaming support.

If you're new to this plugin, please read the documentation first. It only requires basic configuration and API key integration - no advanced technical requirements needed.

**Commercial updates and advanced features**: <https://www.wujiit.com>

## 🚀 Getting Started with DeepSeek

### Quick Setup

1. **Install the Plugin**
   - Upload to `/wp-content/plugins/` or install via WordPress admin
   - Activate the plugin

2. **Configure DeepSeek API**
   - Navigate to: Dashboard > AI Assistant > Settings
   - Add your DeepSeek API key
   - Select model: `deepseek-chat` (recommended)

3. **Start Chatting**
   - Access the chat interface at `/ai-chat/`
   - Or use shortcode: `[deepseek_chat]`

### API Integration Examples

**PHP Server-side:**

```php
function call_deepseek_api($message) {
    $api_key = get_option('deepseek_api_key');

    $payload = [
        'model' => 'deepseek-chat',
        'messages' => [['role' => 'user', 'content' => $message]],
        'stream' => false
    ];

    $response = wp_remote_post('https://api.deepseek.com/chat/completions', [
        'headers' => [
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type' => 'application/json'
        ],
        'body' => json_encode($payload),
        'timeout' => 60
    ]);

    return json_decode(wp_remote_retrieve_body($response), true);
}
```

**JavaScript Frontend:**

```javascript
async function streamDeepSeekResponse(message) {
    const response = await fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            action: 'deepseek_chat',
            message: message,
            stream: true
        })
    });
    // Handle streaming response...
}
```

**cURL Direct API:**

```bash
curl -X POST "https://api.deepseek.com/chat/completions" \
  -H "Authorization: Bearer $DEEPSEEK_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{"model": "deepseek-chat", "messages": [{"role": "user", "content": "Hello!"}]}'
```

> **📚 DeepSeek Resources:**
>
> - [API Documentation](https://platform.deepseek.com/api-docs/) | [Platform](https://platform.deepseek.com/) | [Model Parameters Guide](https://platform.deepseek.com/api-docs/api/create-chat-completion)

## 🚀 Key Features

### 🤖 AI Providers & Models

- **DeepSeek** - Native integration with optimized streaming support
- **Alibaba Qwen** - Tongyi Qianwen text interface with search capabilities
- **Baidu Qianfan** - ERNIE (Wenxin Yiyan) text interface
- **ByteDance Doubao** - AI text interface
- **Moonshot Kimi** - Text interface with document analysis
- **OpenAI** - GPT models integration
- **Tencent Hunyuan** - Text interface
- **xAI Grok** - Text interface
- **Google Gemini** - Text interface
- **Anthropic Claude** - Text interface
- **iFLYTEK Spark** - Text interface with search capabilities
- **Custom AI Models** - Flexible API integration

### 🧠 Advanced AI Applications

- **Intelligent Agents** - Support for Alibaba, Volcano Engine, Tencent Yuanqi, ByteDance Coze
- **PPT Generation** - AI-powered PowerPoint creation via Wenduo API
- **Image Generation** - Pollinations AI and Qwen text-to-image models
- **Video Generation** - Qwen text-to-video and image-to-video models
- **Web Search** - Internet search capability for Qwen and Spark models
- **Document Analysis** - File upload and analysis (Kimi, OpenAI, Qwen-long)

### 📝 Content Management

- **Smart Chat Interface** - Interactive AI conversations with markdown support
- **Article Generation** - Keyword-based content creation
- **SEO Analysis** - Content optimization and spell checking
- **Article Summarization** - AI-powered content summaries
- **Translation Services** - Multi-language article translation
- **Voice Synthesis** - Text-to-speech for articles and AI responses (Tencent Cloud, Baidu Cloud TTS)

### ⚙️ WordPress Integration

- **User Management** - Login-restricted access with user-specific chat history
- **Admin Dashboard** - Complete conversation logs and user management
- **Customizable Interface** - Personalized assistant names and prompts
- **Content Controls** - Custom prompt tutorials and violation keyword detection
- **Data Security** - Conversation logging with privacy controls
- **Flexible Deployment** - Shortcode support and automatic page creation

## � Installation

1. **Download** the latest release from this repository
2. **Upload** to your WordPress admin panel (Plugins > Add New > Upload Plugin)
3. **Activate** the plugin
4. **Configure** your AI API keys in the dashboard

**Alternative:** Upload directly to `/wp-content/plugins/` on your server and set proper permissions.

**Requirements:**

- WordPress 6.7+
- PHP 8.0+
- Active internet connection for AI APIs

## 🛠️ Usage

The plugin automatically creates a front-end chat page when activated. If the page doesn't appear, manually add the shortcode: `[deepseek_chat]`

**Important Notes:**

1. **Translation interface** requires separate configuration (merged from standalone plugin)
2. **AI PPT generation** may have theme compatibility issues (originally designed for specific theme)
3. **Theme compatibility**: Your theme should support full-width or full-screen mode for optimal display

**Need help?** Check the tutorial: <https://www.wujiit.com/wpaidocs>

## 📁 File Structure

| File | Purpose |
|------|---------|
| `wp-ai-chat.php` | Main plugin file |
| `wpaitranslate.php` | Translation and voice features |
| `wpaippt.php` | AI PowerPoint generation |
| `wpaidashscope.php` | Intelligent agent applications |
| `wpai-chat.js` | Main JavaScript functionality |
| `wpai-style.css` | Plugin styles |
| `wpai-script.js` | Translation/voice JavaScript |
| `docmee-ui-sdk-iframe.min.js` | PPT generation SDK |
| `marked.min.js` | Markdown parser |

## �️ Database

The plugin creates two tables:

- `deepseek_chat_logs` - General chat conversations
- `deepseek_agent_chat_logs` - Agent application conversations

**Uninstall:** Manually delete these tables if completely removing the plugin.

## 🤝 Sponsorship

CDN acceleration and security protection for this project are sponsored by **Tencent EdgeOne**. EdgeOne offers a long-term free plan with unlimited traffic and requests, covering Mainland China nodes, with no overage charges.

[🔗 Best Asian CDN, Edge, and Security Solutions - Tencent EdgeOne](https://edgeone.ai/?from=github)

[![EdgeOne](https://edgeone.ai/media/34fe3a45-492d-4ea4-ae5d-ea1087ca7b4b.png)](https://edgeone.ai/?from=github)
