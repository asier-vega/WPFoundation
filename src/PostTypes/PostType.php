<?php

/*
 * This file is part of the WP Helpers library.
 *
 * Copyright (c) 2015 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPHelpers\PostTypes;

/**
 * Abstract class of base post type that implements the interface.
 * This class avoids the redundant task of create the same PostType constructor.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
abstract class PostType implements PostTypeInterface
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        add_action('init', [$this, 'postType']);
        add_action('init', [$this, 'taxonomyType']);

        add_filter('post_type_link', [$this, 'permalink'], 1, 2);
    }
}