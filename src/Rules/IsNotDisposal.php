<?php

namespace Nos\Mailboxlayer\Rules;

use Nos\Mailboxlayer\Models\MailboxEmail;

final class IsNotDisposal extends BaseRule
{
    public function validateEmail(MailboxEmail $mailboxEmail): bool
    {
        return !$mailboxEmail->is_disposable;
    }
}
