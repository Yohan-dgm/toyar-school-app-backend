# 🚀 Local Development Commands for Notification System

## 📋 What You Need to Run

Currently you're running: `php artisan serve --host=172.16.20.183 --port=9999`

**But for the complete notification system to work, you need 3 services running simultaneously:**

1. **Laravel Web Server** (✅ Already running)
2. **Queue Worker** (❌ Missing - Required for push notifications)
3. **Laravel Reverb WebSocket Server** (❌ Missing - Required for real-time updates)

## ⚡ Quick Start (3 Commands)

Open **3 separate terminal windows/tabs** and run these commands:

### Terminal 1: Laravel Server
```bash
php artisan serve --host=172.16.20.183 --port=9999
```
**Purpose:** Serves your Laravel API endpoints
**Status:** ✅ Already running

### Terminal 2: Queue Worker
```bash
php artisan queue:listen --tries=1
```
**Purpose:** Processes push notification jobs in the background
**Required For:** Push notifications to be sent to mobile devices

### Terminal 3: Laravel Reverb (WebSocket Server)
```bash
php artisan reverb:start --host=172.16.20.183 --port=8080
```
**Purpose:** Handles real-time WebSocket connections for instant notifications
**Required For:** Real-time notification updates in the frontend

## 🎯 All-in-One Solution (Recommended)

Instead of managing 3 terminals, you can run everything with one command:

```bash
composer dev
```

This single command runs all services concurrently:
- ✅ Laravel server (`php artisan serve`)
- ✅ Queue worker (`php artisan queue:listen --tries=1`)
- ✅ Log viewer (`php artisan pail`)
- ✅ Vite dev server (`npm run dev`)

**Note:** The `composer dev` command uses your default Laravel server settings, so you might need to modify it if you want to bind to `172.16.20.183:9999`.

## 📊 Service Status Check

### Check if Services are Running:

```bash
# Check Laravel server
curl http://172.16.20.183:9999/api/health
# or
ps aux | grep "php artisan serve"

# Check Queue Worker
ps aux | grep "queue:listen"

# Check Reverb WebSocket Server
ps aux | grep "reverb:start"

# Check all Laravel processes
ps aux | grep artisan
```

### Check Specific Ports:
```bash
# Check if Laravel server is listening on port 9999
lsof -i :9999

# Check if Reverb is listening on port 8080
lsof -i :8080
```

## 🔧 Individual Service Management

### Laravel Server Options:

```bash
# Your current setup (bind to specific IP)
php artisan serve --host=172.16.20.183 --port=9999

# Default (localhost only)
php artisan serve

# Bind to all interfaces
php artisan serve --host=0.0.0.0 --port=9999
```

### Queue Worker Options:

```bash
# Basic queue worker (recommended for development)
php artisan queue:listen --tries=1

# Process specific queue
php artisan queue:work --queue=high,default

# With timeout and memory limits
php artisan queue:work --timeout=60 --memory=512

# Process only one job then exit
php artisan queue:work --once
```

### Laravel Reverb Options:

```bash
# Default Reverb server
php artisan reverb:start

# Bind to specific host (match your Laravel server)
php artisan reverb:start --host=172.16.20.183 --port=8080

# With debug output
php artisan reverb:start --debug

# In background with log file
php artisan reverb:start --host=172.16.20.183 --port=8080 > reverb.log 2>&1 &
```

## 🗂️ Service Descriptions

### 1. Laravel Web Server
**Purpose:** Handles HTTP API requests
**Endpoints Used:**
- `/api/user-management/push-tokens/register`
- `/api/user-management/push-tokens/delete` 
- `/api/communication-management/notifications/*`

**Required For:**
- User authentication
- Push token registration
- Notification CRUD operations

### 2. Queue Worker
**Purpose:** Processes background jobs asynchronously
**Jobs Processed:**
- `SendPushNotificationJob` - Delivers push notifications to Expo
- Other background tasks

**Why Needed:**
- Push notifications are sent via background jobs
- Prevents API timeouts when sending to many devices
- Provides retry logic for failed push deliveries
- Handles rate limiting with Expo API

**What Happens Without It:**
- ❌ Push notifications won't be sent
- ❌ Jobs accumulate in database
- ❌ No retry mechanism for failures

### 3. Laravel Reverb (WebSocket Server)
**Purpose:** Handles real-time WebSocket connections
**Events Broadcasted:**
- `notification.created` - New notification events
- `notification.read` - Read status updates
- `notification.stats.updated` - Badge count updates

**Why Needed:**
- Real-time notification updates in frontend
- Instant badge count updates
- Live notification list updates
- WebSocket authentication

**What Happens Without It:**
- ❌ No real-time updates
- ❌ Users must refresh to see new notifications
- ❌ WebSocket connections fail

## 📁 Configuration Files

