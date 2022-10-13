<?php

namespace Nos\Mailboxlayer\Interfaces\Adapters;

interface HttpClientAdapterInterface
{
    public function get(string $url, array $params = []): array;
}
