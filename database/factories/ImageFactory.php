<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageFactory extends Factory
{


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        //画像
        $sourceDir = base_path('/assets/avatar_seed');
        $targetDir = 'public/image';

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

        $tag = [];
        for ($i = 0; $i <= 3; $i++) {
            $tag[] = fake()->firstName();
        }
        $jsonTag = json_encode($tag);

        return [
            'url' => $fileName,
            'tag' => $jsonTag,
        ];
    }
}
