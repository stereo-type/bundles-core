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
use Symfony\Component\Filesystem\Filesystem;

class AcademCityCoreBundleExtension extends Extension
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
        $bundleConfigFile = (__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . $subDir . DIRECTORY_SEPARATOR . $filename);

        if (!$filesystem->exists($projectConfigDir)) {
            $filesystem->mkdir($projectConfigDir, self::PERMISSIONS_MASK);
        }

        if (!$filesystem->exists($targetConfigFile)) {
            $filesystem->copy($bundleConfigFile, $targetConfigFile);
        }

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

//        // Загружаем сервисы
//        $loader = new YamlFileLoader($container, new FileLocator($projectRoot.'/config/packages/academcity'));
//        $loader->load('core_bundle.yaml');
//
//        // Сохраняем параметр в контейнере
//        $container->setParameter('core_bundle.user_class', $config['user_class']);
    }
}
