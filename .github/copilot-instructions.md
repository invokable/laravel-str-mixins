# GitHub Copilot Onboarding Guide for Laravel Str Mixins

## Repository Overview

**Laravel Str Mixins** is a specialized Laravel package that extends `Illuminate\Support\Str` and `Illuminate\Support\Stringable` with additional functionality primarily designed for Japanese text processing. The package provides enhanced string manipulation methods that work better with multibyte characters and Japanese-specific text formatting needs.

### Primary Purpose
- Extend Laravel's built-in string helpers with Japanese-friendly alternatives
- Provide proper multibyte character handling for text processing
- Offer both static Str methods and fluent Stringable chain methods

## Key Features

### 1. Text Wrapping (`textwrap`)
- **Purpose**: Force text wrapping at specified character width
- **Why needed**: Laravel's `wordWrap()` doesn't work properly with Japanese text
- **Usage**: `Str::textwrap('text', 10)` or `Str::of('text')->textwrap(10)`

### 2. Japanese Character Conversion (`kana`)
- **Purpose**: Convert between different Japanese character types (hiragana, katakana, half-width, full-width)
- **Implementation**: Wrapper around PHP's `mb_convert_kana()` function
- **Usage**: `Str::kana('text', 'KVa')` or `Str::of('text')->kana('KVa')`

### 3. Character-Count Truncation (`truncate`)
- **Purpose**: Truncate text by character count rather than display width
- **Why needed**: Laravel's `limit()` counts half-width as 1 and full-width as 2, which isn't ideal for Japanese
- **Usage**: `Str::truncate('text', 10, '...')` or `Str::of('text')->truncate(10, '...')`

## Architecture Overview

### Package Structure
```
src/
├── StrMixinsServiceProvider.php    # Service provider that registers mixins
├── Str/                           # Static Str macro implementations
│   ├── Kana.php                   # Japanese character conversion
│   ├── TextWrap.php               # Text wrapping functionality
│   └── Truncate.php               # Character-count truncation
└── Stringable/                    # Fluent Stringable mixins
    └── Japanese.php               # Chainable Japanese text methods
```

### Design Patterns

#### 1. Invokable Classes for Str Macros
```php
class TextWrap
{
    public function __invoke(?string $str, int $width = 10, string $break = PHP_EOL): string
    {
        return implode($break, mb_str_split($str ?? '', $width));
    }
}
```

#### 2. Closure-returning Methods for Stringable Mixins
```php
public function textwrap(): Closure
{
    return function (int $width = 10, string $break = PHP_EOL): Stringable {
        return new Stringable(Str::textwrap($this->value, $width, $break));
    };
}
```

## Development Setup

### Requirements
- PHP >= 8.2
- Laravel >= 11.0
- ext-mbstring (for multibyte string functions)

### Installation & Setup
```bash
# Clone and setup
git clone https://github.com/invokable/laravel-str-mixins.git
cd laravel-str-mixins
composer install

# Run tests
./vendor/bin/phpunit

# Check code style
./vendor/bin/pint --test

# Fix code style
./vendor/bin/pint
```

### Testing Environment
- Uses Orchestra Testbench for Laravel package testing
- PHPUnit for unit tests
- All tests should pass and maintain 100% coverage when possible

## Code Style & Conventions

### PHP Standards
- **Strict types**: Always use `declare(strict_types=1);`
- **Laravel Pint**: Follow Laravel coding standards with pint.json configuration
- **PSR-4 autoloading**: `Revolution\Laravel\Mixins` namespace

### Key Conventions
1. **Null handling**: All methods should handle null input gracefully (`$str ?? ''`)
2. **UTF-8 encoding**: Always specify encoding for multibyte functions
3. **Method signatures**: Match Laravel's existing patterns where possible
4. **Return types**: Always specify return types explicitly

