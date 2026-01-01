<?php

namespace App\Security\Voter;

use App\Entity\Door;
use App\Entity\User;
use App\Repository\DoorOpeningRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class DoorOpeningVoter extends Voter
{
    public const OPEN = 'DOOR_OPEN';

    public function __construct(
        private DoorOpeningRepository $doorOpeningRepository
    ) {}

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::OPEN && $subject instanceof Door;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Door $door */
        $door = $subject;

        // 1. Vérifier que la date est arrivée
        $today = new \DateTime();
        if ($door->getAvailableDate() > $today) {
            return false;
        }

        // 2. Vérifier qu'il n'y a pas déjà une ouverture
        $existingOpening = $this->doorOpeningRepository->findOneBy([
            'owner' => $user,
            'door' => $door
        ]);

        return $existingOpening === null;
    }
}