# 📄 REQUIREMENT DOCUMENT

# Sistem Informasi Warga Dusun Kauman, Desa Deras

---

## 1. Database Changes

### 1.1 New Tables

#### `rws` - Rukun Warga

```php
Schema::create('rws', function (Blueprint $table) {
    $table->id();
    $table->string('name', 50);          // RW 01, RW 02
    $table->string('description')->nullable();
    $table->timestamps();
});
```

#### `rts` - Rukun Tetangga

```php
Schema::create('rts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('rw_id')->constrained()->cascadeOnDelete();
    $table->string('name', 50);          // RT 01, RT 02, etc
    $table->string('description')->nullable();
    $table->timestamps();
});
```

#### `waste_types` - Jenis Sampah

```php
Schema::create('waste_types', function (Blueprint $table) {
    $table->id();
    $table->string('name', 100);
    $table->string('slug', 100)->unique();
    $table->text('description')->nullable();
    $table->decimal('price_per_kg', 12, 2);
    $table->string('unit', 20)->default('kg');
    $table->string('icon', 50)->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

#### `waste_deposits` - Setoran Sampah

```php
Schema::create('waste_deposits', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->foreignId('waste_type_id')->constrained()->cascadeOnDelete();
    $table->decimal('weight', 10, 2);     // dalam kg
    $table->decimal('price_per_kg', 12, 2);
    $table->decimal('total_amount', 15, 2);
    $table->date('deposit_date');
    $table->text('notes')->nullable();
    $table->foreignId('recorded_by')->nullable()->constrained('users');
    $table->timestamps();
});
```

#### `waste_redemptions` - Penukaran Saldo (UI Only)

```php
Schema::create('waste_redemptions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->decimal('amount', 15, 2);
    $table->enum('redemption_type', ['cash', 'goods'])->default('cash');
    $table->enum('status', ['pending', 'completed', 'rejected'])->default('pending');
    $table->text('notes')->nullable();
    $table->foreignId('processed_by')->nullable()->constrained('users');
    $table->timestamp('processed_at')->nullable();
    $table->timestamps();
});
```

---

### 1.2 Modified Tables

#### `users` - Tambah Kolom

```php
// Tambah kolom baru
$table->foreignId('rt_id')->nullable()->constrained();
$table->foreignId('rw_id')->nullable()->constrained();
$table->string('nik', 16)->nullable()->unique();
$table->enum('residence_status', ['tetap', 'kontrak', 'kos'])->default('tetap');
$table->string('occupation', 100)->nullable();
$table->decimal('waste_balance', 15, 2)->default(0);
```

#### `transactions` - Tambah Kolom

```php
// Tambah kolom untuk filter per RT
$table->foreignId('rt_id')->nullable()->constrained();
```

---

## 2. Model Changes

### 2.1 New Models

#### `App\Models\Rw.php`

```php
class Rw extends Model
{
    protected $fillable = ['name', 'description'];

    public function rts(): HasMany
    {
        return $this->hasMany(Rt::class);
    }

    public function residents(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Rt::class);
    }
}
```

#### `App\Models\Rt.php`

```php
class Rt extends Model
{
    protected $fillable = ['rw_id', 'name', 'description'];

    public function rw(): BelongsTo
    {
        return $this->belongsTo(Rw::class);
    }

