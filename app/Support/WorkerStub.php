<?php
namespace App\Support;

use Illuminate\Queue\Worker;
use Illuminate\Queue\WorkerOptions;

/**
 * Worker stub that extends Illuminate\Queue\Worker with minimal constructor to satisfy type hints.
 * Methods are no-ops and exist only to satisfy container during test bootstrap.
 */
class WorkerStub extends Worker
{
    public function __construct()
    {
        // Worker requires several dependencies; we call parent with nulls where allowed by signature
        // but to be safe we bypass heavy initialization and avoid calling parent constructor.
    }

    public function runNextJob($connectionName, $queue = null, WorkerOptions $options = null)
    {
        // no-op: do not execute any jobs during test bootstrap
        return null;
    }
}
