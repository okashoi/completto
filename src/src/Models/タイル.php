<?php

declare(strict_types=1);

namespace Okashoi\Completto\Models;

use UnexpectedValueException;

final class タイル
{
    public const 回転してできる数字 = [
        6 => 9,
        9 => 6,
        16 => 91,
        18 => 81,
        19 => 61,
        61 => 19,
        66 => 99,
        68 => 89,
        81 => 18,
        86 => 98,
        89 => 68,
        91 => 16,
        98 => 86,
        99 => 66,
    ];

    private bool $表向きである = false;
    private bool $回転している = false;

    public function __construct(
        /** @var int $数字 タイルに書かれいてる数字（「値」ではない） */
        public readonly int $数字
    ) {
        if ($数字 < 1 || 100 < $数字) {
            throw new UnexpectedValueException('数値は 1 以上 100 以下の整数でなければなりません');
        }
    }

    /**
     * 表向きにする = 値を確定する = 以降回転はできない
     *
     * @throws すでに表向きのタイルを表向きにしようとした
     * @throws 回転できないタイルを回転しようとした
     */
    public function 表向きにする(bool $回転させる = false): void
    {
        if ($this->表向きである) {
            throw new すでに表向きのタイルを表向きにしようとした();
        }
        if ($回転させる && !$this->回転可能である()) {
            throw new 回転できないタイルを回転しようとした('数字: ' . $this->数字);
        }

        $this->表向きである = true;
        $this->回転している = $回転させる;
    }

    public function 表向きである(): bool
    {
        return $this->表向きである;
    }

    public function 回転可能である(): bool
    {
        return in_array($this->数字, array_keys(self::回転してできる数字));
    }

    /**
     * @return int|null 表に向いていない（=値が確定していない）場合に null
     */
    public function 値(): ?int
    {
        if (!$this->表向きである) {
            return null;
        }

        return match ($this->回転している) {
            false => $this->数字,
            true => self::回転してできる数字[$this->数字],
        };
    }
}
