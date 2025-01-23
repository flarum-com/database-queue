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

namespace FlarumCom\DatabaseQueue\Tests\integration\api;

use Flarum\Testing\integration\ConsoleTestCase;
use PHPUnit\Framework\Attributes\Test;

class StatsTest extends ConsoleTestCase
{
    public function setUp(): void
    {
        $this->extension('blomstra-database-queue');
    }

    #[Test]
    public function non_admin_cannot_access_stats()
    {
        $response = $this->send($this->request(
            'GET',
            '/api/database-queue/stats'
        ));

        $this->assertEquals(404, $response->getStatusCode());
    }

    #[Test]
    public function admin_can_access_stats()
    {
        $response = $this->send($this->request(
            'GET',
            '/api/database-queue/stats',
            [
                'authenticatedAs' => 1,
            ]
        ));

        $this->assertEquals(200, $response->getStatusCode());

        $body = json_decode($response->getBody(), true);

        $this->assertEquals('default', $body['queue']);
        $this->assertEquals('inactive', $body['status']);
        $this->assertEquals(0, $body['pendingJobs']);
        $this->assertEquals(0, $body['failedJobs']);
    }

    #[Test]
    public function admin_can_access_stats_with_queue()
    {
        $commandOutput = $this->runCommand(['command' => 'queue:work', '--stop-when-empty' => true]);

        $this->assertEmpty($commandOutput);

        $response = $this->send($this->request(
            'GET',
            '/api/database-queue/stats',
            [
                'authenticatedAs' => 1,
            ]
        ));

        $this->assertEquals(200, $response->getStatusCode());

        $body = json_decode($response->getBody(), true);

        $this->assertEquals('default', $body['queue']);
        $this->assertEquals('running', $body['status']);
        $this->assertEquals(0, $body['pendingJobs']);
        $this->assertEquals(0, $body['failedJobs']);
    }
}
