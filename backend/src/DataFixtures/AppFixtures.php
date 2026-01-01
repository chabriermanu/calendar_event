<?php

//Fixtures = Script pour remplir automatiquement la BDD avec des données de test

namespace App\DataFixtures;

use App\Entity\Door;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Theme;
use App\Entity\FamilyGroup;
use App\Entity\User;
use App\Entity\Famille;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    
    {
    
            // ========== THEMES ==========
        $themes = [
            [
                'name' => 'colorful_village',
                'background' => 'village_colore.jpg',
                'primary' => '#FF6B6B',
                'secondary' => '#4ECDC4',
                'music' => 'jingle_bells.mp3',
                'video' => null,
                'description' => 'Village coloré et joyeux pour les enfants'
            ],
            [
                'name' => 'modern_snow',
                'background' => 'neige_moderne.jpg',
                'primary' => '#00A8E8',
                'secondary' => '#FFFFFF',
                'music' => 'snow_ambient.mp3',
                'video' => 'snow_falling.mp4',
                'description' => 'Ambiance moderne et épurée pour les ados'
            ],
            [
                'name' => 'cozy',
                'background' => 'cheminee.jpg',
                'primary' => '#8B4513',
                'secondary' => '#FFA500',
                'music' => 'home_alone.mp3',
                'video' => 'fireplace.mp4',
                'description' => 'Atmosphère chaleureuse et cosy pour les parents'
            ],
            [
                'name' => 'traditionnel',
                'background' => 'noel_traditionnel.jpg',
                'primary' => '#C41E3A',
                'secondary' => '#0F8A5F',
                'music' => 'silent_night.mp3',
                'video' => null,
                'description' => 'Noël traditionnel pour les grands-parents'
            ]
        ];

        $themeObjects = []; // Pour stocker les objets Theme
        foreach ($themes as $themeData) {
            $theme = new Theme();
            $theme->setName($themeData['name']);
            $theme->setBackgroundImage($themeData['background']);
            $theme->setPrimaryColor($themeData['primary']);
            $theme->setSecondaryColor($themeData['secondary']);
            $theme->setMusicUrl($themeData['music']);
            $theme->setVideoUrl($themeData['video']);
            $theme->setDescription($themeData['description']);
            
            $manager->persist($theme);
            $themeObjects[$themeData['name']] = $theme; // Stocke pour l'utiliser après
        }

        // ========== PORTES ========== 
        $doors = [
            ['day'=>1, 'title'=>'1er décembre', 'message'=> 'le compte à rebours de Noel commence !'],
            ['day' => 2, 'title' => 'Jour 2', 'message' => 'Prends le temps de savourer un chocolat chaud.'],
            ['day' => 3, 'title' => 'Jour 3', 'message' => 'Souris à un inconnu et propage la magie de Noël !'],
            ['day' => 4, 'title' => 'Jour 4', 'message' => 'Écoute ta chanson de Noël préférée.'],
            ['day' => 5, 'title' => 'Jour 5', 'message' => 'Commence à décorer ta maison pour les fêtes !'],
            ['day' => 6, 'title' => 'Jour 6', 'message' => 'Pense à une personne que tu aimerais gâter cette année.'],
            ['day' => 7, 'title' => 'Jour 7', 'message' => 'Allume une bougie parfumée et détends-toi.'],
            ['day' => 8, 'title' => 'Jour 8', 'message' => 'C\'est le moment parfait pour faire des biscuits !'],
            ['day' => 9, 'title' => 'Jour 9', 'message' => 'Regarde un film de Noël classique ce soir.'],
            ['day' => 10, 'title' => 'Jour 10', 'message' => 'Chante un chant de Noël à tue-tête !'],
            ['day' => 11, 'title' => 'Jour 11', 'message' => 'Lis une histoire de Noël avant de dormir.'],
            ['day' => 12, 'title' => 'Jour 12', 'message' => 'Crée une carte de vœux faite main.'],
            ['day' => 13, 'title' => 'Jour 13', 'message' => 'Si il neige, fais un bonhomme de neige !'],
            ['day' => 14, 'title' => 'Jour 14', 'message' => 'Écris un message à quelqu\'un que tu aimes.'],
            ['day' => 15, 'title' => 'Jour 15', 'message' => 'Admire les illuminations de Noël de ta ville.'],
            ['day' => 16, 'title' => 'Jour 16', 'message' => 'Emballe un cadeau avec soin et amour.'],
            ['day' => 17, 'title' => 'Jour 17', 'message' => 'Secoue tes grelots imaginaires !'],
            ['day' => 18, 'title' => 'Jour 18', 'message' => 'Offre un chocolat à quelqu\'un de spécial.'],
            ['day' => 19, 'title' => 'Jour 19', 'message' => 'Prends une photo de Noël avec tes proches.'],
            ['day' => 20, 'title' => 'Jour 20', 'message' => 'Danse sur une musique festive !'],
            ['day' => 21, 'title' => 'Jour 21', 'message' => 'Promène-toi et profite de l\'esprit de Noël.'],
            ['day' => 22, 'title' => 'Jour 22', 'message' => 'Organise une soirée jeux en famille.'],
            ['day' => 23, 'title' => 'Jour 23', 'message' => 'Demain, c\'est le grand jour ! Prépare-toi...'],
            ['day' => 24, 'title' => 'Jour 24 - Réveillon', "message" => 'Joyeux Réveillon ! Profite de cette soirée magique !'],
        ];
        foreach ($doors as $doorData){
            $door = new Door();
            $door -> setDayNumber($doorData['day']);
            $door -> setTitle($doorData['title']);
            $door -> setMessage($doorData["message"]);
           // date de disponibilité à chaque porte
            $door->setAvailableDate(new \DateTime('2026-12-' . str_pad($doorData['day'], 2, '0', STR_PAD_LEFT)));
            $manager->persist($door);

        }
        // ========== FAMILY GROUP ==========
        $familyGroup = new FamilyGroup();
        $familyGroup->setName('Famille Noël 2026');
        $familyGroup->setCode('NOEL2026');
        $familyGroup->setAdminEmail('papa@noel.com');
        $manager->persist($familyGroup);

        // ========== USERS + FAMILLE ==========
        $familyMembers = [
            [
                'pseudo' => 'Khyle',
                'age' => 4,
                'role' => 'enfant',
                'avatar' => 'avatar_khyle.png',
                'theme' => 'colorful_village',
                'roles' => ['ROLE_USER']
            ],
            [
                'pseudo' => 'Khelyann',
                'age' => 16,
                'role' => 'ado',
                'avatar' => 'avatar_teen1.png',
                'theme' => 'modern_snow',
                'roles' => ['ROLE_USER']
            ],
            [
                'pseudo' => 'Papa',
                'age' => 45,
                'role' => 'parent',
                'avatar' => 'avatar_papa.png',
                'theme' => 'cozy',
                'roles' => ['ROLE_USER', 'ROLE_ADMIN']
            ],
            [
                'pseudo' => 'Maman',
                'age' => 42,
                'role' => 'parent',
                'avatar' => 'avatar_maman.png',
                'theme' => 'cozy',
                'roles' => ['ROLE_USER']
            ],
            [
                'pseudo' => 'Mamie',
                'age' => 74,
                'role' => 'grand_parent',
                'avatar' => 'avatar_grandparents.png',
                'theme' => 'traditionnel',
                'roles' => ['ROLE_USER']
            ],
            [
                'pseudo' => 'Papy',
                'age' => 76,
                'role' => 'grand_parent',
                'avatar' => 'avatar_grandparents.png',
                'theme' => 'traditionnel',
                'roles' => ['ROLE_USER']
            ],
        ];

        foreach ($familyMembers as $memberData) {
            // Créer le User
            $user = new User();
            $user->setPseudo($memberData['pseudo']);
            $user->setAge($memberData['age']);
            $user->setAvatar($memberData['avatar']);
            $user->setRoles($memberData['roles']);
            $user->setFamilyGroup($familyGroup);
            
            $manager->persist($user);
            
            // Créer le profil Famille
            $famille = new Famille();
            $famille->setOwner($user);
            $famille->setTheme($themeObjects[$memberData['theme']]);
            $famille->setAvatar($memberData['avatar']);
            $famille->setFamilyRole($memberData['role']);
            $famille->setHasCalendarAccess(true);
            
            $manager->persist($famille);
        }


         $manager->flush();
    }
}
