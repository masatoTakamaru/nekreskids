<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Consts\AddressConst;
use App\Traits\FactoryTrait;

class SchoolFactory extends Factory
{
    use FactoryTrait;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $prefs = AddressConst::PREFECTURE;
        $cities = AddressConst::CITY;

        $pref = fake()->randomKey($prefs);
        $city = fake()->randomKey($cities[$pref]);

        return [
            'name' => 'サンプル学校名' . fake()->text(10),
            'zip' => str_replace('-', '', fake()->postcode()),
            'pref' => $pref,
            'city' => $city,
            'address' => fake()->streetAddress(),
            'tel1' => str_replace('-', '', fake()->phoneNumber()),
            'tel2' => $this->randomNull(str_replace('-', '', fake()->phoneNumber())),
            'charge' => fake()->name(),
            'score' => 0,
        ];
    }

    public function softDeleted()
    {
        return $this->state(function (array $attributes) {
            return [
                'deleted_at' => now(), // deleted_at カラムを設定する
            ];
        });
    }
}
