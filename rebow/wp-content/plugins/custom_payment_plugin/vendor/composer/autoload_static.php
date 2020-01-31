<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3c17389b952a49fd6c57d22bc36a480a
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3c17389b952a49fd6c57d22bc36a480a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3c17389b952a49fd6c57d22bc36a480a::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
