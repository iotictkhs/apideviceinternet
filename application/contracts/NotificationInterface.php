<?php

namespace App\Contracts;

interface NotificationInterface
{
    /**
     * Set message.
     *
     * @param string $message
     */
    public function withMessage($message);

    /**
     * Set receivers.
     *
     * @param string $receiver
     */
    public function withReceiver($receiver);


    /**
     * Send a message to the target.
     */
    public function send();
}
