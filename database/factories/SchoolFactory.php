<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Consts\AddressConst;


class SchoolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $prefs = AddressConst::PREFECTURES;
        $cities = AddressConst::CITIES;

        $pref = fake()->randomKey($prefs);
        $city = fake()->randomElement(array_keys($cities[$pref]));

        return [
            'name' => 'サンプル学校名' . fake()->realText(70),
            'zip' => str_replace('-', '', fake()->postcode()),
            'pref' => $pref,
            'city' => $city,
            'address' => fake()->streetAddress(),
            'tel1' => str_replace('-', '', fake()->phoneNumber()),
            'tel2' => mt_rand(0, 4) ? str_replace('-', '', fake()->phoneNumber()) : null,
            'charge' => fake()->name(),
            'score' => 0,
            'del_flg' => mt_rand(0, 4) ? 0 : 1,

        ];
    }
}
