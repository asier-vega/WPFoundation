<?php

/*
 * This file is part of the WPFoundation library.
 *
 * Copyright (c) 2015-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\LIN3S\WPFoundation\Configuration\Menus;

use LIN3S\WordPressPhpSpecBridge\ObjectBehavior;

/**
 * Spec of Menus class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class MenusSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('fixtures\LIN3S\WPFoundation\Menus');
    }

    function it_extends_menus()
    {
        $this->shouldHaveType('LIN3S\WPFoundation\Configuration\Menus\Menus');
    }

    function it_implements_menus_interface()
    {
        $this->shouldHaveType('LIN3S\WPFoundation\Configuration\Menus\MenusInterface');
    }

    function it_should_be_menus()
    {
        $this->menus();
    }
}
