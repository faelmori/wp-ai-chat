# Contributing to WordPress AI Chat Assistant

Thank you for your interest in contributing to this project! This guide will help you understand how to contribute effectively.

## 🚀 Getting Started

### Prerequisites

- WordPress 6.0+
- PHP 8.0+
- Basic knowledge of WordPress plugin development
- Familiarity with AI APIs (DeepSeek, OpenAI, etc.)

### Development Setup

1. **Clone the repository**

   ```bash
   git clone https://github.com/suqicloud/wp-ai-chat.git
   cd wp-ai-chat
   ```

2. **Install in WordPress**
   - Copy to `/wp-content/plugins/wp-ai-chat/`
   - Activate the plugin in WordPress admin
   - Configure API keys for testing

3. **Development Environment**
   - Use a local WordPress installation
   - Enable `WP_DEBUG` and `WP_DEBUG_LOG` in `wp-config.php`
   - Install WordPress Coding Standards for PHP_CodeSniffer

## 📝 How to Contribute

### Reporting Issues

- Use the [GitHub Issues](https://github.com/suqicloud/wp-ai-chat/issues) page
- Include WordPress version, PHP version, and plugin version
- Provide detailed steps to reproduce the issue
- Include relevant error messages or logs

### Submitting Changes

1. **Fork the repository**
2. **Create a feature branch**

   ```bash
   git checkout -b feature/your-feature-name
   ```

3. **Make your changes**
4. **Test thoroughly**
5. **Commit with clear messages**

   ```bash
   git commit -m "Add: New feature description"
   ```

6. **Push and create a Pull Request**

### Pull Request Guidelines

- **Clear Description**: Explain what your PR does and why
- **Small, Focused Changes**: One feature or fix per PR
- **Test Coverage**: Ensure your changes don't break existing functionality
- **Code Standards**: Follow WordPress Coding Standards
- **Documentation**: Update README or docs if necessary

## 🔧 Development Standards

### Code Quality

**PHP Standards:**

- Follow [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/)
- Use proper sanitization and escaping functions
- Implement nonce verification for all forms and AJAX requests
- Add capability checks for admin operations

**JavaScript Standards:**

- Use modern ES6+ syntax where appropriate
- Follow consistent indentation and naming conventions
- Add comments for complex logic
- Minimize global variables

**Security Requirements:**

- Sanitize all user inputs with appropriate WordPress functions
- Escape all outputs using `esc_html()`, `esc_attr()`, etc.
- Use nonces for all state-changing operations
- Validate file uploads properly
- Check user capabilities before admin operations

### Testing Your Changes

1. **Manual Testing**
   - Test with different AI providers
   - Verify functionality with various user roles
   - Check mobile and desktop interfaces
   - Test with WordPress multisite if applicable

2. **Security Testing**
   - Verify input sanitization
   - Test XSS prevention
   - Check CSRF protection with nonces
   - Validate file upload restrictions

3. **Compatibility Testing**
   - Test with latest WordPress version
   - Verify PHP 8.0+ compatibility
   - Check common theme compatibility
   - Test plugin conflicts

## 🌍 Translation and Internationalization

### Adding Translations

The plugin uses the text domain `wp-ai-chat`. To contribute translations:

1. **Generate POT file** (maintainers only)

   ```bash
   wp i18n make-pot . languages/wp-ai-chat.pot
   ```

2. **Create language files**
   - Use tools like Poedit or Loco Translate
   - Save as `wp-ai-chat-{locale}.po` and `.mo`
   - Place in `/languages/` directory

3. **Submit translations**
   - Create a PR with your translation files
   - Include locale code and language name in description

### Internationalization Guidelines

- Wrap all user-facing strings with `__()` or `_e()`
- Use proper text domain: `wp-ai-chat`
- Avoid concatenating translated strings
- Use placeholders for dynamic content:

  ```php
  sprintf(__('Hello %s!', 'wp-ai-chat'), $username)
  ```

## 🐛 Common Issues and Solutions

### Plugin Conflicts

- Test with default WordPress theme
- Deactivate other plugins during testing
- Check JavaScript console for errors

### API Integration Issues

- Verify API keys are properly configured
- Check rate limits and quotas
- Monitor API response formats for changes

### Performance Considerations

- Optimize database queries
- Use WordPress caching functions where appropriate
- Minimize HTTP requests
- Consider loading assets conditionally

## 📚 Resources

### WordPress Development

- [Plugin Developer Handbook](https://developer.wordpress.org/plugins/)
- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
- [Security Best Practices](https://developer.wordpress.org/plugins/security/)

### AI Integration

- [DeepSeek API Documentation](https://platform.deepseek.com/api-docs/)
- [OpenAI API Reference](https://platform.openai.com/docs/api-reference)

### Tools

- [WordPress CLI](https://wp-cli.org/)
- [PHP_CodeSniffer with WordPress Standards](https://github.com/WordPress/WordPress-Coding-Standards)
- [Query Monitor](https://wordpress.org/plugins/query-monitor/) for debugging

## 🎯 Priority Areas for Contribution

### High Priority

- Security improvements and code review
- DeepSeek API integration enhancements
- Mobile interface optimization
- Performance optimizations

### Medium Priority

- Additional AI provider integrations
- Enhanced error handling
- Admin interface improvements
- Documentation expansion

### Low Priority

- Code refactoring and organization
- Additional translations
- Feature enhancements
- UI/UX improvements

## 📞 Getting Help

- **Documentation**: Check the README and docs folder
- **Issues**: Search existing GitHub issues
- **Discussions**: Start a GitHub Discussion for questions
- **Community**: Join relevant WordPress and AI development communities

## 🏆 Recognition

Contributors will be:

- Listed in the CONTRIBUTORS.md file
- Mentioned in release notes for significant contributions
- Added to the plugin's acknowledgments section

---

**Thank you for contributing to WordPress AI Chat Assistant!** 🚀

Your contributions help make AI technology more accessible to the WordPress community.
