<?php

namespace Tests;

use Illuminate\Support\Str;

class StrTest extends TestCase
{
    public function test_str_text_wrap()
    {
        $this->assertSame("abc\nde", Str::textwrap('abcde', 3));
        $this->assertSame("あいう\nえお", Str::textwrap('あいうえお', 3));
        $this->assertSame("あい\nう\n\nえお", Str::textwrap("あいう\nえお", 2));
        $this->assertSame("ｱｲｳ\nｴｵ", Str::textwrap('ｱｲｳｴｵ', 3));
        $this->assertSame('', Str::textwrap(null, 3));

        $this->assertNotSame("あいう\nえお", Str::wordWrap('あいうえお', 3));
    }

    public function test_str_kana()
    {
        $this->assertSame('abcあいうアイウ', Str::kana('abｃあいうｱｲｳ', 'KVa'));
        $this->assertSame('', Str::kana(null));
    }

    public function test_str_truncate()
    {
        $this->assertSame('abcあいうえお', Str::truncate(str: 'abcあいうえお'));
        $this->assertSame('abcあいうえ...', Str::truncate(str: 'abcあいうえお', limit: 7));
        $this->assertSame('abcあいう___', Str::truncate(str: 'abcあいうえお', limit: 6, end: '___'));
        $this->assertSame('abcあい...', Str::limit('abcあいうえお', 7));
        $this->assertSame('', Str::truncate(null, 1));
    }
}
