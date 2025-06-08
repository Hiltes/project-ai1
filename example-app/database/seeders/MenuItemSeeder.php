<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    public function run()
    {
        $items = [
            // Burgery
            ['name' => 'Burger Classic', 'desc' => 'Wołowina, ser, ogórek, ketchup', 'price' => 28.99, 'cat' => 'Fast Food', 'img' => 'burger-classic.jpg'],
            ['name' => 'Burger BBQ', 'desc' => 'Wołowina, boczek, BBQ, cebula', 'price' => 31.50, 'cat' => 'BBQ & Grill', 'img' => 'burger-bbq.jpg'],
            ['name' => 'Burger Wege', 'desc' => 'Kotlet wege, warzywa, sos', 'price' => 26.99, 'cat' => 'Zdrowe Jedzenie', 'img' => 'burger-wege.jpg'],

            // Frytki
            ['name' => 'Frytki klasyczne', 'desc' => 'Złociste frytki z ziemniaków', 'price' => 9.99, 'cat' => 'Street Food', 'img' => 'frytki-klasyczne.jpg'],
            ['name' => 'Frytki belgijskie', 'desc' => 'Grube frytki, sos czosnkowy', 'price' => 12.50, 'cat' => 'Street Food', 'img' => 'frytki-belgijskie.jpg'],
            ['name' => 'Frytki z batatów', 'desc' => 'Słodkie ziemniaki, chrupiące', 'price' => 13.50, 'cat' => 'Zdrowe Jedzenie', 'img' => 'frytki-bataty.jpg'],

            // Sushi
            ['name' => 'Zestaw Sushi Premium', 'desc' => '12 kawałków, łosoś, tuńczyk, avocado', 'price' => 49.99, 'cat' => 'Kuchnia Azjatycka', 'img' => 'sushi-premium.jpg'],

            // Makaron azjatycki
            ['name' => 'Pad Thai', 'desc' => 'Makaron ryżowy, kurczak, orzeszki', 'price' => 32.00, 'cat' => 'Kuchnia Tajska', 'img' => 'pad-thai.jpg'],
            ['name' => 'Udon z warzywami', 'desc' => 'Makaron udon, warzywa stir-fry', 'price' => 29.00, 'cat' => 'Kuchnia Azjatycka', 'img' => 'udon-warzywa.jpg'],

            // Pizza
            ['name' => 'Pizza Pepperoni', 'desc' => 'Ser, pepperoni, sos pomidorowy', 'price' => 26.99, 'cat' => 'Pizza', 'img' => 'pizza-pepperoni.jpg'],
            ['name' => 'Pizza Wegetariańska', 'desc' => 'Papryka, pieczarki, oliwki, cebula', 'price' => 25.50, 'cat' => 'Pizza', 'img' => 'pizza-wege.jpg'],

            // Napoje
            ['name' => 'Kawa Latte', 'desc' => 'Mleczna kawa', 'price' => 11.00, 'cat' => 'Napoje', 'img' => 'kawa-latte.jpg'],
            ['name' => 'Lemoniada cytrynowa', 'desc' => 'Orzeźwiająca lemoniada', 'price' => 8.50, 'cat' => 'Napoje', 'img' => 'lemoniada.jpg'],
            ['name' => 'Sok pomarańczowy', 'desc' => 'Świeżo wyciskany', 'price' => 9.00, 'cat' => 'Napoje', 'img' => 'sok-pomarancza.jpg'],

            // Zdrowe
            ['name' => 'Kurczak z warzywami', 'desc' => 'Grillowany filet, brokuły, marchew', 'price' => 35.00, 'cat' => 'Zdrowe Jedzenie', 'img' => 'kurczak-warzywa.jpg'],

            // Kanapka
            ['name' => 'Kanapka Club', 'desc' => 'Szynka, sałata, ser, pomidor', 'price' => 17.00, 'cat' => 'Street Food', 'img' => 'club-kanapka.jpg'],

            // Sałatka
            ['name' => 'Sałatka grecka', 'desc' => 'Feta, ogórek, pomidor, oliwki', 'price' => 21.00, 'cat' => 'Zdrowe Jedzenie', 'img' => 'salatka-grecka.jpg'],

            // Zupy
            ['name' => 'Zupa krem z pomidorów', 'desc' => 'Zupa z pieczonych pomidorów', 'price' => 13.00, 'cat' => 'Zupy', 'img' => 'zupa-pomidorowa.jpg'],
            ['name' => 'Zupa jarzynowa', 'desc' => 'Tradycyjna zupa warzywna', 'price' => 11.50, 'cat' => 'Zupy', 'img' => 'zupa-jarzynowa.jpg'],
            ['name' => 'Zupa dyniowa', 'desc' => 'Z kremowej dyni z imbirem', 'price' => 12.00, 'cat' => 'Zupy', 'img' => 'zupa-dyniowa.jpg'],
        ];

        foreach ($items as $item) {
            MenuItem::create([
                'name'          => $item['name'],
                'description'   => $item['desc'],
                'price'         => $item['price'],
                'restaurant_id' => 1,
                'category'      => $item['cat'],
                'rating'        => rand(4, 5),
                'rating_count'  => rand(10, 200),
                'image'         => 'menu_images/' . $item['img'],
            ]);
        }
    }
}
