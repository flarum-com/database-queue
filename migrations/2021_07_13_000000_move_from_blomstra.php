<?php declare(strict_types=1);

use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        $schema
            ->getConnection()
            ->table('migrations')
            ->where('extension', 'blomstra-database-queue')
            ->update(['extension' => 'flarum-com-database-queue']);
    },
    'down' => function (Builder $schema) {
        $schema
            ->getConnection()
            ->table('migrations')
            ->where('extension', 'flarum-com-database-queue')
            ->update(['extension' => 'blomstra-database-queue']);
    }
];