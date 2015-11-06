<?php

namespace Dwo\FlaggingManagerBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @author Dave Www <davewwwo@gmail.com>
 */
class DwoFlaggingManagerExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services/handler.yml');
        $loader->load('services/manager.yml');
        $loader->load('services/validator.yml');
        $loader->load('services/cache_warmer.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setAlias('dwo_flagging_manager.manager', $config['manager']);

        $container->setAlias('dwo_flagging_manager.db.connection', $config['database']['connection']);
        $container->setParameter('dwo_flagging_manager.db.table', $config['database']['table']);
        $container->setParameter('dwo_flagging_manager.index_template', $config['index_template']);
    }
}
