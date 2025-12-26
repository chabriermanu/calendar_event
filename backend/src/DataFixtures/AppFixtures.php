<?php

//Fixtures = Script pour remplir automatiquement la BDD avec des données de test

namespace App\DataFixtures;

use App\Entity\Door;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $doors = [
            ['day'=>1, 'title'=>'1er décembre', 'message'=> 'le compte à  revours de Noel commence !'],
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

            $manager->persist($door);

        }

        $manager->flush();
    }
}
