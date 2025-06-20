<?php

/**
 * Generate a 6-digit numeric verification code.
 */
function generateVerificationCode(): string {
    return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
}

/**
 * Simulate sending verification email (stores code in file instead of actual email).
 */
function sendVerificationEmail(string $email, string $code): bool {
    $file = __DIR__ . '/verification_codes.txt';
    return file_put_contents($file, "$email:$code" . PHP_EOL, FILE_APPEND) !== false;
}

/**
 * Register an email by storing it in a file.
 */
function registerEmail(string $email): bool {
    $file = __DIR__ . '/registered_emails.txt';
    
    // Create file if it doesn't exist
    if (!file_exists($file)) {
        file_put_contents($file, '');
    }
    
    $emails = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    if (in_array($email, $emails)) {
        return false; // Email already exists
    }
    
    return file_put_contents($file, $email . PHP_EOL, FILE_APPEND) !== false;
}

/**
 * Unsubscribe an email by removing it from the list.
 */
function unsubscribeEmail(string $email): bool {
    $file = __DIR__ . '/registered_emails.txt';
    
    if (!file_exists($file)) {
        return false;
    }
    
    $emails = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $updatedEmails = array_diff($emails, [$email]);
    
    return file_put_contents($file, implode(PHP_EOL, $updatedEmails) . PHP_EOL) !== false;
}

/**
 * Fetch GitHub timeline.
 */
function fetchGitHubTimeline() {
    $url = 'https://api.github.com/events';
    $options = [
        'http' => [
            'method' => 'GET',
            'header' => [
                'User-Agent: PHP'
            ]
        ]
    ];
    
    $context = stream_context_create($options);
    $response = @file_get_contents($url, false, $context);
    
    return $response ? json_decode($response, true) : [];
}

/**
 * Format GitHub timeline data. Returns a valid HTML string.
 */
function formatGitHubData(array $data): string {
    if (empty($data)) {
        return '<p>No GitHub events available at this time.</p>';
    }
    
    $html = '<h2>GitHub Timeline Updates</h2><ul>';
    
    foreach (array_slice($data, 0, 5) as $event) {
        $actor = htmlspecialchars($event['actor']['login'] ?? 'Unknown');
        $type = htmlspecialchars($event['type'] ?? 'event');
        $repo = htmlspecialchars($event['repo']['name'] ?? 'Unknown repository');
        
        $html .= "<li><strong>{$actor}</strong> performed {$type} on {$repo}</li>";
    }
    
    $html .= '</ul>';
    return $html;
}

/**
 * Send the formatted GitHub updates to registered emails (simulated).
 */
function sendGitHubUpdatesToSubscribers(): void {
    $file = __DIR__ . '/registered_emails.txt';
    
    if (!file_exists($file)) {
        return;
    }
    
    $emails = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    if (empty($emails)) {
        return;
    }
    
    $timeline = fetchGitHubTimeline();
    $formattedData = formatGitHubData($timeline);
    
    // Simulate sending by logging to file
    $logFile = __DIR__ . '/email_log.txt';
    $logEntry = date('Y-m-d H:i:s') . " - Would send to:\n" . 
                implode("\n", $emails) . 
                "\nContent:\n" . $formattedData . "\n\n";
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}
