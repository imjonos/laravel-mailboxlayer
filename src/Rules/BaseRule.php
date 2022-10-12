<?php

namespace Nos\Mailboxlayer\Rules;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Nos\Mailboxlayer\Models\MailboxEmail;
use Nos\Mailboxlayer\Services\MailboxEmailService;

abstract class BaseRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     * @throws ValidationException
     * @throws BindingResolutionException
     * @throws GuzzleException
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
            $result = $this->validateEmail($mailboxEmail);
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

    abstract public function validateEmail(MailboxEmail $mailboxEmail): bool;

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return trans('nos.mailboxlayer::mailboxlayer.validation.email_not_correct');
    }
}
