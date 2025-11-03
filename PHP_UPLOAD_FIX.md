# PHP Upload Configuration Fix

## Problem
Your server's PHP configuration limits file uploads to 2MB, but you're trying to upload a 4MB image.

## Current Limits
- `upload_max_filesize`: 2M
- `post_max_size`: 8M
- `memory_limit`: 128M

## Solutions

### Option 1: Increase PHP Limits (Recommended)

For WAMP/XAMPP users, edit your `php.ini` file:

1. **Find php.ini file:**
   ```bash
   # WAMP: Usually in C:\wamp64\bin\apache\apache2.x.x\bin\php.ini
   # Or check with: php --ini
   ```

2. **Edit these values:**
   ```ini
   upload_max_filesize = 10M
   post_max_size = 12M
   max_execution_time = 300
   memory_limit = 256M
   ```

3. **Restart Apache/Web Server**

### Option 2: Create .htaccess File (Alternative)

Create/edit `.htaccess` in your Laravel public directory:

```apache
php_value upload_max_filesize 10M
php_value post_max_size 12M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Option 3: Use Smaller Images

For immediate testing, use images smaller than 2MB.

## Verification

After making changes, restart your web server and check:

```bash
php -r "echo 'upload_max_filesize: ' . ini_get('upload_max_filesize') . PHP_EOL;"
```

## Laravel Configuration

The application has been updated to:
- Show current PHP limits on the upload page
- Display real-time file size validation
- Provide better error messages
- Automatically adjust validation based on server limits

## Security Note

When increasing upload limits:
- Consider security implications
- Implement virus scanning for production
- Add rate limiting for uploads
- Monitor disk space usage