<?php
namespace App\Supports;

use App\Contracts\NotificationInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class WANotification implements NotificationInterface
{
    const URL = 'https://app.whatspie.com/api/';

    const TOKEN = 'qN23C4YhBTbR4uV6AIqchAXYyivELIvfxEfwydumANI4vimXMs';

    const DEVICE = '628112545964';

    /**
     * @var string $device
     */
    public $device;

    /**
     * @var ?string $receiver
     */
    public $receiver;

    /**
     * @var ?string $message
     */
    public $message;

    /**
     * @var Client $client
     */
    protected $client;

    /**
     * @param string $device
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => static::URL,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Bearer ' . static::TOKEN,
            ],
        ]);
        $this->device = static::DEVICE;
        $this->receiver = null;
        $this->message = null;
    }

    /**
     * @param string $message
     */
    public function withMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    public function withReceiver($receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * @return Collection
     */
    public function send()
    {
        if ($this->receiver === null) {
            throw new \Exception('Receiver is empty.');
        }

        if ($this->message === null) {
            throw new \Exception('Message is empty.');
        }

        return json_decode($this->client->post('messages', [
            'form_params' => [
                'receiver' => $this->receiver,
                'device' => $this->device,
                'message' => $this->message,
                'type' => 'chat',
            ]
        ])->getBody()->getContents());
    }
}
