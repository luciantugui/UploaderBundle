<?php

namespace Gus\UploaderBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class GusUploaderExtension
 * @package Gus\UploaderBundle\DependencyInjection
 */
class GusUploaderExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('gus_uploader.media_class', $config['media_class']);
        $container->setParameter('gus_uploader.uploads_dir', $config['uploads_dir']);

        foreach ($config['settings'] as $key => $value) {
            $container->setParameter("gus_uploader.settings.$key", $value);
        }

        $asseticBundles = $container->getParameter('assetic.bundles');
        $asseticBundles[]  = 'GusUploaderBundle';
        $container->setParameter('assetic.bundles', $asseticBundles);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}