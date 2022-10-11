<?php

namespace Nos\Mailboxlayer\Interfaces\Repositories;

use Nos\BaseRepository\Interfaces\EloquentRepositoryInterface;
use Nos\Mailboxlayer\Models\MailboxEmail;

interface MailboxEmailRepositoryInterface extends EloquentRepositoryInterface
{
    public function findByEmail(string $email): ?MailboxEmail;
}
