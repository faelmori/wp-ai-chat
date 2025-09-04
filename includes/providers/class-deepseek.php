<?php
/**
 * DeepSeek AI Provider
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
 * DeepSeek Provider Class
 *
 * Handles communication with DeepSeek AI API
 */
class DeepSeek extends Abstract_Provider
{
  /**
   * Provider name
   *
   * @var string
   */
  protected $name = 'deepseek';

  /**
   * Provider display name
   *
   * @var string
   */
  protected $display_name = 'DeepSeek';

  /**
   * API endpoint URL
   *
   * @var string
   */
  protected $api_endpoint = 'https://api.deepseek.com';

  /**
   * Default model
   *
   * @var string
   */
  protected $default_model = 'deepseek-chat';

  /**
   * Available models
   *
   * @var array
   */
  protected $available_models = [
    'deepseek-chat' => 'DeepSeek Chat',
    'deepseek-coder' => 'DeepSeek Coder',
  ];

  /**
   * Supported features
   *
   * @var array
   */
  protected $supported_features = [
    'chat' => true,
    'streaming' => true,
    'image_generation' => false,
    'file_upload' => false,
    'web_search' => false,
  ];

  /**
   * Rate limit settings (DeepSeek specific)
   *
   * @var array
   */
  protected $rate_limits = [
    'requests_per_minute' => 60,
    'tokens_per_minute' => 200000,
  ];

  /**
   * Send chat message to DeepSeek API
   *
   * @param string $message User message
   * @param array  $options Request options
   * @return array|WP_Error Response data or error
   */
  public function send_message($message, $options = [])
  {
    if (!$this->is_configured()) {
      return new \WP_Error(
        'provider_not_configured',
        __('DeepSeek provider is not properly configured.', 'wp-ai-chat')
      );
    }

    $message = $this->sanitize_message($message);

    if (empty($message)) {
      return new \WP_Error(
        'empty_message',
        __('Message cannot be empty.', 'wp-ai-chat')
      );
    }

    $model = isset($options['model']) ? $options['model'] : $this->default_model;
    $temperature = isset($options['temperature']) ? floatval($options['temperature']) : 0.7;
    $max_tokens = isset($options['max_tokens']) ? intval($options['max_tokens']) : 4000;

    $messages = $this->prepare_messages($message, $options);

    $body = [
      'model' => $model,
      'messages' => $messages,
      'temperature' => $temperature,
      'max_tokens' => $max_tokens,
      'stream' => false,
    ];

    // Add system message if provided
    if (isset($options['system_prompt']) && !empty($options['system_prompt'])) {
      array_unshift($messages, [
        'role' => 'system',
        'content' => $this->sanitize_message($options['system_prompt'])
      ]);
      $body['messages'] = $messages;
    }

    $this->log_activity('send_message', [
      'model' => $model,
      'message_length' => strlen($message),
    ]);

    $response = $this->make_request('chat/completions', $body);

    if (is_wp_error($response)) {
      $this->log_activity('send_message_error', [
        'error' => $response->get_error_message(),
      ]);
      return $response;
    }

    return $this->process_chat_response($response);
  }

  /**
   * Stream chat response from DeepSeek API
   *
   * @param string $message User message
   * @param array  $options Request options
   * @return Generator|WP_Error Stream generator or error
   */
  protected function do_stream_request($message, $options = [])
  {
    if (!$this->is_configured()) {
      return new \WP_Error(
        'provider_not_configured',
        __('DeepSeek provider is not properly configured.', 'wp-ai-chat')
      );
    }

    $message = $this->sanitize_message($message);
    $model = isset($options['model']) ? $options['model'] : $this->default_model;
    $temperature = isset($options['temperature']) ? floatval($options['temperature']) : 0.7;

    $messages = $this->prepare_messages($message, $options);

    $body = [
      'model' => $model,
      'messages' => $messages,
      'temperature' => $temperature,
      'stream' => true,
    ];

    $url = trailingslashit($this->api_endpoint) . 'chat/completions';

    $args = [
      'method' => 'POST',
      'headers' => $this->build_headers(),
      'body' => wp_json_encode($body),
      'timeout' => 60,
      'stream' => true,
    ];

    // Note: This is a simplified streaming implementation
    // In a real implementation, you'd use curl with callbacks or similar
    return $this->process_streaming_response($url, $args);
  }

  /**
   * Prepare messages array for API request
   *
   * @param string $message Current message
   * @param array  $options Options including conversation history
   * @return array
   */
  private function prepare_messages($message, $options = [])
  {
    $messages = [];

    // Add conversation history if provided
    if (isset($options['conversation_history']) && is_array($options['conversation_history'])) {
      foreach ($options['conversation_history'] as $history_item) {
        if (isset($history_item['role']) && isset($history_item['content'])) {
          $messages[] = [
            'role' => sanitize_text_field($history_item['role']),
            'content' => $this->sanitize_message($history_item['content'])
          ];
        }
      }
    }

    // Add current message
    $messages[] = [
      'role' => 'user',
      'content' => $message
    ];

    return $messages;
  }

