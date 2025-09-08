<?php

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

$finder = Finder::create()
    ->in(__DIR__)
    ->append([__FILE__])
;

return (new Config())
    ->setRules([
        '@Symfony' => true,
        '@PSR12' => true,
        'php_unit_method_casing' => ['case' => 'camel_case'],
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder)
;
