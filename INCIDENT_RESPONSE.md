# Incident Response Playbook — H2WHOA

**Last Updated:** 2026-05-06  
**Scope:** h2whoa Laravel web application (customer portal, admin panel, orders, GCash payments)

---

## Severity Levels

| Level | Label | Description | Response Time |
|-------|-------|-------------|---------------|
| P1 | Critical | Data breach, full system compromise, payment fraud | Immediate |
| P2 | High | Unauthorized admin access, IDOR exploitation, brute force success | < 1 hour |
| P3 | Medium | Suspicious activity, failed attack attempts, anomalous traffic | < 4 hours |
| P4 | Low | Policy violations, minor misconfigurations discovered | < 24 hours |

---

## Step 1 — Detect & Identify

Before anything else, determine what is happening.

### Signs of Active Attack

| Symptom | Likely Threat |
|---------|---------------|
| Spike in failed login attempts | Brute force / credential stuffing |
| Repeated `404` or `403` on admin routes | Admin panel enumeration |
| Unexpected orders placed with no matching payment | Cart price manipulation (H3) |
| Order or invoice IDs accessed by wrong user | IDOR exploitation (C3, C4) |
| Strange SQL errors in logs | SQL injection attempt |
| Large volume of requests from single IP | DDoS or scraping |
| GCash order IDs being accessed without session | GCash order ownership bypass (M3) |
| Debug routes `/debug-*` being called | Info disclosure via debug routes (C5) |
| Unfamiliar admin account or session | Account takeover / insider threat |
| File uploads with unexpected extensions | Malicious file upload |

### Where to Look

```bash
# Laravel application logs
storage/logs/laravel.log

# Web server access log (adjust path to your server config)
/var/log/nginx/access.log
/var/log/apache2/access.log

# Auth-specific activity — search for login events
grep -i "login\|auth\|failed\|unauthorized" storage/logs/laravel.log

# Suspicious IP activity
grep "<suspicious-ip>" /var/log/nginx/access.log | tail -100

# Recent file changes (detect webshells or modified files)
find . -newer composer.lock -not -path "./storage/*" -not -path "./vendor/*"
```

---

## Step 2 — Contain

Stop the bleeding immediately. Do not try to investigate fully before containing.

### P1 — Critical (Data Breach / Full Compromise)

- [ ] Take the application offline immediately — enable maintenance mode:
  ```bash
  php artisan down --message="Temporarily unavailable. Please check back soon." --retry=60
  ```
- [ ] Revoke all active sessions:
  ```bash
  php artisan session:flush   # if using database sessions
  # or truncate the sessions table manually:
  # DELETE FROM sessions;
  ```
- [ ] Change admin credentials immediately via database:
  ```sql
  UPDATE admins SET password = '<new-bcrypt-hash>' WHERE email = '<admin-email>';
  ```
- [ ] Rotate `APP_KEY` in `.env` (invalidates all encrypted data/cookies):
  ```bash
  php artisan key:generate
  ```
- [ ] Block attacker IP at the server/firewall level.
- [ ] Notify your hosting provider.

### P2 — High (Unauthorized Access / Active Exploitation)

- [ ] Block the attacker IP immediately (server firewall or hosting panel).
- [ ] Invalidate all sessions for affected accounts:
  ```sql
  DELETE FROM sessions WHERE user_id = <affected-id>;
  ```
- [ ] If admin compromise suspected — rotate admin password and `APP_KEY`.
- [ ] If IDOR exploitation (C3/C4) — temporarily restrict the affected route:
  ```php
  // routes/web.php — add temporary block
  Route::any('/customer/{id}', fn() => abort(503));
  Route::any('/invoice/{order}', fn() => abort(503));
  ```
- [ ] Enable maintenance mode if exploitation is ongoing.

### P3 — Medium (Suspicious Activity / Probing)

- [ ] Block the source IP at the firewall.
- [ ] Increase log verbosity temporarily:
  ```env
  LOG_LEVEL=debug
  ```
- [ ] Monitor logs in real time:
  ```bash
  tail -f storage/logs/laravel.log
  ```
- [ ] No need to take the app offline unless escalation occurs.

### P4 — Low (Misconfiguration / Policy Violation)

- [ ] Document the finding.
- [ ] Schedule a fix — do not rush hotfixes that may break the app.
- [ ] No containment action required unless P3+ indicators appear.

---

## Step 3 — Investigate

Only after containment — gather evidence for root cause analysis.

### Questions to Answer

