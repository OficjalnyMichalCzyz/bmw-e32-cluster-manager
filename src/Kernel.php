<?php

declare(strict_types=1);

namespace E32CM;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

function log(string $message): void
{
    echo($message . PHP_EOL);
}

function DEBUG_logChar(string $message, ?int $position): void
{
    if (is_null($position)) {
        echo $message;
        return;
    }

    echo(mb_substr($message, $position, 1, 'UTF-8'));
}

class Kernel extends BaseKernel
{
    const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    use MicroKernelTrait;

    /**
     * {@inheritdoc}
     */
    public function registerBundles(): iterable
    {
        $contents = require ($this->getApplicationConfigDirectory() . '/bundles.php');
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }
    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->setParameter('container.autowiring.strict_mode', true);

        $applicationConfigDirectory = $this->getApplicationConfigDirectory();

        $loader->load($applicationConfigDirectory . '/packages/*' . self::CONFIG_EXTS, "glob");
        $loader->load($applicationConfigDirectory . '/container/*' . self::CONFIG_EXTS, "glob");
    }
    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $applicationConfigDirectory = $this->getApplicationConfigDirectory();

        $routes->import($applicationConfigDirectory . '/{routes}/'.$this->environment.'/*.yaml');
        $routes->import($applicationConfigDirectory . '/{routes}/*.yaml');
        $routes->import($applicationConfigDirectory . '/routes.yaml');
    }
    private function getApplicationConfigDirectory(): string
    {
        return $this->getProjectDir() . '/config/application';
    }
}
