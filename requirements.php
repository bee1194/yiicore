<?php
/**
 * Application requirement checker script.
 *
 * In order to run this script use the following console command:
 * php requirements.php
 *
 * In order to run this script from the web, you should copy it to the web root.
 * If you are using Linux you can create a hard link instead, using the following command:
 * ln ../../requirements.php requirements.php
 */

// you may need to adjust this path to the correct Yii framework path
// uncomment and adjust the following line if Yii is not located at the default path
//$frameworkPath = dirname(__FILE__) . '/vendor/yiisoft/yii2';
if (!isset($frameworkPath)) {
    $searchPaths = array(
        dirname(__FILE__) . '/vendor/yiisoft/yii2',
        dirname(__FILE__) . '/../../vendor/yiisoft/yii2',
    );
    foreach ($searchPaths as $path) {
        if (is_dir($path)) {
            $frameworkPath = $path;
            break;
        }
    }
}
if (!isset($frameworkPath) || !is_dir($frameworkPath)) {
    $message = "<h1>Error</h1>\n\n"
        . "<p><strong>The path to yii framework seems to be incorrect.</strong></p>\n"
        . '<p>You need to install Yii framework via composer or adjust the framework path in file <abbr title="' . __FILE__ . '">' . basename(__FILE__) . "</abbr>.</p>\n"
        . '<p>Please refer to the <abbr title="' . dirname(dirname(dirname(__FILE__))) . "/README.md\">README</abbr> on how to install Yii.</p>\n";
    if (!empty($_SERVER['argv'])) {
        // do not print HTML when used in console mode
        echo strip_tags($message);
    } else {
        echo $message;
    }
    exit(1);
}

require_once $frameworkPath . '/requirements/YiiRequirementChecker.php';
$requirementsChecker = new YiiRequirementChecker();

$gdMemo = $imagickMemo = 'Either GD PHP extension with FreeType support or ImageMagick PHP extension with PNG support is required for image CAPTCHA.';
$gdOK = $imagickOK = FALSE;

if (extension_loaded('imagick')) {
    $imagick = new Imagick();
    $imagickFormats = $imagick->queryFormats('PNG');
    if (in_array('PNG', $imagickFormats)) {
        $imagickOK = TRUE;
    } else {
        $imagickMemo = 'Imagick extension should be installed with PNG support in order to be used for image CAPTCHA.';
    }
}

if (extension_loaded('gd')) {
    $gdInfo = gd_info();
    if (!empty($gdInfo['FreeType Support'])) {
        $gdOK = TRUE;
    } else {
        $gdMemo = 'GD extension should be installed with FreeType support in order to be used for image CAPTCHA.';
    }
}

/**
 * Adjust requirements according to your application specifics.
 */
$requirements = array(
    // Database :
    array(
        'name' => 'PDO extension',
        'mandatory' => TRUE,
        'condition' => extension_loaded('pdo'),
        'by' => 'All DB-related classes',
    ),
    array(
        'name' => 'PDO SQLite extension',
        'mandatory' => FALSE,
        'condition' => extension_loaded('pdo_sqlite'),
        'by' => 'All DB-related classes',
        'memo' => 'Required for SQLite database.',
    ),
    array(
        'name' => 'PDO MySQL extension',
        'mandatory' => FALSE,
        'condition' => extension_loaded('pdo_mysql'),
        'by' => 'All DB-related classes',
        'memo' => 'Required for MySQL database.',
    ),
    array(
        'name' => 'PDO PostgreSQL extension',
        'mandatory' => FALSE,
        'condition' => extension_loaded('pdo_pgsql'),
        'by' => 'All DB-related classes',
        'memo' => 'Required for PostgreSQL database.',
    ),
    // Cache :
    array(
        'name' => 'Memcache extension',
        'mandatory' => FALSE,
        'condition' => extension_loaded('memcache') || extension_loaded('memcached'),
        'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-caching-memcache.html">MemCache</a>',
        'memo' => extension_loaded('memcached') ? 'To use memcached set <a href="http://www.yiiframework.com/doc-2.0/yii-caching-memcache.html#$useMemcached-detail">MemCache::useMemcached</a> to <code>true</code>.' : ''
    ),
    array(
        'name' => 'APC extension',
        'mandatory' => FALSE,
        'condition' => extension_loaded('apc'),
        'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-caching-apccache.html">ApcCache</a>',
    ),
    // CAPTCHA:
    array(
        'name' => 'GD PHP extension with FreeType support',
        'mandatory' => FALSE,
        'condition' => $gdOK,
        'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-captcha-captcha.html">Captcha</a>',
        'memo' => $gdMemo,
    ),
    array(
        'name' => 'ImageMagick PHP extension with PNG support',
        'mandatory' => FALSE,
        'condition' => $imagickOK,
        'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-captcha-captcha.html">Captcha</a>',
        'memo' => $imagickMemo,
    ),
    // PHP ini :
    'phpExposePhp' => array(
        'name' => 'Expose PHP',
        'mandatory' => FALSE,
        'condition' => $requirementsChecker->checkPhpIniOff("expose_php"),
        'by' => 'Security reasons',
        'memo' => '"expose_php" should be disabled at php.ini',
    ),
    'phpAllowUrlInclude' => array(
        'name' => 'PHP allow url include',
        'mandatory' => FALSE,
        'condition' => $requirementsChecker->checkPhpIniOff("allow_url_include"),
        'by' => 'Security reasons',
        'memo' => '"allow_url_include" should be disabled at php.ini',
    ),
    'phpSmtp' => array(
        'name' => 'PHP mail SMTP',
        'mandatory' => FALSE,
        'condition' => strlen(ini_get('SMTP')) > 0,
        'by' => 'Email sending',
        'memo' => 'PHP mail SMTP server required',
    ),
);

$result = $requirementsChecker->checkYii()->check($requirements)->getResult();
$requirementsChecker->render();

exit($result['summary']['errors'] === 0 ? 0 : 1);
