# Security Policy

Thank you for using our Phreme (PHP Framework). We prioritize the security of our users and strive to make this framework as secure as possible. If you discover any security vulnerabilities, please follow the guidelines below to report them.

## Reporting a Vulnerability

If you believe you have found a security vulnerability in our Phreme (PHP Framework), we encourage you to let us know right away. We will investigate all legitimate reports and do our best to quickly fix the problem.

Please email your report to: [weare.phreme@callvgroup.net]

### In your report, please include:

- A detailed description of the vulnerability.
- Steps to reproduce the vulnerability.
- The potential impact of the vulnerability.
- Any suggestions you may have for mitigating the vulnerability.

## Handling of Reported Vulnerabilities

Upon receiving a vulnerability report, we will:

1. Acknowledge receipt of the report within 3 business days.
2. Begin investigating the issue and provide an estimated timeline for fixing the vulnerability.
3. Keep you informed about the progress and any potential updates.
4. Notify you when the vulnerability has been fixed and provide you with a patch or new release.

## Security Best Practices

To ensure the security of your application, we recommend the following practices:

1. **Keep Your Framework Updated**: Always use the latest version of the Phreme to ensure you have the latest security patches.
2. **Secure Configuration**: Properly configure your environment variables, especially those related to security such as `CRYPT_PRIVATE_KEY` and `COOKIE_FILE`.
3. **Sanitize Inputs**: Always sanitize user inputs to prevent SQL injection, XSS, and other common vulnerabilities. Our framework provides utilities for handling and sanitizing POST, GET, REQUEST, and SERVER variables.
4. **Use Encrypted Cookies**: Leverage the framework’s encrypted cookie support to protect sensitive user data.
5. **Implement HTTPS**: Use HTTPS to encrypt data transmitted between your server and users.

## Updating Security-Related Dependencies

We use Composer for dependency management. Regularly update your dependencies to incorporate the latest security fixes by running:

```bash
composer update
```

## Version Support

We maintain active support for the most recent versions of our framework. Security patches will be backported to previous versions as deemed necessary.

## Credits

We would like to thank the following individuals and organizations for reporting security vulnerabilities and helping us improve the security of our Phreme (PHP Framework):

- [Name] for [specific vulnerability]
- [Organization] for [specific vulnerability]

We appreciate your contributions and efforts in keeping our framework secure.

For further details and documentation, please refer to our official documentation.

Thank you for helping us keep our Phreme (PHP Framework) secure!

---

Please feel free to reach out with any questions or concerns regarding our security practices.
