<?php

/**
 * @copyright  2024 Zhalayletdinov Vyacheslav evil_tut@mail.ru
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
declare(strict_types=1);

namespace CoreBundle;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class CoreBundle extends AbstractBundle
{
    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
                   ->children()
                        ->arrayNode('core_bundle')
                            ->children()
                                ->scalarNode('user_class')->end()
                            ->end()
                        ->end()
                   ->end();
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
//        $container->import('../config/services.yaml');
//
        $container
            ->parameters()
            ->set('core_bundle.user_class', $config['user_class']);

//        $container->services()
//                  ->get('acme_social.twitter_client')
//                  ->arg(0, $config['twitter']['client_id'])
//                  ->arg(1, $config['twitter']['client_secret'])

    }
}
