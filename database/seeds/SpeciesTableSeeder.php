<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpeciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('species')->insert([
            'name' => 'Erizo Verde',
            'scientificName' => 'Arbacia dufresnii',
            'description' => 'Hasta 5 cm de diámetro (sin contar las espinas). De color verde con espinas gruesas blancas o marrones. Pies ambulacrales marrones. Grandes zonas desprovistas de espinas y espinas cortas sobre la cara aboral. Esta especies se encuentra en grandes densidades sobre los arrecifes de la patagonia norte.',
            'diet' => 'Omnívoro (puede consumir briozoos, cirripedios o poliquetos entre otros y macroalgas como Undaria pinnatifida )',
            'habitat' => 'Mayormente en el submareal pero puede ser encontrado también en el intermareal. Se lo encuentra principalmente sobre algas y fondos rocosos.',
            'reproduction' => 'Sexos separados , fertilización externa y desarrollo indirecto (larva-juvenil)',
            'group_id' => 2
        ]);
        DB::table('species')->insert([
            'name' => 'Estrella incubadora',
            'scientificName' => 'Anasterias antarctica',
            'description' => 'Hasta 17 cm de diámetro. Es una estrella de mar que puede encontrarse hasta los 80 m de profundidad, pero suele ser más común en la zona del intermareal. De color verde oscuro o marrón en la parte aboral y blanca en la parte oral.',
            'diet' => 'Depredador oportunista. Consume principalmente mejillones pero puede también alimentarse de gasterópodos o crustáceos.',
            'habitat' => 'Mayormente en el intermareal escondida en pozas de mareas o bajo rocas. Pero es observada con frecuencia sobre los arrecifes rocosos de poca profundidad.',
            'reproduction' => 'Esta especie a diferencia de la mayoría de asteroideos no utiliza larvas de vida libre durante su reproducción. El desarrollo se lleva a cabo durantes meses en el cuerpo de la madre que raramente se alimenta durante ese periodo. La madre forma una camara de incubacion en la parte oral, arqueando sus brazos y manteniéndose adherida al sustrato. Los huevos y embriones se mantienen unidos durante la incubación gracias a una sustancia cohesiva.',
            'group_id' => 2
        ]);
        DB::table('species')->insert([
            'name' => 'Estrella de seis brazos',
            'scientificName' => 'Allostichaster capensis',
            'description' => 'Hasta 6 cm de diámetro. De color naranja, amarillo o rosa pálido. Es abundante en los arrecifes rocosos. Normalmente presenta 6 brazos pero suele observarse con tres brazos luego de una división del cuerpo (reproducción asexual)',
            'diet' => 'Depredadora de gasterópodos (Tegula patagonica), cholgas (Aulacomya atra atra) y bivalvos (Lithophaga patagonica).',
            'habitat' => 'En el submareal y puede llegar hasta 100 m de profundidad.',
            'reproduction' => 'Puede reproducirse mediante la liberación de gametas al agua y formación de larva de vida libre, como también puede reproducirse de forma asexual. Tiene la capacidad de dividir su cuerpo en dos, generando dos individuos de tres brazos que luego regeneran la mitad faltante. Durante el proceso de regeneración su capacidad de depredación se ve reducida por la falta de todos los brazos, razón por la cual deben tener energía acumulada para poder sobrevivir.',
            'group_id' => 2
        ]);
        DB::table('species')->insert([
            'name' => 'Trofón',
            'scientificName' => 'Trophon geversianus',
            'description' => 'Tamaño hasta 10 cm de largo de concha. La concha es de blanca a marrón y puede ser lisa o con notorias costillas. El pie es blanco y presenta opérculo que es una placa que se desarrolla en la parte posterior del pie y es usada para cerrar la abertura de la concha cuando el animal se retrae en su interior.',
            'diet' => 'Es carnívoro, puede perforar valvas de bivalvos secretando sustancias químicas que le permite ingresar su rádula (aparato masticador) para consumir las partes blandas de la presa.',
            'habitat' => 'En el intermareal se lo encuentra generalmente sobre bancos de mejillines de los cuales se alimenta. También habita en el submareal sobre bancos de cholga o mejillones y puede llegar hasta los 100 m de profundidad.',
            'reproduction' => 'Se reproducen mediante fecundación interna. La hembra coloca los huevos dentro de ovicápsulas que son adheridas sobre sustratos duros. Allí dentro se desarrolla la larva hasta que salen de las cápsulas como pequeños juveniles.',
            'group_id' => 3
        ]);
        DB::table('species')->insert([
            'name' => 'Caracol trompo',
            'scientificName' => 'Tegula patagonica',
            'description' => 'Tamaño hasta 2 cm de largo de concha. La concha es sólida y de forma cónica coloración marrón, blanca o rosada (si se encuentra cubierta por el alga calcarea Lithothamnium). El pie es negro y presenta opérculo que es una placa que se desarrolla en la parte posterior del pie y es usada para cerrar la abertura de la concha cuando el animal se retrae en su interior.',
            'diet' => 'Es herbívoro, se alimenta del biofilm que se encuentra sobre las algas.',
            'habitat' => 'En el intermareal se lo encuentra generalmente en el nivel bajo donde a abundan las algas. En posas de marea o debajo de rocas. Es una especie abundante. Se la encuentra también en el submareal somero donde es muy abundante.',
            'reproduction' => 'Se reproducen mediante fecundación externa. Hembras y machos liberan los gametos al agua donde se produce la fecundación y posterior formación de larva de vida libre que luego recluta en forma de juvenil.',
            'group_id' => 3
        ]);
        DB::table('species')->insert([
            'name' => 'Lapa chica',
            'scientificName' => 'Siphonaria lessonii',
            'description' => 'Tamaño hasta 2 cm de largo de concha. La concha es triangular en vista lateral, el apice puede ser redondeado o aguzado y dirigido hacia atrás, coloración marrón o verdosa, algunas con bandas de color más oscura. Presenta la cavidad del manto modificada para captar oxigeno atmosférico (pulmonado)',
            'diet' => 'Es herbívoro, se alimenta de algas y bacterias que se encuentra sobre las algas.',
            'habitat' => 'En el intermareal se lo encuentra generalmente en el nivel medio y alto de costas rocosas. Se lo encuentra sobre mejillines o cirripedios, en grietas o fisuras. Es una especie abundante.',
            'reproduction' => 'Se reproducen mediante una masa ovígera en la que se encuentran varias ovícapsulas que contiene un único embrión en su interior. Una vez completada la gestación el embrión eclosiona como larva (desarrollo indirecto)',
            'group_id' => 3
        ]);
        DB::table('species')->insert([
            'name' => 'Babosa de mar moteada',
            'scientificName' => 'Pleurobranchaea maculata',
            'description' => 'Tamaño hasta 15 cm de largo de concha. Carece de concha externa, presenta una branquia en forma de pluma alojada debajo del manto del lado derecho y dos rinóforos (forma de cuernos). Color moteado en tonos que van del marrón al crema. Presenta un compuesto químico (TTX, neurotoxina) en el cuerpo que es perjudicial para el ser humano, por lo que se recomienda no manipularlo. Es una especie introducida, originaria de Nueva Zelanda y del sudeste de Australia.',
            'diet' => 'Es carnívoro se alimenta de una gran variedad de invertebrados incluso se han reportado casos de canibalismo.',
            'habitat' => 'se lo encuentra en fondos blandos y rocosos desde el intermareal al submareal. Luego de fuertes vientos o marejadas se los puede observar en la playa o en posas de marea.',
            'reproduction' => 'Son hermafroditas con copula recíproca, producen una masa ovígera en forma de cilindros gelatinosos espiralados de color blanco. Estas masas pueden acumular toxinas. Completada la gestación el embrión eclosiona como larva nadadoras. Luego de la metamorfosis se asientan como juveniles.',
            'group_id' => 3
        ]);
        DB::table('species')->insert([
            'name' => 'Mejillín',
            'scientificName' => 'Brachidontes rodriguezii / Perumytilus purpuratus',
            'description' => 'El mejillín es el organismo que domina la zona rocosa entre mareas dándole un color pardo negruzco característico. Se trata de especies emparentadas con el mejillón comestible, pero de talla más pequeña, con una conchilla de color violáceo y pardo- negruzco con la presencia de costillas. La relevancia del mejillín es tal, que sus agrupamientos se denominan el mejillinar, comunidad característica del nivel medio de los intermareales duros. Es una especie bioingeniera, ya que con su maraña de filamentos del biso hace disponible un nuevo hábitat para que vivan decenas de especies asociadas al mejillinar.',
            'diet' => 'Son filtradores, alimentándose de partículas en suspensión en el agua, como pequeñas algas y detritos orgánicos. Poseen sexos separados, el mejillín descarga sus productos sexuales al agua, donde se fertiliza el huevo y se origina una larva libre nadadora y planctotrófica (que se alimenta del plancton).',
            'habitat' => 'Se adhiere al sustrato rocoso u otros sustratos duros, por medio de los filamentos del biso, que son secretados por una glándula especial en la base del pie. Los filamentos del biso hacen que el mejillín soporte las embestidas de las olas ya que lo sujetan firmemente al sustrato.',
            'reproduction' => 'Se reproducen mediante fecundación externa. Presentan sexos separados es decir hay machos y hembras. Las larvas quedan a la deriva de las corrientes hasta que produce el reclutamiento.',
            'group_id' => 3
        ]);
        DB::table('species')->insert([
            'name' => 'Cirripedio común',
            'scientificName' => 'Balanus glandula',
            'description' => 'Es un crustáceo de vida sésil que poseen una concha en forma de cono compuesta por 12 placas que están cementadas entre ellas. Por su morfología fueron confundidos antiguamente como moluscos. Su concha está adherida al sustrato y en el interior se albergan las partes blandas del organismo. La concha posee una abertura por donde el animal puede sacar sus cirros (apéndices torácicos birramosos). En esta especie la concha puede llegar a medir hasta 25 cm de altura. En Chile son un recurso pesquero.',
            'diet' => 'Son organismos filtradores que a través de un abanico de seis pares de cirros, capturan organismos del plancton (fitoplancton, zooplancton, larvas, etc.).',
            'habitat' => 'Se los puede encontrar en la zona del intermareal y submareal hasta 30 m de profundidad. Se encuentra en el Pacífico en las costas de Perú y Chile, y sobre el Atlántico sur en las costas de Argentina.',
            'reproduction' => 'Son hermafroditas con fecundación cruzada. Utilizan un pene expansible que puede llegar hasta otro cirripedio hermafrodita para poder fecundarlo. Los huevos son incubados en el interior de la concha y luego se liberan larvas nauplius de vida libre que formarán parte de plantón. Luego de 3 a 6 semanas el último estadio de la larva volverá al sedimento para continuar con el desarrollo hasta adulto.',
            'group_id' => 4
        ]);
        DB::table('species')->insert([
            'name' => 'Cangrejo verde',
            'scientificName' => 'Carcinus maenas',
            'description' => 'Es un crustáceo invasor europeo. Posee un caparazón con diversos colores que van en los tonos verdes con manchas entre amarillas y naranjas dorsales y ventrales, machos adultos con tonos azulados. El largo del caparazón puede alcanzar los 9 cm, presenta 5 espinas laterales. Es una especie con comportamiento agresivo.',
            'diet' => 'Son depredadores de invertebrados marinos, y se han registrado casos de canibalismo',
            'habitat' => 'Se los puede encontrar en la zona del intermareal bajo y submareal somero sobre fondos duros y blandos.',
            'reproduction' => 'presentan sexos separados, los machos con pinzas de mayor tamaño. El macho se monta y sostiene a la hembra hasta que esta muda y se produce la copula. La hembra incuba huevos en su abdomen, de los cuales se liberan larvas de vida libre, para luego de la metamorfosis asentarse como cangrejos juveniles.',
            'group_id' => 4
        ]);
        DB::table('species')->insert([
            'name' => 'Cangrejo de las rocas',
            'scientificName' => 'Cyrtograpsus angulatus',
            'description' => 'Posee un caparazón con diversos colores que van en los tonos verdes y pueden presentar manchas negras dorsales en adultos, los juveniles pueden presentar manchas claras. El caparazón presenta 4 dientes laterales, siendo el mayor el cuarto y el menor el tercero contando desde adelante. Puede alcanzar un tamaño de 5,5 cm de largo de caparazón. Esta especie presenta autotomía frente a distintos estímulos, luego de perder un apéndice lo regenera. Los machos presentan pinzas más robustas que las hembras, ambas con textura granulosa. Se caracteriza por tener la cuarta pata aplanada con muchas sedas.',
            'diet' => 'Son carnívoros y carroñeros',
            'habitat' => 'Se los puede encontrar en la zona del intermareal media y baja en grietas o debajo de rocas. En intermareales blandos y rocosos.',
            'reproduction' => 'presentan sexos separados, los machos con pinzas de mayor tamaño. El macho se monta y sostiene a la hembra hasta que esta muda y se produce la copula. La hembra incuba huevos en su abdomen, de los cuales se liberan larvas de vida libre, para luego de la metamorfosis asentarse como cangrejos juveniles.',
            'group_id' => 4
        ]);
        DB::table('species')->insert([
            'name' => 'Anémona rayada',
            'scientificName' => 'Diadumene lineata',
            'description' => 'Es una pequeña anémona que puede alcanzar hasta 5 cm de alto. Su característica principal son las rayas amarillas que posee sobre la columna de color verde. Los tentáculos suelen blancos o semi transparentes y normalmente tienen entre 25-50 por ejemplar.',
            'diet' => 'Capturan el alimento mediante sus tentáculos y lo llevan a la boca que también es su ano. Se alimenta de plancton o cualquier otro pequeño animal que pueda ser capturado.',
            'habitat' => 'Se encuentra en las pozas de marea o en la zona submareal. Puede adherirse a los muelles o cascos de barcos por lo cual es una potencial especie invasora.',
            'reproduction' => 'Poseen reproducción sexual con liberación de gametas al agua y larva de vida libre. También puede reproducirse asexualmente partiendo un pedazo de la base y regenerando un nuevo individuo.',
            'group_id' => 5
        ]);
        DB::table('species')->insert([
            'name' => 'Anémona punteada',
            'scientificName' => 'Parabunodactis imperfecta',
            'description' => 'Es una anémona común en el intermareal y puede alcanzar hasta 6 cm de diámetro. En su columna posee líneas de puntos y sus tentáculos son de color marrones claros. Puede llegar a tener hasta 100 tentáculos.',
            'diet'=> 'Capturan el alimento mediante sus tentáculos y lo llevan a la boca que también es su ano. Se alimenta de plancton o cualquier otro pequeño animal que pueda ser capturado.',
            'habitat' => 'Necesitan de un sustrato duro para asentarse. Se encuentra en las pozas de marea o en la zona submareal. En algunos casos puede estar descubierta de agua por algunas horas en la zona del intermareal rocoso.',
            'reproduction' => 'Poseen reproducción sexual con liberación de gametas al agua y larva de vida libre.',
            'group_id' => 5
        ]);
    }
}
