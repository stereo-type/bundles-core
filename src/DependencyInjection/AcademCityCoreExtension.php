<?php

/**
 * @copyright  2024 Zhalayletdinov Vyacheslav evil_tut@mail.ru
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
declare(strict_types=1);

namespace AcademCity\CoreBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Filesystem\Filesystem;

class AcademCityCoreExtension extends Extension
{
    private const PERMISSIONS_MASK = 0755;
    public function load(array $configs, ContainerBuilder $container): void
    {
        $filesystem = new Filesystem();
        $projectRoot = $container->getParameter('kernel.project_dir');
        $subDir = DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'packages';
        $filename = 'academ_city_core_bundle.yaml';
        $projectConfigDir = $projectRoot . $subDir;
        $targetConfigFile = $projectConfigDir . DIRECTORY_SEPARATOR . $filename;
        $bundleConfigFile = (__DIR__ . '/../Resources' . $subDir . DIRECTORY_SEPARATOR . $filename);
        if (!$filesystem->exists($projectConfigDir)) {
            $filesystem->mkdir($projectConfigDir, self::PERMISSIONS_MASK);
        }

        if (!$filesystem->exists($targetConfigFile)) {
            $filesystem->copy($bundleConfigFile, $targetConfigFile);
        }

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.yaml');

        $container->setParameter('academ_city_core.user_class', $config['user_class']);
    }
}
