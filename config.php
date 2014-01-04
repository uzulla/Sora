<?php
session_start();

require 'vendor/autoload.php';

define('BASE_PATH', __DIR__.DIRECTORY_SEPARATOR);
define('DB_DSN', "sqlite:".BASE_PATH."sqlite.db");

define('PASSWORD_SALT_LENGTH', 8);
define('PASSWORD_STRETCH_TIMES', 1234);

define('POST_IMAGE_DIR', __DIR__."/htdocs/post_images");
define('POST_IMAGE_MAX_FILE_SIZE', 1*1024*1024); // 1Mbyte

define('SLIM_CSRF_DEFENDER_KEY_NAME', 'csrf_token');

define('POST_PER_PAGE', 5);
define('DEBUG', TRUE);

define('TEMPLATES_DIR_PATH', __DIR__.'/templates');

define('ADMIN_USER_NAME', 'admin');
define('ADMIN_PASSWORD', 'adminpassword567');

if(!isset($db_settings)){
    $db_settings = array(
        'driver' => 'sqlite',
        'database' => BASE_PATH."sqlite.db",
    );
}
\Sora\DB\Base::registerIlluminate($db_settings);
