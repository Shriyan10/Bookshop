<?php

namespace App\response;

class ServerResponse implements \JsonSerializable
{
    public mixed $data;
    public string|null $message;

    public function __construct(mixed $data = null, mixed $message = null)
    {
        $this->data = $data;
        $this->message = $message;
    }

    public function jsonSerialize(): array
    {
        $response = [];
        if (!empty($this->data) || $this->data === 0) {
            $response['data'] = $this->data;
        }
        if (!empty($this->message)) {
            $response['message'] = $this->message;
        }
        return $response;
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData(mixed $data): void
    {
        $this->data = $data;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }
}
