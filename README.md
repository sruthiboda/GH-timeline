GitHub Updates Subscription System
A PHP-based system that allows users to subscribe, verify, and unsubscribe from GitHub timeline updates, with simulated email functionality and file-based storage.

Key Features
✅ Email Verification

Generates 6-digit codes (generateVerificationCode())

Simulates email sending by storing codes in verification_codes.txt (sendVerificationEmail())

✅ Subscription Management

Registers emails in registered_emails.txt (registerEmail())

Unsubscribes emails by removing them from the file (unsubscribeEmail())

✅ GitHub Integration

Fetches public GitHub events via API (fetchGitHubTimeline())

Formats data as HTML (formatGitHubData())

✅ Update Distribution

Simulates sending updates by logging to email_log.txt (sendGitHubUpdatesToSubscribers())

Ready for CRON job automation (via cron.php)