  /**
   * Process chat response from DeepSeek API
   *
   * @param array $response API response
   * @return array Processed response
   */
  private function process_chat_response($response)
  {
    if (!isset($response['choices'][0]['message']['content'])) {
      return new \WP_Error(
        'invalid_response',
        __('Invalid response from DeepSeek API.', 'wp-ai-chat')
      );
    }

    $content = $response['choices'][0]['message']['content'];
    $usage = isset($response['usage']) ? $response['usage'] : [];

    return [
      'success' => true,
      'content' => $content,
      'usage' => $usage,
      'model' => $response['model'] ?? $this->default_model,
      'provider' => $this->name,
    ];
  }

  /**
   * Process streaming response (simplified implementation)
   *
   * @param string $url Request URL
   * @param array  $args Request arguments
   * @return Generator
   */
  private function process_streaming_response($url, $args)
  {
    // This is a simplified implementation
    // In production, you'd use curl with CURLOPT_WRITEFUNCTION

    $response = wp_remote_request($url, $args);

    if (is_wp_error($response)) {
      yield ['error' => $response->get_error_message()];
      return;
    }

    $body = wp_remote_retrieve_body($response);
    $lines = explode("\n", $body);

    foreach ($lines as $line) {
      if (strpos($line, 'data: ') === 0) {
        $data = substr($line, 6);

        if ($data === '[DONE]') {
          yield ['done' => true];
          break;
        }

        $decoded = json_decode($data, true);
        if ($decoded && isset($decoded['choices'][0]['delta']['content'])) {
          yield [
            'content' => $decoded['choices'][0]['delta']['content'],
            'done' => false
          ];
        }
      }
    }
  }

  /**
   * Get account balance from DeepSeek API
   *
   * @return array|WP_Error Balance information or error
   */
  public function get_balance()
  {
    if (!$this->is_configured()) {
      return new \WP_Error(
        'provider_not_configured',
        __('DeepSeek provider is not properly configured.', 'wp-ai-chat')
      );
    }

    $response = $this->make_request('user/balance', [], ['method' => 'GET']);

    if (is_wp_error($response)) {
      return $response;
    }

    return [
      'success' => true,
      'balance' => $response,
    ];
  }

  /**
   * Image generation (not supported by DeepSeek)
   *
   * @param string $prompt Image prompt
   * @param array  $options Generation options
   * @return WP_Error
   */
  protected function do_image_request($prompt, $options = [])
  {
    return new \WP_Error(
      'feature_not_supported',
      __('Image generation is not supported by DeepSeek.', 'wp-ai-chat')
    );
  }

  /**
   * File analysis (not supported by DeepSeek)
   *
   * @param string $file_path File path
   * @param array  $options Analysis options
   * @return WP_Error
   */
  protected function do_file_analysis($file_path, $options = [])
  {
    return new \WP_Error(
      'feature_not_supported',
      __('File analysis is not supported by DeepSeek.', 'wp-ai-chat')
    );
  }

  /**
   * Validate API key with DeepSeek
   *
   * @return bool|WP_Error
   */
  protected function do_api_validation()
  {
    $response = $this->make_request('user/balance', [], ['method' => 'GET']);

    if (is_wp_error($response)) {
      return new \WP_Error(
        'invalid_api_key',
        __('Invalid DeepSeek API key.', 'wp-ai-chat')
      );
    }

    return true;
  }

  /**
   * Get DeepSeek specific settings schema
   *
   * @return array
   */
  public function get_settings_schema()
  {
    return [
      'api_key' => [
        'type' => 'string',
        'label' => __('API Key', 'wp-ai-chat'),
        'description' => __('Your DeepSeek API key from platform.deepseek.com', 'wp-ai-chat'),
        'required' => true,
      ],
      'default_model' => [
        'type' => 'select',
        'label' => __('Default Model', 'wp-ai-chat'),
        'description' => __('The default model to use for chat requests', 'wp-ai-chat'),
        'options' => $this->available_models,
        'default' => $this->default_model,
      ],
      'temperature' => [
        'type' => 'number',
        'label' => __('Temperature', 'wp-ai-chat'),
        'description' => __('Controls randomness: 0 is focused, 1 is creative', 'wp-ai-chat'),
        'min' => 0,
        'max' => 1,
        'step' => 0.1,
        'default' => 0.7,
      ],
      'max_tokens' => [
        'type' => 'number',
        'label' => __('Max Tokens', 'wp-ai-chat'),
        'description' => __('Maximum number of tokens in the response', 'wp-ai-chat'),
        'min' => 1,
        'max' => 8000,
        'default' => 4000,
      ],
    ];
  }
}
