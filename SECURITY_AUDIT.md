# Security Audit Report — H2WHOA

**Initial Audit Date:** 2026-05-05  
**Updated:** 2026-05-05 (reviewed commits `591de0f` and `838c153`)  
**Auditor:** Manual code review  
**Scope:** Full codebase — controllers, routes, middleware, config, views  

---

## Changelog — What the New Commits Fixed

| Finding | Status | Notes |
|---------|--------|-------|
| C1 — AdminAuth middleware unregistered | ✅ Fixed | Admin now uses proper `auth:admin` Eloquent guard |
| C2 — Admin routes unprotected | ⚠️ Partial | Core routes moved into protected group, but many duplicates remain outside |
| C3 — IDOR: update any customer | ❌ Not fixed | `PUT /customer/{id}` still unprotected on `routes/web.php:194` |
| C4 — IDOR: view any invoice | ❌ Not fixed | `/invoice/{order}` still has no auth or ownership check |
| C5 — Debug routes expose DB data | ❌ Not fixed | Both debug routes still present on lines 205–214 |
| H1 — No login rate limiting | ✅ Fixed | `RateLimiter` added to both customer and admin login |
| H2 — Order routes missing auth | ❌ Not fixed | All order routes still have no `auth:customer` middleware |
| H3 — Cart price manipulation | ❌ Not fixed | `saveChanges()` still trusts client-supplied prices |
| H4 — Admin password config risk | ✅ Fixed | Replaced with proper `Admin` Eloquent model and guard |
| M1 — APP_DEBUG=true in .env.example | ❌ Not fixed | Unchanged |
| M2 — Sessions not encrypted | ❌ Not fixed | Unchanged |
| M3 — GCash order ownership | ❌ Not fixed | `GcashController` unchanged |
| M4 — Order deletion no ownership | ❌ Not fixed | `destroy()` still has no ownership check |
| L1 — Session data logged | ⚠️ Partial | Most removed from `OrderController`; `GcashController:34` still logs full session |
| L2 — Unsanitized filename stored | ❌ Not fixed | Still stores `getClientOriginalName()` |
| L3 — Weak password minimum (6) | ✅ Fixed | Raised to `min:8` |
| L4 — Duplicate route definition | ✅ Fixed | Placeholder removed |

**New issues introduced by the new commits:** 4 (see N1–N4 below)

---

## Summary

| Severity | Original | Now Fixed | Remaining | New | Total Open |
|----------|----------|-----------|-----------|-----|------------|
| Critical | 5 | 1 | 4 | 1 | 5 |
| High | 4 | 1 | 3 | 1 | 4 |
| Medium | 4 | 0 | 4 | 1 | 5 |
| Low | 4 | 2 | 2 | 1 | 3 |
| **Total** | **17** | **4** | **13** | **4** | **17** |

---

## Critical

---

### C1 — AdminAuth Middleware Never Registered or Applied

**File:** `bootstrap/app.php:13`, `app/Http/Middleware/AdminAuth.php`

The `AdminAuth` middleware class exists and is correctly written, but it is never registered in `bootstrap/app.php`. The `withMiddleware` block is completely empty:

```php
// bootstrap/app.php
->withMiddleware(function (Middleware $middleware) {
    // nothing here
})
```

As a result, the middleware cannot be applied to any route, and the admin authentication guard is effectively non-functional across the entire application.

**Impact:** All admin-facing routes that rely on this middleware offer zero access control.

**Fix:** Register the middleware alias in `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminAuth::class,
    ]);
})
```

Then apply it to all admin routes:

```php
Route::middleware('admin')->group(function () {
    // all /admin/* routes
});
```

---

### C2 — Admin Routes Have No Authentication Protection

**File:** `routes/web.php:107–229`

The following admin routes are publicly accessible by anyone without authentication:

