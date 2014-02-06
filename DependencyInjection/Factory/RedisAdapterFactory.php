<?php

namespace Knp\Bundle\GaufretteBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

class RedisAdapterFactory implements AdapterFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container
            ->setDefinition($id, new DefinitionDecorator('knp_gaufrette.adapter.redis'))
            ->addArgument(new Reference($config['service_id']))
            ->addArgument($config['options'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'redis';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('service_id')->isRequired()->cannotBeEmpty()->end()
                ->arrayNode('options')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('ttl')->defaultValue('3600')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
