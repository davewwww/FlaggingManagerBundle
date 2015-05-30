<?php

namespace Dwo\FlaggingManagerBundle\Tests\Fixtures;

use Dwo\FlaggingManagerBundle\DependencyInjection\DwoFlaggingManagerExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\MergeExtensionConfigurationPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class Container
{
    public static function createContainer(array $data = array())
    {
        $containerBuilder = new ContainerBuilder(
            new ParameterBag(
                array_merge(
                    array(
                        'kernel.bundles'     => array(
                            'DwoFlaggingBundle' => 'Dwo\\FlaggingManagerBundle\\DwoFlaggingManagerBundle',
                        ),
                        'kernel.cache_dir'   => __DIR__,
                        'kernel.debug'       => false,
                        'kernel.environment' => 'test',
                        'kernel.name'        => 'kernel',
                        'kernel.root_dir'    => __DIR__,
                    ),
                    $data
                )
            )
        );

        return $containerBuilder;
    }

    /**
     * @param array $configs
     * @param array $data
     *
     * @return ContainerBuilder
     */
    public static function createContainerFromFixtures($configs = array('config.yml'), $data = array())
    {
        $container = self::createContainer($data);
        $container->registerExtension(new DwoFlaggingManagerExtension());

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
        foreach ($configs as $config) {
            $loader->load($config);
        }

        $container->addCompilerPass(new MergeExtensionConfigurationPass());
        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());
        $container->compile();

        return $container;
    }
}
