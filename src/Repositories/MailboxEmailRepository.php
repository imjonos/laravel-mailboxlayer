<?php

namespace Nos\Mailboxlayer\Repositories;

use Nos\CRUD\Repositories\BaseRepository;
use Nos\Mailboxlayer\Interfaces\Repositories\MailboxEmailRepositoryInterface;
use Nos\Mailboxlayer\Models\MailboxEmail;

/**
 * @method MailboxEmail getModel()
 */
final class MailboxEmailRepository extends BaseRepository implements MailboxEmailRepositoryInterface
{
    protected string $class = MailboxEmail::class;

    public function findByEmail(string $email): ?MailboxEmail
    {
        return $this->query()->whereEmail($email)->first();
    }
}
