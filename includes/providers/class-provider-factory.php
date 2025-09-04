<?php

/**
 * AI Provider Factory
 *
 * @package WP_AI_Chat\Providers
 * @since   1.0.0
 */

namespace WP_AI_Chat\Providers;

// Prevent direct access
if (!defined('ABSPATH')) {
  exit;
}

/**
 * Provider Factory Class
 *
 * Manages AI provider instances and registration
 */
class Provider_Factory
{
  /**
   * Registered providers
   *
   * @var array
   */
  private $providers = [];

  /**
   * Provider instances
   *
   * @var array
   */
  private $instances = [];

  /**
   * Constructor
   */
  public function __construct()
  {
    $this->register_default_providers();

    // Allow plugins to register custom providers
    do_action('wp_ai_chat_register_providers', $this);
  }

  /**
   * Register default providers
   */
  private function register_default_providers()
  {
    $this->register_provider('deepseek', DeepSeek::class);
    $this->register_provider('openai', OpenAI::class);
    $this->register_provider('qwen', Qwen::class);
    $this->register_provider('claude', Claude::class);
    $this->register_provider('gemini', Gemini::class);
  }

  /**
   * Register a provider
   *
   * @param string $name Provider name
   * @param string $class_name Provider class name
   * @param array  $args Optional arguments
   * @return bool Success status
   */
  public function register_provider($name, $class_name, $args = [])
  {
    if (empty($name) || empty($class_name)) {
      return false;
    }

    // Validate class exists and extends Abstract_Provider
    if (!class_exists($class_name) || !is_subclass_of($class_name, Abstract_Provider::class)) {
      error_log("WP AI Chat: Provider class {$class_name} does not exist or does not extend Abstract_Provider");
      return false;
    }

    $this->providers[$name] = [
      'class' => $class_name,
      'args' => $args,
    ];

    return true;
  }

  /**
   * Unregister a provider
   *
   * @param string $name Provider name
   * @return bool Success status
   */
  public function unregister_provider($name)
  {
    if (!isset($this->providers[$name])) {
      return false;
    }

    unset($this->providers[$name]);

    // Remove instance if exists
    if (isset($this->instances[$name])) {
      unset($this->instances[$name]);
    }

    return true;
  }

  /**
   * Get provider instance
   *
   * @param string $name Provider name
   * @return Abstract_Provider|false Provider instance or false
   */
  public function get_provider($name = '')
  {
    // If no name provided, get default provider
    if (empty($name)) {
      $name = $this->get_default_provider();
    }

    // Return cached instance if exists
    if (isset($this->instances[$name])) {
      return $this->instances[$name];
    }

    // Check if provider is registered
    if (!isset($this->providers[$name])) {
      error_log("WP AI Chat: Provider '{$name}' is not registered");
      return false;
    }

    $provider_config = $this->providers[$name];
    $class_name = $provider_config['class'];
    $args = $provider_config['args'];

    try {
      // Load provider settings
      $settings = $this->get_provider_settings($name);
      $config = array_merge($args, $settings);

      // Create instance
      $instance = new $class_name($config);

      // Cache instance
      $this->instances[$name] = $instance;

      return $instance;
    } catch (Exception $e) {
      error_log("WP AI Chat: Error creating provider '{$name}': " . $e->getMessage());
      return false;
    }
  }

  /**
   * Get all registered providers
   *
   * @return array Provider names and classes
   */
  public function get_registered_providers()
  {
    return $this->providers;
  }

  /**
   * Get available providers (configured and ready)
   *
   * @return array Available provider instances
   */
  public function get_available_providers()
  {
    $available = [];

    foreach (array_keys($this->providers) as $name) {
      $provider = $this->get_provider($name);
      if ($provider && $provider->is_configured()) {
        $available[$name] = $provider;
      }
    }

    return $available;
  }

  /**
   * Check if provider exists
   *
   * @param string $name Provider name
   * @return bool
   */
  public function provider_exists($name)
  {
    return isset($this->providers[$name]);
  }