| Route | Line | Risk |
|-------|------|------|
| `GET /admin/history` | 107 | View sales history |
| `GET /admin/stocks` | 111 | View inventory |
| `GET /admin/orders` | 151 | View all customer orders |
| `PUT /admin/orders/{order}/status` | 155 | Change any order status |
| `GET /admin/sales-data` | 172 | Fetch financial data as JSON |
| `GET /admin/item-sales-data` | 194 | Fetch item sales as JSON |
| `GET /admin/activity-log/*` | 216–224 | View audit logs |
| `GET/POST/DEL /admin/upload-image` | 227–229 | Upload/delete product images |
| `stocks` resource (full CRUD) | 115 | Create/edit/delete stock |
| `sales` resource (full CRUD) | 170 | Create/edit/delete sales |

Only the `/admin` dashboard (line 119) has a manual `if (!session('is_admin'))` check. Every other admin route is wide open.

**Impact:** Any unauthenticated person can view all business data, manipulate inventory, change order statuses, upload files, and alter sales records.

**Fix:** Wrap all admin routes in an authenticated middleware group after fixing C1.

---

### C3 — IDOR: Any User Can Update Any Customer's Profile

**File:** `routes/web.php:105`, `app/Http/Controllers/CustomerController.php:61–64`

A `PUT /customer/{id}` route exists with no authentication middleware:

```php
// routes/web.php
Route::put('/customer/{id}', [CustomerController::class, 'update'])->name('customer.update');
```

Inside `CustomerController::update()`, when an `$id` is passed, it simply fetches that customer with no ownership or authentication check:

```php
$customer = $id ? Customer::findOrFail($id) : Auth::guard('customer')->user();
```

**Impact:** An unauthenticated attacker can send `PUT /customer/1` (or any ID) and overwrite any customer's name, phone number, and address.

**Fix:** Add `auth:customer` middleware to the route and verify the authenticated user owns the record:

```php
Route::put('/customer/{id}', [CustomerController::class, 'update'])
    ->name('customer.update')
    ->middleware('auth:customer');
```

```php
// In the controller, after retrieving the customer:
if ($customer->customer_id !== Auth::guard('customer')->id()) {
    abort(403);
}
```

---

### C4 — IDOR: Invoice Viewable by Anyone Without Authentication

**File:** `routes/web.php:63`, `app/Http/Controllers/OrderController.php:598–602`

The invoice route has no authentication middleware:

```php
Route::get('/invoice/{order}', [OrderController::class, 'invoice'])->name('orders.invoice');
```

And the controller performs no ownership check:

```php
public function invoice(Order $order)
{
    return view('invoice', compact('order'));
}
```

**Impact:** Any unauthenticated user who guesses or enumerates an order ID (sequential integers are trivially enumerable) can view the full invoice of any customer, including their name, address, phone number, and order details.

**Fix:** Add `auth:customer` middleware and an ownership check:

```php
Route::get('/invoice/{order}', [OrderController::class, 'invoice'])
    ->name('orders.invoice')
    ->middleware('auth:customer');
```

```php
public function invoice(Order $order)
{
    if ($order->customer_id !== Auth::guard('customer')->id()) {
        abort(403);
    }
    return view('invoice', compact('order'));
}
```

---

### C5 — Debug Routes Expose Raw Database Data Publicly

**File:** `routes/web.php:158–167`

Two debug routes were left in the codebase with no authentication and no middleware:

```php
Route::get('/debug/orders-null-datetime', function () {
    $nullOrders = DB::table('orders')->whereNull('order_datetime')->get();
    return response()->json($nullOrders);
});

Route::get('/check-delivered-orders', function () {
    $deliveredOrders = Order::where('order_status', 'Delivered')->get();
    return response()->json($deliveredOrders);
});
```

**Impact:** Anyone can call these endpoints to retrieve raw order records including customer names, addresses, phone numbers, payment method IDs, and amounts paid.

**Fix:** Delete both routes entirely. They serve no production purpose.

---

## High

---

### H1 — No Rate Limiting on Login Routes

**File:** `bootstrap/app.php:13`, `routes/web.php:42–43, 53`

