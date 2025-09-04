<?php
/**
 * Abstract AI Provider Class
 *
 * Base class for all AI service providers
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
 * Abstract AI Provider
 *
 * Defines the interface and common functionality for all AI providers.
 * Each provider must implement the abstract methods to handle API communication.
 */
abstract class Abstract_Provider
{
  /**
   * Provider name
   *
   * @var string
   */
  protected $name = '';

  /**
   * Provider display name
   *
   * @var string
   */
  protected $display_name = '';

  /**
   * API endpoint URL
   *
   * @var string
   */
  protected $api_endpoint = '';

  /**
   * API key
   *
   * @var string
   */
  protected $api_key = '';

  /**
   * Default model
   *
   * @var string
   */
  protected $default_model = '';

  /**
   * Available models
   *
   * @var array
   */
  protected $available_models = [];

  /**
   * Supported features
   *
   * @var array
   */
  protected $supported_features = [
    'chat' => true,
    'streaming' => false,
    'image_generation' => false,
    'file_upload' => false,
    'web_search' => false,
  ];

  /**
   * Rate limit settings
   *
   * @var array
   */
  protected $rate_limits = [
    'requests_per_minute' => 60,
    'tokens_per_minute' => 150000,
  ];

  /**
   * Constructor
   *
   * @param array $config Provider configuration
   */
  public function __construct($config = [])
  {
    $this->configure($config);
    $this->load_settings();
  }

  /**
   * Configure provider with given settings
   *
   * @param array $config Configuration array
   */
  protected function configure($config)
  {
    if (isset($config['api_key'])) {
      $this->api_key = sanitize_text_field($config['api_key']);
    }

    if (isset($config['api_endpoint'])) {
      $this->api_endpoint = esc_url_raw($config['api_endpoint']);
    }

    if (isset($config['default_model'])) {
      $this->default_model = sanitize_text_field($config['default_model']);
    }
  }

  /**
   * Load provider settings from WordPress options
   */
  protected function load_settings()
  {
    $option_key = 'wp_ai_chat_' . $this->name . '_settings';
    $settings = get_option($option_key, []);

    if (isset($settings['api_key'])) {
      $this->api_key = $settings['api_key'];
    }

    if (isset($settings['default_model'])) {
      $this->default_model = $settings['default_model'];
    }
  }

  /**
   * Send chat message
   *
   * @param string $message User message
   * @param array  $options Request options
   * @return array|WP_Error Response data or error
   */
  abstract public function send_message($message, $options = []);

  /**
   * Stream chat response
   *
   * @param string $message User message
   * @param array  $options Request options
   * @return Generator|WP_Error Stream generator or error
   */
  public function stream_message($message, $options = [])
  {
    if (!$this->supports_feature('streaming')) {
      return new \WP_Error(
        'feature_not_supported',
        __('Streaming is not supported by this provider.', 'wp-ai-chat')
      );
    }

    return $this->do_stream_request($message, $options);
  }

  /**
   * Generate image
   *
   * @param string $prompt Image prompt
   * @param array  $options Generation options
   * @return array|WP_Error Response data or error
   */
  public function generate_image($prompt, $options = [])
  {
    if (!$this->supports_feature('image_generation')) {
      return new \WP_Error(
        'feature_not_supported',
        __('Image generation is not supported by this provider.', 'wp-ai-chat')
      );
    }

    return $this->do_image_request($prompt, $options);
  }

  /**
   * Upload and analyze file
   *
   * @param string $file_path File path
   * @param array  $options Analysis options
   * @return array|WP_Error Response data or error
   */
  public function analyze_file($file_path, $options = [])
  {
    if (!$this->supports_feature('file_upload')) {
      return new \WP_Error(
        'feature_not_supported',
        __('File analysis is not supported by this provider.', 'wp-ai-chat')
      );
    }

    if (!file_exists($file_path)) {
      return new \WP_Error(
        'file_not_found',
        __('File not found.', 'wp-ai-chat')
      );
    }

    return $this->do_file_analysis($file_path, $options);
  }

  /**
   * Check if provider supports a feature
   *
   * @param string $feature Feature name
   * @return bool
   */
  public function supports_feature($feature)
  {
    return isset($this->supported_features[$feature]) && $this->supported_features[$feature];
  }

  /**
   * Get provider name
   *
   * @return string
   */
  public function get_name()
  {
    return $this->name;
  }

  /**
   * Get provider display name
   *
   * @return string
   */
  public function get_display_name()
  {
    return $this->display_name ?: ucfirst($this->name);
  }

