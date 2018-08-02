<?php

$finder = PhpCsFixer\Finder::create()
    ->in(['src', 'tests'])
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        'declare_strict_types' => false,
        'native_function_invocation' => true,
        'no_empty_comment' => true,
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'no_extra_consecutive_blank_lines' => true,
        'no_leading_import_slash' => true,
        'no_leading_namespace_whitespace' => true,
        'no_unused_imports' => true,
        'no_useless_else' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'phpdoc_add_missing_param_annotation' => ['only_untyped' => true],
        'protected_to_private' => true,
        'strict_comparison' => true,
        'ternary_operator_spaces' => true,
        'ternary_to_null_coalescing' => false,
    ])
    ->setFinder($finder)
;

