// Types correspondant aux DTOs backend
export interface User {
  id: number;
  pseudo: string;
  age: number;
  avatar: string;
}

export interface FamilyCodeResponse {
  familyId: number;
  familyName: string;
  users: User[];
}

export interface AuthResponse {
  token: string;
  user: {
    id: number;
    pseudo: string;
    roles: string[];
  };
}

export interface UserMeResponse {
  id: number;
  pseudo: string;
  age: number;
  avatar: string;
  roles: string[];
}

export interface Theme {
  id: number;
  name: string;
  backgroundImage: string;
  primaryColor: string;
  secondaryColor: string;
  musicUrl?: string;
  videoUrl?: string;
}

export interface FamilleProfileResponse {
  id: number;
  avatar: string;
  familyRole: string;
  hasCalendarAccess: boolean;
  theme: Theme | null;
}