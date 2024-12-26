<?php

/**
 * @copyright  2024 Zhalayletdinov Vyacheslav evil_tut@mail.ru
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
declare(strict_types=1);

namespace AcademCity\CoreBundle\DependencyInjection;

use InvalidArgumentException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class AcademCityCoreExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        if (!$config['user_class']) {
            throw new InvalidArgumentException(
                'The "user_class" must be configured'
            );
        }

        $loader = new YamlFileLoader($container, new FileLocator(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'config'));
        $loader->load('services.yaml');
        $container->setParameter('academ_city_core.user_class', $config['user_class']);
    }
}
