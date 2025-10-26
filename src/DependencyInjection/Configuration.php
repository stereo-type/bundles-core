<?php

/**
 * @copyright  2024 Zhalayletdinov Vyacheslav evil_tut@mail.ru
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
declare(strict_types=1);

namespace Slcorp\CoreBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('academ_city_core');
        $root = $treeBuilder->getRootNode();
        $root
            ->children()
                ->scalarNode('user_class')
                    ->defaultValue('App\Entity\User')
                ->end()
            ->end();
        return $treeBuilder;
    }
}