    public function residents(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->name . ' / ' . $this->rw->name;
    }
}
```

#### `App\Models\WasteType.php`

```php
class WasteType extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price_per_kg',
        'unit', 'icon', 'is_active'
    ];

    protected $casts = [
        'price_per_kg' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function deposits(): HasMany
    {
        return $this->hasMany(WasteDeposit::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price_per_kg, 0, ',', '.');
    }
}
```

#### `App\Models\WasteDeposit.php`

```php
class WasteDeposit extends Model
{
    protected $fillable = [
        'user_id', 'waste_type_id', 'weight', 'price_per_kg',
        'total_amount', 'deposit_date', 'notes', 'recorded_by'
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'price_per_kg' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'deposit_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function wasteType(): BelongsTo
    {
        return $this->belongsTo(WasteType::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }
}
```

#### `App\Models\WasteRedemption.php`

```php
class WasteRedemption extends Model
{
    protected $fillable = [
        'user_id', 'amount', 'redemption_type', 'status',
        'notes', 'processed_by', 'processed_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
```

---

### 2.2 Modified Models

#### `App\Models\User.php` - Tambahan

```php
// Tambah ke $fillable
'rt_id', 'rw_id', 'nik', 'residence_status', 'occupation', 'waste_balance'

// Tambah relationships
public function rt(): BelongsTo
{
    return $this->belongsTo(Rt::class);
}

public function rw(): BelongsTo
{
    return $this->belongsTo(Rw::class);
}

public function wasteDeposits(): HasMany
{
    return $this->hasMany(WasteDeposit::class);
}

public function wasteRedemptions(): HasMany
{
    return $this->hasMany(WasteRedemption::class);
}

// Tambah to casts
'waste_balance' => 'decimal:2',

// Tambah helper
public function getFormattedWasteBalanceAttribute(): string
{
    return 'Rp ' . number_format($this->waste_balance, 0, ',', '.');
}

public function getFullRtRwAttribute(): string
{
    if (!$this->rt) return '-';
    return $this->rt->name . ' / ' . $this->rt->rw->name;
}
```

#### `App\Models\Transaction.php` - Tambahan

```php
// Tambah ke $fillable
'rt_id'

// Tambah relationship
public function rt(): BelongsTo
{
    return $this->belongsTo(Rt::class);
}

// Tambah scope
public function scopeByRt(Builder $query, ?int $rtId): Builder
{
    if (!$rtId) return $query;
    return $query->where('rt_id', $rtId);
}
```

---

## 3. New Enums

#### `App\Enums\ResidenceStatus.php`

```php
enum ResidenceStatus: string
{
    case TETAP = 'tetap';
    case KONTRAK = 'kontrak';
    case KOS = 'kos';

    public function label(): string
    {
        return match($this) {
            self::TETAP => 'Warga Tetap',
            self::KONTRAK => 'Kontrak',
            self::KOS => 'Kos',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::TETAP => 'badge-success',
            self::KONTRAK => 'badge-warning',
            self::KOS => 'badge-info',
        };
    }
}
```

#### `App\Enums\RedemptionStatus.php`

```php
enum RedemptionStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Menunggu',
            self::COMPLETED => 'Selesai',
            self::REJECTED => 'Ditolak',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::PENDING => 'badge-warning',
            self::COMPLETED => 'badge-success',
            self::REJECTED => 'badge-danger',
        };
    }
}
```

---

## 4. Controller Changes

### 4.1 New Controllers

#### `App\Http\Controllers\Admin\WasteBankController.php`

-   `index()` - Dashboard bank sampah
-   `deposits()` - List semua setoran
-   `createDeposit()` - Form tambah setoran
-   `storeDeposit()` - Simpan setoran
-   `wasteTypes()` - Kelola jenis sampah
-   `storeWasteType()` - Tambah jenis sampah
-   `updateWasteType()` - Update jenis sampah
-   `redemptions()` - List penukaran (UI only)

#### `App\Http\Controllers\Warga\WasteBankController.php`

-   `index()` - Dashboard saldo & ringkasan
-   `history()` - Riwayat setoran
-   `redeem()` - Form penukaran (UI only)

### 4.2 Renamed Controllers

| Sebelum              | Sesudah              |
| -------------------- | -------------------- |
| `Member\*Controller` | `Warga\*Controller`  |
| `MemberController`   | `ResidentController` |

### 4.3 Modified Controllers

#### `Admin\DashboardController`

-   Tambah statistik per RT
-   Tambah statistik bank sampah
-   Filter data berdasarkan RT

#### `Admin\ResidentController` (sebelumnya MemberController)

-   Tambah field RT/RW saat create/edit
-   Filter berdasarkan RT/RW
-   Tambah kolom NIK, status kependudukan

#### `Admin\FinanceController`

-   Tambah filter per RT
-   Tambah agregasi total semua RT
-   Update kategori baru

---

## 5. View Changes

### 5.1 Layout Changes

#### Ganti semua referensi:

-   "PADRP ASSYUKRO" → "Kauman"
-   "Persatuan Anak Daerah, Pesantren, dan Rantau" → "Sistem Informasi Warga RT/RW"
-   "Anggota" → "Warga"
-   "Organisasi" → "Lingkungan"
-   Logo Assyukro → Text "Kauman"

### 5.2 New Views

```
resources/views/
├── admin/
│   ├── waste-bank/
│   │   ├── index.blade.php       # Dashboard bank sampah
│   │   ├── deposits.blade.php    # List setoran
│   │   ├── create-deposit.blade.php
│   │   ├── waste-types.blade.php # Kelola jenis sampah
│   │   └── redemptions.blade.php # Penukaran (UI)
│   └── residents/                # Rename dari members
│       ├── index.blade.php
│       ├── create.blade.php
│       ├── edit.blade.php
│       ├── show.blade.php
│       └── pending.blade.php
├── warga/                        # Rename dari member
│   ├── dashboard.blade.php
│   ├── waste-bank/
│   │   ├── index.blade.php       # Saldo & ringkasan
│   │   ├── history.blade.php     # Riwayat setoran
│   │   └── redeem.blade.php      # Penukaran (UI)
│   ├── finance/
│   ├── events/
│   └── profile.blade.php
└── ...
```

### 5.3 Redesigned Views

-   `welcome.blade.php` - Landing page baru tema RT/RW
-   `auth/login.blade.php` - Desain baru
-   `auth/register.blade.php` - Tambah field RT/RW
-   `admin/dashboard.blade.php` - Layout baru + bank sampah
-   `warga/dashboard.blade.php` - Layout baru + saldo sampah

---

## 6. Routes Changes

### `routes/web.php`

```php
// Rename prefix member → warga
Route::prefix('warga')
    ->name('warga.')
    ->middleware(['auth', 'warga', 'approved'])
    ->group(function () {
        // ... existing routes

        // Bank Sampah routes
        Route::prefix('waste-bank')->name('waste-bank.')->group(function () {
            Route::get('/', [WargaWasteBankController::class, 'index'])->name('index');
            Route::get('/history', [WargaWasteBankController::class, 'history'])->name('history');
            Route::get('/redeem', [WargaWasteBankController::class, 'redeem'])->name('redeem');
            Route::post('/redeem', [WargaWasteBankController::class, 'storeRedemption'])->name('redeem.store');
        });
    });

// Admin routes - tambah waste bank
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        // ... existing routes