### Queue Configuration
File: `config/queue.php`
```php
'default' => env('QUEUE_CONNECTION', 'database'),
```

Current setting in `.env`:
```
QUEUE_CONNECTION=database
```

### Broadcasting Configuration
File: `config/broadcasting.php`
```php
'default' => env('BROADCAST_CONNECTION', 'reverb'),
```

Current settings in `.env`:
```
BROADCAST_CONNECTION=reverb
REVERB_APP_KEY=ftlvjzbndng2pip2xruw
REVERB_HOST=0.0.0.0
REVERB_PORT=8080
```

## 🚨 Troubleshooting

### Queue Worker Issues

**Problem:** Jobs not processing
```bash
# Check failed jobs
php artisan queue:failed

# Check queued jobs
PGPASSWORD=1234 psql -h 127.0.0.1 -U macbookair -d school_app -c "SELECT * FROM jobs LIMIT 5;"

# Clear failed jobs
php artisan queue:flush

# Restart queue worker
php artisan queue:restart
```

**Problem:** Queue worker stops
```bash
# Check if process is running
ps aux | grep queue:listen

# Restart if stopped
php artisan queue:listen --tries=1
```

### Reverb WebSocket Issues

**Problem:** WebSocket connections failing
```bash
# Check if Reverb is running
ps aux | grep reverb

# Check port availability
lsof -i :8080

# Restart Reverb
pkill -f reverb
php artisan reverb:start --host=172.16.20.183 --port=8080
```

**Problem:** Authentication errors
- Verify JWT tokens are valid
- Check CORS settings in `config/cors.php`
- Ensure Reverb app key matches in `.env`

### Laravel Server Issues

**Problem:** Server not accessible from network
```bash
# Use 0.0.0.0 to bind to all interfaces
php artisan serve --host=0.0.0.0 --port=9999

# Check firewall settings
# Ensure port 9999 is accessible from your network
```

## 📝 Development Workflow

### Starting Development Session:
```bash
# Option 1: All-in-one (recommended)
composer dev

# Option 2: Manual (3 terminals)
# Terminal 1:
php artisan serve --host=172.16.20.183 --port=9999

# Terminal 2:
php artisan queue:listen --tries=1

# Terminal 3:
php artisan reverb:start --host=172.16.20.183 --port=8080
```

### Stopping Services:
```bash
# Stop all Laravel processes
pkill -f "php artisan"

# Stop specific services
pkill -f "php artisan serve"
pkill -f "php artisan queue"
pkill -f "php artisan reverb"
```

### Restarting Services:
```bash
# Restart queue worker (after code changes)
php artisan queue:restart

# Restart Reverb (after config changes)
pkill -f reverb
php artisan reverb:start --host=172.16.20.183 --port=8080
```

## ✅ Verification Checklist

After starting all services, verify they're working:

### 1. Laravel Server ✅
```bash
curl -I http://172.16.20.183:9999
# Should return: HTTP/1.1 200 OK
```

### 2. Queue Worker ✅
```bash
# Create a test job and check it processes
php artisan tinker --execute="dispatch(new App\Jobs\SendPushNotificationJob(1));"

# Check queue worker output for processing message
```

### 3. Reverb WebSocket ✅
```bash
# Check if port is listening
lsof -i :8080

# Test WebSocket connection (if you have wscat)
wscat -c ws://172.16.20.183:8080
```

### 4. Complete System Test ✅
Use the provided Postman collection to:
1. Authenticate user
2. Register push token
3. Create notification
4. Verify all services process the request

## 🎯 Production Notes

For production deployment:

### Queue Worker (Use Supervisor)
```bash
# Install supervisor
sudo apt install supervisor

# Create config: /etc/supervisor/conf.d/laravel-queue.conf
[program:laravel-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/app/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=4
```

### Reverb WebSocket (Use PM2)
```bash
npm install -g pm2
pm2 start "php artisan reverb:start" --name reverb-server
```

## 📞 Quick Reference

**Start Everything:**
```bash
composer dev
```

**Or Manual (3 commands):**
```bash
php artisan serve --host=172.16.20.183 --port=9999
php artisan queue:listen --tries=1
php artisan reverb:start --host=172.16.20.183 --port=8080
```

**Check Status:**
```bash
ps aux | grep artisan
lsof -i :9999
lsof -i :8080
```

**Stop Everything:**
```bash
pkill -f "php artisan"
```

**Test Notification System:**
- Import Postman collection
- Follow NOTIFICATION_PUSH_TESTING_GUIDE.md
- Verify all 3 services are responding

---

## 🎉 Summary

**You currently run:** 1 command
**You need to run:** 3 commands (or use `composer dev`)

The missing services (Queue Worker and Reverb WebSocket) are essential for:
- ✅ **Push notifications** to be delivered
- ✅ **Real-time updates** to work in the frontend

Start all services and your notification system will work completely! 🚀