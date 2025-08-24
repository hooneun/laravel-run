# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel 12.x application with React frontend using Inertia.js for seamless SPA-like navigation. The tech stack includes:

- **Backend**: Laravel 12.x with PHP 8.2+
- **Frontend**: React 19.x with TypeScript
- **SPA Framework**: Inertia.js v2 (with SSR support enabled)
- **UI Components**: shadcn/ui with Radix UI primitives
- **Styling**: Tailwind CSS v4
- **Testing**: Pest PHP for backend, SQLite in-memory for test database
- **Build**: Vite with Laravel plugin
- **Database**: SQLite (development), configured for easy migration testing

## Development Commands

### Backend Development
```bash
# Start development server with all services (recommended)
composer dev
# This runs: Laravel server + queue worker + logs + Vite concurrently

# Individual services
php artisan serve                    # Laravel server only
php artisan queue:listen --tries=1  # Queue worker
php artisan pail --timeout=0        # Real-time logs

# Database operations
php artisan migrate                  # Run migrations
php artisan migrate:fresh --seed    # Fresh database with seeding
php artisan tinker                   # Laravel REPL
```

### Frontend Development
```bash
npm run dev          # Vite development server
npm run build        # Production build
npm run build:ssr    # Build with SSR support

# Development with SSR
composer dev:ssr     # Full stack with SSR instead of Vite dev
```

### Code Quality & Testing
```bash
# Backend testing
composer test                        # Run all tests
php artisan test                     # Alternative test command
php artisan test --filter=ExampleTest  # Run specific test

# Frontend linting/formatting
npm run lint         # ESLint with auto-fix
npm run format       # Prettier formatting
npm run format:check # Check formatting only
npm run types        # TypeScript type checking
```

### Laravel-specific Commands
```bash
php artisan route:list              # View all routes
php artisan config:clear            # Clear config cache
php artisan view:clear              # Clear view cache
php artisan optimize                # Optimize for production
vendor/bin/pint                     # Laravel Pint (PHP CS Fixer)
```

## Architecture Overview

### Backend Structure
- **Routes**: Defined in `routes/web.php`, `routes/auth.php`, `routes/settings.php`
- **Controllers**: Minimal logic, primarily return Inertia renders
- **Middleware**: `HandleInertiaRequests` shares global data (user, quotes, sidebar state)
- **Models**: Standard Eloquent models in `app/Models/`
- **Database**: SQLite file (`database/database.sqlite`) with standard Laravel migrations

### Frontend Architecture
- **Page Components**: Located in `resources/js/pages/` - these are Inertia page components
- **Layout System**: Hierarchical layouts in `resources/js/layouts/`
  - `app-layout.tsx` - Main authenticated app layout with sidebar
  - `auth-layout.tsx` - Authentication pages layout
  - `settings/layout.tsx` - Settings section layout
- **UI Components**: 
  - `resources/js/components/ui/` - shadcn/ui base components
  - `resources/js/components/` - Application-specific components
- **Hooks**: React hooks in `resources/js/hooks/` for shared logic
- **Type Definitions**: TypeScript types in `resources/js/types/`

### Key Integrations
- **Inertia.js**: Provides SPA-like navigation without API endpoints
- **Ziggy**: Laravel route generation for frontend (`route()` helper available in React)
- **Tailwind CSS**: Utility-first styling with shadcn/ui design system
- **SSR**: Server-side rendering enabled by default for SEO and performance

### Data Flow
1. Laravel routes return `Inertia::render('page-name', $data)`
2. Inertia passes data as props to React page components
3. Shared data (user, auth state, etc.) available via `usePage().props`
4. Forms submit to Laravel routes, Inertia handles redirect/error states
5. Client-side navigation preserves SPA feel while maintaining server state

### Component Patterns
- Page components receive Laravel data as props
- Layouts wrap page components with common UI (sidebars, headers)
- UI components use Tailwind + shadcn/ui patterns with proper TypeScript
- Form handling follows Inertia patterns with Laravel validation
- Authentication state automatically shared via middleware

### Development Workflow
1. Backend changes: Modify Laravel routes/controllers, run migrations if needed
2. Frontend changes: Edit React components, Inertia handles data binding
3. New pages: Create Laravel route + React page component in `resources/js/pages/`
4. Database changes: Create migration, update models, run `php artisan migrate`
5. Testing: Run Pest tests for backend, consider adding E2E tests for complex user flows

## Important Notes

- **Database**: Uses SQLite file storage - commit `database/database.sqlite` is ignored by git
- **Environment**: Copy `.env.example` to `.env` for local development
- **Asset Building**: Vite handles React compilation, Laravel Mix is not used
- **SSR**: Enabled by default in `config/inertia.php`, helps with SEO and initial page load
- **TypeScript**: Strict mode enabled, all new React code should be TypeScript
- **Styling**: Use Tailwind utilities, leverage shadcn/ui components for consistency