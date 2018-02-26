<?php

/*
 * This file is part of the WPFoundation library.
 *
 * Copyright (c) 2015-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace LIN3S\WPFoundation;

/**
 * Abstract class of assets class that implements the interface.
 * This class avoids the use of callbacks in the constructor.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
abstract class Assets
{
    abstract public function developmentAssets() : void;

    abstract public function productionAssets() : void;

    abstract public function adminAssets() : void;

    public function __construct()
    {
        defined('WP_DEBUG') && true === WP_DEBUG
            ? add_action('wp_enqueue_scripts', [$this, 'developmentAssets'])
            : add_action('wp_enqueue_scripts', [$this, 'productionAssets']);

        add_action('admin_enqueue_scripts', [$this, 'adminAssets']);
    }

    protected function addScript(
        string $name,
        string $from,
        array $dependencies = ['jquery'],
        string $version = '1.0.0',
        bool $inFooter = true,
        ?string $ajaxUrl = null
    ) {
        wp_enqueue_script($name, $this->path($from, $name), $dependencies, $version, $inFooter);

        if (null !== $ajaxUrl) {
            $this->registerAjaxUrls($name, $ajaxUrl);
        }

        return $this;
    }

    protected function addStylesheet(
        string $name,
        string $from,
        array $dependencies = [],
        string $version = '1.0.0',
        string $media = 'all'
    ) {
        wp_enqueue_style($name, $this->path($from, $name, 'css'), $dependencies, $version, $media);

        return $this;
    }

    /*
     *  Usage example with name="subscribe" and ajaxUrl="subscribeAjax":
     *
     *      // subscribe.js
     *
     *      $.ajax({
     *          url: subscribeAjax.ajaxUrl,
     *          method: 'GET',
     *          data: {
     *              action: 'ajax-action-registered-in-your-php-file',
     *          }
     *      }).done(function (response) {
     *         (...)
     *      });
     */
    protected function registerAjaxUrls(string $name, string $ajaxUrl) : void
    {
        if (false === is_array($ajaxUrl)) {
            $ajaxUrl = [$ajaxUrl];
        }
        foreach ($ajaxUrl as $url) {
            wp_localize_script($name, $url, [
                'ajaxUrl' => admin_url('admin-ajax.php'),
            ]);
        }
    }

    private function path(string $from, string $name, string $fileType = 'js') : string
    {
        return get_template_directory_uri() . '/Resources/' . $from . '/' . $name . '.' . $fileType;
    }
}