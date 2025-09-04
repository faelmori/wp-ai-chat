<?php
/**
 * Main Plugin Class
 *
 * @package WP_AI_Chat
 * @since   1.0.0
 */

namespace WP_AI_Chat;

use WP_AI_Chat\Core\Database;
use WP_AI_Chat\Core\Settings;
use WP_AI_Chat\Admin\Admin_Menu;
use WP_AI_Chat\Frontend\Shortcodes;
use WP_AI_Chat\Frontend\Ajax_Handlers;
use WP_AI_Chat\Providers\Provider_Factory;

// Prevent direct access
if (!defined('ABSPATH')) {
  exit;
}

/**
 * Main WP AI Chat Plugin Class
 *
 * Singleton pattern to ensure only one instance of the plugin runs.
 * Handles initialization, hooks, and coordination of all plugin components.
 */
final class WP_AI_Chat
{
  /**
   * Plugin instance
   *
   * @var WP_AI_Chat|null
   */
  private static $instance = null;

  /**
   * Plugin version
   *
   * @var string
   */
  public $version = WP_AI_CHAT_VERSION;

  /**
   * Database handler
   *
   * @var Database
   */
  public $database;

  /**
   * Settings handler
   *
   * @var Settings
   */
  public $settings;

  /**
   * Admin menu handler
   *
   * @var Admin_Menu
   */
  public $admin_menu;

  /**
   * Shortcodes handler
   *
   * @var Shortcodes
   */
  public $shortcodes;

  /**
   * AJAX handlers
   *
   * @var Ajax_Handlers
   */
  public $ajax_handlers;

  /**
   * Provider factory
   *
   * @var Provider_Factory
   */
  public $provider_factory;

  /**
   * Plugin initialization status
   *
   * @var bool
   */
  private $initialized = false;