  /**
   * Get default provider name
   *
   * @return string
   */
  public function get_default_provider()
  {
    $default = get_option('wp_ai_chat_default_provider', 'deepseek');

    // Ensure default provider is registered
    if (!$this->provider_exists($default)) {
      $registered = array_keys($this->providers);
      $default = !empty($registered) ? $registered[0] : 'deepseek';
    }

    return apply_filters('wp_ai_chat_default_provider', $default);
  }

  /**
   * Set default provider
   *
   * @param string $name Provider name
   * @return bool Success status
   */
  public function set_default_provider($name)
  {
    if (!$this->provider_exists($name)) {
      return false;
    }

    return update_option('wp_ai_chat_default_provider', $name);
  }

  /**
   * Get provider settings
   *
   * @param string $name Provider name
   * @return array Provider settings
   */
  private function get_provider_settings($name)
  {
    $option_key = "wp_ai_chat_{$name}_settings";
    return get_option($option_key, []);
  }

  /**
   * Get providers list for admin interface
   *
   * @return array Formatted providers list
   */
  public function get_providers_for_admin()
  {
    $providers_list = [];

    foreach ($this->providers as $name => $config) {
      $provider = $this->get_provider($name);

      if ($provider) {
        $providers_list[$name] = [
          'name' => $name,
          'display_name' => $provider->get_display_name(),
          'configured' => $provider->is_configured(),
          'supported_features' => $provider->get_supported_features(),
          'available_models' => $provider->get_available_models(),
          'settings_schema' => method_exists($provider, 'get_settings_schema')
            ? $provider->get_settings_schema()
            : [],
        ];
      }
    }

    return $providers_list;
  }

  /**
   * Get providers by feature
   *
   * @param string $feature Feature name (e.g., 'streaming', 'image_generation')
   * @return array Providers that support the feature
   */
  public function get_providers_by_feature($feature)
  {
    $providers_with_feature = [];

    foreach ($this->get_available_providers() as $name => $provider) {
      if ($provider->supports_feature($feature)) {
        $providers_with_feature[$name] = $provider;
      }
    }

    return $providers_with_feature;
  }

  /**
   * Validate all provider configurations
   *
   * @return array Validation results
   */
  public function validate_all_providers()
  {
    $results = [];

    foreach (array_keys($this->providers) as $name) {
      $provider = $this->get_provider($name);

      if ($provider) {
        $validation = $provider->validate_api_key();
        $results[$name] = [
          'configured' => $provider->is_configured(),
          'valid' => !is_wp_error($validation),
          'error' => is_wp_error($validation) ? $validation->get_error_message() : null,
        ];
      } else {
        $results[$name] = [
          'configured' => false,
          'valid' => false,
          'error' => 'Provider could not be instantiated',
        ];
      }
    }

    return $results;
  }

  /**
   * Get provider statistics
   *
   * @return array Provider usage statistics
   */
  public function get_provider_statistics()
  {
    global $wpdb;

    $table_name = $wpdb->prefix . 'deepseek_chat_logs';

    // This is a simplified version - in reality, you'd track provider usage
    $stats = [
      'total_requests' => 0,
      'by_provider' => [],
      'last_24h' => 0,
    ];

    // Query would depend on how you track provider usage in the database
    // This is just a placeholder structure

    return $stats;
  }

  /**
   * Clear provider instances cache
   */
  public function clear_cache()
  {
    $this->instances = [];
  }

  /**
   * Get provider instance without caching
   *
   * @param string $name Provider name
   * @return Abstract_Provider|false
   */
  public function create_fresh_provider($name)
  {
    if (!isset($this->providers[$name])) {
      return false;
    }

    $provider_config = $this->providers[$name];
    $class_name = $provider_config['class'];
    $args = $provider_config['args'];

    $settings = $this->get_provider_settings($name);
    $config = array_merge($args, $settings);

    try {
      return new $class_name($config);
    } catch (Exception $e) {
      error_log("WP AI Chat: Error creating fresh provider '{$name}': " . $e->getMessage());
      return false;
    }
  }
}
