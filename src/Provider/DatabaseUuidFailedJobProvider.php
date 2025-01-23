<?php

/*
 * This file is part of blomstra/database-queue
 *
 * Copyright (c) 2023 Blomstra Ltd.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 */

namespace FlarumCom\DatabaseQueue\Provider;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\ConnectionResolverInterface;

class DatabaseUuidFailedJobProvider extends \Illuminate\Queue\Failed\DatabaseUuidFailedJobProvider
{
    public function __construct(ConnectionResolverInterface $resolver, $database, $table, protected ConnectionInterface $connection)
    {
        parent::__construct($resolver, $database, $table);
    }

    /**
     * Get a new query builder instance for the table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getTable()
    {
        return $this->connection->table($this->table);
    }
}
