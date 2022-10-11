<?php

namespace Nos\Mailboxlayer\Rules;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Nos\Mailboxlayer\Services\MailboxEmailService;

final class IsMxRecord implements Rule
{
    private MailboxEmailService $mailboxEmailService;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(MailboxEmailService $mailboxEmailService)
    {
        $this->mailboxEmailService = $mailboxEmailService;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     * @throws ValidationException
     * @throws BindingResolutionException
     */
    public function passes($attribute, $value): bool
    {
        $result = false;

        $validator = Validator::make([
            $attribute => $value
        ], [
            $attribute => 'email'
        ]);

        $validator->validate();

        if (!$validator->fails()) {
            $mailboxEmail = $this->mailboxEmailService->getByEmail($value);
            $result = $mailboxEmail->mx_records;
        }

        return $result;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return trans('nos.mailboxlayer::validation.email_not_correct');
    }
}
