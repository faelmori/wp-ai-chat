<img src="https://github.com/suqicloud/wp-ai-chat/blob/main/ic_logo.png" width="60">

# Xiaoban WordPress Asistente IA

[![License](https://img.shields.io/badge/license-GPL-blue.svg)](LICENSE)
[![Version](https://img.shields.io/badge/version-4.0.5-green.svg)](https://github.com/suqicloud/wp-ai-chat/releases/tag/4.0.5)
[![WordPress](https://img.shields.io/badge/WordPress-6.7-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-8.0-orange.svg)](https://www.php.net/)
[![Nginx](https://img.shields.io/badge/Nginx-1.2-green.svg)](https://nginx.org/)

## 📌 Introducción del Proyecto

Completamente de código abierto y gratuito - Plugin de asistente IA para WordPress, que permite: chat conversacional IA (generación de texto, imagen y video), reproducción de voz conversacional IA, generación de artículos IA, análisis SEO de artículos IA, resumen de artículos IA, traducción de artículos IA, generación de PowerPoint IA, análisis de documentos IA, aplicaciones de agentes inteligentes IA y reproducción de voz del contenido de artículos.

Si no sabes cómo usarlo, lee primero la documentación. Solo requiere configuración básica e integración de claves API, y este tipo de plugin no requiere requisitos de alto nivel.

Actualizaciones relacionadas con el código fuente comercial de la herramienta Wuji AI: <https://www.wujiit.com>

## 🚀 Características

1. Interfaz de texto Deepseek integrada
1. Interfaz de texto Ali Tongyi Qianwen integrada
1. Interfaz de texto Baidu Qianfan (Wenxin Yiyan) integrada
1. Interfaz de texto Doubao AI integrada
1. Interfaz de texto Kimi integrada
1. Interfaz de texto OpenAI integrada
1. Interfaz de texto Tencent Hunyuan integrada
1. Interfaz de texto Grok integrada
1. Interfaz de texto Gemini integrada
1. Interfaz de texto Claude integrada
1. Interfaz de texto iFlytek Spark integrada
1. Interfaz de modelo de texto IA personalizada integrada
1. Soporta integración con aplicaciones de agentes inteligentes de Alibaba
1. Soporta integración con aplicaciones de agentes inteligentes de Volcano Engine
1. Soporta integración con aplicaciones de agentes inteligentes de Tencent Yuanqi
1. Soporta integración con aplicaciones de agentes inteligentes de ByteButton
1. Soporta generación de archivos PPT usando la interfaz Wenduoduo AIPPT
1. Soporta modelo de texto a imagen con IA mediante polling
1. Soporta modelo de generación de imágenes de Tongyi Qianwen
1. Soporta modelo de generación de videos de Tongyi Qianwen (texto a video e imagen a video)
1. Soporta búsqueda en línea para algunos modelos de Tongyi Qianwen e iFlytek Spark
1. Los parámetros del modelo son personalizables
1. El sistema almacena la primera oración de los registros de conversación en una tabla de datos separada
1. Los usuarios pueden eliminar su propio historial de conversaciones
1. Los registros de conversación de usuarios se pueden eliminar en el backend
1. Las conversaciones de aplicaciones de agentes de usuarios se pueden eliminar en el backend
1. Se pueden generar artículos basados en palabras clave
1. Se pueden crear resúmenes de artículos usando la interfaz IA
1. Muestra el portal del asistente IA en el frontend
1. El acceso está limitado a usuarios registrados
1. Soporta formato Markdown
1. Información de saldo de DeepSeek
1. Se puede realizar traducción de artículos usando la interfaz IA
1. Soporta integración con servicios TTS de Tencent Cloud y Baidu Cloud para reproducción de voz del contenido de artículos
1. Reproducción de voz de respuestas IA
1. Prompts personalizables
1. Enlace de tutorial de palabras de prompt personalizable
1. Cargar automáticamente el botón de copiar para contenido Markdown
1. Soporta detección de palabras clave
1. Los PPT generados por IA pueden verificar permisos de miembros (puede no funcionar en algunos sitios web)
1. Preguntas de apertura de aplicaciones de agentes inteligentes
1. Personalizar el nombre del asistente IA del frontend, etc.
1. Personalizar el texto de aviso de cierre de sesión
1. Soportar selección de interfaz de usuario del frontend
1. Soportar Kimi y Tongyi Qianwen qwen-long para cargar archivos para análisis de contenido de documentos
1. Soportar selección de parámetros de modelo de usuario del frontend
1. Soporta análisis SEO del contenido de artículos y detección de errores tipográficos

## 📥 Instalación

1. Descarga la versión más reciente.

2. Accede al backend de plugins de WordPress

3. Sube el paquete de archivos local para la instalación

O sube directamente al directorio de plugins del sitio web /wp-content/plugins en el servidor. Recuerda configurar los permisos.

Base de Desarrollo: WordPress 6.7.1
Versión PHP: PHP 8.0

## 🛠️ Instrucciones

Se creará automáticamente una página de chat del frontend cuando se habilite el plugin. Si no, agrega manualmente el shortcode: [deepseek_chat]

1 - La interfaz de traducción de artículos necesita configurarse por separado. Esto era originalmente parte de otro plugin, pero lo fusioné y lo uso directamente sin más complicaciones.

2 - La función de generación de PPT por IA también se fusionó desde un plugin separado, y esta característica se adaptó originalmente para mi propio tema, por lo que la compatibilidad puede ser pobre.

Si ya no usas el plugin, elimina las siguientes tablas en tu base de datos: deepseek_chat_logs y deepseek_agent_chat_logs.

Tutorial: <https://www.wujiit.com/wpaidocs>

Tu página de tema debe soportar modo de ancho completo o pantalla completa; de lo contrario, aparecerá demasiado estrecho. Si no, revisa la hoja de estilos de tu tema y habilita la visualización en pantalla completa de la página del Asistente Deepseek a través de código.

Este plugin se diseñó originalmente para probar la capacidad de DeepSeek de escribir su propio código. Parte de él era código propio de DeepSeek (la interfaz de diálogo IA con DeepSeek y la versión más temprana de generación de artículos). Otros plugins se fusionaron posteriormente en él, por lo que los nombres de funciones y otras cosas en el código pueden verse desordenados, pero todos están comentados.

## Descripción de Archivos

Archivo Principal: wp-ai-chat.php
Archivo de Audio de Traducción: wpaitranslate.php
Archivo de PowerPoint Generado por IA: wpaippt.php
Archivo de Aplicación de Agente: wpaidashscope.php
Archivo JS Principal: wpai-chat.js
Archivo CSS: wpai-style.css
Archivo JS de Audio de Traducción: wpai-script.js
Archivo JS de Llamada de PowerPoint: docmee-ui-sdk-iframe.min.js
Archivo de Analizador Markdown: marked.min.js

## Patrocinio

La aceleración CDN y protección de seguridad para este proyecto son patrocinadas por Tencent EdgeOne. EdgeOne ofrece un plan gratuito a largo plazo con tráfico y solicitudes ilimitadas, cubriendo nodos en China Continental, sin cargos por exceso. Las partes interesadas pueden hacer clic en el enlace a continuación para reclamar su suscripción.

[Las Mejores Soluciones CDN, Edge y de Seguridad de Asia - Tencent EdgeOne](https://edgeone.ai/zh?from=github)

[![EdgeOne](https://edgeone.ai/media/34fe3a45-492d-4ea4-ae5d-ea1087ca7b4b.png)](https://edgeone.ai/?from=github)
PowerPoint Calling JS File: docmee-ui-sdk-iframe.min.js
Markdown Parser File: marked.min.js

## Sponsorship

CDN acceleration and security protection for this project are sponsored by Tencent EdgeOne. EdgeOne offers a long-term free plan with unlimited traffic and requests, covering nodes in Mainland China, with no overage charges. Interested parties can click the link below to claim your subscription.

CDN acceleration and security protection for this project are sponsored by Tencent EdgeOne. EdgeOne offers a long-term free plan with unlimited traffic and requests, covering nodes in Mainland China, with no overage charges. charges. Interested parties can click the link below to claim it.

[Best Asian CDN, Edge, and Security Solutions - Tencent EdgeOne](https://edgeone.ai/zh?from=github)

[Best Asian CDN, Edge, and Secure Solutions - Tencent EdgeOne](https://edgeone.ai/zh?from=github)

[![EdgeOne](https://edgeone.ai/media/34fe3a45-492d-4ea4-ae5d-ea1087ca7b4b.png)](https://edgeone.ai/?from=github)
