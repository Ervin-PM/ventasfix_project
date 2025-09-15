<?php
namespace App\Support;

use Illuminate\Queue\Listener as BaseListener;

class ListenerStub extends BaseListener
{
    public function __construct($commandPath = null)
    {
        parent::__construct($commandPath ?? base_path());
    }
}
