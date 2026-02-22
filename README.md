# Laravel Str mixins

Mixin that extends `Illuminate\Support\Str` mainly for Japanese language use

## Requirements
- PHP >= 8.3
- Laravel >= 12.0

## Versioning

| ver                                                             | PHP  | Laravel |
|-----------------------------------------------------------------|------|---------|
| [1.x](https://github.com/invokable/laravel-str-mixins/tree/1.x) | ^7.2 | 6       |
| 2.x                                                             | ^8.3 | ^12   |

- v1.x is for Laravel 6 only.
- v2.x supports Laravel 7 and above only for Fluent Strings.

## Installation
```shell
composer require revolution/laravel-str-mixins
```

### Uninstall
```shell
composer remove revolution/laravel-str-mixins
```

## Str

### Str::textwrap(string $str, int $width = 10, string $break = PHP_EOL): string
Line breaks at specified number of characters. Simple line breaks without word-wrapping rules.

```php
$text = Str::textwrap(str: 'abcde', width: 3);

// abc
// de
```

Originally intended for forcing line breaks to fit within OGP image width.

Changed to `textwrap` because Laravel 10.19.0 added a function with the same name `Str::wordWrap()`. Kept instead of removing because the behavior is different. `Str::wordWrap()` doesn't work as expected with Japanese text.

### Str::kana(string $str, string $option = 'KV', string $encoding = 'UTF-8'): string
Same as `mb_convert_kana()`.

```php
$text = Str::kana(str: 'abｃあいうｱｲｳ', option: 'KVa');

// abcあいうアイウ
```

### Str::truncate(string $str, int $limit = 100, string $end = '...'): string
`Str::limit()` counts half-width characters as 1 and full-width characters as 2 when truncating. It uses multibyte functions but counts by character width.

```php
$text = Str::limit('abcあいうえお', 7);

// abcあい...
```

`Str::truncate()` counts by the number of characters for truncation, which works better for Japanese text.

```php
$text = Str::truncate(str: 'abcあいうえお', limit: 7);

// abcあいうえ...
```

## Fluent Strings

### textwrap(int $width = 10, string $break = PHP_EOL): Stringable

```php
$text = Str::of('abcde')->textwrap(width: 3)->value();

// abc
// de
```

### kana(string $option = 'KV', string $encoding = 'UTF-8'): Stringable

```php
$text = Str::of('abｃあいうｱｲｳ')->kana(option: 'KVa')->value();

// abcあいうアイウ
```

For chaining use:

```php
$text = Str::of('abｃあいうｱｲｳ')->kana(option: 'KVa')->textwrap(3)->value();

// abc
// あいう
// アイウ
```

### truncate(int $limit = 100, string $end = '...'): Stringable
```php
$text = Str::of('abcあいうえお')->truncate(limit: 6, end: '___')->value();

// abcあいう___
```

## LICENSE
MIT      
