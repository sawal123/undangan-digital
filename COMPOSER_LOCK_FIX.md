# Fix Composer Lock File - PHP 8.3 Compatibility

## Problem
CI workflow fails on `Install PHP dependencies` step because:
- CI uses PHP 8.2
- `composer.lock` requires PHP 8.4.1+
- `composer.json` specifies `^8.2` but lock file is incompatible

This is a **BLOCKER** for CI pipeline.

## Solution

### Step 1: Check PHP Version
Ensure you have PHP 8.3 installed locally (production version):
```bash
php --version
```

Expected output:
```
PHP 8.3.x (CLI)
```

### Step 2: Update Composer Lock File
Run this command from project root with PHP 8.3:

```bash
composer update symfony/css-selector tijsverkoyen/css-to-inline-styles --with-all-dependencies
```

This will:
- Resolve dependency conflicts with PHP 8.3
- Update `composer.lock` with compatible versions
- Keep `composer.json` unchanged (still `^8.2`)

### Step 3: Verify Changes
Check git diff:
```bash
git diff composer.lock
```

You should see version changes only, not major removals.

### Step 4: Test Locally
Verify Laravel still works:
```bash
php artisan migrate:fresh --seed
php artisan test
```

Expected: All tests pass ✅

### Step 5: Commit Changes
```bash
git add composer.lock
git commit -m "chore: update composer.lock for PHP 8.3 compatibility

- Updated symfony/css-selector to compatible version
- Updated tijsverkoyen/css-to-inline-styles to compatible version
- Lock file now works with PHP 8.2, 8.3, and 8.4
"
```

### Step 6: Push to Branch
```bash
git push origin audit-dashboard-user
```

### Step 7: Verify CI
Check GitHub Actions - CI should now:
- ✅ Install PHP dependencies successfully
- ✅ Run migrations
- ✅ Run tests (45 passed)
- ✅ Build frontend (npm)

---

## Important Notes

### Do NOT:
- ❌ Change CI to use PHP 8.4 if production is PHP 8.3
- ❌ Modify CI workflow file without reason
- ❌ Downgrade PHP beyond `^8.2`

### Why This Happens:
- Dependencies are updated daily on maintainer's PHP 8.4 environment
- Some packages drop support for older PHP versions
- Lock file must always match your deployment environment

### Maintenance:
- Keep PHP version in sync across: local → CI → production
- Run `composer update` regularly to catch incompatibilities early
- Test locally before pushing if changing lock file

---

## Troubleshooting

If you get errors during `composer update`:

**Error: `Your version of PHP, 8.2.x, does not satisfy requirements`**
- You're using PHP 8.2 to update lock file
- Install PHP 8.3 locally and retry

**Error: `The requested PHP extension ... is missing`**
- Install the missing PHP extension
- Or modify docker image in local development

**Error: `Package X version mismatch`**
- Delete `composer.lock`
- Run `composer install` instead of update
- This will regenerate lock file from scratch

---

**Status:** Ready to execute when PHP 8.3 is available locally
