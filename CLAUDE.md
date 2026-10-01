# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel-based school management application backend with a modular architecture. The application uses PHP 8.2+ and Laravel 11.9+ framework.

## Key Architecture Patterns

### Modular Structure
The application follows a strict modular architecture where each business domain is organized into separate modules under the `modules/` directory:

- **AccountManagement**: Financial operations (invoices, bills, payments, deposits)
- **ActivityFeedManagement**: Social features (posts, likes, hashtags, media)
- **AdmissionManagement**: Applicant management and admission processes
- **AttendanceManagement**: Student and educator attendance tracking, leave management
- **CalendarManagement**: Events, holidays, special classes
- **EducatorFeedbackManagement**: Feedback system for educators
- **ExamManagement**: Examination scheduling, quiz management, marks, reports
- **GeneralEntityManagement**: Common entities (banks, countries, religions, etc.)
- **ParentManagement**: Parent/guardian relationships
- **ProgramManagement**: Academic programs, subjects, grade levels
- **StudentManagement**: Student data and operations
- **SystemEntityManagement**: System-wide entities and default configurations
- **UserManagement**: Authentication and user profiles

Each module contains:
- `Database/Sql/` - SQL schema files
- `Intents/` - Business logic organized by entity and action
- `Models/` - Eloquent models
- `Providers/` - Service providers
- `routes.php` - Module routes
- `config.php` - Module configuration

### Intent-Based Architecture
Business logic is organized using an Intent-Action-DTO pattern:

- **Intent**: Entry point that handles request validation and routing
- **Action**: Contains the actual business logic (uses `Lorisleiva\Actions`)
- **DTO Classes**:
  - `UserDTO`: Validates user input
  - `SystemDTO`: Adds system-generated data (user_id, timestamps, etc.)
  - `DTO`: Final validation combining user and system data
  - `ResDTO`: Response data structure

Example structure: `modules/ActivityFeedManagement/Intents/SchoolPost/CreateSchoolPost/`

### Database Layer
- Uses PostgreSQL as primary database (`pgsql_testing` for tests)
- SQL schema files in `modules/*/Database/Sql/`
- Models use standard Laravel Eloquent patterns
- Custom `BaseModel` provides common functionality

## Development Commands

### Backend Development
```bash
# Start development server with all services
composer dev

# This runs concurrently:
# - php artisan serve (web server)
# - php artisan queue:listen --tries=1 (queue worker)
# - php artisan pail (log viewer)
# - npm run dev (frontend assets)

# Individual services
php artisan serve
php artisan queue:listen --tries=1
php artisan pail
```

### Frontend Assets
```bash
# Development
npm run dev

# Production build
npm run build
```

### Testing
```bash
# Run all tests (includes module tests)
php artisan test
# or
./vendor/bin/pest

# Run specific test suites
./vendor/bin/pest tests/Unit
./vendor/bin/pest tests/Feature
./vendor/bin/pest modules/*/Tests
```

### Code Quality
```bash
# Format code
./vendor/bin/pint

# Generate IDE helpers for models
composer ide
```

### Database
```bash
# Run migrations
php artisan migrate

# Fresh migration with seeding
php artisan migrate:fresh --seed
```

## Key Dependencies

### Backend
- **lorisleiva/laravel-actions**: Action-based architecture
- **spatie/laravel-data**: DTO validation and transformation
- **spatie/laravel-multitenancy**: Multi-tenant support
- **spatie/laravel-permission**: Role-based permissions
- **laravel/sanctum**: API authentication
- **laravel/reverb**: WebSocket broadcasting
- **brick/money**: Money/currency handling
- **stimulsoft/reports-php**: Report generation

### Frontend
- **Vite**: Build tool and dev server
- **Tailwind CSS**: Utility-first CSS framework
- **Laravel Vite Plugin**: Laravel-Vite integration

### Testing
- **Pest PHP**: Testing framework
- **Laravel Pail**: Log monitoring

## API Structure

All API routes are prefixed and organized by module:
- `/api/general-entity-management/*`
- `/api/user-management/*`
- `/api/student-management/*`
- `/api/calendar-management/*`  
- `/api/activity-feed-management/*`
- `/api/activity-feed/*` (frontend routes)
- `/api/educator-feedback-management/*`

Authentication uses custom `AuthGuard` middleware instead of Laravel's default.

## Development Notes

### Module Registration
Modules are auto-registered via their service providers in `bootstrap/app.php`. Routes are automatically loaded with appropriate prefixes.

### Error Handling
Custom exception handling for API responses:
- 401: Authentication required
- 419: Token mismatch 
- 429: Rate limiting
- All API errors return JSON with consistent structure

### File Storage
Media files are stored in `storage/app/public/` with symbolic link at `public/storage`.

### Multi-tenancy
Application supports multi-tenant architecture via Spatie's multitenancy package.

## Working with Modules

When adding new functionality:
1. Identify the appropriate module or create a new one
2. Follow the Intent-Action-DTO pattern
3. Add SQL schema files to `Database/Sql/`
4. Create Eloquent models with proper relationships
5. Register routes in the module's `routes.php`
6. Write tests in the module's `Tests/` directory

## Reports
Uses Stimulsoft Reports for generating PDF reports. Report templates (.mrt files) are stored in `public/` directory.

## Package Manager
This project uses Yarn 4.9.2+ as the package manager for Node.js dependencies. Use `yarn` instead of `npm` for consistency.

## Environment Configuration
- Development database: PostgreSQL 
- Testing database: `pgsql_testing` (configured in phpunit.xml)
- Media storage: `storage/app/public/` with symlink at `public/storage`

## graphify

This project has a knowledge graph at graphify-out/ with god nodes, community structure, and cross-file relationships.

Rules:
- For codebase questions, first run `graphify query "<question>"` when graphify-out/graph.json exists. Use `graphify path "<A>" "<B>"` for relationships and `graphify explain "<concept>"` for focused concepts. These return a scoped subgraph, usually much smaller than GRAPH_REPORT.md or raw grep output.
- If graphify-out/wiki/index.md exists, use it for broad navigation instead of raw source browsing.
- Read graphify-out/GRAPH_REPORT.md only for broad architecture review or when query/path/explain do not surface enough context.
- After modifying code, run `graphify update .` to keep the graph current (AST-only, no API cost).
