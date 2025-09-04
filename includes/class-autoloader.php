<?php
/**
 * Autoloader for WP AI Chat Plugin
 *
 * PSR-4 compliant autoloader for WordPress environment
 *
 * @package WP_AI_Chat
 * @since   1.0.0
 */

namespace WP_AI_Chat;

// Prevent direct access
if (!defined('ABSPATH')) {
  exit;
}

/**
 * Class Autoloader
 *
 * Handles automatic loading of plugin classes following PSR-4 standards
 * adapted for WordPress conventions.
 */
class Autoloader
{
  /**
   * Base directory for the namespace prefix.
   *
   * @var string
   */
  private $base_dir;

  /**
   * Array of namespace prefixes and their base directories.
   *
   * @var array
   */
  private $namespaces = [];

  /**
   * Constructor
   *
   * @param string $base_dir Base directory for class files
   */
  public function __construct($base_dir = '')
  {
    $this->base_dir = $base_dir ?: WP_AI_CHAT_PLUGIN_DIR;
    $this->setup_namespaces();
  }

  /**
   * Setup namespace mappings
   */
  private function setup_namespaces()
  {
    $this->namespaces = [
      'WP_AI_Chat\\' => $this->base_dir . 'includes/',
      'WP_AI_Chat\\Core\\' => $this->base_dir . 'includes/core/',
      'WP_AI_Chat\\Providers\\' => $this->base_dir . 'includes/providers/',
      'WP_AI_Chat\\Admin\\' => $this->base_dir . 'includes/admin/',
      'WP_AI_Chat\\Frontend\\' => $this->base_dir . 'includes/frontend/',
      'WP_AI_Chat\\Integrations\\' => $this->base_dir . 'includes/integrations/',
    ];
  }

  /**
   * Register autoloader with SPL
   *
   * @return bool True on success, false on failure
   */
  public function register()
  {
    return spl_autoload_register([$this, 'load_class']);
  }

  /**
   * Unregister autoloader
   *
   * @return bool True on success, false on failure
   */
  public function unregister()
  {
    return spl_autoload_unregister([$this, 'load_class']);
  }

  /**
   * Load class file for the given class name
   *
   * @param string $class_name The fully-qualified class name
   * @return bool True if class was loaded, false otherwise
   */
  public function load_class($class_name)
  {
    // Find the longest matching namespace prefix
    $namespace_prefix = '';
    $base_dir = '';

    foreach ($this->namespaces as $prefix => $dir) {
      if (strpos($class_name, $prefix) === 0) {
        if (strlen($prefix) > strlen($namespace_prefix)) {
          $namespace_prefix = $prefix;
          $base_dir = $dir;
        }
      }
    }

    // If no namespace match found, skip
    if (empty($namespace_prefix)) {
      return false;
    }

    // Get the relative class name
    $relative_class = substr($class_name, strlen($namespace_prefix));

    // Convert namespace separators to directory separators
    $relative_class = str_replace('\\', '/', $relative_class);

    // Convert CamelCase to WordPress naming convention (kebab-case)
    $file_name = $this->convert_to_file_name($relative_class);

    // Build the full file path
    $file_path = $base_dir . $file_name . '.php';

    // If the file exists, require it
    if (file_exists($file_path)) {
      require_once $file_path;
      return true;
    }

    return false;
  }

  /**
   * Convert class name to WordPress file naming convention
   *
   * @param string $class_name Class name to convert
   * @return string Converted file name
   */
  private function convert_to_file_name($class_name)
  {
    // Handle different naming patterns
    $file_name = $class_name;

    // Convert PascalCase to kebab-case
    $file_name = preg_replace('/([a-z])([A-Z])/', '$1-$2', $file_name);
    $file_name = strtolower($file_name);

    // Add class- prefix if not present and not interface/trait/abstract
    if (!preg_match('/^(class-|interface-|trait-|abstract-)/', $file_name)) {
      $file_name = 'class-' . $file_name;
    }

    return $file_name;
  }

  /**
   * Get loaded classes (for debugging)
   *
   * @return array List of loaded classes
   */
  public function get_loaded_classes()
  {
    return array_filter(get_declared_classes(), function ($class) {
      return strpos($class, 'WP_AI_Chat\\') === 0;
    });
  }

  /**
   * Check if a class can be autoloaded
   *
   * @param string $class_name Class name to check
   * @return bool True if class can be loaded
   */
  public function can_load_class($class_name)
  {
    foreach ($this->namespaces as $prefix => $dir) {
      if (strpos($class_name, $prefix) === 0) {
        $relative_class = substr($class_name, strlen($prefix));
        $file_name = $this->convert_to_file_name($relative_class);
        $file_path = $dir . $file_name . '.php';

        return file_exists($file_path);
      }
    }

    return false;
  }
}

// Initialize autoloader if not already done
if (!class_exists('WP_AI_Chat\\Autoloader') || !function_exists('wp_ai_chat_autoloader')) {
  /**
   * Get plugin autoloader instance
   *
   * @return Autoloader
   */
  function wp_ai_chat_autoloader()
  {
    static $autoloader = null;

    if (null === $autoloader) {
      $autoloader = new Autoloader();
      $autoloader->register();
    }

    return $autoloader;
  }

  // Register autoloader
  wp_ai_chat_autoloader();
}
