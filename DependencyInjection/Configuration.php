<?php

namespace BeSimple\SsoAuthBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $serverDefinition = $treeBuilder
            ->root('be_simple_sso_auth')
            ->fixXmlConfig('provider')
            ->useAttributeAsKey('id')
            ->prototype('array');

        $this->setComponentDefinition($serverDefinition, 'protocol');
        $this->setComponentDefinition($serverDefinition, 'server');

        return $treeBuilder;
    }

    /**
     * @param \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $serverDefinition
     * @param string                                                           $name
     */
    private function setComponentDefinition(ArrayNodeDefinition $serverDefinition, $name)
    {
        $serverDefinition
            ->children()
                ->arrayNode($name)
                    ->useAttributeAsKey('id')
                    ->beforeNormalization()
                        ->ifString()->then(function($value) {
                            return array('id' => $value);
                        })
                    ->end()
                    ->prototype('scalar');
    }
}
