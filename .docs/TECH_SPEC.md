# Technical Specification

# Website PADRP ASSYUKRO

---

## 1. Project Structure

```
padrp-assyukro/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   ├── RegisterController.php
│   │   │   │   └── ForgotPasswordController.php
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── MemberController.php
│   │   │   │   ├── FinanceController.php
│   │   │   │   ├── EventController.php
│   │   │   │   └── ProfileController.php
│   │   │   ├── Member/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── EventController.php
│   │   │   │   ├── FinanceController.php
│   │   │   │   └── ProfileController.php
│   │   │   └── HomeController.php
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php
│   │   │   ├── MemberMiddleware.php
│   │   │   └── CheckApproved.php
│   │   └── Requests/
│   │       ├── Auth/
│   │       │   └── RegisterRequest.php
│   │       ├── MemberRequest.php
│   │       ├── TransactionRequest.php
│   │       └── EventRequest.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Category.php
│   │   ├── Transaction.php
│   │   └── Event.php
│   ├── Enums/
│   │   ├── UserRole.php
│   │   ├── UserStatus.php
│   │   ├── Gender.php
│   │   ├── TransactionType.php
│   │   └── EventStatus.php
│   └── Services/
│       ├── MemberService.php
│       ├── FinanceService.php
│       └── EventService.php
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_categories_table.php
│   │   ├── 0001_01_01_000002_create_transactions_table.php
│   │   └── 0001_01_01_000003_create_events_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── CategorySeeder.php
│       └── AdminSeeder.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   ├── admin.blade.php
│   │   │   ├── member.blade.php
│   │   │   └── guest.blade.php
│   │   ├── components/
│   │   │   ├── admin/
│   │   │   │   ├── sidebar.blade.php
│   │   │   │   └── header.blade.php
│   │   │   ├── member/
│   │   │   │   ├── sidebar.blade.php
│   │   │   │   └── header.blade.php
│   │   │   ├── card.blade.php
│   │   │   ├── button.blade.php
│   │   │   ├── input.blade.php
│   │   │   ├── select.blade.php
│   │   │   ├── modal.blade.php
│   │   │   ├── alert.blade.php
│   │   │   └── table.blade.php
│   │   ├── auth/
│   │   │   ├── login.blade.php
│   │   │   ├── register.blade.php
│   │   │   └── forgot-password.blade.php
│   │   ├── admin/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── members/
│   │   │   │   ├── index.blade.php
│   │   │   │   ├── pending.blade.php
│   │   │   │   ├── create.blade.php
│   │   │   │   ├── show.blade.php
│   │   │   │   └── edit.blade.php
│   │   │   ├── finance/
│   │   │   │   ├── index.blade.php
│   │   │   │   ├── category.blade.php
│   │   │   │   ├── create.blade.php
│   │   │   │   └── edit.blade.php
│   │   │   ├── events/
│   │   │   │   ├── index.blade.php
│   │   │   │   ├── create.blade.php
│   │   │   │   ├── show.blade.php
│   │   │   │   └── edit.blade.php
│   │   │   └── profile.blade.php
│   │   ├── member/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── events/
│   │   │   │   ├── index.blade.php
│   │   │   │   └── show.blade.php
│   │   │   ├── finance/
│   │   │   │   ├── index.blade.php
│   │   │   │   └── category.blade.php
│   │   │   └── profile.blade.php
│   │   └── welcome.blade.php
│   ├── css/
│   │   └── app.css
│   └── js/
│       └── app.js
├── routes/
│   ├── web.php
│   ├── auth.php
│   ├── admin.php
│   └── member.php
└── public/
    └── assets/
        └── images/
```

---

## 2. Route Definitions

### 2.1 Public Routes (`routes/web.php`)

```php
Route::get('/', [HomeController::class, 'index'])->name('home');
```

### 2.2 Auth Routes (`routes/auth.php`)

```php
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
```

### 2.3 Admin Routes (`routes/admin.php`)

```php
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Members
    Route::get('/members/pending', [MemberController::class, 'pending'])->name('members.pending');
    Route::post('/members/{user}/approve', [MemberController::class, 'approve'])->name('members.approve');
    Route::post('/members/{user}/reject', [MemberController::class, 'reject'])->name('members.reject');
    Route::resource('members', MemberController::class);

    // Finance
    Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index');
    Route::get('/finance/category/{category}', [FinanceController::class, 'category'])->name('finance.category');
    Route::resource('transactions', FinanceController::class)->except(['index', 'show']);

    // Events
    Route::resource('events', EventController::class);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});
```

### 2.4 Member Routes (`routes/member.php`)