  /**
   * Get plugin instance (Singleton pattern)
   *
   * @return WP_AI_Chat
   */
  public static function instance()
  {
    if (null === self::$instance) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  /**
   * Constructor - Private to enforce singleton
   */
  private function __construct()
  {
    $this->setup_constants();
    $this->includes();
    $this->init_hooks();
  }

  /**
   * Prevent cloning
   */
  private function __clone()
  {
  }

  /**
   * Prevent unserializing
   */
  private function __wakeup()
  {
  }

  /**
   * Setup plugin constants
   */
  private function setup_constants()
  {
    // Already defined in main plugin file, but ensure they exist
    if (!defined('WP_AI_CHAT_VERSION')) {
      define('WP_AI_CHAT_VERSION', '4.0.5');
    }

    if (!defined('WP_AI_CHAT_PLUGIN_DIR')) {
      define('WP_AI_CHAT_PLUGIN_DIR', plugin_dir_path(dirname(__FILE__)));
    }

    if (!defined('WP_AI_CHAT_PLUGIN_URL')) {
      define('WP_AI_CHAT_PLUGIN_URL', plugin_dir_url(dirname(__FILE__)));
    }

    if (!defined('WP_AI_CHAT_TEXT_DOMAIN')) {
      define('WP_AI_CHAT_TEXT_DOMAIN', 'wp-ai-chat');
    }
  }

  /**
   * Include required files
   */
  private function includes()
  {
    // Autoloader should handle class loading
    // Legacy includes for non-class files
    $legacy_files = [
      'wpaitranslate.php',
      'wpaippt.php',
      'wpaidashscope.php',
      'wpaifiles.php'
    ];

    foreach ($legacy_files as $file) {
      $file_path = WP_AI_CHAT_PLUGIN_DIR . $file;
      if (file_exists($file_path)) {
        require_once $file_path;
      }
    }
  }

  /**
   * Setup hooks
   */
  private function init_hooks()
  {
    // Plugin lifecycle hooks
    register_activation_hook(WP_AI_CHAT_PLUGIN_DIR . 'wp-ai-chat.php', [$this, 'activate']);
    register_deactivation_hook(WP_AI_CHAT_PLUGIN_DIR . 'wp-ai-chat.php', [$this, 'deactivate']);

    // WordPress init hooks
    add_action('init', [$this, 'init'], 0);
    add_action('plugins_loaded', [$this, 'load_textdomain']);

    // Admin hooks
    if (is_admin()) {
      add_action('admin_init', [$this, 'init_admin']);
    }

    // REST API hooks
    add_action('rest_api_init', [$this, 'init_rest_api']);

    // Frontend hooks
    if (!is_admin()) {
      add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_scripts']);
    }
  }

  /**
   * Initialize plugin
   */
  public function init()
  {
    if ($this->initialized) {
      return;
    }

    // Initialize core components
    $this->database = new Database();
    $this->settings = new Settings();
    $this->provider_factory = new Provider_Factory();

    // Initialize frontend components
    $this->shortcodes = new Shortcodes();
    $this->ajax_handlers = new Ajax_Handlers();

    // Fire init action
    do_action('wp_ai_chat_init', $this);

    $this->initialized = true;
  }

  /**
   * Initialize admin components
   */
  public function init_admin()
  {
    if (!current_user_can('manage_options')) {
      return;
    }

    $this->admin_menu = new Admin_Menu();

    add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
  }

  /**
   * Initialize REST API endpoints
   */
  public function init_rest_api()
  {
    // Register REST routes
    register_rest_route('wp-ai-chat/v1', '/chat', [
      'methods' => 'POST',
      'callback' => [$this->ajax_handlers, 'handle_rest_chat'],
      'permission_callback' => [$this, 'check_rest_permissions'],
    ]);
  }

  /**
   * Load plugin text domain
   */
  public function load_textdomain()
  {
    load_plugin_textdomain(
      WP_AI_CHAT_TEXT_DOMAIN,
      false,
      dirname(plugin_basename(WP_AI_CHAT_PLUGIN_DIR . 'wp-ai-chat.php')) . '/languages'
    );
  }

  /**
   * Plugin activation
   */
  public function activate()
  {
    // Initialize database if not already done
    if (!$this->database) {
      $this->database = new Database();
    }

    $this->database->create_tables();

    // Create default pages/posts if needed
    $this->create_default_content();

    // Set default options
    $this->settings->set_default_options();

    // Clear any caches
    flush_rewrite_rules();

    do_action('wp_ai_chat_activated');
  }

  /**
   * Plugin deactivation
   */
  public function deactivate()
  {
    // Clear scheduled events
    wp_clear_scheduled_hook('wp_ai_chat_cleanup');

    // Clear caches
    flush_rewrite_rules();

    do_action('wp_ai_chat_deactivated');
  }

  /**
   * Check REST API permissions
   *
   * @return bool
   */
  public function check_rest_permissions()
  {
    // For now, require user to be logged in
    // This can be customized based on plugin settings
    return is_user_logged_in();
  }

  /**
   * Enqueue frontend scripts and styles
   */
  public function enqueue_frontend_scripts()
  {
    wp_enqueue_style(
      'wp-ai-chat-frontend',
      WP_AI_CHAT_PLUGIN_URL . 'assets/css/frontend.css',
      [],
      $this->version
    );

    wp_enqueue_script(
      'wp-ai-chat-frontend',
      WP_AI_CHAT_PLUGIN_URL . 'assets/js/frontend.js',
      ['jquery'],
      $this->version,
      true
    );

    // Localize script with AJAX URL and nonces
    wp_localize_script('wp-ai-chat-frontend', 'wpAiChat', [
      'ajaxUrl' => admin_url('admin-ajax.php'),
      'restUrl' => rest_url('wp-ai-chat/v1/'),
      'nonce' => wp_create_nonce('wp_ai_chat_nonce'),
      'strings' => [
        'error' => __('An error occurred. Please try again.', WP_AI_CHAT_TEXT_DOMAIN),
        'loading' => __('Loading...', WP_AI_CHAT_TEXT_DOMAIN),
      ]
    ]);
  }

  /**
   * Enqueue admin scripts and styles
   */
  public function enqueue_admin_scripts()
  {
    $screen = get_current_screen();

    // Only load on plugin pages
    if (!$screen || strpos($screen->id, 'wp-ai-chat') === false) {
      return;
    }

    wp_enqueue_style(
      'wp-ai-chat-admin',
      WP_AI_CHAT_PLUGIN_URL . 'assets/css/admin.css',
      [],
      $this->version
    );

    wp_enqueue_script(
      'wp-ai-chat-admin',
      WP_AI_CHAT_PLUGIN_URL . 'assets/js/admin.js',
      ['jquery'],
      $this->version,
      true
    );
  }

  /**
   * Create default content (pages, posts, etc.)
   */
  private function create_default_content()
  {
    // Check if chat page already exists
    $existing_page = get_posts([
      'post_type' => 'page',
      'post_status' => 'publish',
      'meta_query' => [
        [
          'key' => '_wp_ai_chat_page',
          'value' => '1',
        ]
      ],
      'numberposts' => 1
    ]);

    if (empty($existing_page)) {
      // Create chat page
      $page_id = wp_insert_post([
        'post_title' => __('AI Chat', WP_AI_CHAT_TEXT_DOMAIN),
        'post_content' => '[wp_ai_chat]',
        'post_status' => 'publish',
        'post_type' => 'page',
        'meta_input' => [
          '_wp_ai_chat_page' => '1'
        ]
      ]);

      if ($page_id && !is_wp_error($page_id)) {
        update_option('wp_ai_chat_page_id', $page_id);
      }
    }
  }

  /**
   * Get provider instance
   *
   * @param string $provider_name Provider name
   * @return object|false Provider instance or false on failure
   */
  public function get_provider($provider_name = '')
  {
    if (!$this->provider_factory) {
      return false;
    }

    return $this->provider_factory->get_provider($provider_name);
  }

  /**
   * Get plugin version
   *
   * @return string
   */
  public function get_version()
  {
    return $this->version;
  }

  /**
   * Check if plugin is properly initialized
   *
   * @return bool
   */
  public function is_initialized()
  {
    return $this->initialized;
  }
}

/**
 * Get main plugin instance
 *
 * @return WP_AI_Chat
 */
function wp_ai_chat()
{
  return WP_AI_Chat::instance();
}
