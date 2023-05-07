<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Consts\RecruitConst;
use App\Consts\AddressConst;
use App\Consts\UserConst;

class InstructorFactory extends Factory
{


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $activities = RecruitConst::ACTIVITY;
        $prefs = AddressConst::PREFECTURE;
        $cities = AddressConst::CITIES;
        $genders = UserConst::GENDERS;
        $act_areas = [];
        $loop = mt_rand(1, 5);

        $pref = fake()->randomKey($prefs);
        $city = fake()->randomKey($cities[$pref]);

        for ($i = 1; $i <= $loop; $i++) {
            $act_pref = fake()->randomKey($prefs);
            $act_city = fake()->randomKey($cities[$pref]);
            $act_areas[] = [$i => ['pref' => $act_pref, 'city' => $act_city]];
        }
        //avatar画像
        $sourceDir = base_path('/assets/avatar_seed');
        $targetDir = 'public/avatars';

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
        Storage::put($targetDir . '/' . $fileName, $image);

        $arrTemp = fake()->randomElements(array_keys($activities), mt_rand(0, 5));
        $activities = [];
        $count = 1;
        foreach($arrTemp as $item) {
            $activities[$count] = $item;
            $count++;
        }

        return [
            'name' => fake()->name(),
            'name_kana' => fake()->kanaName(),
            'avatar_url' => $fileName,
            'pr' => mt_rand(0, 4) ? fake()->realText(500) : null,
            'activities' => mt_rand(0,4) ? json_encode($activities) : null,
            'other_activities' => mt_rand(0, 4) ? '指導できる活動その他' . fake()->realText(100) : null,
            'ontime' => mt_rand(0, 4) ? '指導できる曜日や時間帯' . fake()->realText(100) : null,
            'act_areas' => !empty($act_areas) ? json_encode($act_areas) : null,
            'birth' => fake()->date(),
            'cert' => mt_rand(0, 4) ? '所有資格' . fake()->realText(100) : null,
            'gender' => fake()->randomKey($genders),
            'zip' => str_replace('-', '', fake()->postcode()),
            'pref' => $pref,
            'city' => $city,
            'address' => fake()->streetAddress(),
            'tel' => mt_rand(0, 4) ? str_replace('-', '', fake()->phoneNumber()) : null,
            'keep' => 0,
            'del_flg' => mt_rand(0, 2) ? 0 : 1,
        ];
    }
}
