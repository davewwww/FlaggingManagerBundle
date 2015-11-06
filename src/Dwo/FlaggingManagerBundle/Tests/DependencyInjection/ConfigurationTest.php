<?php

namespace Dwo\FlaggingManagerBundle\Tests\DependencyInjection;

use Dwo\FlaggingManagerBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Yaml;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        $yml = Yaml::parse(file_get_contents(__DIR__.'/../Fixtures/config.yml'));

        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), array($yml['dwo_flagging_manager']));

        self::assertEquals('foo', $config['manager']);
        self::assertEquals('bar', $config['database']['connection']);
        self::assertEquals('foobar', $config['database']['table']);
    }

    public static function testDefaultValues()
    {
        $yml = Yaml::parse(file_get_contents(__DIR__.'/../Fixtures/config_empty.yml'));

        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), array($yml['dwo_flagging_manager']));

        self::assertEquals('DwoFlaggingManagerBundle::index.html.twig', $config['index_template']);
        self::assertEquals('dwo_flagging_manager.manager.feature.db', $config['manager']);
        self::assertEquals('doctrine.dbal.default_connection', $config['database']['connection']);
        self::assertEquals('features', $config['database']['table']);
    }
}