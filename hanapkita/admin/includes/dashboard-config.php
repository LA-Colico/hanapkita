<?php
/**
 * Hanap-Kita Dashboard Configuration
 * Customize your dashboard settings here
 */

// ================================
// GENERAL SETTINGS
// ================================

// Application name and branding
define('APP_NAME', 'Hanap-Kita');
define('APP_TAGLINE', 'Admin Portal');
define('APP_VERSION', '2.1.0');

// Default timezone
define('DEFAULT_TIMEZONE', 'Asia/Manila');
date_default_timezone_set(DEFAULT_TIMEZONE);

// ================================
// UI/UX SETTINGS
// ================================

// Color scheme - Primary orange theme
define('PRIMARY_COLOR', '#FF6B00');
define('SECONDARY_COLOR', '#FF8F42');
define('BACKGROUND_COLOR', '#FEF7F0');
define('SUCCESS_COLOR', '#48BB78');
define('WARNING_COLOR', '#F59E0B');
define('ERROR_COLOR', '#EF4444');
define('INFO_COLOR', '#3B82F6');

// Typography
define('PRIMARY_FONT', 'Inter');
define('FALLBACK_FONTS', '-apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif');

// Layout settings
define('SIDEBAR_WIDTH', '280px');
define('CARD_BORDER_RADIUS', '20px');
define('BUTTON_BORDER_RADIUS', '12px');

// ================================
// DASHBOARD SETTINGS
// ================================

// Auto-refresh settings
define('AUTO_REFRESH_ENABLED', true);
define('REFRESH_INTERVAL', 30000); // milliseconds (30 seconds)
define('CHART_ANIMATION_DURATION', 1000); // milliseconds

// Statistics settings
define('SHOW_TODAY_STATS', true);
define('SHOW_WEEK_STATS', true);
define('SHOW_MONTH_STATS', true);

// Chart settings
define('MAX_CHART_DATA_POINTS', 30); // days for applications chart
define('MAX_CATEGORY_CHART_ITEMS', 8);
define('CHART_HEIGHT_SMALL', 300); // pixels
define('CHART_HEIGHT_LARGE', 400); // pixels

// Activity feed settings
define('RECENT_ACTIVITIES_LIMIT', 8);
define('ACTIVITY_AUTO_REFRESH', true);

// ================================
// ACTIVITY LOGGING SETTINGS
// ================================

// Enable/disable logging for different actions
define('LOG_ADMIN_ACTIONS', true);
define('LOG_EMPLOYER_SESSIONS', true);
define('LOG_JOBSEEKER_SESSIONS', true);
define('LOG_VIEW_ACTIONS', true); // Set to false to reduce log volume

// Log retention settings
define('LOG_RETENTION_DAYS', 90); // days to keep logs
define('AUTO_CLEANUP_LOGS', true);
define('LOG_CLEANUP_FREQUENCY', 'daily'); // daily, weekly, monthly

// Session tracking
define('TRACK_USER_AGENT', true);
define('TRACK_IP_ADDRESS', true);
define('TRACK_SESSION_DURATION', true);

// ================================
// PERFORMANCE SETTINGS
// ================================

// Caching
define('ENABLE_QUERY_CACHE', true);
define('CACHE_DURATION', 300); // seconds (5 minutes)

// Pagination
define('DEFAULT_PAGE_SIZE', 20);
define('MAX_PAGE_SIZE', 100);

// Image/file uploads
define('MAX_UPLOAD_SIZE', '5MB');
define('ALLOWED_IMAGE_TYPES', 'jpg,jpeg,png,gif');
define('ALLOWED_FILE_TYPES', 'pdf,doc,docx,xls,xlsx');

// ================================
// NOTIFICATION SETTINGS
// ================================

// Toast notifications
define('NOTIFICATION_DURATION', 3000); // milliseconds
define('NOTIFICATION_POSITION', 'top-right'); // top-right, top-left, bottom-right, bottom-left

// Email notifications (if implemented)
define('SEND_EMAIL_NOTIFICATIONS', false);
define('ADMIN_EMAIL', 'admin@hanapkita.com');
define('NOTIFICATION_EMAIL_FROM', 'noreply@hanapkita.com');

