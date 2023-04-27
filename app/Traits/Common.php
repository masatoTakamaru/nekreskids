<?php

namespace App\Traits;

trait Common {
    /**
     * モデルのプロパティを連想配列でまとめて格納する
     */
    public function setAttrs($attrs): void
    {
        foreach ($attrs as $key => $value) {
            $this->$key = $value;
        }
    }
}