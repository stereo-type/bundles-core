<?php

/**
 * @copyright  2024 Zhalayletdinov Vyacheslav evil_tut@mail.ru
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
declare(strict_types=1);

namespace AcademCity\CoreBundle;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class AcademCityCoreBundle extends AbstractBundle
{
    private const PERMISSIONS_MASK = 0755;


    public function boot(): void
    {
        parent::boot();

        $filesystem = new Filesystem();
        $container = $this->container;

        $projectRoot = $container->getParameter('kernel.project_dir');
        $subDir = "/config/packages";
        $filename = "academcity_core.yaml";
        $projectConfigDir = $projectRoot . $subDir;
        $targetConfigFile = $projectConfigDir . "/$filename";
        $bundleConfigFile = __DIR__ . "/../Resources/config/packages/$filename";

        if (!$filesystem->exists($projectConfigDir)) {
            $filesystem->mkdir($projectConfigDir, self::PERMISSIONS_MASK);
        }

        if (!$filesystem->exists($targetConfigFile)) {
            $filesystem->copy($bundleConfigFile, $targetConfigFile);
        }
    }

    public function configure(DefinitionConfigurator $definition): void
    {
        /** @var ArrayNodeDefinition $root*/
        $root = $definition->rootNode();
        $root
            ->children()
                ->scalarNode('user_class')->end()
            ->end();
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container
            ->parameters()
            ->set('academ_city_core.user_class', $config['user_class']);
    }
}
