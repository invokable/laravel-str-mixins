# Laravel Str mixins

主に日本語用に`Illuminate\Support\Str`を拡張するmixin

## 必要条件
- PHP >= 8.3
- Laravel >= 12.0

## バージョン情報

| バージョン                                                      | PHP  | Laravel |
|----------------------------------------------------------------|------|---------|
| [1.x](https://github.com/invokable/laravel-str-mixins/tree/1.x) | ^7.2 | 6       |
| 2.x                                                            | ^8.3 | ^12   |

- v1.xはLaravel 6のみに対応しています。
- v2.xはFluent Stringsのため、Laravel 7以上のみに対応しています。

## インストール方法
```shell
composer require revolution/laravel-str-mixins
```

### アンインストール方法
```shell
composer remove revolution/laravel-str-mixins
```

## Str

### Str::textwrap(string $str, int $width = 10, string $break = PHP_EOL): string
指定した文字数で改行します。単純な改行処理のため、禁則処理などは行いません。

```php
$text = Str::textwrap(str: 'abcde', width: 3);

// abc
// de
```

元々はOGP画像の幅に収めるための強制的な改行が目的でした。

Laravel 10.19.0で同名の`Str::wordWrap()`が追加されたため、`textwrap`に名称変更しました。動作が異なるため削除せずに残しています。`Str::wordWrap()`は日本語テキストでは期待通りの動作をしません。

### Str::kana(string $str, string $option = 'KV', string $encoding = 'UTF-8'): string
`mb_convert_kana()`と同等の機能を提供します。

```php
$text = Str::kana(str: 'abｃあいうｱｲｳ', option: 'KVa');

// abcあいうアイウ
```

### Str::truncate(string $str, int $limit = 100, string $end = '...'): string
`Str::limit()`は半角文字を1、全角文字を2としてカウントして切り捨てます。マルチバイト関数を使用していますが、文字の幅でカウントしています。

```php
$text = Str::limit('abcあいうえお', 7);

// abcあい...
```

日本語テキストでは期待通りの動作をしないため、`Str::truncate()`は文字数でカウントして切り捨てを行います。

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

メソッドチェーンで使用する例：

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

## ライセンス
MIT    
