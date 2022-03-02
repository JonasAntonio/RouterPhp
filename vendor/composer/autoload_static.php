<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7e993e30251f0b6601b6011c408e60f9
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Src\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Src\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7e993e30251f0b6601b6011c408e60f9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7e993e30251f0b6601b6011c408e60f9::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit7e993e30251f0b6601b6011c408e60f9::$classMap;

        }, null, ClassLoader::class);
    }
}
