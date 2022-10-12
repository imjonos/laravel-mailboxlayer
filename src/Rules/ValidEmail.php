<?php

namespace Nos\Mailboxlayer\Rules;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Nos\Mailboxlayer\Models\MailboxEmail;

final class ValidEmail extends BaseRule
{
    /**
     * @throws ValidationException
     */
    public function validateEmail(MailboxEmail $mailboxEmail): bool
    {
        $validator = Validator::make([
            'email' => $mailboxEmail->email
        ], [
            'email' => [new IsMxRecord(), new IsNotDisposal()]
        ]);

        $validator->validate();

        return !$validator->fails();
    }
}
