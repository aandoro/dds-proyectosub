<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            'name' => 'INTERMAREAL',
            'description' => 'La zona intermareal es una zona del mar que queda descubierta entre la bajamar y la pleamar de sicigia. Existen por lo tanto distintos tipos de intermareales, dependiendo de los sustratos que queden al descubierto, los hay de sedimentos duros o blandos. Los organismos que habitan en los intermareales del mundo tienen que soportar condiciones ambientales extremas y particularmente las especies de los intermareales patagónicos las más extremas del mundo. Las dos variables físicas que presentan mayor influencia en estos ambientes son la temperatura y la desecación como consecuencia de los fuertes vientos predominantes del Sudoeste. La exposición al oleaje y los cambios de salinidad son también importantes en la estructura ecosistémica de los niveles bajo, medio y alto de los intermareales.'
        ]);
        DB::table('groups')->insert([
            'name' => 'EQUINODERMOS',
            'description' => 'Se conoce con el nombre de equinodermos a un grupo de invertebrados exclusivamente marinos, que incluye a las estrellas de mar, los erizos de mar y los pepinos de mar. Presentan simetría radial, pentarradiada, y no poseen cabeza. Tienen un sistema único entre los animales, el sistema vascular acuífero, que les permite movilizarse, capturar alimento y respirar entre otras funciones. En algunos países ciertas partes del cuerpo de los erizos y pepinos de mar son consideras una delicia gastronómica.'
        ]);
        DB::table('groups')->insert([
            'name' => 'GASTERÓPODOS',
            'description' => 'Los gasterópodos son un grupo de moluscos que incluyen a los caracoles y babosas. En la mayoría de ellos el cuerpo se encuentra constituido por una cabeza diferenciada, una concha calcárea, órganos internos y un pié musculoso. Luego de morir, las conchas de los gasterópodos adornan las vitrinas de muchos coleccionistas o museos. Recientemente en nuestro país se los ha comenzado a pescar debido a que su pie es sabroso y nutritivo.'
        ]);
        DB::table('groups')->insert([
            'name' => 'CRUSTÁCEOS',
            'description' => 'Los crustáceos más conocidos son los cangrejos, las langostas y el krill. Los miembros de este subfilo son primordialmente marinos aunque existen también de agua dulce, terrestre y semiterrestre. Los crustáceos son los artrópodos más abundantes, diversos y ampliamente distribuidos en los océanos del mundo. Presentan caparazón duro segmentado, el cual mudan varias veces durante su vida incrementando su tamaño. Algunas especies son explotadas comercialmente y consumidas por el hombre.'
        ]);
        DB::table('groups')->insert([
            'name' => 'GELATINOSOS',
            'description' => 'Los animales gelatinosos son invertebrados simples de cuerpo blando que pueden estar fijos al fondo marino o tener vida libre. Comprenden dos grupos con gran diversidad de formas: los ctenóforos y los cnidarios, dentro de este último se encuentran las anémonas, los corales y las medusas. Suelen ser transparentes o coloridos, de apariencia gelatinosa. Se alimentan mediante tentáculos y algunas especies pueden ser urticantes. '
        ]);
    }
}