### Example Code Pattern
```php
<?php

declare(strict_types=1);

namespace Revolution\Laravel\Mixins\Str;

class ExampleMethod
{
    public function __invoke(?string $str, int $param = 10): string
    {
        $str = $str ?? '';
        
        // Your multibyte-safe implementation here
        return mb_substr($str, 0, $param, 'UTF-8');
    }
}
```

## Testing Patterns

### Test Structure
```php
class StrTest extends TestCase
{
    public function test_method_name()
    {
        // Test normal case
        $this->assertSame('expected', Str::method('input'));
        
        // Test Japanese text
        $this->assertSame('あいう', Str::method('あいうえお', 3));
        
        // Test null handling
        $this->assertSame('', Str::method(null));
    }
}
```

### Important Test Cases
1. **Null input handling**: Every method should handle null gracefully
2. **Japanese text**: Test with hiragana, katakana, and kanji
3. **Mixed content**: Test with mixed ASCII and Japanese characters
4. **Edge cases**: Empty strings, very long strings, special characters

## Contributing Guidelines

### Adding New Features

1. **For Str macros**:
   - Create invokable class in `src/Str/`
   - Register in `StrMixinsServiceProvider::boot()`
   - Add corresponding method in `src/Stringable/Japanese.php`

2. **For Stringable-only methods**:
   - Add method to `src/Stringable/Japanese.php`
   - Return closure that creates new Stringable instance

### Pull Request Process
1. Write tests first (TDD approach recommended)
2. Implement minimal functionality
3. Ensure all tests pass
4. Run Pint to fix code style
5. Update documentation if needed
6. Add examples in both English and Japanese if applicable

## GitHub Copilot Usage Tips

### Effective Prompts

#### For implementing new string methods:
```
// Create a new Str macro for [functionality] that handles Japanese text properly
// Include null safety and UTF-8 encoding
// Follow the existing pattern in src/Str/
```

#### For tests:
```
// Create comprehensive tests for the [method] function
// Include tests for Japanese text, null input, and edge cases
// Follow the existing test patterns in tests/
```

#### For Stringable mixins:
```
// Add a fluent method for [functionality] to the Japanese mixin
// Should return a Closure that creates a new Stringable instance
// Use the corresponding Str:: method internally
```

### Context-Aware Development

When working with Copilot in this repository:

1. **Mention multibyte considerations**: Always specify when working with text that needs UTF-8 handling
2. **Reference existing patterns**: Point to similar methods for consistency
3. **Include Japanese examples**: Ask for examples with actual Japanese characters
4. **Test coverage**: Request comprehensive test cases including edge cases

### Common Gotchas to Mention

1. **Encoding**: Always specify UTF-8 encoding for mb_* functions
2. **Null safety**: Use null coalescing (`$str ?? ''`) for optional string parameters
3. **Return types**: Str methods return string, Stringable methods return Stringable
4. **Testing**: Don't forget to test with actual Japanese characters, not just ASCII

### Useful Context for Copilot

```php
// When adding new functionality, remember:
// - This package focuses on Japanese text processing
// - All methods should handle null input gracefully
// - Use multibyte functions (mb_*) for proper Unicode support
// - Follow the existing invokable class pattern for Str macros
// - Add corresponding Stringable methods for method chaining
// - Write comprehensive tests including Japanese text examples
```

## File Organization

- **Source code**: Keep focused, single-responsibility classes
- **Tests**: Mirror the source structure in the tests directory
- **Documentation**: Update both README.md and README_ja.md for user-facing changes
- **Examples**: Include practical examples showing real Japanese text usage

## Development Workflow

1. **Start with tests**: Write failing tests first
2. **Implement incrementally**: Small, focused changes
3. **Test frequently**: Run tests after each change
4. **Style check**: Use Pint to maintain code style
5. **Documentation**: Update docs for any API changes

This guide should help GitHub Copilot provide more contextually appropriate suggestions and help developers understand the specific patterns and requirements of this Japanese text processing focused Laravel package.