  /**
   * Get available models
   *
   * @return array
   */
  public function get_available_models()
  {
    return $this->available_models;
  }

  /**
   * Get default model
   *
   * @return string
   */
  public function get_default_model()
  {
    return $this->default_model;
  }

  /**
   * Get supported features
   *
   * @return array
   */
  public function get_supported_features()
  {
    return $this->supported_features;
  }

  /**
   * Check if provider is configured
   *
   * @return bool
   */
  public function is_configured()
  {
    return !empty($this->api_key) && !empty($this->api_endpoint);
  }

  /**
   * Get rate limits
   *
   * @return array
   */
  public function get_rate_limits()
  {
    return $this->rate_limits;
  }

  /**
   * Validate API key
   *
   * @return bool|WP_Error
   */
  public function validate_api_key()
  {
    if (empty($this->api_key)) {
      return new \WP_Error(
        'missing_api_key',
        __('API key is required.', 'wp-ai-chat')
      );
    }

    return $this->do_api_validation();
  }

  /**
   * Build request headers
   *
   * @param array $additional_headers Additional headers
   * @return array
   */
  protected function build_headers($additional_headers = [])
  {
    $headers = [
      'Content-Type' => 'application/json',
      'User-Agent' => 'WP-AI-Chat/' . WP_AI_CHAT_VERSION,
    ];

    if (!empty($this->api_key)) {
      $headers['Authorization'] = 'Bearer ' . $this->api_key;
    }

    return array_merge($headers, $additional_headers);
  }

  /**
   * Make HTTP request
   *
   * @param string $endpoint API endpoint
   * @param array  $body Request body
   * @param array  $args Additional arguments
   * @return array|WP_Error
   */
  protected function make_request($endpoint, $body = [], $args = [])
  {
    $url = trailingslashit($this->api_endpoint) . ltrim($endpoint, '/');

    $default_args = [
      'method' => 'POST',
      'headers' => $this->build_headers(),
      'body' => wp_json_encode($body),
      'timeout' => 30,
    ];

    $request_args = wp_parse_args($args, $default_args);

    // Apply filters for customization
    $request_args = apply_filters('wp_ai_chat_request_args', $request_args, $this->name, $endpoint);

    $response = wp_remote_request($url, $request_args);

    if (is_wp_error($response)) {
      return $response;
    }

    $response_code = wp_remote_retrieve_response_code($response);
    $response_body = wp_remote_retrieve_body($response);

    if ($response_code >= 400) {
      $error_data = json_decode($response_body, true);
      $error_message = isset($error_data['error']['message'])
        ? $error_data['error']['message']
        : 'API request failed';

      return new \WP_Error(
        'api_error',
        $error_message,
        ['response_code' => $response_code, 'response_body' => $response_body]
      );
    }

    $decoded_response = json_decode($response_body, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
      return new \WP_Error(
        'json_decode_error',
        __('Failed to decode API response.', 'wp-ai-chat')
      );
    }

    return $decoded_response;
  }

  /**
   * Sanitize message content
   *
   * @param string $message Message to sanitize
   * @return string
   */
  protected function sanitize_message($message)
  {
    return wp_kses_post(trim($message));
  }

  /**
   * Log provider activity
   *
   * @param string $action Action performed
   * @param array  $data Additional data
   */
  protected function log_activity($action, $data = [])
  {
    if (!WP_DEBUG) {
      return;
    }

    $log_data = [
      'provider' => $this->name,
      'action' => $action,
      'timestamp' => current_time('mysql'),
      'data' => $data,
    ];

    error_log('WP AI Chat: ' . wp_json_encode($log_data));
  }

  // Abstract methods that must be implemented by providers

  /**
   * Perform streaming request
   *
   * @param string $message User message
   * @param array  $options Request options
   * @return Generator|WP_Error
   */
  abstract protected function do_stream_request($message, $options = []);

  /**
   * Perform image generation request
   *
   * @param string $prompt Image prompt
   * @param array  $options Generation options
   * @return array|WP_Error
   */
  abstract protected function do_image_request($prompt, $options = []);

  /**
   * Perform file analysis
   *
   * @param string $file_path File path
   * @param array  $options Analysis options
   * @return array|WP_Error
   */
  abstract protected function do_file_analysis($file_path, $options = []);

  /**
   * Validate API key with provider
   *
   * @return bool|WP_Error
   */
  abstract protected function do_api_validation();
}
