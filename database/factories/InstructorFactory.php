<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Consts\RecruitConst;
use App\Consts\AddressConst;
use App\Consts\UserConst;
use App\Traits\FactoryTrait;

class InstructorFactory extends Factory
{
    use FactoryTrait;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $arrActivity = RecruitConst::ACTIVITY;
        $arrPref = AddressConst::PREFECTURE;
        $arrCity = AddressConst::CITY;
        $gender = UserConst::GENDER;
        $actArea = [];

        $pref = fake()->randomKey($arrPref);
        $city = fake()->randomKey($arrCity[$pref]);

        for ($i = 1; $i <= 5; $i++) {
            $actPref = fake()->randomKey($arrPref);
            $actCity = fake()->randomKey($arrCity[$actPref]);
            $actArea[$i] = ['pref' => $actPref, 'city' => $actCity];
        }
        //avatar画像
        $sourceDir = base_path('/assets/avatar_seed');
        $targetDir = 'avatars';

        // 画像ファイルのパスのリストを取得する
        $files = File::allFiles($sourceDir);
        $imagePaths = array_map(function ($file) {
            return $file->getPathname();
        }, $files);

        // 画像ファイルをランダムに選択する
        $randomImagePath = $imagePaths[array_rand($imagePaths)];

        // 画像ファイルを読み込む
        $image = file_get_contents($randomImagePath);

        // 画像ファイルをターゲットディレクトリに保存する
        $fileName = Str::ulid() . '.jpg';
        Storage::disk('public')->put($targetDir . '/' . $fileName, $image);

        $arrTemp = fake()->randomElements(array_keys($arrActivity), mt_rand(0, 5));
        $activity = [];
        $count = 1;

        foreach ($arrTemp as $item) {
            $activity[$count] = $item;
            $count++;
        }

        return [
            'name' => fake()->name(),
            'name_kana' => fake()->kanaName(),
            'avatar_url' => $fileName,
            'pr' => $this->randomNull(fake()->realText(mt_rand(10, 200))),
            'activities' => $this->randomNull(json_encode($activity), json_encode(array())),
            'other_activities' => $this->randomNull('指導できる活動その他' . fake()->realText(mt_rand(10, 100))),
            'ontime' => $this->randomNull('指導できる曜日や時間帯' . fake()->realText(mt_rand(10, 100))),
            'act_areas' => !empty($actArea) ? json_encode($actArea) : json_encode(array()),
            'birth' => fake()->date(),
            'cert' => $this->randomNull('所有資格' . fake()->realText(mt_rand(10, 100))),
            'gender' => fake()->randomKey($gender),
            'zip' => str_replace('-', '', fake()->postcode()),
            'pref' => $pref,
            'city' => $city,
            'address' => fake()->streetAddress(),
            'tel' => $this->randomNull(str_replace('-', '', fake()->phoneNumber())),
            'keep' => 0,
        ];
    }
}
