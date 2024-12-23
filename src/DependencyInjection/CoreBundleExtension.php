<?php

/**
 * @copyright  2024 Zhalayletdinov Vyacheslav evil_tut@mail.ru
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
declare(strict_types=1);

namespace AcademCity\CoreBundleDependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class CoreBundleExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $projectRoot = $container->getParameter('kernel.project_dir');

        // Загружаем сервисы
        $loader = new YamlFileLoader($container, new FileLocator($projectRoot.'/config/packages/academcity'));
        $loader->load('core_bundle.yaml');

        // Сохраняем параметр в контейнере
        $container->setParameter('core_bundle.user_class', $config['user_class']);
    }
}
