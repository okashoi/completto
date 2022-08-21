<?php

declare(strict_types=1);

namespace Okashoi\Completto\Models;

use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

class タイルTest extends TestCase
{
    /**
     * @test
     */
    public function 書かれている数字が0以下のタイルは存在しないこと(): void
    {
        $this->expectException(UnexpectedValueException::class);

        new タイル(0);
    }

    /**
     * @test
     */
    public function 書かれている数字が100より大きいタイルは存在しないこと(): void
    {
        $this->expectException(UnexpectedValueException::class);

        new タイル(101);
    }

    /**
     * @test
     */
    public function 表向きになっていないタイルの値は取得できない（nullになる）こと(): void
    {
        $タイル = new タイル(6);

        $this->assertNull($タイル->値());
    }

    /**
     * @test
     */
    public function 表向きにしたタイルの値が取得できること(): void
    {
        $タイル = new タイル(6);
        $タイル->表向きにする();

        $this->assertSame(6, $タイル->値());
    }

    /**
     * @test
     */
    public function 回転できるタイルを回転したときの値が取得できること(): void
    {
        $タイル = new タイル(6);
        $タイル->表向きにする(回転させる: true);

        $this->assertSame(9, $タイル->値());
    }

    /**
     * @test
     */
    public function 表向きのタイルは表に返せないこと(): void
    {
        $this->expectException(すでに表向きのタイルを表向きにしようとした::class);

        $タイル = new タイル(1);
        $タイル->表向きにする();
        $タイル->表向きにする();
    }

    /**
     * @test
     */
    public function 回転できないタイルは回転できないこと(): void
    {
        $this->expectException(回転できないタイルを回転しようとした::class);

        $タイル = new タイル(1);
        $タイル->表向きにする(回転させる: true);
    }
}
