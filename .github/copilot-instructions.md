# AI Copilot Instructions for test_contact-form

## Project Overview
This is a **Laravel 8 contact form application** with Docker containerization (PHP 8.2, MySQL 8.0, Nginx). The app manages contact submissions through a multi-step flow (form → confirmation → thanks) and provides an admin panel for viewing/searching/exporting contacts.

**Core Domain**: Contact management with category classification (delivery, exchange, trouble, shop inquiry, other). Contacts are linked to categories via foreign key relationship.

## Architecture & Data Flow

### Key Components
- **Frontend**: Blade templates in `resources/views/` with jQuery modals for UX interactivity
- **Controllers**: `ContactController` (main form/admin flow), `AuthController` (login/register), `CsvDownloadController` (exports)
- **Models**: `Contact`, `Category`, `User` with soft deletes via timestamps
- **Validation**: Custom `ContactRequest` FormRequest class handles form validation and Japanese error messages

### Workflow Pattern
1. **Index** → Shows contact form, categories loaded from DB
2. **Confirm** → POST to `/confirm`, displays preview with formatted telephone number
3. **Store** → POST to `/thanks`, converts gender/category Japanese labels → integer IDs (see `ContactController::store()` line 54-76), saves Contact
4. **Admin** → GET-protected dashboard, displays paginated contacts, converts gender IDs back to labels for display

**Critical conversion logic**: Gender (1=男性, 2=女性, 3=その他) and Category (1-5) are stored as integers but form submission sends Japanese text labels. Controller manually maps text→ID in `store()` method.

## Development Environment Setup

### Docker Commands
```bash
# Initial setup
docker-compose up -d --build

# Inside PHP container
docker-compose exec php bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
```

### Key URLs
- Contact form: `http://localhost/`
- Admin dashboard: `http://localhost/admin` (auth required)
- phpMyAdmin: `http://localhost:8080/` (user: `laravel_user`, pass: `laravel_pass`)

### Database Configuration
- Database: `laravel_db`
- User: `laravel_user` / Password: `laravel_pass`
- Root: `root` / Password: `root`

## Project-Specific Patterns & Conventions

### Form Handling with Separated Telephone Fields
- Telephone is split into three form inputs (`front-tel`, `middle-tel`, `back-tel`) but stored as single `tel` column
- `ContactController::confirm()` concatenates fields with `implode()` for preview display
- This pattern differs from typical Laravel practices—preserve this throughout modifications

### Validation & Error Messages
- `ContactRequest` class centralizes rules and Japanese error messages (crucial for UX)
- Messages key example: `"last_name.required" => "姓を入力してください"`
- Always extend or reference this class for form validation

### Gender & Category Mapping
- **Source of truth**: Integer columns in database (gender: 1-3, category_id: 1-5)
- **Conversion points**: 
  - Form submission (`ContactController::store()`) converts labels → IDs
  - Display (`ContactController::admin()`) converts IDs → labels
- Do NOT store labels directly; maintain this ID-based pattern
- `Category` model: Categories are predefined (5 fixed categories), loaded via seeder

### Model Protection
- `Contact::$guarded = ['id']` protects ID from mass assignment
- `$filable` lists assignable fields (should match fillable, note typo: `filable` vs `fillable`)
- Use `Contact::create($contact)` pattern, not `new Contact()`

## Testing & Quality Assurance

### Test Structure
- Unit tests: `tests/Unit/`
- Feature tests: `tests/Feature/`
- PHPUnit configured in `phpunit.xml`

### Running Tests
```bash
php artisan test
```

- Test DB uses array cache driver (no SQLite fallback commented in phpunit.xml)
- Database factories exist for `Contact` and `User` models

## Integration Points & Dependencies

### External Libraries
- **Laravel Fortify**: Authentication scaffolding (login/register views auto-generated)
- **Laravel Sanctum**: Token-based API auth (configured but not actively used in form app)
- **jQuery 3.7.1**: Modal interactions in public JavaScript
- **PHPMyAdmin**: DB GUI for development/debugging

### Routes to Understand
- `/` (GET) → Contact form index
- `/confirm` (POST) → Validation + preview
- `/thanks` (POST) → Store contact
- `/admin` (GET) → Auth-protected admin dashboard
- `/admin/search` (GET) → Search contacts (filters via query params)
- `/admin/delete` (POST) → Soft delete contact
- `/admin/csv-download` (GET) → Export contacts to CSV

### Database Relationships
- `Contact` → `Category` (many-to-one via `category_id` foreign key)
- Cascade delete configured: deleting category removes related contacts
- Soft deletes via `deleted_at` timestamps (though controller doesn't show explicit soft delete usage)

## Common Development Tasks

### Adding a New Form Field
1. Add column to `2023_10_15_081426_create_contacts_table.php` migration
2. Add field to `Contact::$filable` array
3. Add validation rule to `ContactRequest::rules()`
4. Add error message to `ContactRequest::messages()` (Japanese)
5. Include in form view and confirm/display logic

### Modifying Contact Storage Logic
- Always work through `ContactController::store()` and `confirm()` for form-to-DB mapping
- Preserve the gender/category conversion pattern or update it consistently across `store()`, `admin()`, and `search()` display logic

### Admin Search Implementation
- Check `ContactController::search()` implementation—it builds queries dynamically based on request parameters
- Search functionality is paginated and must maintain filter state across pagination

## File Layout Summary
- `src/app/Http/Controllers/` → Business logic (3 main controllers)
- `src/app/Http/Requests/ContactRequest.php` → Centralized validation
- `src/app/Models/` → Eloquent models (3 core models)
- `src/resources/views/` → Blade templates (5 key views)
- `src/routes/web.php` → All routes in one file
- `src/database/migrations/` → 7 migrations (users, contacts, categories, etc.)
- `src/database/seeders/` → Populates categories and test contacts
- `docker/php/`, `docker/nginx/`, `docker/mysql/` → Container configurations

## Notes for AI Agents
- This is a **Japanese-language application**—maintain Japanese text in messages, labels, and UI
- **No API/SPA structure**: Traditional server-side rendering with Blade templates
- **No REST API**: Routes are all for web form handling; no JSON endpoints (except CSV export)
- Avoid modern Laravel patterns (e.g., actions, query builders with classes) not used in this codebase
- When generating code, follow the existing `implode()` and manual mapping patterns rather than introducing abstraction layers
