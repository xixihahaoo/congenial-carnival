<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc3a7cdc4c68ae6177c208ba62b76f10e
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Workerman\\' => 10,
        ),
        'G' => 
        array (
            'GatewayWorker\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Workerman\\' => 
        array (
            0 => __DIR__ . '/..' . '/workerman/workerman',
        ),
        'GatewayWorker\\' => 
        array (
            0 => __DIR__ . '/..' . '/workerman/gateway-worker/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc3a7cdc4c68ae6177c208ba62b76f10e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc3a7cdc4c68ae6177c208ba62b76f10e::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
