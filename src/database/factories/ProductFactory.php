<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->randomElement([
                'BlueBerry Cake',
                'Strawberry Chocolate Cake',
                'Strawberry Cake',
                'Strawberry Pop Cream',
                'Hot Cake',
                'Roll Cream Cake',
                'Fruits Strawberry Cake',
                'Fruits Cake',
                'Strawberry Donut',
                'Almond Donut'
            ]),
            'price' => $this->faker->randomElement([500, 600, 800, 900, 1000, 1200, 1500, 1800]),
            'description' => $this->faker->randomElement([
                '濃厚なブルーベリーの風味が広がる、しっとりとしたケーキ',
                'イチゴとチョコレートの絶妙なハーモニーを楽しめる一品',
                '新鮮なイチゴを贅沢に使用した、甘さ控えめのふわふわケーキ',
                '軽やかなクリームとイチゴの酸味が絶妙なバランス',
                '外はカリッと、中はふんわり焼き上げたクラシックなホットケーキ',
                'なめらかなクリームをたっぷり巻き込んだロールケーキ',
                '色とりどりのフルーツをふんだんに使った贅沢なタルト',
                'ジューシーなフルーツがたっぷりの、特別な日にぴったりなケーキ',
                'イチゴの風味が広がる、もちもち食感のドーナツ',
                '香ばしいアーモンドの風味が楽しめる大人向けのドーナツ',
            ]),
            'image_path' => $this->faker->randomElement([
                'berry.jpeg',
                'cake2.jpeg',
                'Cake6.jpeg',
                'pop-cream.jpeg',
                'hot-cake.jpeg',
                'roll-cake.jpeg',
                'cake7.jpeg',
                'cake3.jpeg',
                'donut1.jpeg',
                'donut2.jpeg'
            ]),
        ];
    }
}