The `withMiddleware` block in `bootstrap/app.php` is empty, so Laravel's built-in throttle middleware is not applied. The login routes have no rate limiting:

```php
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/admin-login', [LoginController::class, 'adminLogin'])->name('admin.login.submit');
```

**Impact:** Unlimited brute-force attempts are possible on both customer and admin login endpoints.

**Fix:** Apply the throttle middleware to login routes:

```php
Route::post('/login', [LoginController::class, 'login'])
    ->name('login.submit')
    ->middleware('throttle:5,1'); // 5 attempts per minute

Route::post('/admin-login', [LoginController::class, 'adminLogin'])
    ->name('admin.login.submit')
    ->middleware('throttle:5,1');
```

---

### H2 — Customer Order Routes Lack Authentication Middleware

**File:** `routes/web.php:71–79`

Most customer-facing order routes have no `auth:customer` middleware:

```php
Route::get('/orders', [OrderController::class, 'index']);           // no auth
Route::get('/orders/create', [OrderController::class, 'create']);   // no auth
Route::post('/orders', [OrderController::class, 'store']);          // no auth
Route::delete('/orders/{id}', [OrderController::class, 'destroy']); // no auth
Route::get('/orders/{id}/edit', [OrderController::class, 'edit']);  // no auth
Route::put('/orders/{id}', [OrderController::class, 'update']);     // no auth
```

Additionally, `OrderController::destroy()` (line 101) and `edit()` (line 116) perform no ownership check — any user can delete or edit any order by ID.

**Fix:** Wrap all order routes in an `auth:customer` middleware group and add ownership checks in the controller.

---

### H3 — Cart Price Manipulation via POST Request

**File:** `app/Http/Controllers/OrderController.php:318`

The `saveChanges()` method trusts the client-supplied `price` field from the POST body:

```php
$price = $product['price'] ?? ($product['total_price'] / $product['quantity'] ?? 0);
```

Prices are never validated against the actual database price for the product.

**Impact:** A customer can craft a POST request with `price = 0.01` and place an order for any item at an arbitrary price of their choosing.

**Fix:** Always resolve prices from the database, never from client input:

```php
$stock = Stock::findOrFail($product['stock_id']);
$price = $stock->price_per_unit;
```

---

### H4 — Admin Password Configuration Risk

**File:** `config/auth.php:122`, `.env.example`

The admin password is stored as:

```php
'password' => env('ADMIN_PASSWORD'), // Replace with a securely hashed password
```

The `.env.example` file does not include an `ADMIN_PASSWORD` variable at all. If a developer sets this to a plaintext string (e.g., `ADMIN_PASSWORD=admin123`), `Hash::check()` will always return `false` and no one can log in, prompting them to "fix" it by removing the hash check — a common and dangerous mistake.

**Impact:** Likely misconfiguration in deployment leading to either a locked-out admin panel or a plaintext password comparison.

**Fix:** Add `ADMIN_PASSWORD` to `.env.example` with a note, and document that the value must be a bcrypt hash:

```
# Generate with: php -r "echo password_hash('your-password', PASSWORD_BCRYPT);"
ADMIN_PASSWORD=
```

---

## Medium

---

### M1 — `APP_DEBUG=true` in `.env.example`

**File:** `.env.example:4`

```
APP_DEBUG=true
```

If a developer copies `.env.example` to `.env` for production deployment without changing this value, full stack traces including file paths, database queries, environment variables, and internal configuration will be shown to end users on any error.

**Fix:** Change to `APP_DEBUG=false` in `.env.example` and add a comment:

```
APP_DEBUG=false  # NEVER set to true in production
```

---

### M2 — Sessions Not Encrypted

**File:** `.env.example:35`

```
SESSION_ENCRYPT=false
```

Sessions are stored unencrypted in the database. Cart contents, delivery addresses, payment method IDs, and session tokens are stored in plaintext.

**Fix:** Enable session encryption:

```
SESSION_ENCRYPT=true
```

