<?php

namespace Tee\Admin\Tests;

use Tee\System\Tests\TestCase;

class InitializeTest extends TestCase {

    public function testSomethingIsTrue()
    {
        $this->assertTrue(\moduleEnabled('admin'));
        $this->assertTrue(\moduleEnabled('auth'));
        $this->assertTrue(\moduleEnabled('user'));
        $this->assertTrue(\moduleEnabled('system'));
    }

}