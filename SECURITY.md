# Security Policy

## Supported Versions

We provide security updates for the following versions:

| Version | Supported          |
| ------- | ------------------ |
| 4.0.x   | :white_check_mark: |
| < 4.0   | :x:                |

## Reporting a Vulnerability

We take security vulnerabilities seriously. If you discover a security vulnerability in WP AI Chat, please report it privately by following these steps:

### How to Report

1. **DO NOT** open a public issue on GitHub
2. Email: [security@yoursite.com](mailto:security@yoursite.com)
3. Include the word "SECURITY" in the subject line
4. Provide detailed information about the vulnerability

### What to Include

- Description of the vulnerability
- Steps to reproduce the issue
- Potential impact assessment
- Suggested fix (if you have one)
- Your contact information

### Response Timeline

- **Initial Response**: Within 24-48 hours
- **Vulnerability Assessment**: Within 1 week
- **Fix Development**: 1-4 weeks (depending on severity)
- **Release**: Coordinated disclosure after fix is ready

### Security Best Practices

When using this plugin:

1. **Keep Updated**: Always use the latest version
2. **Strong API Keys**: Use unique, strong API keys for AI services
3. **User Permissions**: Limit plugin access to trusted users only
4. **Regular Audits**: Review AI chat logs periodically
5. **Rate Limiting**: Configure appropriate rate limits for AI requests

### Hall of Fame

We acknowledge security researchers who responsibly disclose vulnerabilities:

<!-- Security researchers will be listed here -->

## Security Features

This plugin implements:

- ✅ **Input Sanitization**: All user inputs are properly sanitized
- ✅ **Output Escaping**: All outputs are escaped for XSS prevention
- ✅ **Nonce Protection**: CSRF protection on all forms and AJAX calls
- ✅ **Capability Checks**: Proper WordPress permission verification
- ✅ **Rate Limiting**: Built-in API rate limiting
- ✅ **Secure API Communication**: HTTPS-only API calls
- ✅ **Data Validation**: Strict validation of all AI provider responses

## Contact

For security-related questions or concerns:

- Email: <security@yoursite.com>
- GPG Key: [Optional - link to public key]

Thank you for helping keep WP AI Chat secure! 🔒