---

### M3 — GCash Payment: No Order Ownership Validation

**File:** `app/Http/Controllers/GcashController.php:27`

The `order_id` used to associate a GCash receipt is taken from user input with no check that the order belongs to the authenticated customer:

```php
$orderId = $request->input('order_id') ?? session('order_id');
```

**Impact:** A customer can link their GCash receipt to another customer's order, potentially marking someone else's unpaid order as paid.

**Fix:** Verify the order belongs to the authenticated customer:

```php
$orderId = session('order_id');
$order = Order::where('order_id', $orderId)
    ->where('customer_id', Auth::guard('customer')->id())
    ->firstOrFail();
```

---

### M4 — Order Deletion Has No Ownership Check

**File:** `app/Http/Controllers/OrderController.php:101–114`

`OrderController::destroy()` fetches any order by ID and deletes it without verifying the requesting user owns the order:

```php
public function destroy($id)
{
    $order = Order::findOrFail($id);
    // no ownership check
    $order->delete();
}
```

**Impact:** Combined with the missing auth middleware (H2), any visitor can delete any order.

**Fix:**

```php
$order = Order::where('order_id', $id)
    ->where('customer_id', Auth::guard('customer')->id())
    ->firstOrFail();
```

---

## Low

---

### L1 — Sensitive Session Data Written to Logs

**File:** `app/Http/Controllers/OrderController.php:369`, `app/Http/Controllers/GcashController.php:34`

Multiple debug log statements dump the entire session to disk:

```php
Log::info('Session Data:', session()->all());
Log::info('Session Data:', $request->session()->all());
```

Sessions contain cart items, delivery addresses, payment method IDs, and authentication tokens.

**Fix:** Remove all `Log::info('Session Data:' ...)` calls before production deployment. If logging is needed, log only specific safe fields.

---

### L2 — Client-Supplied Filename Stored Without Sanitization

**File:** `app/Http/Controllers/ImageUploadController.php:26`

```php
UploadedImage::create([
    'file_name' => $file->getClientOriginalName(),
    ...
]);
```

The original filename from the client is stored and later rendered in the admin UI. A filename like `<img src=x onerror=alert(1)>.jpg` could cause XSS if rendered unescaped.

**Fix:** Either discard the original filename entirely or sanitize it before storing:

```php
'file_name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
```

And always use `{{ }}` (not `{!! !!}`) when rendering filenames in Blade templates.

---

### L3 — Weak Minimum Password Length (6 Characters)

**File:** `app/Http/Controllers/CustomerController.php:28`

```php
'password' => 'required|confirmed|min:6',
```

Six characters is below current NIST SP 800-63B guidelines which recommend a minimum of 8 characters.

**Fix:**

```php
'password' => 'required|confirmed|min:8',
```

---

### L4 — Duplicate Route Definition

**File:** `routes/web.php:48–52`

The `/admin-login` route is defined twice:

```php
// Line 48 — dead code, never reached
Route::get('/admin-login', fn() => 'Admin Login — Coming Soon')->name('admin.login');

// Line 52 — actual route
Route::get('/admin-login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
```

The first definition is a placeholder that was never removed. Laravel uses the last definition, so the controller route wins — but this creates confusion and the placeholder could mask the real route if the lines are reordered.

**Fix:** Remove lines 48–49 entirely.

---

## New Issues — Introduced in Commits `591de0f` / `838c153`

---

### N1 — CRITICAL: Duplicate Admin Routes Still Exist Outside the Protected Group

**File:** `routes/web.php:198–276`

The new commits correctly added admin routes inside a `middleware(['auth:admin'])` group (lines 48–138). However, the **old unprotected versions of those same routes were never removed** and still exist:

| Unprotected route remaining | Line |
|-----------------------------|------|
| `GET /admin/orders` | 198 |
| `PUT /admin/orders/{order}/status` | 202 |
| `GET /admin/sales-data` | 219 |
| `GET /admin/item-sales-data` | 241 |
| `GET /admin/activity-log` and all sub-routes | 263–271 |
| `GET/POST/DEL /admin/upload-image` | 274–276 |
| `Route::resource('sales', ...)` | 217 |

