<?php

namespace Gus\UploaderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Gus\UploaderBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('gus_uploader');

        $rootNode
            ->children()
                ->scalarNode('media_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('uploads_dir')->isRequired()->cannotBeEmpty()->end()
                ->arrayNode('settings')
                    ->children()
                        ->scalarNode('upload_dir')
                            ->defaultValue('files/')
                        ->end()
                        ->scalarNode('upload_url')
                            ->defaultValue('/files/')
                        ->end()
                        ->booleanNode('user_dirs')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('inline_file_types')
                            ->defaultValue('/\.(gif|jpe?g|png)$/i')
                        ->end()
                        ->scalarNode('accept_file_types')
                            ->defaultValue('/.+$/i')
                        ->end()
                        ->booleanNode('download_via_php')
                            ->defaultFalse()
                        ->end()
                        ->booleanNode('print_response')
                            ->defaultTrue()
                        ->end()
                        ->scalarNode('mkdir_mode')
                            ->defaultValue(0755)
                        ->end()
                        ->scalarNode('readfile_chunk_size')
                            ->defaultValue(10485760)
                        ->end()
                        ->scalarNode('max_file_size')
                            ->defaultValue(null)
                        ->end()
                        ->scalarNode('min_file_size')
                            ->defaultValue(1)
                        ->end()
                        ->scalarNode('max_number_of_files')
                            ->defaultValue(null)
                        ->end()
                        ->booleanNode('correct_image_extensions')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('max_width')
                            ->defaultValue(null)
                        ->end()
                        ->scalarNode('max_height')
                            ->defaultValue(null)
                        ->end()
                        ->scalarNode('min_width')
                            ->defaultValue(1)
                        ->end()
                        ->scalarNode('min_height')
                            ->defaultValue(1)
                        ->end()
                        ->booleanNode('discard_aborted_uploads')
                            ->defaultTrue()
                        ->end()
                        ->scalarNode('image_library')
                            ->defaultValue(1)
                        ->end()
                        ->arrayNode('image_versions')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->children()
                                ->arrayNode('original')
                                    ->isRequired()
                                    ->children()
                                        ->booleanNode('auto_orient')
                                            ->defaultTrue()
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('medium')
                                    ->children()
                                        ->scalarNode('max_width')
                                            ->isRequired()
                                            ->cannotBeEmpty()
                                        ->end()
                                        ->scalarNode('max_height')
                                            ->isRequired()
                                            ->cannotBeEmpty()
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('thumbnail')
                                    ->children()
                                        ->scalarNode('max_width')
                                            ->isRequired()
                                            ->cannotBeEmpty()
                                        ->end()
                                        ->scalarNode('max_height')
                                            ->isRequired()
                                            ->cannotBeEmpty()
                                        ->end()
                                        ->booleanNode('crop')
                                            ->defaultFalse()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}