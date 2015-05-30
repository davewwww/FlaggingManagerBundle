<?php

namespace Dwo\FlaggingManagerBundle\Tests\DependencyInjection;

use Dwo\FlaggingManagerBundle\Tests\Fixtures\Container;

class DwoFlaggingManagerExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testConfig()
    {
        $container = Container::createContainerFromFixtures();

        $this->assertTrue($container->hasAlias('dwo_flagging_manager.manager'));
        $this->assertTrue($container->hasAlias('dwo_flagging_manager.db.connection'));
        $this->assertTrue($container->hasParameter('dwo_flagging_manager.db.table'));
    }

    /**
     * @dataProvider servicesProvider
     */
    public function testServices($service)
    {
        $container = Container::createContainerFromFixtures();

        $this->assertTrue($container->has($service));
    }

    public function servicesProvider() {
        return array(
            array('dwo_flagging_manager.manager.feature.db'),
            array('dwo_flagging_manager.manager.feature.cache'),
            array('dwo_flagging_manager.manager.config_prototype'),
            array('dwo_flagging_manager.handler'),
            array('dwo_flagging_manager.validator.voters_exists'),
        );
    }
}