Laravel matches routes in order of definition. The protected group is defined first, so URL requests to `/admin/orders` do hit the protected route. **However**, the named routes (e.g., `->name('admin.orders')`) are overridden by the later unprotected definitions, meaning `route('admin.orders')` in any Blade template or redirect resolves to the unprotected version's name binding — this is confusing and fragile. Any reordering of routes would silently break the protection.

The `stocks` CRUD resource (`Route::resource('stocks', StockController::class)`) was removed entirely — but the new admin group only added a `GET /admin/stocks` view route. The actual create/store/edit/update/destroy operations for stock are now **missing from all routes**, which may be a functional regression.

**Fix:** Delete all the duplicate unprotected admin routes (lines 198–276) and move any missing functionality (stocks CRUD, full activity log routes, image upload) into the protected group.

---

### N2 — HIGH: Default Admin Password `"password"` Hardcoded in Seeder

**File:** `database/seeders/AdminSeeder.php:19`

```php
Admin::create([
    'name'     => 'Admin',
    'email'    => 'admin@h2whoa.com',
    'password' => Hash::make('password'), // Change this in production
]);
```

`password` is one of the most commonly tried passwords in credential attacks. The comment "Change this in production" is routinely ignored during deployment.

**Impact:** If `php artisan db:seed` is run in production without changing this first, the admin account is immediately compromised by any attacker who tries the email `admin@h2whoa.com` with the password `password`.

**Fix:** Remove the hardcoded default entirely. Force the password to come from an environment variable:

```php
Admin::create([
    'name'     => 'Admin',
    'email'    => env('ADMIN_EMAIL'),
    'password' => Hash::make(env('ADMIN_PASSWORD')),
]);
```

And add both to `.env.example` with clear instructions.

---

### N3 — MEDIUM: Content Security Policy Uses `unsafe-inline` and `unsafe-eval`

**File:** `app/Http/Middleware/SecurityHeaders.php:38`

```php
$response->header('Content-Security-Policy',
    "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; ..."
);
```

`'unsafe-inline'` allows any inline `<script>` tag or `onclick=` attribute to execute. `'unsafe-eval'` allows `eval()`. Together they completely negate the XSS protection that CSP is meant to provide — an attacker who can inject any HTML can still run arbitrary JavaScript.

**Fix:** Remove `'unsafe-inline'` and `'unsafe-eval'`. Use nonces or hashes for legitimate inline scripts instead:

```php
$nonce = base64_encode(random_bytes(16));
session(['csp_nonce' => $nonce]);
$response->header('Content-Security-Policy',
    "default-src 'self'; script-src 'self' 'nonce-{$nonce}'; style-src 'self' 'nonce-{$nonce}'; ..."
);
```

Then add `nonce="{{ session('csp_nonce') }}"` to legitimate `<script>` and `<style>` tags in your Blade templates.

---

### N4 — LOW: `GcashController` Still Logs Full Session Data

**File:** `app/Http/Controllers/GcashController.php:34`

The `OrderController` debug log statements were cleaned up in the new commits, but `GcashController` was not updated:

```php
Log::info('Session Data:', session()->all());
```

This dumps the entire session — including cart, addresses, and the `order_id` — to the log file on every GCash payment submission.

**Fix:** Remove this line.

---

## Recommended Fix Priority

1. **Immediately:** Fix C5 (debug routes), N1 (duplicate unprotected routes) — live data exposure right now
2. **Before first user:** Fix C3, C4, H2 — IDOR and missing order auth
3. **Before launch:** Fix H3, M3, M4, N2 — price manipulation, GCash ownership, weak seeder password
4. **Before production:** Fix M1, M2, N3 — config hardening and CSP
5. **Cleanup:** Fix M3, L1, L2, N4 — logging and filename hygiene
