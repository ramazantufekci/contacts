<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd3fbc9bc0a674eeafa34c244312d7159
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'DRContacts\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'DRContacts\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd3fbc9bc0a674eeafa34c244312d7159::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd3fbc9bc0a674eeafa34c244312d7159::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
