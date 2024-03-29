<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita6f22ecb874fbde5f836d0120db0004d
{
    public static $files = array (
        '3a37ebac017bc098e9a86b35401e7a68' => __DIR__ . '/..' . '/mongodb/mongodb/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MongoDB\\' => 8,
        ),
        'F' => 
        array (
            'Framework\\' => 10,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MongoDB\\' => 
        array (
            0 => __DIR__ . '/..' . '/mongodb/mongodb/src',
        ),
        'Framework\\' => 
        array (
            0 => __DIR__ . '/../..' . '/framework',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $prefixesPsr0 = array (
        'M' => 
        array (
            'Monolog' => 
            array (
                0 => __DIR__ . '/..' . '/monolog/monolog/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita6f22ecb874fbde5f836d0120db0004d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita6f22ecb874fbde5f836d0120db0004d::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInita6f22ecb874fbde5f836d0120db0004d::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
