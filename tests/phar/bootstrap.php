<?php

declare(strict_types=1);

\spl_autoload_register(function ($className) {
    // Only load this specific namespace. Anything else should be loaded from the phar.
    if (0 === \strpos($className, 'Zalas\PHPUnit\Doubles\Tests\TestCase\\TestDoubles\\')) {
        $path = \sprintf('%s/../%s.php', __DIR__, \strtr($className, ['\\' => '/', 'Zalas\PHPUnit\Doubles\Tests\\' => '']));

        if (\file_exists($path)) {
            require_once $path;
        }
    }
});
