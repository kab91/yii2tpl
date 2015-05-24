<?php
/**
 * Configuration file for the "yii asset" console command.
 * Note that in the console environment, some path aliases like '@webroot' and '@web' may not exist.
 * Please define these missing path aliases.
 */
return [
    // Adjust command/callback for JavaScript files compressing:
    'jsCompressor' => 'java -jar assets/tools/compiler.jar --warning_level QUIET --js {from} --js_output_file {to}',

    // Adjust command/callback for CSS files compressing:
    'cssCompressor' => 'java -jar assets/tools/yuicompressor.jar --type css {from} -o {to}',

    // The list of asset bundles to compress:
    'bundles' => [
        'app\assets\AppAsset',
    ],
    // Asset bundle for compression output:
    'targets' => [
        'app\assets\CompressedAsset' => [
            'basePath' => '@webroot/assets',
            'baseUrl' => '/assets',
            'js' => 'all-{hash}.js',
            'css' => 'all-{hash}.css',
        ],
    ],
    // Asset manager configuration:
    'assetManager' => [
        'basePath' => '@webroot/assets',
        'baseUrl' => '/assets',
    ],
];