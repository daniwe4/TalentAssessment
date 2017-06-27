<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfb31f567a2e725092633d205e4df9759
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'CaT\\Plugins\\TalentAssessment\\' => 29,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'CaT\\Plugins\\TalentAssessment\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
    );

    public static $classMap = array (
        'FPDF' => __DIR__ . '/..' . '/setasign/fpdf/fpdf.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfb31f567a2e725092633d205e4df9759::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfb31f567a2e725092633d205e4df9759::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitfb31f567a2e725092633d205e4df9759::$classMap;

        }, null, ClassLoader::class);
    }
}