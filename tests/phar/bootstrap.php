<?php

declare(strict_types=1);

class AutoloaderNamespace
{
    public function __construct(
        public readonly string $prefixToMatch,
        public readonly string $prefixToRemove,
        public readonly string $pathTemplate,
    ) {
    }
}

\spl_autoload_register(function ($className) {
    // Only load these specific namespaces. Anything else should be loaded from the phar.
    // These are namespaces that would normally be loaded by project's autoloader, which we do not have here.
    $namespaces = [
        new AutoloaderNamespace(
            'Zalas\PHPUnit\Doubles\Tests\TestCase\\TestDoubles\\',
            'Zalas\PHPUnit\Doubles\Tests\\',
            __DIR__ . '/../%s.php'
        ),
        new AutoloaderNamespace(
            'Prophecy\\',
            'Prophecy\\',
            __DIR__ . '/../../vendor/phpspec/prophecy/src/Prophecy/%s.php'
        ),
        new AutoloaderNamespace(
            'Prophecy\Prophecy\\',
            'Prophecy\Prophecy\\',
            __DIR__ . '/../../vendor/phpspec/prophecy/src/Prophecy/Prophecy/%s.php'
        ),
        new AutoloaderNamespace(
            'Prophecy\PhpUnit\\',
            'Prophecy\PhpUnit\\',
            __DIR__ . '/../../vendor/phpspec/prophecy-phpunit/src/%s.php'
        ),
        new AutoloaderNamespace(
            'phpDocumentor\Reflection\\',
            'phpDocumentor\Reflection\\',
            __DIR__ . '/../../vendor/phpdocumentor/reflection-docblock/src/%s.php'
        ),
        new AutoloaderNamespace(
            'phpDocumentor\Reflection\\',
            'phpDocumentor\Reflection\\',
            __DIR__ . '/../../vendor/phpdocumentor/type-resolver/src/%s.php'
        ),
        new AutoloaderNamespace(
            'PHPStan\PhpDocParser\\',
            'PHPStan\PhpDocParser\\',
            __DIR__ . '/../../vendor/phpstan/phpdoc-parser/src/%s.php'
        ),
        new AutoloaderNamespace(
            'Webmozart\Assert\\',
            'Webmozart\Assert\\',
            __DIR__ . '/../../vendor/webmozart/assert/src/%s.php'
        ),
        new AutoloaderNamespace(
            'SebastianBergmann\Comparator\\',
            'SebastianBergmann\Comparator\\',
            __DIR__ . '/../../vendor/sebastian/comparator/src/%s.php'
        ),
        new AutoloaderNamespace(
            'SebastianBergmann\Exporter\\',
            'SebastianBergmann\Exporter\\',
            __DIR__ . '/../../vendor/sebastian/exporter/src/%s.php'
        ),
        new AutoloaderNamespace(
            'SebastianBergmann\RecursionContext\\',
            'SebastianBergmann\RecursionContext\\',
            __DIR__ . '/../../vendor/sebastian/recursion-context/src/%s.php'
        ),
    ];

    foreach ($namespaces as $namespace) {
        if (\str_starts_with($className, $namespace->prefixToMatch)) {
            $path = \sprintf($namespace->pathTemplate, \strtr($className, ['\\' => '/', $namespace->prefixToRemove => '']));

            if (\file_exists($path)) {
                require_once $path;

                return;
            }
        }
    }
});
