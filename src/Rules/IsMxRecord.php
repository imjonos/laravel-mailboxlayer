<?php

namespace Nos\Mailboxlayer\Rules;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Nos\Mailboxlayer\Services\MailboxEmailService;

final class IsMxRecord implements Rule
{
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
            $mailboxEmail = $this->getMailboxEmailService()->getByEmail($value);
            $result = $mailboxEmail->mx_records;
        }

        return $result;
    }

    /**
     * @throws BindingResolutionException
     */
    private function getMailboxEmailService(): MailboxEmailService
    {
        return app()->make(MailboxEmailService::class);
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
