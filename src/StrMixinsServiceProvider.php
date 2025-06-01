<?php

declare(strict_types=1);

namespace Revolution\Laravel\Mixins;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use ReflectionException;
use Revolution\Laravel\Mixins\Str\Kana;
use Revolution\Laravel\Mixins\Str\TextWrap;
use Revolution\Laravel\Mixins\Str\Truncate;
use Revolution\Laravel\Mixins\Stringable\Japanese;

class StrMixinsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @throws ReflectionException
     */
    public function boot(): void
    {
        Str::macro('textwrap', new TextWrap);
        Str::macro('kana', new Kana);
        Str::macro('truncate', new Truncate);

        Stringable::mixin(new Japanese);
    }
}
