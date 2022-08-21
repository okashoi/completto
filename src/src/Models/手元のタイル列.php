<?php

declare(strict_types=1);

namespace Okashoi\Completto\Models;

use UnexpectedValueException;

final class 手元のタイル列
{
    public const タイルの数 = 22;

    /**
     * @param non-empty-list<タイル> $タイル列
     */
    public function __construct(private array $タイル列)
    {
        if (count($タイル列) !== self::タイルの数) {
            $message = sprintf('タイル列のタイルの数は %d でなければなりません（実際に渡されたタイルの数: %d）', self::タイルの数, count($タイル列));
            throw new UnexpectedValueException($message);
        }

        if (!$this->値は昇順に並んでいる()) {
            throw new UnexpectedValueException('値は昇順に並んでいなければなりません');
        }
    }

    private function 値は昇順に並んでいる(): bool
    {
        /** @var list<int> $値の列 */
        $値の列 = [];
        foreach ($this->タイル列 as $タイル) {
            if (!$タイル->表向きである()) {
                continue;
            }

            $値 = $タイル->値();
            assert(is_int($値));
            $値の列[] = $値;
        }

        for ($i = 0; $i < count($値の列) - 1; $i++) {
            // 次の値よりも大きかったら昇順ではない
            if ($値の列[$i] >= $値の列[$i + 1]) {
                return false;
            }
        }

        return true;
    }

    /**
     * @throws UnexpectedValueException 範囲外の位置を指定した
     */
    private function タイルの位置の指定が正しいか調べる(int $タイルの位置（0始まり）): void
    {
        if (0 <= $タイルの位置（0始まり） && $タイルの位置（0始まり） < self::タイルの数) {
            return;
        }
        $message = sprintf('タイルの位置は 0 ～ %d のあいだで指定しなければなりません（実際に指定された位置: %d 番目（0 始まり））', self::タイルの数 - 1, $タイルの位置（0始まり）);
        throw new UnexpectedValueException($message);
    }

    /**
     * @return タイル 置き換えられて手元からあふれてきたタイル
     * @throws UnexpectedValueException 範囲外の位置を指定した
     * @throws 表向きの手元のタイルを置き換えようとした
     * @throws 値が昇順にならないような入れ替えをしようとした
     */
    public function タイルを置き換える(int $タイルの位置（0始まり）, タイル $置き換えるタイル): タイル
    {
        $this->タイルの位置の指定が正しいか調べる($タイルの位置（0始まり）);

        // 不正な操作があった場合にもとに戻すために、並び替え前のタイル列を退避させておく
        $並び替え前のタイル列 = $this->タイル列;

        $置き換えられたタイル = $this->タイル列[$タイルの位置（0始まり）];
        if ($置き換えられたタイル->表向きである()) {
            throw new 表向きの手元のタイルを置き換えようとした();
        }
        $this->タイル列[$タイルの位置（0始まり）] = $置き換えるタイル;

        if (!$this->値は昇順に並んでいる()) {
            $this->タイル列 = $並び替え前のタイル列;
            throw new 値が昇順にならないような入れ替えをしようとした();
        }

        return $置き換えられたタイル;
    }

    /**
     * @throws UnexpectedValueException 範囲外の位置を指定した
     * @throws 値が昇順にならないような入れ替えをしようとした
     */
    public function タイルを並び替える(int $ひとつめのタイルの位置（0始まり）, int $ふたつめのタイルの位置（0始まり）): void
    {
        $this->タイルの位置の指定が正しいか調べる($ひとつめのタイルの位置（0始まり）);
        $this->タイルの位置の指定が正しいか調べる($ふたつめのタイルの位置（0始まり）);

        // 不正な操作があった場合にもとに戻すために、並び替え前のタイル列を退避させておく
        $並び替え前のタイル列 = $this->タイル列;

        $ひとつめのタイル = $this->タイル列[$ひとつめのタイルの位置（0始まり）];
        $ふたつめのタイル = $this->タイル列[$ふたつめのタイルの位置（0始まり）];

        // NOTE: 「片方が表向きでもう片方が裏向きである」という検証が必要そうだが
        //       両方表だった場合は、後段の「昇順に並んでいるか」の検証で引っかかり
        //       両方裏だった場合はゲーム進行に支障はきたさないため、あえて検証をしないことにした

        $this->タイル列[$ひとつめのタイルの位置（0始まり）] = $ふたつめのタイル;
        $this->タイル列[$ふたつめのタイルの位置（0始まり）] = $ひとつめのタイル;

        if (!$this->値は昇順に並んでいる()) {
            $this->タイル列 = $並び替え前のタイル列;
            throw new 値が昇順にならないような入れ替えをしようとした();
        }
    }

    public function 勝利条件を満たしている(): bool
    {
        foreach ($this->タイル列 as $タイル) {
            if (!$タイル->表向きである()) {
                return false;
            }
        }
        assert($this->値は昇順に並んでいる());

        return true;
    }
}
