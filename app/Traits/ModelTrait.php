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

    /**
     * 検索キーワードを分割して配列で返す
     * @param $keyword string
     */
    public function splitKeyword($keyword): array
    {
        //半角スペースと全角スペースで分割
        return preg_split('/[\s\xE3\x80\x80]/u', $keyword);
    }

}