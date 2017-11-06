<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3da414801e6930212dbed7fe6dec735d
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Automattic\\WooCommerce\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Automattic\\WooCommerce\\' => 
        array (
            0 => __DIR__ . '/..' . '/automattic/woocommerce/src/WooCommerce',
        ),
    );

    public static $classMap = array (
        'PWAcommerce\\Admin\\Admin_Ajax' => __DIR__ . '/../..' . '/admin/class-admin-ajax.php',
        'PWAcommerce\\Admin\\Admin_Init' => __DIR__ . '/../..' . '/admin/admin-init.php',
        'PWAcommerce\\Core\\PWAcommerce' => __DIR__ . '/../..' . '/core/class-pwacommerce.php',
        'PWAcommerce\\Includes\\Options' => __DIR__ . '/../..' . '/includes/class-options.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3da414801e6930212dbed7fe6dec735d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3da414801e6930212dbed7fe6dec735d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3da414801e6930212dbed7fe6dec735d::$classMap;

        }, null, ClassLoader::class);
    }
}