        // Rename members → residents
        Route::resource('residents', ResidentController::class);
        Route::get('/residents/pending', [ResidentController::class, 'pending'])->name('residents.pending');

        // Bank Sampah routes
        Route::prefix('waste-bank')->name('waste-bank.')->group(function () {
            Route::get('/', [AdminWasteBankController::class, 'index'])->name('index');
            Route::get('/deposits', [AdminWasteBankController::class, 'deposits'])->name('deposits');
            Route::get('/deposits/create', [AdminWasteBankController::class, 'createDeposit'])->name('deposits.create');
            Route::post('/deposits', [AdminWasteBankController::class, 'storeDeposit'])->name('deposits.store');
            Route::get('/types', [AdminWasteBankController::class, 'wasteTypes'])->name('types');
            Route::post('/types', [AdminWasteBankController::class, 'storeWasteType'])->name('types.store');
            Route::put('/types/{wasteType}', [AdminWasteBankController::class, 'updateWasteType'])->name('types.update');
            Route::delete('/types/{wasteType}', [AdminWasteBankController::class, 'destroyWasteType'])->name('types.destroy');
            Route::get('/redemptions', [AdminWasteBankController::class, 'redemptions'])->name('redemptions');
        });
    });
```

---

## 7. Middleware Changes

### Rename `member` middleware → `warga`

File: `app/Http/Middleware/MemberMiddleware.php` → `WargaMiddleware.php`

---

## 8. Seeders

### New Seeders

#### `RwRtSeeder.php`

```php
// RW 01
$rw1 = Rw::create(['name' => 'RW 01', 'description' => 'Rukun Warga 01']);
Rt::create(['rw_id' => $rw1->id, 'name' => 'RT 03', 'description' => 'Rukun Tetangga 03']);
Rt::create(['rw_id' => $rw1->id, 'name' => 'RT 04', 'description' => 'Rukun Tetangga 04']);

