// Configuration des avatars par tranche d'âge
export interface AvatarOption {
  id: string;
  path: string;
  label: string;
}

// Liste des avatars disponibles par tranche d'âge
// Les avatars sont dans backend/public/assets/avatar/
export const avatarConfig = {
  // Enfants (0-10 ans)
  enfants: [
    {
      id: 'enfant-1',
      path: '/public/avatar/avatar_enfant.png',
      label: 'Enfant garçon',
    },
    {
      id: 'enfant-2',
      path: '/public/avatar/avatar_enfant_female.png',
      label: 'Enfant fille',
    },
  ],
  // Ados (10-18 ans)
  ados: [
    {
      id: 'ado-1',
      path: '/public/avatar/avatar_tenn.png',
      label: 'Ado garçon',
    },
    {
      id: 'ado-2',
      path: '/public/avatar/avatar_tenn_female.png',
      label: 'Ado fille',
    },
  ],
  // Adultes (18-60 ans)
  adultes: [
    {
      id: 'adulte-1',
      path: '/public/avatar/avatar-male..png',
      label: 'Papa',
    },
    {
      id: 'adulte-2',
      path: '/public/avatar/icons8-female.png',
      label: 'Maman',
    },
  ],
  // Seniors (60+ ans)
  seniors: [
    {
      id: 'senior-1',
      path: '/public/avatar/icons8-grandfather.png',
      label: 'Papi',
    },
    {
      id: 'senior-2',
      path: '/public/avatar/icons8-grandmother.png',
      label: 'Mamie',
    },
  ],
};

// Fonction pour obtenir 2 avatars aléatoires selon l'âge
export const get2RandomAvatarsByAge = (age: number): AvatarOption[] => {
  let availableAvatars: AvatarOption[] = [];

  if (age >= 0 && age < 10) {
    availableAvatars = avatarConfig.enfants;
  } else if (age >= 10 && age < 18) {
    availableAvatars = avatarConfig.ados;
  } else if (age >= 18 && age < 60) {
    availableAvatars = avatarConfig.adultes;
  } else {
    availableAvatars = avatarConfig.seniors;
  }

  // Si on a 2 avatars ou moins, on retourne tous les avatars disponibles
  if (availableAvatars.length <= 2) {
    return availableAvatars;
  }

  // Sinon, mélanger et prendre 2 avatars aléatoires
  const shuffled = [...availableAvatars].sort(() => Math.random() - 0.5);
  return shuffled.slice(0, 2);
};

// Fonction pour obtenir la catégorie d'âge (pour l'affichage)
export const getAgeCategory = (age: number): string => {
  if (age >= 0 && age < 10) return 'Enfant (0-10 ans)';
  if (age >= 10 && age < 18) return 'Ado (10-18 ans)';
  if (age >= 18 && age < 60) return 'Adulte (18-60 ans)';
  if (age >= 60) return 'Senior (60+ ans)';
  return 'Âge invalide'; // Pour les cas d'erreur
};