1. **What was accessed?** (routes, endpoints, database records)
2. **Who accessed it?** (IP, user account, session ID)
3. **When did it start?** (first log entry showing the behavior)
4. **How did they get in?** (which vulnerability was exploited)
5. **What was taken or changed?** (customer data, orders, payments, files)

### Evidence to Collect

```bash
# Save relevant log sections — do not modify originals
cp storage/logs/laravel.log storage/logs/laravel.log.incident-$(date +%Y%m%d)

# Get attacker IP list from access log
awk '{print $1}' /var/log/nginx/access.log | sort | uniq -c | sort -rn | head -20

# Check for newly created or modified files (possible webshells)
find public/ -name "*.php" -newer composer.lock
find storage/ -name "*.php"

# Database — check for unexpected admin accounts
SELECT * FROM admins;
SELECT * FROM users ORDER BY created_at DESC LIMIT 20;
```

### Known Vulnerable Areas to Check First (based on current audit)

| Ref | Location | What to Check |
|-----|----------|---------------|
| C3 | `PUT /customer/{id}` | Logs for customer ID mismatch (attacker vs. victim) |
| C4 | `/invoice/{order}` | Logs for invoice access by wrong user |
| C5 | `/debug-*` routes | Any hits on those routes in access log |
| H3 | `saveChanges()` in CartController | Orders with prices below expected |
| M3 | `GcashController` | GCash orders accessed without matching session |
| L2 | File upload endpoint | Check `storage/app/` for unexpected file types |

---

## Step 4 — Eradicate

Remove the threat entirely before restoring service.

- [ ] Patch or disable the exploited vulnerability (reference the SECURITY_AUDIT.md findings).
- [ ] Remove any malicious files uploaded or created (webshells, backdoors).
- [ ] Delete any unauthorized accounts created during the incident.
- [ ] Verify no cron jobs or scheduled tasks were added:
  ```bash
  crontab -l
  php artisan schedule:list
  ```
- [ ] Rotate all secrets — `APP_KEY`, database password, GCash API credentials if exposed.
- [ ] Run a fresh `composer install` if vendor files may have been tampered with.

---

## Step 5 — Recover

Restore normal operations carefully.

- [ ] Verify the exploit path is fully closed before going back online.
- [ ] Restore from a clean backup if data integrity is in question.
- [ ] Run a database integrity check — verify orders, payments, and customer records.
- [ ] Bring the app back online:
  ```bash
  php artisan up
  ```
- [ ] Monitor logs closely for the first 24 hours after recovery.
- [ ] Notify affected users if their data was accessed (legal/ethical obligation).

---

## Step 6 — Post-Incident Review

Complete this within 72 hours of resolution.

### Review Checklist

- [ ] Write an incident summary (see template below).
- [ ] Identify which SECURITY_AUDIT.md finding was exploited.
- [ ] Determine why the vulnerability was not fixed before exploitation.
- [ ] Update SECURITY_AUDIT.md with the finding status.
- [ ] Add or improve monitoring/alerting to detect this earlier next time.
- [ ] Schedule remaining open vulnerabilities for immediate remediation.

### Incident Summary Template

```
## Incident Summary

**Date:** YYYY-MM-DD  
**Duration:** X hours  
**Severity:** P1 / P2 / P3 / P4  
**Status:** Resolved

### What Happened
(brief description of the attack)

### Root Cause
(which vulnerability — reference SECURITY_AUDIT.md ID if applicable)

### Data Affected
(what user data, orders, or payment info was accessed or modified)

### Actions Taken
(containment, eradication, recovery steps performed)

### Preventive Measures
(what was fixed or changed to prevent recurrence)
```

---

## Quick Reference — Emergency Commands

```bash
# Take app offline immediately
php artisan down

# Bring app back online
php artisan up

# Clear all caches
php artisan cache:clear && php artisan config:clear && php artisan route:clear

# Regenerate app key (invalidates cookies and encrypted data)
php artisan key:generate

# View live logs
tail -f storage/logs/laravel.log

# Find recently modified PHP files (potential webshell detection)
find . -name "*.php" -newer composer.lock -not -path "./vendor/*"

# Kill all active sessions (database driver)
php artisan tinker --execute="DB::table('sessions')->truncate();"
```

---

## Contact & Escalation

> Fill in your actual contacts below.

| Role | Name | Contact |
|------|------|---------|
| Project Lead | | |
| Hosting / Server Admin | | |
| Database Admin | | |
| GCash / Payment Support | | |
| Legal / Compliance | | |

---

*Reference: SECURITY_AUDIT.md for full vulnerability inventory. Update this document after each incident.*
