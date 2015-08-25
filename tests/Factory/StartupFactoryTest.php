<?php

/**
 * StatesBundle.
 *
 * LICENSE
 *
 * This source file is subject to the MIT license and the version 3 of the GPL3
 * license that are bundled with this package in the folder licences
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@uni-alteri.com so we can send you a copy immediately.
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @license     http://teknoo.it/license/gpl-3.0     GPL v3 License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */

namespace UniAlteri\Tests\Bundle\StatesBundle;

use UniAlteri\Bundle\StatesBundle\Factory;
use UniAlteri\States\Factory\Exception;
use UniAlteri\Tests\Bundle\StatesBundle\Support\DoctrineMockProxy;
use UniAlteri\Tests\Support;

class StartupFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Prepare test, reinitialize the StartupFactory.
     */
    protected function setUp()
    {
        Factory\StartupFactory::reset();
        parent::setUp();
    }

    /**
     * The startup factory must throw an exception when the proxy cannot be initialized.
     */
    public function testForwardStartupProxyNotInitialized()
    {
        try {
            Factory\StartupFactory::forwardStartup(new Support\MockProxy(null));
        } catch (Exception\UnavailableFactory $e) {
            return;
        } catch (\Exception $e) {
        }

        $this->fail('Error, the startup factory must throw an exception when the proxy cannot be initialized');
    }

    /**
     * Test normal behavior of forward startup.
     */
    public function testForwardStartup()
    {
        $factory = new Support\MockFactory('My\Stated\Class', new Support\MockFinder('My\Stated\Class', 'path/to/class'), new \ArrayObject());
        Factory\StartupFactory::registerFactory('UniAlteri\Tests\Support\MockProxy', $factory);
        $proxy = new Support\MockProxy(null);
        Factory\StartupFactory::forwardStartup($proxy);
        $this->assertSame($factory->getStartupProxy(), $proxy);
    }

    /**
     * Test normal behavior of forward startup.
     */
    public function testForwardStartupFromProxy()
    {
        $factory = new Support\MockFactory('My\Stated\Class', new Support\MockFinder('My\Stated\Class', 'path/to/class'), new \ArrayObject());
        Factory\StartupFactory::registerFactory('UniAlteri\Tests\Support\MockProxy', $factory);
        $proxy = new DoctrineMockProxy(null);
        Factory\StartupFactory::forwardStartup($proxy);
        $this->assertSame($factory->getStartupProxy(), $proxy);
    }

    /**
     * Test Factory\StartupFactory::listRegisteredFactory if its return all initialized factory.
     */
    public function testListRegisteredFactory()
    {
        $factory = new Support\MockFactory('My\Stated\Class', new Support\MockFinder('My\Stated\Class', 'path/to/class'), new \ArrayObject());
        Factory\StartupFactory::registerFactory('UniAlteri\Tests\Support\MockProxy1', $factory);
        Factory\StartupFactory::reset();
        Factory\StartupFactory::registerFactory('UniAlteri\Tests\Support\MockProxy2', $factory);
        Factory\StartupFactory::registerFactory('UniAlteri\Tests\Support\MockProxy3', $factory);
        $this->assertEquals(
            array(
                'UniAlteri\Tests\Support\MockProxy2',
                'UniAlteri\Tests\Support\MockProxy3',
            ),
            Factory\StartupFactory::listRegisteredFactory()
        );
    }

    /**
     * Test Factory\StartupFactory::listRegisteredFactory if its return all initialized factory.
     */
    public function testListRegisteredFactoryEmpty()
    {
        Factory\StartupFactory::reset();
        $this->assertEquals(
            array(),
            Factory\StartupFactory::listRegisteredFactory()
        );
    }
}
