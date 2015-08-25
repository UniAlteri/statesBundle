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

namespace UniAlteri\Tests\Bundle\StatesBundle\Support;

use UniAlteri\Bundle\StatesBundle\Entity\IntegratedEntity as AbstractIntegratedEntity;
use UniAlteri\States\Proxy\ArrayAccessTrait;
use UniAlteri\States\Proxy\IteratorTrait;
use UniAlteri\States\Proxy\MagicCallTrait;
use UniAlteri\States\Proxy\SerializableTrait;

/**
 * Class IntegratedEntity
 * To build an specific instance of the class IntegratedEntity to test this default class.
 * By default, the class Proxy\Integrated uses '\UniAlteri\States\Factory\StandardStartupFactory' as startup factory.
 * But, in the test, we will use '\UniAlteri\Tests\Support\MockStartupFactory' to unit testing only the proxy.
 *
 * This extends support implements also all supported standard interface to tests implementation provided by the trait Proxy.
 * To avoid errors in the usage of this lib, these interfaces are not defined with released proxies.
 * You must implement these interface, according to your needs, in your derived proxies like in this class.
 *
 * @copyright   Copyright (c) 2009-2015 Uni Alteri (http://uni-alteri.com)
 *
 * @link        http://teknoo.it/states Project website
 *
 * @license     http://teknoo.it/license/mit         MIT License
 * @license     http://teknoo.it/license/gpl-3.0     GPL v3 License
 * @author      Richard Déloge <r.deloge@uni-alteri.com>
 */
class IntegratedEntity extends AbstractIntegratedEntity implements
    \Serializable,
    \ArrayAccess,
    \SeekableIterator,
    \Countable
{

    use ArrayAccessTrait,
        MagicCallTrait,
        IteratorTrait,
        SerializableTrait;

    /**
     * Class name of the factory to use during set up to initialize this object.
     * It is a virtual factory, it does nothing except logs actions.
     *
     * @var string
     */
    protected static $startupFactoryClassName = '\UniAlteri\Tests\Support\MockStartupFactory';

    /**
     * Method to update static::$_startupFactoryClassName to run some unit tests.
     *
     * @param string $className
     */
    public static function defineStartupFactoryClassName($className)
    {
        static::$startupFactoryClassName = $className;
    }
}
