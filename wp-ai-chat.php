<?php
/*
Plugin Name: WordPress AI Chat Assistant
Description: Comprehensive AI assistant plugin for WordPress with support for DeepSeek, Qwen, GPT and other AI models. Features include conversational chat, content generation, SEO analysis, translation, PPT creation, and intelligent agent applications.
Plugin URI: https://github.com/suqicloud/wp-ai-chat
Version: 4.0.5
Author: Summer
License: GPL-2.0+
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Author URI: https://www.jingxialai.com/
Text Domain: wp-ai-chat
Domain Path: /languages
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 8.0
Network: false
*/

// Prevent direct access
if (!defined('ABSPATH')) {
  exit;
}

// Plugin constants
define('WP_AI_CHAT_VERSION', '4.0.5');
define('WP_AI_CHAT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WP_AI_CHAT_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WP_AI_CHAT_TEXT_DOMAIN', 'wp-ai-chat');

// Include autoloader
require_once WP_AI_CHAT_PLUGIN_DIR . 'includes/class-autoloader.php';

// Load plugin text domain for internationalization
function wp_ai_chat_load_textdomain()
{
  load_plugin_textdomain(
    WP_AI_CHAT_TEXT_DOMAIN,
    false,
    dirname(plugin_basename(__FILE__)) . '/languages'
  );
}
add_action('plugins_loaded', 'wp_ai_chat_load_textdomain');

// Initialize the main plugin class
function wp_ai_chat_init()
{
  // Include main plugin class
  require_once WP_AI_CHAT_PLUGIN_DIR . 'includes/class-wp-ai-chat.php';

  // Start the plugin
  \WP_AI_Chat\wp_ai_chat();
}

// Hook initialization
add_action('plugins_loaded', 'wp_ai_chat_init', 10);

// Plugin activation hook
register_activation_hook(__FILE__, function () {
  // Create database tables and default content
  wp_ai_chat_init();
  $plugin = \WP_AI_Chat\wp_ai_chat();
  $plugin->activate();
});

// Plugin deactivation hook
register_deactivation_hook(__FILE__, function () {
  if (function_exists('\WP_AI_Chat\wp_ai_chat')) {
    $plugin = \WP_AI_Chat\wp_ai_chat();
    $plugin->deactivate();
  }
});

// Add settings link to plugin list
function wp_ai_chat_add_settings_link($links)
{
  $settings_link = '<a href="admin.php?page=wp-ai-chat">' . __('Settings', WP_AI_CHAT_TEXT_DOMAIN) . '</a>';
  array_unshift($links, $settings_link);
  return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wp_ai_chat_add_settings_link');