```php
Route::middleware(['auth', 'member', 'approved'])->prefix('member')->name('member.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Events (read-only)
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

    // Finance (read-only)
    Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index');
    Route::get('/finance/category/{category}', [FinanceController::class, 'category'])->name('finance.category');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});
```

---

## 3. Model Definitions

### 3.1 User Model

```php
class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address',
        'birth_date', 'gender', 'role', 'status', 'joined_at'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
            'joined_at' => 'date',
            'role' => UserRole::class,
            'status' => UserStatus::class,
            'gender' => Gender::class,
        ];
    }

    // Relationships
    public function transactions(): HasMany
    public function events(): HasMany

    // Scopes
    public function scopeActive($query)
    public function scopePending($query)
    public function scopeMembers($query)
    public function scopeAdmins($query)

    // Helpers
    public function isAdmin(): bool
    public function isMember(): bool
    public function isApproved(): bool
    public function isPending(): bool
}
```

### 3.2 Category Model

```php
class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    // Relationships
    public function transactions(): HasMany

    // Accessors
    public function getBalanceAttribute(): float
    public function getTotalIncomeAttribute(): float
    public function getTotalExpenseAttribute(): float
}
```

### 3.3 Transaction Model

```php
class Transaction extends Model
{
    protected $fillable = [
        'category_id', 'user_id', 'type', 'amount',
        'description', 'transaction_date'
    ];

    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
            'amount' => 'decimal:2',
            'type' => TransactionType::class,
        ];
    }

    // Relationships
    public function category(): BelongsTo
    public function user(): BelongsTo

    // Scopes
    public function scopeIncome($query)
    public function scopeExpense($query)
    public function scopeByCategory($query, $categoryId)
    public function scopeByDateRange($query, $from, $to)
}
```

### 3.4 Event Model

```php
class Event extends Model
{
    protected $fillable = [
        'title', 'description', 'event_date', 'start_time',
        'end_time', 'location', 'status', 'created_by'
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
            'status' => EventStatus::class,
        ];
    }

    // Relationships
    public function creator(): BelongsTo

    // Scopes
    public function scopeUpcoming($query)
    public function scopeCompleted($query)
    public function scopeOngoing($query)

    // Boot method to auto-update status
    protected static function boot()
}
```

---

## 4. Enums

### 4.1 UserRole

```php
enum UserRole: string
{
    case ADMIN = 'admin';
    case ANGGOTA = 'anggota';

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Admin',
            self::ANGGOTA => 'Anggota',
        };
    }
}
```

### 4.2 UserStatus

```php
enum UserStatus: string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Menunggu Persetujuan',
            self::ACTIVE => 'Aktif',
            self::INACTIVE => 'Non-Aktif',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'yellow',
            self::ACTIVE => 'green',
            self::INACTIVE => 'red',
        };
    }
}
```

### 4.3 Gender

```php
enum Gender: string
{
    case MALE = 'L';
    case FEMALE = 'P';

    public function label(): string
    {
        return match($this) {
            self::MALE => 'Laki-laki',
            self::FEMALE => 'Perempuan',
        };
    }
}
```

### 4.4 TransactionType

```php
enum TransactionType: string
{
    case INCOME = 'income';
    case EXPENSE = 'expense';

    public function label(): string
    {
        return match($this) {
            self::INCOME => 'Pemasukan',
            self::EXPENSE => 'Pengeluaran',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::INCOME => 'green',
            self::EXPENSE => 'red',
        };
    }
}
```

### 4.5 EventStatus

```php
enum EventStatus: string
{
    case UPCOMING = 'upcoming';
    case ONGOING = 'ongoing';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match($this) {
            self::UPCOMING => 'Akan Datang',
            self::ONGOING => 'Sedang Berlangsung',
            self::COMPLETED => 'Selesai',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::UPCOMING => 'blue',
            self::ONGOING => 'yellow',
            self::COMPLETED => 'green',
        };
    }
}
```

---

## 5. Middleware

### 5.1 AdminMiddleware

```php
class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }
        return $next($request);
    }
}
```

### 5.2 MemberMiddleware

```php
class MemberMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isMember()) {
            abort(403, 'Unauthorized access');
        }
        return $next($request);
    }
}
```

### 5.3 CheckApproved

```php
class CheckApproved
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->isApproved()) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Akun Anda belum disetujui oleh admin.');
        }
        return $next($request);
    }
}
```

---

## 6. Services

### 6.1 MemberService

```php
class MemberService
{
    public function getAllMembers(array $filters = []): LengthAwarePaginator
    public function getPendingMembers(): Collection
    public function createMember(array $data): User
    public function updateMember(User $user, array $data): User
    public function approveMember(User $user): User
    public function rejectMember(User $user, string $reason): void
    public function toggleStatus(User $user): User
    public function deleteMember(User $user): void
}
```