// RW 02
$rw2 = Rw::create(['name' => 'RW 02', 'description' => 'Rukun Warga 02']);
Rt::create(['rw_id' => $rw2->id, 'name' => 'RT 01', 'description' => 'Rukun Tetangga 01']);
Rt::create(['rw_id' => $rw2->id, 'name' => 'RT 02', 'description' => 'Rukun Tetangga 02']);
```

#### `WasteTypeSeeder.php`

```php
$types = [
    ['name' => 'Plastik', 'slug' => 'plastik', 'price_per_kg' => 2000, 'icon' => '♻️'],
    ['name' => 'Kertas/Kardus', 'slug' => 'kertas-kardus', 'price_per_kg' => 1500, 'icon' => '📄'],
    ['name' => 'Logam/Besi', 'slug' => 'logam-besi', 'price_per_kg' => 5000, 'icon' => '⚙️'],
    ['name' => 'Botol Kaca', 'slug' => 'botol-kaca', 'price_per_kg' => 1000, 'icon' => '🍾'],
    ['name' => 'Aluminium/Kaleng', 'slug' => 'aluminium-kaleng', 'price_per_kg' => 8000, 'icon' => '🥫'],
    ['name' => 'Elektronik', 'slug' => 'elektronik', 'price_per_kg' => 3000, 'icon' => '📱'],
    ['name' => 'Minyak Jelantah', 'slug' => 'minyak-jelantah', 'price_per_kg' => 4000, 'icon' => '🛢️'],
];
```

#### `CategorySeeder.php` (Update)

```php
$categories = [
    ['name' => 'Kas RT', 'slug' => 'kas-rt', 'icon' => '💰', 'color' => 'teal'],
    ['name' => 'Dana Sosial', 'slug' => 'dana-sosial', 'icon' => '🤝', 'color' => 'blue'],
    ['name' => 'Keuangan Kegiatan', 'slug' => 'keuangan-kegiatan', 'icon' => '📅', 'color' => 'purple'],
    ['name' => 'Iuran Kebersihan', 'slug' => 'iuran-kebersihan', 'icon' => '🧹', 'color' => 'green'],
    ['name' => 'Dana Keamanan', 'slug' => 'dana-keamanan', 'icon' => '🛡️', 'color' => 'orange'],
    ['name' => 'Bank Sampah', 'slug' => 'bank-sampah', 'icon' => '♻️', 'color' => 'emerald'],
];
```

---

## 9. Files to Delete/Rename

### Rename

-   `app/Http/Controllers/Member/` → `app/Http/Controllers/Warga/`
-   `app/Http/Controllers/Admin/MemberController.php` → `ResidentController.php`
-   `app/Http/Middleware/MemberMiddleware.php` → `WargaMiddleware.php`
-   `resources/views/member/` → `resources/views/warga/`
-   `resources/views/admin/members/` → `resources/views/admin/residents/`

### Delete

-   `logo_assyukro.png` (root folder)
-   `public/images/logo.png` (ganti dengan text Kauman)

---

## 10. Environment Update

### `.env`

```
APP_NAME="Kauman"
```

### `config/app.php`

```php
'name' => env('APP_NAME', 'Kauman'),
```

---

## 11. Validation Rules

### Resident Registration/Create

```php
[
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'password' => 'required|min:8|confirmed',
    'phone' => 'required|string|max:20',
    'address' => 'required|string',
    'birth_date' => 'required|date',
    'gender' => 'required|in:L,P',
    'nik' => 'nullable|string|size:16|unique:users',
    'rt_id' => 'required|exists:rts,id',
    'residence_status' => 'required|in:tetap,kontrak,kos',
    'occupation' => 'nullable|string|max:100',
]
```

### Waste Deposit

```php
[
    'user_id' => 'required|exists:users,id',
    'waste_type_id' => 'required|exists:waste_types,id',
    'weight' => 'required|numeric|min:0.1',
    'deposit_date' => 'required|date',
    'notes' => 'nullable|string|max:500',
]
```

---

## ✅ Implementation Checklist

-   [ ] Create all new migrations
-   [ ] Create all new models
-   [ ] Create all new enums
-   [ ] Update existing models
-   [ ] Rename and update controllers
-   [ ] Update routes
-   [ ] Update middleware
-   [ ] Create new seeders
-   [ ] Redesign views
-   [ ] Update branding
-   [ ] Test all features
-   [ ] Update documentation

---

**Document Version:** 1.0  
**Created:** 2026-01-11  
**Last Updated:** 2026-01-11
