<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Civilization;
use App\Models\ArtifactSource;
use App\Models\ArtifactTag;
use App\Models\Artifact;
use App\Models\Auction;
use App\Models\Bid;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. UTILISATEURS
        $admin = User::create([
            'name' => 'Indiana Jones',
            'email' => 'indy@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'identity_verified' => 'verified',
            'email_verified_at' => now(),
        ]);

        $users = collect([
            [
                'name' => 'Lara Croft',
                'email' => 'lara@example.com',
                'identity_verified' => 'verified',
            ],
            [
                'name' => 'Benjamin Gates',
                'email' => 'gates@example.com',
                'identity_verified' => 'verified',
            ],
            [
                'name' => 'Jack Sparrow',
                'email' => 'jack@example.com',
                'identity_verified' => 'verified',
            ],
            [
                'name' => 'Bilbo Baggins',
                'email' => 'bilbo@example.com',
                'identity_verified' => 'verified',
            ],
            [
                'name' => 'Allan Quatermain',
                'email' => 'allan@example.com',
                'identity_verified' => 'pending',
            ],
            [
                'name' => 'Rick O’Connell',
                'email' => 'rick@example.com',
                'identity_verified' => 'pending',
            ],
            [
                'name' => 'Sarah Connor',
                'email' => 'connor@example.com',
                'identity_verified' => 'pending',
            ],
            [
                'name' => 'Evelyn Carnahan',
                'email' => 'evelyn@example.com',
                'identity_verified' => 'pending',
            ],
            [
                'name' => 'Alan Grant',
                'email' => 'grant@example.com',
                'identity_verified' => 'pending',
            ],

        ])->map(function ($userData) {
            return User::create([
                ...$userData,
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]);
        });

        // 2. CIVILISATIONS
        $civilizations = [
            // Bassin Méditerranéen
            [
                'name' => 'Égypte Ancienne',
                'description' => 'L\'une des plus fascinantes civilisations de l\'histoire humaine, l\'Égypte ancienne a prospéré le long du Nil pendant plus de 3000 ans. Connue pour ses pyramides monumentales, ses hiéroglyphes mystérieux et ses pharaons divins, elle nous a légué des trésors inestimables témoignant d\'une sophistication artistique et technique remarquable.',
                'period' => '3100 av. J.-C. - 30 av. J.-C.',
                'region' => 'Bassin Méditerranéen',
            ],
            [
                'name' => 'Grèce Antique',
                'description' => 'Berceau de la démocratie, de la philosophie et des arts occidentaux, la Grèce antique a profondément marqué l\'histoire de l\'humanité. Des cités-États comme Athènes et Sparte ont développé des systèmes politiques, des œuvres d\'art et des pensées philosophiques qui continuent d\'influencer notre monde moderne.',
                'period' => '800 av. J.-C. - 146 av. J.-C.',
                'region' => 'Bassin Méditerranéen',
            ],
            [
                'name' => 'Empire Romain',
                'description' => 'L\'Empire romain, s\'étendant à son apogée sur trois continents, a créé un système politique, juridique et architectural qui a façonné le monde occidental. De l\'ingénierie des aqueducs aux mosaïques délicates, l\'héritage romain témoigne d\'une civilisation d\'une sophistication extraordinaire.',
                'period' => '27 av. J.-C. - 476 ap. J.-C.',
                'region' => 'Bassin Méditerranéen',
            ],
            [
                'name' => 'Étrusques',
                'description' => 'Mystérieuse civilisation pré-romaine d\'Italie centrale, les Étrusques ont développé une culture raffinée entre le VIIIe et le IIIe siècle av. J.-C. Leurs tombes richement décorées et leurs objets d\'art témoignent d\'une société prospère et d\'une maîtrise artistique exceptionnelle.',
                'period' => '768 av. J.-C. - 264 av. J.-C.',
                'region' => 'Bassin Méditerranéen',
            ],
            // Afrique
            [
                'name' => 'Royaume du Bénin',
                'description' => 'Puissant royaume d\'Afrique de l\'Ouest, le Bénin était renommé pour ses bronzes exceptionnels et son organisation militaire sophistiquée. Les plaques de bronze du palais royal constituent l\'un des plus grands trésors artistiques de l\'Afrique.',
                'period' => '1180 - 1897',
                'region' => 'Afrique',
            ],
            [
                'name' => 'Empire du Ghana',
                'description' => 'Premier des grands empires commerciaux d\'Afrique de l\'Ouest, le Ghana contrôlait les routes de l\'or et du sel trans-sahariennes. Sa richesse légendaire et son organisation politique ont inspiré les empires qui lui ont succédé.',
                'period' => '300 - 1200',
                'region' => 'Afrique',
            ],
            [
                'name' => 'Civilisation Nok',
                'description' => 'L\'une des plus anciennes civilisations d\'Afrique subsaharienne, les Nok sont célèbres pour leurs sculptures en terre cuite d\'une expressivité saisissante. Leur maîtrise de la métallurgie du fer marque une étape cruciale dans l\'histoire africaine.',
                'period' => '1500 av. J.-C. - 500 ap. J.-C.',
                'region' => 'Afrique',
            ],
            [
                'name' => 'Royaume de Koush',
                'description' => 'Héritier de la tradition pharaonique, le royaume de Koush (Nubie) a développé une civilisation unique mêlant influences égyptiennes et traditions africaines. Les pyramides de Méroé témoignent de la grandeur de cette civilisation méconnue.',
                'period' => '1070 av. J.-C. - 350 ap. J.-C.',
                'region' => 'Afrique',
            ],
            // Amériques Précolombiennes
            [
                'name' => 'Maya',
                'description' => 'Brillante civilisation mésoaméricaine, les Mayas ont développé l\'écriture, l\'astronomie et les mathématiques à un niveau extraordinaire. Leurs cités majestueuses, perdues dans la jungle, continuent de révéler les secrets d\'une société complexe et raffinée.',
                'period' => '2000 av. J.-C. - 1500 ap. J.-C.',
                'region' => 'Amériques Précolombiennes',
            ],
            [
                'name' => 'Inca',
                'description' => 'Le plus vaste empire précolombien, les Incas ont unifié les Andes sous leur autorité, créant un système administratif remarquable. Leur maîtrise de l\'architecture en pierre, visible à Machu Picchu, défie encore notre compréhension.',
                'period' => '1438 - 1533',
                'region' => 'Amériques Précolombiennes',
            ],
            [
                'name' => 'Olmèques',
                'description' => 'Considérés comme la "culture mère" de la Mésoamérique, les Olmèques ont créé les premières grandes sculptures monumentales des Amériques. Leurs têtes colossales en basalte restent l\'un des mystères archéologiques les plus fascinants.',
                'period' => '1500 av. J.-C. - 400 av. J.-C.',
                'region' => 'Amériques Précolombiennes',
            ],
            [
                'name' => 'Moche',
                'description' => 'Civilisation pré-incaïque de la côte nord du Pérou, les Moche étaient des maîtres céramistes et orfèvres. Leurs poteries narratives et leurs bijoux en or témoignent d\'une société guerrière et religieuse complexe.',
                'period' => '100 - 700 ap. J.-C.',
                'region' => 'Amériques Précolombiennes',
            ],
            // Proche-Orient
            [
                'name' => 'Mésopotamie',
                'description' => 'Berceau de la civilisation entre le Tigre et l\'Euphrate, la Mésopotamie a vu naître l\'écriture, la roue et les premières cités. Des Sumériens aux Babyloniens, cette région a été le creuset d\'innovations qui ont transformé l\'humanité.',
                'period' => '3500 av. J.-C. - 539 av. J.-C.',
                'region' => 'Proche-Orient',
            ],
            [
                'name' => 'Empire Perse',
                'description' => 'Le premier empire véritablement mondial, la Perse achéménide s\'étendait de l\'Indus à la Méditerranée. Tolérants et administrateurs habiles, les Perses ont créé un modèle d\'empire multiculturel d\'une longévité remarquable.',
                'period' => '550 av. J.-C. - 330 av. J.-C.',
                'region' => 'Proche-Orient',
            ],
            [
                'name' => 'Phénicie',
                'description' => 'Peuple de marins et de marchands, les Phéniciens ont dominé le commerce méditerranéen et créé l\'alphabet qui est l\'ancêtre du nôtre. Leurs comptoirs, de Carthage à Cadix, ont diffusé leur culture dans tout le bassin méditerranéen.',
                'period' => '1200 av. J.-C. - 539 av. J.-C.',
                'region' => 'Proche-Orient',
            ],
            // Asie
            [
                'name' => 'Dynastie Shang',
                'description' => 'Première dynastie chinoise historiquement confirmée, les Shang ont développé l\'écriture chinoise et produit des bronzes rituels d\'une qualité artistique incomparable. Leurs os oraculaires nous donnent un aperçu unique de leurs pratiques divinatoires.',
                'period' => '1600 av. J.-C. - 1046 av. J.-C.',
                'region' => 'Asie',
            ],
            [
                'name' => 'Empire Khmer',
                'description' => 'Constructeurs d\'Angkor Wat, les Khmers ont créé le plus vaste complexe religieux du monde. Leur maîtrise de l\'hydraulique et de l\'architecture monumentale témoigne d\'une civilisation d\'une sophistication remarquable.',
                'period' => '802 - 1431',
                'region' => 'Asie',
            ],
            [
                'name' => 'Civilisation de l\'Indus',
                'description' => 'L\'une des plus anciennes civilisations urbaines, la civilisation de l\'Indus reste largement mystérieuse. Ses cités planifiées comme Harappa et Mohenjo-daro révèlent une organisation urbaine étonnamment moderne.',
                'period' => '3300 av. J.-C. - 1300 av. J.-C.',
                'region' => 'Asie',
            ],
        ];

        foreach ($civilizations as $civ) {
            Civilization::create([
                ...$civ,
                'slug' => Str::slug($civ['name']),
            ]);
        }

        // 3. SOURCES
        $sources = [
            [
                'type' => 'private_collection',
                'name' => 'Collection Rothschild',
                'description' => 'Une des plus prestigieuses collections privées d\'Europe, rassemblée sur cinq générations. Réputée pour l\'authenticité irréprochable de ses pièces et leur provenance documentée.',
            ],
            [
                'type' => 'estate',
                'name' => 'Succession du Professeur Henri Chevallier',
                'description' => 'Archéologue renommé, le Pr. Chevallier a participé aux fouilles de Saqqarah dans les années 1960. Sa collection personnelle, constituée légalement, comprend des pièces exceptionnelles.',
            ],
            [
                'type' => 'institution',
                'name' => 'Fondation Archéologique de Genève',
                'description' => 'Institution reconnue internationalement pour ses recherches et sa rigueur scientifique. Cède occasionnellement des pièces en double pour financer ses fouilles.',
            ],
            [
                'type' => 'archaeologist',
                'name' => 'Dr. Sarah Mitchell',
                'description' => 'Spécialiste des civilisations précolombiennes, membre de l\'American Archaeological Association. Propose des pièces issues de collections d\'étude avec documentation complète.',
            ],
            [
                'type' => 'private_collection',
                'name' => 'Collection Van Der Berg',
                'description' => 'Collection familiale néerlandaise spécialisée dans l\'art grec et romain. Trois générations de collectionneurs passionnés avec une traçabilité exemplaire.',
            ],
        ];

        foreach ($sources as $source) {
            ArtifactSource::create($source);
        }

        // 4. TAGS
        $tags = [
            'Céramique', 'Bronze', 'Or', 'Argent', 'Pierre', 'Terre cuite',
            'Bijou', 'Sculpture', 'Vase', 'Monnaie', 'Arme', 'Outil',
            'Rituel', 'Funéraire', 'Domestique', 'Royal', 'Religieux',
            'Rare', 'Exceptionnel', 'Museum Quality', 'Provenance royale'
        ];

        foreach ($tags as $tagName) {
            ArtifactTag::create([
                'name' => $tagName,
                'slug' => Str::slug($tagName),
            ]);
        }

        // 5. ARTEFACTS
        $artifacts = [
            [
                'title' => 'Masque funéraire en or - XXIe dynastie',
                'description' => 'Exceptionnel masque funéraire en or martelé, probablement issu de la nécropole thébaine. Ce masque, d\'une finesse d\'exécution remarquable, présente les traits idéalisés caractéristiques de l\'art égyptien de la Troisième Période Intermédiaire. Les yeux, autrefois incrustés de pierres semi-précieuses, conservent leur intensité hypnotique. La coiffe némes est finement ciselée avec des motifs de cobras protecteurs. Des traces de pigments bleus subsistent dans les sillons, témoignant de la polychromie originale. Hauteur : 32 cm. Un certificat d\'authenticité du Laboratoire d\'Égyptologie de l\'Université de Genève accompagne cette pièce.',
                'civilization_id' => 1, // Égypte
                'source_id' => 2, // Succession Chevallier
                'discovery_site' => 'Thèbes Ouest',
                'discovery_year' => '1967',
                'archaeologist' => 'Pr. Henri Chevallier',
                'discovery_context' => 'Fouilles autorisées dans la Vallée des Nobles, tombe TT64',
                'materials' => ['Or', 'Traces de lapis-lazuli', 'Pigments'],
                'dimensions' => ['hauteur' => '32cm', 'largeur' => '24cm', 'poids' => '1.2kg'],
                'condition_grade' => 'Excellent',
                'condition_notes' => 'Quelques incrustations manquantes au niveau des yeux. Légère déformation de l\'oreille gauche.',
                'has_restoration' => false,
                'authenticated' => true,
                'authentication_certificate' => 'Certificat Université de Genève n°EG-2023-1247',
                'provenance_history' => [
                    '1967 - Découverte lors des fouilles officielles',
                    '1968 - Collection Pr. Chevallier (partage légal)',
                    '2024 - Succession Chevallier'
                ],
                'legend' => 'Les masques funéraires dorés étaient réservés à l\'élite égyptienne, symbolisant la transformation du défunt en Osiris.',
                'price' => 125000,
                'sale_type' => 'immediate',
                'status' => 'available',
                'images' => ['mask-egypt-001.jpg', 'mask-egypt-002.jpg', 'mask-egypt-003.jpg'],
                'featured' => true,
                'wishlist_count' => 47,
            ],
            [
                'title' => 'Amphore panathénaïque - Figures noires',
                'description' => 'Magnifique amphore panathénaïque attribuée au Groupe de Léagros, actif à Athènes vers 520-500 av. J.-C. La face A présente Athéna Promachos entre deux colonnes doriques surmontées de coqs, avec l\'inscription "TON ATHENETHEN ATHLON" (des jeux d\'Athènes). La face B illustre une course de chars d\'une vivacité exceptionnelle, avec quatre quadriges en pleine action. La qualité du dessin, la finesse des incisions et l\'excellent état de conservation en font une pièce muséale. Ces amphores, remplies d\'huile sacrée, étaient offertes aux vainqueurs des Jeux Panathénaïques.',
                'civilization_id' => 2, // Grèce
                'source_id' => 5, // Collection Van Der Berg
                'discovery_site' => 'Vulci, Étrurie',
                'discovery_year' => '1834',
                'archaeologist' => 'Lucien Bonaparte',
                'discovery_context' => 'Nécropole étrusque, tombe princière',
                'materials' => ['Terre cuite', 'Engobe noir', 'Rehauts blancs et rouges'],
                'dimensions' => ['hauteur' => '62cm', 'diamètre' => '39cm', 'contenance' => '38 litres'],
                'condition_grade' => 'Very Good',
                'condition_notes' => 'Petit éclat recollé sur la lèvre. Légère usure des rehauts blancs.',
                'has_restoration' => true,
                'authenticated' => true,
                'authentication_certificate' => 'Expertise Dr. Boardman, Oxford, 2019',
                'provenance_history' => [
                    '1834 - Fouilles de Lucien Bonaparte à Vulci',
                    '1835-1920 - Collection Bonaparte',
                    '1920 - Vente Hôtel Drouot, Paris',
                    '1920-2024 - Collection Van Der Berg'
                ],
                'legend' => 'Seuls les vainqueurs des épreuves sportives recevaient ces prestigieuses amphores, véritables trophées antiques.',
                'price' => 85000,
                'sale_type' => 'auction',
                'status' => 'available',
                'images' => ['amphora-greek-001.jpg', 'amphora-greek-002.jpg'],
                'featured' => true,
                'wishlist_count' => 23,
            ],
            [
                'title' => 'Tête colossale olmèque en jade',
                'description' => 'Extraordinaire tête en jade vert sombre, caractéristique de l\'art olmèque classique (1200-900 av. J.-C.). Cette sculpture présente les traits distinctifs olmèques : lèvres épaisses tournées vers le bas, nez épaté, yeux en amande mi-clos donnant une expression de sérénité mystique. La qualité exceptionnelle du jade, probablement originaire du Guatemala, et le poli miroir témoignent de centaines d\'heures de travail. Une perforation biconique au sommet suggère un usage rituel comme pendentif cérémoniel pour un prêtre ou un dirigeant.',
                'civilization_id' => 11, // Olmèques
                'source_id' => 4, // Dr. Sarah Mitchell
                'discovery_site' => 'La Venta, Tabasco',
                'discovery_year' => '1955',
                'archaeologist' => 'Expédition Yale University',
                'discovery_context' => 'Offrande massive 4, Complexe A',
                'materials' => ['Jade néphrite', 'Traces de cinabre'],
                'dimensions' => ['hauteur' => '15cm', 'largeur' => '12cm', 'épaisseur' => '10cm', 'poids' => '2.3kg'],
                'condition_grade' => 'Perfect',
                'condition_notes' => 'État de conservation exceptionnel. Poli d\'origine intact.',
                'has_restoration' => false,
                'authenticated' => true,
                'authentication_certificate' => 'Yale University Art Gallery - Certificat n°YAG-2022-089',
                'provenance_history' => [
                    '1955 - Découverte officielle',
                    '1956-2020 - Collection d\'étude Yale University',
                    '2020 - Déaccessionnée légalement',
                    '2020-2024 - Collection Dr. Mitchell'
                ],
                'legend' => 'Les Olmèques, "peuple du jaguar", considéraient le jade plus précieux que l\'or, symbole de vie éternelle et de pouvoir divin.',
                'price' => 180000,
                'sale_type' => 'immediate',
                'status' => 'available',
                'images' => ['jade-olmec-001.jpg', 'jade-olmec-002.jpg'],
                'featured' => true,
                'wishlist_count' => 67,
            ],
            [
                'title' => 'Plaque palatiale en bronze du Bénin',
                'description' => 'Plaque en bronze coulé représentant l\'Oba (roi) en tenue d\'apparat, flanqué de deux dignitaires porteurs d\'éventails. Cette œuvre du XVIe siècle illustre la sophistication de l\'art de cour béninois. L\'Oba, au centre, porte la couronne de corail caractéristique et un collier de perles de corail à plusieurs rangs. Les scarifications royales sont finement rendues. Le fond est orné de rosettes symbolisant le léopard, animal royal. Cette plaque ornait les piliers du palais royal d\'Edo (actuel Benin City) et servait de chronique visuelle du règne.',
                'civilization_id' => 5, // Royaume du Bénin
                'source_id' => 3, // Fondation Genève
                'discovery_site' => 'Benin City, Nigeria',
                'discovery_year' => '1897',
                'archaeologist' => 'Expédition britannique',
                'discovery_context' => 'Palais royal de l\'Oba',
                'materials' => ['Bronze', 'Alliage cuivreux avec zinc et plomb'],
                'dimensions' => ['hauteur' => '43cm', 'largeur' => '35cm', 'épaisseur' => '4cm', 'poids' => '8.7kg'],
                'condition_grade' => 'Excellent',
                'condition_notes' => 'Patine verte noble. Quelques concrétions calcaires au revers.',
                'has_restoration' => false,
                'authenticated' => true,
                'authentication_certificate' => 'Expertise Museum für Völkerkunde, Berlin, 2021',
                'provenance_history' => [
                    '1897 - Collection lors de l\'expédition punitive',
                    '1898-1960 - Collection privée britannique',
                    '1960-2024 - Fondation Archéologique de Genève'
                ],
                'legend' => 'Ces plaques constituaient une encyclopédie visuelle de l\'histoire du royaume, chaque Oba commandant de nouvelles œuvres.',
                'price' => 95000,
                'sale_type' => 'auction',
                'status' => 'available',
                'images' => ['benin-bronze-001.jpg', 'benin-bronze-002.jpg'],
                'featured' => false,
                'wishlist_count' => 34,
            ],
            [
                'title' => 'Vase rituel Ding - Dynastie Shang',
                'description' => 'Imposant vase rituel tripode ding en bronze, datant de la période Shang tardive (XIIe-XIe siècle av. J.-C.). Ce récipient cérémoniel servait aux offrandes de viande lors des rituels ancestraux. La panse est ornée de masques taotie (dragons stylisés) sur fond de spirales lei wen d\'une précision extraordinaire. Les anses verticales sont surmontées de têtes de bovins. Une inscription de 23 caractères à l\'intérieur identifie le propriétaire comme un haut dignitaire de la cour. La patine vert malachite, acquise au cours de trois millénaires, sublime la qualité exceptionnelle du bronze.',
                'civilization_id' => 16, // Dynastie Shang
                'source_id' => 1, // Collection Rothschild
                'discovery_site' => 'Anyang, Henan',
                'discovery_year' => '1928',
                'archaeologist' => 'Academia Sinica',
                'discovery_context' => 'Tombe royale M1001, secteur Xiaotun',
                'materials' => ['Bronze', 'Alliage cuivre-étain-plomb'],
                'dimensions' => ['hauteur' => '38cm', 'diamètre' => '32cm', 'poids' => '12.4kg'],
                'condition_grade' => 'Very Good',
                'condition_notes' => 'Petite fissure stable sur un pied. Patine archéologique homogène.',
                'has_restoration' => false,
                'authenticated' => true,
                'authentication_certificate' => 'Expertise Musée Guimet n°2020-847',
                'provenance_history' => [
                    '1928 - Découverte archéologique',
                    '1930 - Collection C.T. Loo, Paris',
                    '1935-2024 - Collection Rothschild'
                ],
                'legend' => 'Les bronzes rituels Shang représentent l\'apogée technique et artistique de l\'âge du bronze chinois.',
                'price' => 220000,
                'sale_type' => 'immediate',
                'status' => 'available',
                'images' => ['ding-shang-001.jpg', 'ding-shang-002.jpg'],
                'featured' => true,
                'wishlist_count' => 89,
            ],
            [
                'title' => 'Tablette cunéiforme - Contrat commercial sumérien',
                'description' => 'Tablette d\'argile cuite portant un texte cunéiforme en sumérien, datée de la IIIe dynastie d\'Ur (vers 2050 av. J.-C.). Le document enregistre la vente de 20 moutons gras par le marchand Lu-Enlil au temple d\'Inanna contre 2 mines d\'argent. Le texte, rédigé par le scribe Ur-Nammu, comprend la liste des témoins et l\'empreinte du sceau-cylindre du vendeur. Cette tablette offre un aperçu fascinant de l\'économie mésopotamienne et de l\'une des plus anciennes formes d\'écriture de l\'humanité.',
                'civilization_id' => 13, // Mésopotamie
                'source_id' => 2, // Succession Chevallier
                'discovery_site' => 'Ur, Iraq',
                'discovery_year' => '1965',
                'archaeologist' => 'Mission franco-irakienne',
                'discovery_context' => 'Archives du quartier des marchands',
                'materials' => ['Argile cuite'],
                'dimensions' => ['hauteur' => '8.5cm', 'largeur' => '5.5cm', 'épaisseur' => '2.8cm'],
                'condition_grade' => 'Good',
                'condition_notes' => 'Coin supérieur droit ébréché. Texte lisible à 95%.',
                'has_restoration' => false,
                'authenticated' => true,
                'authentication_certificate' => 'CNRS - Laboratoire d\'Assyriologie',
                'provenance_history' => [
                    '1965 - Fouilles officielles',
                    '1966 - Partage légal',
                    '1966-2024 - Collection Chevallier'
                ],
                'legend' => 'Ces tablettes constituent les plus anciens documents commerciaux de l\'humanité, témoins de la naissance de l\'économie.',
                'price' => 15000,
                'sale_type' => 'immediate',
                'status' => 'available',
                'images' => ['tablet-sumerian-001.jpg', 'tablet-sumerian-002.jpg'],
                'featured' => false,
                'wishlist_count' => 12,
            ],
            [
                'title' => 'Parure royale Maya en jade et coquillage',
                'description' => 'Ensemble exceptionnel composé d\'un pectoral, de boucles d\'oreilles et d\'un bracelet, caractéristique de l\'élite maya de la période classique (600-800 ap. J.-C.). Le pectoral central représente le dieu du maïs émergeant de sa carapace, sculpté dans un jade vert pomme translucide. Les éléments en coquillage spondylus orange créent un contraste saisissant. Les hiéroglyphes gravés au revers du pectoral mentionnent un "ajaw" (seigneur) de Palenque. Cette parure témoigne du raffinement extrême de l\'art lapidaire maya et de l\'importance symbolique du jade.',
                'civilization_id' => 9, // Maya
                'source_id' => 4, // Dr. Mitchell
                'discovery_site' => 'Palenque, Chiapas',
                'discovery_year' => '1952',
                'archaeologist' => 'Alberto Ruz Lhuillier',
                'discovery_context' => 'Temple des Inscriptions, chambre funéraire',
                'materials' => ['Jade', 'Spondylus', 'Nacre', 'Obsidienne'],
                'dimensions' => ['pectoral' => '18x15cm', 'boucles' => '8cm', 'bracelet' => '22cm circonférence'],
                'condition_grade' => 'Excellent',
                'condition_notes' => 'Ensemble complet. Quelques perles du bracelet remplacées.',
                'has_restoration' => true,
                'authenticated' => true,
                'authentication_certificate' => 'INAH Mexico - Permis export n°2022-1847',
                'provenance_history' => [
                    '1952 - Découverte archéologique',
                    '1953-2020 - Musée régional de Palenque',
                    '2020 - Déaccession autorisée',
                    '2020-2024 - Collection Mitchell'
                ],
                'legend' => 'Le jade, "chalchihuitl" en nahuatl, était plus précieux que l\'or pour les Mayas, symbole de vie, de fertilité et de pouvoir.',
                'price' => 145000,
                'sale_type' => 'auction',
                'status' => 'available',
                'images' => ['maya-jade-001.jpg', 'maya-jade-002.jpg', 'maya-jade-003.jpg'],
                'featured' => true,
                'wishlist_count' => 78,
            ],
            [
                'title' => 'Rhyton achéménide en argent doré',
                'description' => 'Somptueux rhyton (vase à libation) en argent partiellement doré, terminé par un protomé de lion bondissant. Cette pièce d\'orfèvrerie persane du Ve siècle av. J.-C. illustre le raffinement de la cour achéménide. Le corps du vase est orné de registres horizontaux présentant des processions de tributaires apportant des offrandes au Grand Roi. La crinière du lion est finement ciselée et dorée, les yeux étaient originellement incrustés de pierres précieuses. Un chef-d\'œuvre de l\'orfèvrerie antique qui ornait probablement la table royale de Persépolis.',
                'civilization_id' => 14, // Empire Perse
                'source_id' => 1, // Collection Rothschild
                'discovery_site' => 'Ecbatane (Hamadan)',
                'discovery_year' => '1923',
                'archaeologist' => 'Ernst Herzfeld',
                'discovery_context' => 'Trésor du palais satrape',
                'materials' => ['Argent', 'Dorure au mercure', 'Traces de cornaline'],
                'dimensions' => ['hauteur' => '28cm', 'longueur' => '32cm', 'poids' => '1.8kg'],
                'condition_grade' => 'Very Good',
                'condition_notes' => 'Incrustations des yeux manquantes. Petite restauration ancienne sur la panse.',
                'has_restoration' => true,
                'authenticated' => true,
                'authentication_certificate' => 'British Museum - Rapport d\'expertise 2019',
                'provenance_history' => [
                    '1923 - Découverte lors des fouilles',
                    '1925 - Collection Joseph Duveen',
                    '1945-2024 - Collection Rothschild'
                ],
                'legend' => 'Les rhytons servaient lors des banquets royaux perses, le vin s\'écoulant par la gueule de l\'animal dans les coupes des convives.',
                'price' => 380000,
                'sale_type' => 'immediate',
                'status' => 'available',
                'images' => ['rhyton-persian-001.jpg', 'rhyton-persian-002.jpg'],
                'featured' => true,
                'wishlist_count' => 124,
            ],
            [
                'title' => 'Portrait funéraire du Fayoum',
                'description' => 'Portrait peint à l\'encaustique sur panneau de bois, provenant de la nécropole d\'Hawara (IIe siècle ap. J.-C.). Cette œuvre saisissante représente une jeune femme de l\'élite gréco-égyptienne, parée de bijoux en or. La technique de l\'encaustique (cire chaude mélangée aux pigments) confère au portrait une luminosité et une profondeur remarquables. Le regard direct et l\'expression mélancolique créent une connexion émotionnelle immédiate avec le spectateur. Un témoignage poignant du syncrétisme culturel de l\'Égypte romaine.',
                'civilization_id' => 1, // Égypte
                'source_id' => 5, // Van Der Berg
                'discovery_site' => 'Hawara, Fayoum',
                'discovery_year' => '1888',
                'archaeologist' => 'Flinders Petrie',
                'discovery_context' => 'Nécropole gréco-romaine',
                'materials' => ['Bois de tilleul', 'Encaustique', 'Feuille d\'or'],
                'dimensions' => ['hauteur' => '35cm', 'largeur' => '20cm', 'épaisseur' => '2cm'],
                'condition_grade' => 'Good',
                'condition_notes' => 'Quelques craquelures d\'âge. Couleurs remarquablement préservées.',
                'has_restoration' => false,
                'authenticated' => true,
                'authentication_certificate' => 'Thermoluminescence - Oxford Lab 2020',
                'provenance_history' => [
                    '1888 - Fouilles Petrie',
                    '1889 - Collection Reinhardt, Vienne',
                    '1938 - Acquisition Van Der Berg'
                ],
                'legend' => 'Ces portraits, placés sur les momies, sont considérés comme les ancêtres du portrait occidental.',
                'price' => 65000,
                'sale_type' => 'immediate',
                'status' => 'available',
                'images' => ['fayum-portrait-001.jpg', 'fayum-portrait-002.jpg'],
                'featured' => false,
                'wishlist_count' => 45,
            ],
            [
                'title' => 'Miroir étrusque en bronze gravé',
                'description' => 'Miroir circulaire en bronze poli avec manche en ivoire, chef-d\'œuvre de l\'art étrusque du IVe siècle av. J.-C. Le revers présente une scène mythologique finement gravée : Turan (Aphrodite étrusque) couronnant Hercle (Héraclès) sous le regard d\'Apulu (Apollon). La maîtrise du dessin, avec ses détails anatomiques précis et ses drapés fluides, témoigne du raffinement de l\'art étrusque. Le manche en ivoire, sculpté en forme de jeune femme, est un ajout luxueux rare.',
                'civilization_id' => 4, // Étrusques
                'source_id' => 3, // Fondation Genève
                'discovery_site' => 'Vulci',
                'discovery_year' => '1857',
                'archaeologist' => 'Alessandro François',
                'discovery_context' => 'Tombe de la famille Tetnies',
                'materials' => ['Bronze', 'Ivoire d\'éléphant', 'Traces d\'argent'],
                'dimensions' => ['diamètre' => '15.5cm', 'longueur totale' => '28cm'],
                'condition_grade' => 'Excellent',
                'condition_notes' => 'Surface réfléchissante bien conservée. Manche intact.',
                'has_restoration' => false,
                'authenticated' => true,
                'authentication_certificate' => 'Museo Nazionale Etrusco - Expertise 2021',
                'provenance_history' => [
                    '1857 - Découverte tombe François',
                    '1860-1950 - Collection Torlonia, Rome',
                    '1950-2024 - Fondation Archéologique Genève'
                ],
                'legend' => 'Ces miroirs étaient des cadeaux de mariage prisés, symboles de beauté et de statut social.',
                'price' => 48000,
                'sale_type' => 'immediate',
                'status' => 'available',
                'images' => ['mirror-etruscan-001.jpg', 'mirror-etruscan-002.jpg'],
                'featured' => false,
                'wishlist_count' => 29,
            ],
        ];

        // Créer les artefacts et attacher des tags
        $tagIds = ArtifactTag::pluck('id')->toArray();
        
        foreach ($artifacts as $artifactData) {
            $artifact = Artifact::create($artifactData);
            
            // Attacher 3-5 tags aléatoires par artefact
            $randomTags = array_rand($tagIds, rand(3, 5));
            if (!is_array($randomTags)) {
                $randomTags = [$randomTags];
            }
            $artifact->tags()->attach(array_map(fn($key) => $tagIds[$key], $randomTags));
        }

        // 6. ENCHÈRES FLASH (5 minutes)
        $auctionArtifacts = Artifact::where('sale_type', 'auction')->get();
        
        foreach ($auctionArtifacts as $index => $artifact) {
            $startPrice = $artifact->price * 0.6; // Prix de départ à 60% du prix estimé
            
            // Créer des enchères à différents stades
            if ($index == 0) {
                // Enchère qui vient de commencer (1 minute)
                $startsAt = Carbon::now()->subMinute();
                $endsAt = Carbon::now()->addMinutes(4);
                $status = 'active';
            } elseif ($index == 1) {
                // Enchère à mi-parcours (2.5 minutes)
                $startsAt = Carbon::now()->subMinutes(2)->subSeconds(30);
                $endsAt = Carbon::now()->addMinutes(2)->addSeconds(30);
                $status = 'active';
            } elseif ($index == 2) {
                // Enchère qui se termine bientôt (4 minutes écoulées)
                $startsAt = Carbon::now()->subMinutes(4);
                $endsAt = Carbon::now()->addMinute();
                $status = 'active';
            } else {
                // Enchère à venir dans les prochaines minutes
                $startsAt = Carbon::now()->addMinutes(rand(1, 10));
                $endsAt = $startsAt->copy()->addMinutes(5);
                $status = 'upcoming';
            }
            
            $auction = Auction::create([
                'artifact_id' => $artifact->id,
                'starting_price' => $startPrice,
                'current_price' => $startPrice,
                'reserve_price' => $artifact->price * 0.8,
                'bid_increment' => 500, // Incrément plus petit pour plus d'action
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'status' => $status,
            ]);

            // Pour les enchères actives, simuler une activité intense
            if ($status === 'active') {
                $elapsedSeconds = $startsAt->diffInSeconds(Carbon::now());
                $numberOfBids = min($elapsedSeconds / 3, 80); // Une enchère toutes les 3 secondes max
                
                $currentPrice = $startPrice;
                $allUsers = User::where('role', 'user')->get();
                
                for ($i = 0; $i < $numberOfBids; $i++) {
                    $bidder = $allUsers->random();
                    $currentPrice += $auction->bid_increment * rand(1, 2);
                    
                    // Calculer le moment de l'enchère
                    $bidTime = $startsAt->copy()->addSeconds($i * rand(2, 5));
                    
                    $bid = Bid::create([
                        'auction_id' => $auction->id,
                        'user_id' => $bidder->id,
                        'amount' => $currentPrice,
                        'is_automatic' => rand(0, 100) < 30, // 30% d'enchères automatiques
                        'max_amount' => rand(0, 100) < 30 ? $currentPrice + rand(2000, 10000) : null,
                    ]);
                    
                    // Forcer le timestamp pour simuler l'historique
                    $bid->created_at = $bidTime;
                    $bid->updated_at = $bidTime;
                    $bid->save();
                }

                $auction->update(['current_price' => $currentPrice]);
            }
        }

        // 7. QUELQUES ITEMS EN PANIER
        $users->each(function ($user) {
            $artifacts = Artifact::where('status', 'available')
                ->where('sale_type', 'immediate')
                ->inRandomOrder()
                ->take(rand(0, 3))
                ->get();
            
            foreach ($artifacts as $artifact) {
                $user->cartItems()->create([
                    'artifact_id' => $artifact->id,
                ]);
            }
        });
    }
}