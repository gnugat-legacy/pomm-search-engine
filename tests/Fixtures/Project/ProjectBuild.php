<?php

/*
 * This file is part of the gnugat/pomm-search-engine package.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gnugat\PommSearchEngine\Test\Fixtures\Project;

use Gnugat\PommSearchEngine\PommFetcher;
use Gnugat\SearchEngine\ResourceDefinition;
use PommProject\Foundation\Pomm;
use Symfony\Component\Yaml\Yaml;

class ProjectBuild
{
    /**
     * @return ResourceDefinition
     */
    public static function blogResourceDefinition()
    {
        return new ResourceDefinition(
            'blog',
            array(
                'id' => ResourceDefinition::TYPE_INTEGER,
                'title' => ResourceDefinition::TYPE_STRING,
                'author_id' => ResourceDefinition::TYPE_INTEGER,
            ),
            array('author')
        );
    }

    /**
     * @return ResourceDefinition
     */
    public static function blogSelectBuilder()
    {
        return new BlogSelectBuilder();
    }

    /**
     * @return PommFetcher
     */
    public static function fetcher()
    {
        return new PommFetcher(self::queryManager());
    }

    /**
     * @return \PommProject\Foundation\QueryManager\QueryManagerInterface
     */
    public static function queryManager()
    {
        $config = self::config();

        $pomm = new Pomm(array(
            $config['database'] => array(
                'dsn' => "pgsql://{$config['username']}:{$config['password']}@{$config['host']}:{$config['port']}/{$config['database']}",
                'class:session_builder' => '\PommProject\Foundation\SessionBuilder',
            ),
        ));

        return $pomm->getDefaultsession()->getQueryManager();
    }

    /**
     * @return array
     */
    public static function config()
    {
        $config = Yaml::parse(file_get_contents(__DIR__.'/config.yml'));

        return $config['parameters'];
    }
}
