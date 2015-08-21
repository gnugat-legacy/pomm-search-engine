<?php

/*
 * This file is part of the gnugat/pomm-search-engine package.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gnugat\PommSearchEngine;

use Gnugat\SearchEngine\Fetcher;
use PommProject\Foundation\QueryManager\QueryManagerInterface;

class PommFetcher implements Fetcher
{
    /**
     * @var QueryManagerInterface
     */
    private $queryManager;

    /**
     * @param QueryManagerInterface $queryManager
     */
    public function __construct(QueryManagerInterface $queryManager)
    {
        $this->queryManager = $queryManager;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll($sql, array $parameters)
    {
        return iterator_to_array($this->getPommIterator($sql, $parameters));
    }

    /**
     * {@inheritdoc}
     */
    public function fetchFirst($sql, array $parameters)
    {
        $result = $this->getPommIterator($sql, $parameters)->current();

        return $result;
    }

    /**
     * @param string $sql
     * @param array  $parameters
     *
     * @return \PDOStatement
     */
    private function getPommIterator($sql, array $parameters)
    {
        $pommParameters = array();
        foreach ($parameters as $parameter) {
            $sql = str_replace($parameter['name'], '$*', $sql);
            $pommParameters[] = $parameter['value'];
        }

        return $this->queryManager->query($sql, $pommParameters);
    }
}
