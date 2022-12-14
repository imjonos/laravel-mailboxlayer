<?php

namespace Nos\Mailboxlayer\Rules;

use Nos\Mailboxlayer\Models\MailboxEmail;

final class IsMxRecord extends BaseRule
{

    public function validateEmail(MailboxEmail $mailboxEmail): bool
    {
        return $mailboxEmail->mx_records;
    }
}