// ================================
// SECURITY SETTINGS
// ================================

// Session settings
define('SESSION_LIFETIME', 3600); // seconds (1 hour)
define('SESSION_REGENERATE_ID', true);

// Password requirements
define('MIN_PASSWORD_LENGTH', 8);
define('REQUIRE_STRONG_PASSWORD', true);

// Rate limiting
define('ENABLE_RATE_LIMITING', true);
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_DURATION', 900); // seconds (15 minutes)

// ================================
// API SETTINGS
// ================================

// API endpoints
define('API_BASE_URL', 'api/');
define('API_TIMEOUT', 10000); // milliseconds
define('API_RETRY_ATTEMPTS', 3);

// CORS settings
define('ENABLE_CORS', true);
define('ALLOWED_ORIGINS', '*'); // Use specific domains in production

// ================================
// FEATURE FLAGS
// ================================

// Dashboard features
define('FEATURE_REAL_TIME_CHARTS', true);
define('FEATURE_EXPORT_CHARTS', true);
define('FEATURE_ACTIVITY_LOGS', true);
define('FEATURE_USER_SESSIONS', true);
define('FEATURE_ADVANCED_SEARCH', true);

// UI features
define('FEATURE_DARK_MODE', false); // Coming soon
define('FEATURE_CUSTOMIZABLE_DASHBOARD', false); // Coming soon
define('FEATURE_MOBILE_APP_API', false); // Coming soon

// ================================
// LOCALIZATION SETTINGS
// ================================

// Language settings
define('DEFAULT_LANGUAGE', 'en');
define('AVAILABLE_LANGUAGES', 'en,fil'); // English, Filipino
define('DATE_FORMAT', 'M j, Y');
define('TIME_FORMAT', 'g:i A');
define('DATETIME_FORMAT', 'M j, Y g:i A');

// Currency (for future job salary features)
define('DEFAULT_CURRENCY', 'PHP');
define('CURRENCY_SYMBOL', '₱');

// ================================
// DEVELOPMENT SETTINGS
// ================================

// Debug mode (set to false in production)
define('DEBUG_MODE', false);
define('SHOW_SQL_QUERIES', false);
define('LOG_SQL_QUERIES', false);

// Error reporting
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// ================================
// CUSTOM CSS VARIABLES
// ================================

/**
 * Generate CSS custom properties from configuration
 */
function getDashboardCSSVariables() {
    return "
    :root {
        --primary-orange: " . PRIMARY_COLOR . ";
        --secondary-orange: " . SECONDARY_COLOR . ";
        --bg-peach: " . BACKGROUND_COLOR . ";
        --success-green: " . SUCCESS_COLOR . ";
        --warning-yellow: " . WARNING_COLOR . ";
        --error-red: " . ERROR_COLOR . ";
        --info-blue: " . INFO_COLOR . ";
        --primary-font: '" . PRIMARY_FONT . "', " . FALLBACK_FONTS . ";
        --sidebar-width: " . SIDEBAR_WIDTH . ";
        --card-border-radius: " . CARD_BORDER_RADIUS . ";
        --button-border-radius: " . BUTTON_BORDER_RADIUS . ";
    }";
}

// ================================
// JAVASCRIPT CONFIGURATION
// ================================

/**
 * Generate JavaScript configuration object
 */
