# Contributing

Thanks for your interest in contributing! Please follow these guidelines to help us keep quality high.

## Development setup
- PHP 8.1+
- Composer 2
- Run `composer install`

## Coding standards
- PSR-4 autoloading, namespaces under `Webumer\Bcb`
- Prefer small, focused PRs
- Include PHPDoc for public methods

## Testing
- Add or update tests under `tests/`
- Ensure `vendor/bin/phpunit` passes in CI

## Pull Requests
- Describe what changed and why
- Include usage examples when adding new endpoints
- Update README if behavior changes
- No breaking changes without discussion; follow SemVer

## Release process
- Maintainers tag releases `vX.Y.Z`
- Packagist auto-updates on tags

## Security
- Do not include secrets in code or examples
- Report vulnerabilities privately via GitHub Security advisories
