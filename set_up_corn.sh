#!/bin/bash

# Full path to PHP and cron.php (update this based on your machine)
PHP_PATH="/usr/bin/php"
CRON_FILE="$(pwd)/cron.php"

# CRON line to add
CRON_JOB="*/5 * * * * $PHP_PATH $CRON_FILE"

# Check if the CRON job already exists
(crontab -l 2>/dev/null | grep -F "$CRON_FILE") >/dev/null
if [ $? -eq 0 ]; then
    echo "CRON job already exists."
else
    (crontab -l 2>/dev/null; echo "$CRON_JOB") | crontab -
    echo "CRON job added successfully to run every 5 minutes."
fi