function getDashboardJSConfig() {
    return [
        'app' => [
            'name' => APP_NAME,
            'version' => APP_VERSION,
            'debug' => DEBUG_MODE
        ],
        'dashboard' => [
            'autoRefresh' => AUTO_REFRESH_ENABLED,
            'refreshInterval' => REFRESH_INTERVAL,
            'chartAnimationDuration' => CHART_ANIMATION_DURATION,
            'recentActivitiesLimit' => RECENT_ACTIVITIES_LIMIT
        ],
        'api' => [
            'baseUrl' => API_BASE_URL,
            'timeout' => API_TIMEOUT,
            'retryAttempts' => API_RETRY_ATTEMPTS
        ],
        'charts' => [
            'maxDataPoints' => MAX_CHART_DATA_POINTS,
            'maxCategoryItems' => MAX_CATEGORY_CHART_ITEMS,
            'heightSmall' => CHART_HEIGHT_SMALL,
            'heightLarge' => CHART_HEIGHT_LARGE
        ],
        'notifications' => [
            'duration' => NOTIFICATION_DURATION,
            'position' => NOTIFICATION_POSITION
        ],
        'features' => [
            'realTimeCharts' => FEATURE_REAL_TIME_CHARTS,
            'exportCharts' => FEATURE_EXPORT_CHARTS,
            'activityLogs' => FEATURE_ACTIVITY_LOGS,
            'userSessions' => FEATURE_USER_SESSIONS,
            'darkMode' => FEATURE_DARK_MODE
        ],
        'localization' => [
            'language' => DEFAULT_LANGUAGE,
            'timezone' => DEFAULT_TIMEZONE,
            'dateFormat' => DATE_FORMAT,
            'timeFormat' => TIME_FORMAT,
            'currency' => DEFAULT_CURRENCY,
            'currencySymbol' => CURRENCY_SYMBOL
        ]
    ];
}

// ================================
// HELPER FUNCTIONS
// ================================

/**
 * Get formatted date/time
 */
function getFormattedDate($timestamp = null, $format = null) {
    $timestamp = $timestamp ?: time();
    $format = $format ?: DATETIME_FORMAT;
    return date($format, $timestamp);
}

/**
 * Check if feature is enabled
 */
function isFeatureEnabled($feature) {
    $features = [
        'real_time_charts' => FEATURE_REAL_TIME_CHARTS,
        'export_charts' => FEATURE_EXPORT_CHARTS,
        'activity_logs' => FEATURE_ACTIVITY_LOGS,
        'user_sessions' => FEATURE_USER_SESSIONS,
        'dark_mode' => FEATURE_DARK_MODE,
        'advanced_search' => FEATURE_ADVANCED_SEARCH
    ];
    
    return isset($features[$feature]) ? $features[$feature] : false;
}

/**
 * Get color by type
 */
function getColorByType($type) {
    $colors = [
        'primary' => PRIMARY_COLOR,
        'secondary' => SECONDARY_COLOR,
        'success' => SUCCESS_COLOR,
        'warning' => WARNING_COLOR,
        'error' => ERROR_COLOR,
        'info' => INFO_COLOR
    ];
    
    return isset($colors[$type]) ? $colors[$type] : PRIMARY_COLOR;
}

/**
 * Format currency amount
 */
function formatCurrency($amount) {
    return CURRENCY_SYMBOL . number_format($amount, 2);
}

/**
 * Get application version with build number
 */
function getAppVersion() {
    $buildNumber = DEBUG_MODE ? '-dev' : '';
    return APP_VERSION . $buildNumber;
}

// ================================
// VALIDATION FUNCTIONS
// ================================

/**
 * Validate configuration settings
 */
function validateConfiguration() {
    $errors = [];
    
    // Check required constants
    $required = ['APP_NAME', 'PRIMARY_COLOR', 'DEFAULT_TIMEZONE'];
    foreach ($required as $constant) {
        if (!defined($constant)) {
            $errors[] = "Missing required configuration: $constant";
        }
    }
    
    // Validate colors (basic hex color validation)
    $colors = [PRIMARY_COLOR, SECONDARY_COLOR, SUCCESS_COLOR, WARNING_COLOR, ERROR_COLOR];
    foreach ($colors as $color) {
        if (!preg_match('/^#[a-fA-F0-9]{6}$/', $color)) {
            $errors[] = "Invalid color format: $color";
        }
    }
    
    // Validate refresh interval
    if (REFRESH_INTERVAL < 5000) {
        $errors[] = "Refresh interval too low (minimum 5000ms recommended)";
    }
    
    return $errors;
}

// Run validation in debug mode
if (DEBUG_MODE) {
    $config_errors = validateConfiguration();
    if (!empty($config_errors)) {
        error_log('Dashboard Configuration Errors: ' . implode(', ', $config_errors));
    }
}

// ================================
// EXPORT CONFIGURATION
// ================================

// Make configuration available to other files
global $dashboard_config;
$dashboard_config = [
    'css_variables' => getDashboardCSSVariables(),
    'js_config' => getDashboardJSConfig(),
    'version' => getAppVersion()
];
?>