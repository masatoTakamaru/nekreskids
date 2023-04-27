<?php

namespace App\Traits;

trait ModelTrait {
    /**
     * モデルのプロパティを連想配列でまとめて格納する
     * @param $attrs array モデルのプロパティと値を格納した連想配列
     */
    public function setAttrs($attrs): void
    {
        foreach ($attrs as $key => $value) {
            $this->$key = $value;
        }
    }
}