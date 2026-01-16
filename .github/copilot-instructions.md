# AI Coding Assistant Instructions

## Project Overview
This is a **family advent calendar application** with a Symfony backend and React frontend. The app allows family members to share an interactive advent calendar with photo uploads, using a unique multi-tenant authentication system.

## Architecture
- **Backend**: Symfony 7.4 with API Platform, PostgreSQL, JWT authentication
- **Frontend**: React 18 + TypeScript + Vite + Tailwind CSS
- **Authentication**: 2-step flow (family code → profile selection, no individual passwords)
- **Data Flow**: FamilyGroup → Users → Familles (themed profiles) → DoorOpenings → Photos

## Key Components & Patterns

### Backend Patterns
- **Entities**: Located in `src/Entity/` with Doctrine ORM mappings
- **DTOs**: Request/response objects in `src/DTO/` (e.g., `PhotoUploadRequestDTO`)
- **Services**: Business logic in `src/Service/` (e.g., `PhotoService` handles file uploads)
- **Controllers**: REST endpoints in `src/Controller/` with custom auth routes
- **Security**: JWT tokens via Lexik bundle, voters for authorization

### Frontend Patterns
- **API Layer**: Axios instance in `src/api/axios.ts` with JWT interceptors
- **State Management**: React Context API (`src/context/AuthContext.tsx`)
- **Types**: TypeScript interfaces in `src/types/index.ts` matching backend DTOs
- **Routing**: React Router with protected routes
- **Styling**: Tailwind CSS with custom theme colors from backend

## Authentication Flow
```typescript
// Step 1: Verify family code
POST /auth/family { "code": "NOEL2026" }
// Returns family info + user profiles

// Step 2: Select profile
POST /auth/profile { "familyId": 1, "userId": 3 }
// Returns JWT token + user data
```

## File Upload Pattern
```php
// DTO validation
#[Assert\File(maxSize: '5M', mimeTypes: ['image/jpeg', 'image/png', 'image/webp'])]
public ?UploadedFile $photo = null;

// Service handles storage
$filename = uniqid() . '.' . $dto->photo->guessExtension();
$dto->photo->move($this->uploadDir, $filename);
```

## Development Workflows

### Backend Setup
```bash
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
php bin/console lexik:jwt:generate-keypair
symfony serve
```

### Frontend Setup
```bash
npm install
npm run dev  # Runs on http://localhost:5173
```

### Database
- PostgreSQL via Docker Compose
- Migrations in `migrations/` directory
- Fixtures for test data setup

## Code Conventions

### Naming & Structure
- **Entities**: PascalCase class names, snake_case table names
- **Routes**: RESTful with `/api/` prefix for data endpoints, `/auth/` for auth
- **Files**: Uploaded to `public/uploads/galerie/` with unique filenames
- **Themes**: 4 theme types (child, teen, parent, grandparent) with custom colors/music

### Security
- All protected routes require `Authorization: Bearer <token>` header
- Voters control access (e.g., users can only access their own door openings)
- File uploads validated for type/size
- CORS configured for frontend origin

### Error Handling
- Backend returns JSON errors with appropriate HTTP status codes
- Frontend axios interceptor handles 401 responses by clearing auth state
- Validation errors collected and returned in structured format

## Common Tasks

### Adding New API Endpoint
1. Create DTO in `src/DTO/` if needed
2. Add controller method with proper security attributes
3. Update frontend types and API calls
4. Test with JWT authentication

### Adding New Entity Relationship
1. Update Doctrine mappings in entity classes
2. Create migration: `php bin/console doctrine:migrations:diff`
3. Update API Platform configuration if exposing via REST
4. Update frontend types to match

### File Upload Feature
1. Create DTO with file validation constraints
2. Add controller endpoint with file handling
3. Use service for storage logic (unique naming, directory management)
4. Return public URL for frontend access

## Testing
- PHPUnit configured in `phpunit.dist.xml`
- Run tests: `php bin/phpunit`
- Fixtures available for test data setup

## Deployment Notes
- Environment variables for database connection
- JWT keys need to be generated in production
- Upload directory must be writable
- Static assets served from `public/` directory</content>
<parameter name="filePath">c:\Users\PC\Desktop\calendar_event\.github\copilot-instructions.md