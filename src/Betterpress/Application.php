<?php

namespace Betterpress;

use AdamQuaile\PhpGlobal\Constants\ConstantWrapper;
use Betterpress\Extensions\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class Application
{
    private $wpDir;
    private $config;
    private $container;

    public function __construct($config, $wpDir)
    {
        $this->wpDir = $wpDir;
        $this->config = $config;

        $this->container = new ContainerBuilder();
        $this->buildCoreServices();

    }

    public function setup()
    {
        $this->registerExtensions();
        $this->registerHooks();
    }

    private function buildCoreServices()
    {
        $container = $this->container;
        $container
            ->register('wordpress.hook_manager', 'Betterpress\Bridge\Wordpress\Hooks\HookManager');

        $container
            ->register('php.globals.constants', 'AdamQuaile\PhpGlobal\Constants\ConstantWrapper');
    }

    private function registerExtensions()
    {
        foreach ($this->config['wordpress']['extensions'] as $className) {
            /**
             * @var Extension $extension
             */
            $extension = new $className;
            $extension->build($this->container);
        }
    }

    private function registerHooks()
    {
        $this->container->get('wordpress.hook_manager')->registerHooks();
    }

    public function configure()
    {
        $constants = $this->container->get('php.globals.constants');

        $constants->set(
            'WP_CONTENT_DIR',
            $this->wpDir . DIRECTORY_SEPARATOR . $this->config['wordpress']['structure']['content']
        );

        $constants->set('DB_NAME', $this->config['wordpress']['database']['name']);
        $constants->set('DB_USER', $this->config['wordpress']['database']['user']);
        $constants->set('DB_PASSWORD', $this->config['wordpress']['database']['password']);
        $constants->set('DB_HOST', $this->config['wordpress']['database']['host']);
        $constants->set('DB_CHARSET', 'utf8');
        $constants->set('DB_COLLATE', '');

        /**#@+
         * Authentication Unique Keys and Salts.
         *
         * Change these to different unique phrases!
         * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
         * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
         *
         * @since 2.6.0
         */
        $constants->set('AUTH_KEY',         'FS,>|oRYX?V$Y5fMM8RkAQD@rw1e(Uv%;K)Kh<t>tPk`SWx+|u+;m9%fUQ-CCc+p');
        $constants->set('SECURE_AUTH_KEY',  '1ax!M_+J75}aMY&+[CDX/}ik# A1Fb-PQ0&J54(jo$4OF3FyQ|3a;WXNl=]U)ag+');
        $constants->set('LOGGED_IN_KEY',    ';,QPpOh@y0M|;TQiY>G_nW+5;dn?5Qx;58G7:5+82>T8LmbPMg.Rb5eO(&sO%[ML');
        $constants->set('NONCE_KEY',        'I*`V3w$E 7KLMsBgE3q:Bw/G~@@xs$iz.Y4X(Spq-`v6?C-_cC8p:3=/fZ[K2l}$');
        $constants->set('AUTH_SALT',        'D]5OESq-Ix=wpcoKD)i+1?3CZsY+M,YV4@`;N+h-dvS?+U(vE:<6mc!w&|M<Sc&]');
        $constants->set('SECURE_AUTH_SALT', 'LOqY%UZS;O$[gIVKV wjp[93l~F_L$rtVs~[)=Z)7{C)S#-v>zLfu@V7-z}[Kx)n');
        $constants->set('LOGGED_IN_SALT',   'zGXvU&Io_Q!ZV3-vUpC;@:g!![xpV;k-k0}| kLb*;#KX@>W|u,t7z3Q*Q(t$3+-');
        $constants->set('NONCE_SALT',       'ZXernd/,u]}5c/l%P|i~~]ul;?Ec#Q@C3UrNI.fL+qAff@H$ M+zrq ;fF]3*LGR');

        /**#@-*/

        /**
         * WordPress Database Table prefix.
         *
         * You can have multiple installations in one database if you give each a unique
         * prefix. Only numbers, letters, and underscores please!
         */
        $table_prefix  = 'wp_';

        /**
         * For developers: WordPress debugging mode.
         *
         * Change this to true to enable the display of notices during development.
         * It is strongly recommended that plugin and theme developers use WP_DEBUG
         * in their development environments.
         */
        $constants->set('WP_DEBUG', false);

        /* That's all, stop editing! Happy blogging. */

        /** Sets up WordPress vars and included files. */
        require_once(ABSPATH . 'wp-settings.php');

    }
}