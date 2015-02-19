<?php

namespace Betterpress;

use Betterpress\Extensions\BetterpressBundle;
use Betterpress\Extensions\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Betterpress\Extensions\BetterpressFramework\DependencyInjection\Config\Extension as ContainerExtension;
use Symfony\Component\Yaml\Yaml;

abstract class Application
{
    private $wpDir;
    private $config;
    private $container;

    /**
     * @var BetterpressBundle[]
     */
    private $extensions = [];

    public function __construct($wpDir)
    {
        $this->wpDir = $wpDir;

        $this->container = new ContainerBuilder();
        $this->container->set('container', $this->container);
        $this->registerExtensions();

        $yamlLoader = new YamlFileLoader($this->container, new FileLocator([$wpDir.'/app/config']));
        $yamlLoader->load('config.yml');

        $this->container->compile();

    }

    public function setup()
    {
        foreach ($this->extensions as $extension) {
            $extension->setup($this, $this->container);
        }
    }


    /**
     * @return BetterpressBundle[]
     */

    abstract public function getExtensions();

    private function registerExtensions()
    {
        foreach ($this->getExtensions() as $extension) {
            $this->extensions[] = $extension;
            $this->container->registerExtension($extension->getContainerExtension());
        }
        foreach ($this->extensions as $extension) {
            $extension->build($this->container);
        }
    }

    public function configure()
    {

        $constants = $this->container->get('php.globals.constants');

        $constants->set(
            'WP_CONTENT_DIR',
            $this->wpDir . DIRECTORY_SEPARATOR . $this->container->getParameter('wordpress.structure.content')
        );

        $constants->set('DB_NAME',      $this->container->getParameter('wordpress.database.name'));
        $constants->set('DB_USER',      $this->container->getParameter('wordpress.database.user'));
        $constants->set('DB_PASSWORD',  $this->container->getParameter('wordpress.database.password'));
        $constants->set('DB_HOST',      $this->container->getParameter('wordpress.database.host'));
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
        $constants->set('WP_DEBUG', $this->container->getParameter('debug'));

        /* That's all, stop editing! Happy blogging. */

        /** Sets up WordPress vars and included files. */
        require_once(ABSPATH . 'wp-settings.php');

    }
}