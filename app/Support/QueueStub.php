<?php

namespace App\Support;

use Illuminate\Contracts\Queue\Factory as QueueFactory;

/**
 * Minimal queue stub implementing the Queue Factory contract.
 * Methods are no-ops and exist only to satisfy container type hints during tests.
 */
class QueueStub implements QueueFactory
{
    public function connection($name = null)
    {
        return $this;
    }

    public function push($job, $data = '', $queue = null)
    {
        return null;
    }

    public function pushOn($queue, $job, $data = '')
    {
        return null;
    }

    public function later($delay, $job, $data = '', $queue = null)
    {
        return null;
    }

    public function laterOn($queue, $delay, $job, $data = '')
    {
        return null;
    }

    public function pop($queue = null)
    {
        return null;
    }
}
