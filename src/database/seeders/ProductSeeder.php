<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name' => 'BlueBerry Cake',
                'price' => 800,
                'description' => '濃厚なブルーベリーの風味が広がる、しっとりとしたケーキ',
                'image_path' => 'berry.jpeg',
            ],
            [
                'name' => 'Strawberry Chocolate Cake',
                'price' => 1200,
                'description' => 'イチゴとチョコレートの絶妙なハーモニーを楽しめる一品',
                'image_path' => 'cake2.jpeg',
            ],
            [
                'name' => 'Strawberry Cake',
                'price' => 1500,
                'description' => '新鮮なイチゴを贅沢に使用した、甘さ控えめのふわふわケーキ',
                'image_path' => 'Cake6.jpeg',
            ],
            [
                'name' => 'Strawberry Pop Cream',
                'price' => 600,
                'description' => '軽やかなクリームとイチゴの酸味が絶妙なバランス',
                'image_path' => 'pop-cream.jpeg',
            ],
            [
                'name' => 'Hot Cake',
                'price' => 800,
                'description' => '外はカリッと、中はふんわり焼き上げたクラシックなホットケーキ',
                'image_path' => 'hot-cake.jpeg',
            ],
            [
                'name' => 'Roll Cream Cake',
                'price' => 1000,
                'description' => 'なめらかなクリームをたっぷり巻き込んだロールケーキ',
                'image_path' => 'roll-cake.jpeg',
            ],
            [
                'name' => 'Fruits Strawberry Cake',
                'price' => 1800,
                'description' => '色とりどりのフルーツをふんだんに使った贅沢なタルト',
                'image_path' => 'cake7.jpeg',
            ],
            [
                'name' => 'Fruits Cake',
                'price' => 900,
                'description' => 'ジューシーなフルーツがたっぷりの、特別な日にぴったりなケーキ',
                'image_path' => 'cake3.jpeg',
            ],
            [
                'name' => 'Strawberry Donut',
                'price' => 500,
                'description' => 'イチゴの風味が広がる、もちもち食感のドーナツ',
                'image_path' => 'donut1.jpeg',
            ],
            [
                'name' => 'Almond Donut',
                'price' => 500,
                'description' => '香ばしいアーモンドの風味が楽しめる大人向けのドーナツ',
                'image_path' => 'donut2.jpeg',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
