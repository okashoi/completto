<?php

declare(strict_types=1);

namespace Okashoi\Completto\Models;

use RuntimeException;
use UnexpectedValueException;

final class 中央の場のタイル郡
{
    public readonly int $タイルの数;

    /**
     * @param non-empty-list<タイル> $タイル郡 タイルの位置にゲーム上の意味があるため、「郡」という名前だが配列として保持
     */
    public function __construct(private array $タイル郡)
    {
        $this->タイルの数 = count($this->タイル郡);
    }

    public function タイルをシャッフルする(): void
    {
        if (shuffle($this->タイル郡) === false) {
            throw new RuntimeException();
        }
    }

    /**
     * @throws UnexpectedValueException 範囲外の位置を指定した
     */
    private function タイルの位置の指定が正しいか調べる(int $タイルの位置（0始まり）): void
    {
        if (0 <= $タイルの位置（0始まり） && $タイルの位置（0始まり） < $this->タイルの数) {
            return;
        }
        $message = sprintf('タイルの位置は 0 ～ %d のあいだで指定しなければなりません（実際に指定された位置: %d 番目（0 始まり））', $this->タイルの数 - 1, $タイルの位置（0始まり）);
        throw new UnexpectedValueException($message);
    }

    /**
     * @throws UnexpectedValueException 範囲外の位置を指定した
     */
    public function タイルを見る(int $タイルの位置（0始まり）): タイル
    {
        $this->タイルの位置の指定が正しいか調べる($タイルの位置（0始まり）);

        return $this->タイル郡[$タイルの位置（0始まり）];
    }

    /**
     * @return タイル 置き換えられてあふれてきたタイル
     * @throws UnexpectedValueException 範囲外の位置を指定した
     */
    public function タイルを置き換える(int $タイルの位置（0始まり）, タイル $置き換えるタイル): タイル
    {
        $this->タイルの位置の指定が正しいか調べる($タイルの位置（0始まり）);

        $置き換えられたタイル = $this->タイル郡[$タイルの位置（0始まり）];
        $this->タイル郡[$タイルの位置（0始まり）] = $置き換えるタイル;

        return $置き換えられたタイル;
    }
}
