<?php

namespace App\Traits;

use App\Consts\AddressConst;

trait CommonTrait
{
    /**
     * 検索キーワードを分割して配列で返す
     * @param string $keyword
     */
    private function splitKeyword($keyword): array|null
    {
        //半角スペースと全角スペースで分割
        return $keyword ? preg_split('/[\s\xE3\x80\x80]/u', $keyword) : null;
    }

    /**
     * 指定数以上の文字列を省略
     * 例えば30字なら、29文字＋…で30文字とする。
     * @param string $str
     * @param int $maxlen
     */
    private function abbrStr($str, $maxlen): string|null
    {
        if (mb_strlen($str) <= $maxlen) return $str;

        return mb_substr($str, 0, $maxlen - 1) . '…';
    }


    /**
     * 連想配列の値にnullがあれば、文字列を代入
     * @param array $array
     * @param string $str 
     */
    private function fillStr($array, $str): array|object
    {
        foreach ($array as $key => $value) {
            if (
                empty($value)
                || (json_decode($value, true) === null
                    && json_last_error() !== JSON_ERROR_NONE)
            ) {
                $value = $str;
            }
        }

        return $array;
    }

    /**
     * 都道府県・市町村で抽出
     * @param obj $query
     */
    private function wherePrefCity($query, $keyword): object
    {
        $pref = AddressConst::PREFECTURE;
        $city = AddressConst::CITY;
        $mergeCity = array();

        foreach ($city as $item) {
            $mergeCity = array_merge($mergeCity, $item);
        }

        //都道府県
        $prefTemp = preg_grep('/' . preg_quote($keyword, '/') . '/u', $pref);
        $prefMatches = array_keys($prefTemp);

        foreach ($prefMatches as $item) {
            $query->orWhere('pref', 'LIKE', '%' . $item . '%');
        }

        //市町村
        $cityTemp = preg_grep('/' . preg_quote($keyword, '/') . '/u', $mergeCity);
        $cityMatches = array_keys($cityTemp);

        foreach ($cityMatches as $item) {
            $query->orWhere('city', 'LIKE', '%' . $item . '%');
        }

        return $query;
    }

    /**
     * 県名を取得する
     * @param str $pref
     */
    private function getPref($pref): string|null
    {
        $arrPref = AddressConst::PREFECTURE;

        if (!isset($arrPref[$pref])) return null;

        return $arrPref[$pref];
    }

    private function getCity($pref, $city): string|null
    {
        $arrCity = AddressConst::CITY;

        if (!isset($arrCity[$pref][$city])) return null;

        return $arrCity[$pref][$city];
    }

}
