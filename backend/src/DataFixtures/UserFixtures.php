<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $famille = [
            ['email' => 'papa@calendrier.com', 'pseudo' => 'Papa', 'password' => 'noel2026', 'roles' => ['ROLE_ADMIN']],
            ['email' => 'maman@calendrier.com', 'pseudo' => 'Maman', 'password' => 'noel2026', 'roles' => ['ROLE_USER']],
            ['email' => 'papy@calendrier.com', 'pseudo' => 'Papy', 'password' => 'noel2026', 'roles' => ['ROLE_USER']],
            ['email' => 'mamie@calendrier.com', 'pseudo' => 'Mamie', 'password' => 'noel2026', 'roles' => ['ROLE_USER']],
            ['email' => 'fils1@calendrier.com', 'pseudo' => 'Khelyann', 'password' => 'noel2026', 'roles' => ['ROLE_USER']],
            ['email' => 'fils2@calendrier.com', 'pseudo' => 'Khyle', 'password' => 'noel2026', 'roles' => ['ROLE_USER']],
        ];

        foreach ($famille as $userData) {
            $user = new User();
            $user->setEmail($userData['email']);
            $user->setPseudo($userData['pseudo']);
            $user->setRoles($userData['roles']);
            
            $hashedPassword = $this->passwordHasher->hashPassword($user, $userData['password']);
            $user->setPassword($hashedPassword);

            // Dit à Doctrine : "Prépare cet objet User pour la sauvegarde"
            // Mais NE SAUVEGARDE PAS ENCORE en base !
            // Plus PERFORMANT qu'envoyer 6 requêtes séparées !
            $manager->persist($user);
        }

        // Dit à Doctrine : "Maintenant, SAUVEGARDE TOUT ce qui a été préparé avec persist()"
        // // UNE SEULE requête SQL pour tout sauvegarder 
        $manager->flush();
    }
}