### 6.2 FinanceService

```php
class FinanceService
{
    public function getAllCategories(): Collection
    public function getCategoryWithTransactions(Category $category, array $filters = []): Category
    public function getTotalBalance(): float
    public function getBalanceByCategory(Category $category): float
    public function createTransaction(array $data): Transaction
    public function updateTransaction(Transaction $transaction, array $data): Transaction
    public function deleteTransaction(Transaction $transaction): void
}
```

### 6.3 EventService

```php
class EventService
{
    public function getAllEvents(array $filters = []): LengthAwarePaginator
    public function getUpcomingEvents(int $limit = 5): Collection
    public function getCompletedEvents(): LengthAwarePaginator
    public function createEvent(array $data): Event
    public function updateEvent(Event $event, array $data): Event
    public function deleteEvent(Event $event): void
    public function updateEventStatuses(): void
}
```

---

## 7. Validation Rules

### 7.1 RegisterRequest

```php
[
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    'password' => ['required', 'string', 'min:8', 'confirmed'],
    'phone' => ['required', 'string', 'max:20'],
    'address' => ['required', 'string'],
    'birth_date' => ['required', 'date', 'before:today'],
    'gender' => ['required', Rule::enum(Gender::class)],
]
```

### 7.2 MemberRequest

```php
[
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->member)],
    'phone' => ['required', 'string', 'max:20'],
    'address' => ['required', 'string'],
    'birth_date' => ['required', 'date', 'before:today'],
    'gender' => ['required', Rule::enum(Gender::class)],
    'status' => ['sometimes', Rule::enum(UserStatus::class)],
]
```

### 7.3 TransactionRequest

```php
[
    'category_id' => ['required', 'exists:categories,id'],
    'type' => ['required', Rule::enum(TransactionType::class)],
    'amount' => ['required', 'numeric', 'min:0'],
    'description' => ['required', 'string'],
    'transaction_date' => ['required', 'date'],
]
```

### 7.4 EventRequest

```php
[
    'title' => ['required', 'string', 'max:255'],
    'description' => ['required', 'string'],
    'event_date' => ['required', 'date'],
    'start_time' => ['required', 'date_format:H:i'],
    'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
    'location' => ['required', 'string', 'max:255'],
]
```

---

## 8. Design System (Tailwind CSS)

### 8.1 Color Palette

```css
/* Primary Colors */
--primary-50: #eff6ff;
--primary-100: #dbeafe;
--primary-500: #3b82f6;
--primary-600: #2563eb;
--primary-700: #1d4ed8;

/* Secondary Colors */
--secondary-50: #f0fdf4;
--secondary-500: #22c55e;
--secondary-600: #16a34a;

/* Accent Colors */
--accent-50: #fff7ed;
--accent-500: #f97316;
--accent-600: #ea580c;

/* Neutral Colors */
--gray-50: #f9fafb;
--gray-100: #f3f4f6;
--gray-200: #e5e7eb;
--gray-300: #d1d5db;
--gray-500: #6b7280;
--gray-700: #374151;
--gray-800: #1f2937;
--gray-900: #111827;
```

### 8.2 Typography

```css
/* Headings */
h1: text-3xl font-bold text-gray-900
h2: text-2xl font-semibold text-gray-800
h3: text-xl font-semibold text-gray-800
h4: text-lg font-medium text-gray-700

/* Body */
body: text-base text-gray-600
small: text-sm text-gray-500
```

### 8.3 Component Classes

```css
/* Buttons */
.btn-primary: bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg
.btn-secondary: bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg
.btn-danger: bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg

/* Cards */
.card: bg-white rounded-xl shadow-sm border border-gray-200 p-6

/* Inputs */
.input: border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500

/* Badges */
.badge-success: bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs
.badge-warning: bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs
.badge-danger: bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs
```

---

## 9. Commands & Setup

### 9.1 Initial Setup

```bash
# Create Laravel project
composer create-project laravel/laravel padrp-assyukro

# Install dependencies
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p

# Install Laravel Breeze (optional, for auth scaffolding reference)
composer require laravel/breeze --dev
php artisan breeze:install blade

# Setup database
php artisan migrate
php artisan db:seed
```

### 9.2 Development Commands

```bash
# Run development server
php artisan serve

# Compile assets
npm run dev

# Run migrations
php artisan migrate

# Run seeders
php artisan db:seed

# Clear caches
php artisan optimize:clear
```

### 9.3 Artisan Commands to Create

```bash
# Custom command to update event statuses
php artisan events:update-status
```

---

**Document Version:** 1.0  
**Last Updated:** 25 Desember 2024
