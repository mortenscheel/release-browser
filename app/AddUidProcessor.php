<?php

namespace App;

use Monolog\Processor\UidProcessor;

class AddUidProcessor
{
    /**
     * Customize the given logger instance.
     *
     * @param \Illuminate\Log\Logger $logger
     * @return void
     */
    public function __invoke($logger)
    {
        $logger->pushProcessor(new UidProcessor());
        /** @var \Monolog\Handler\StreamHandler $handler */
        foreach ($logger->getHandlers() as $handler) {
            // $handler->pushProcessor(new UidProcessor());
        }
    }
}
