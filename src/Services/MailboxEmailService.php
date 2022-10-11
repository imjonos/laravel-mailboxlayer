<?php

namespace Nos\Mailboxlayer\Services;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Http;
use Nos\CRUD\Services\BaseService;
use Nos\Mailboxlayer\Interfaces\Repositories\MailboxEmailRepositoryInterface;
use Nos\Mailboxlayer\Models\MailboxEmail;

/**
 * @method MailboxEmailRepositoryInterface getRepository()
 * @method MailboxEmail create(array $data)
 * @method MailboxEmail find(int $modelId)
 */
final class MailboxEmailService extends BaseService
{
    protected string $repositoryClass = MailboxEmailRepositoryInterface::class;
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('mailboxlayer.api_key');
    }

    /**
     * @throws BindingResolutionException
     */
    public function getByEmail(string $email): MailboxEmail
    {
        $mailboxEmail = $this->getRepository()->findByEmail($email);
        if (!$mailboxEmail) {
            $data = $this->getEmailData($email);

            $mailboxEmail = $this->create([
                'email' => $data['email'],
                'can_connect_smtp' => $data['can_connect_smtp'],
                'domain' => $data['domain'],
                'free' => $data['free'],
                'is_catch_all' => $data['is_catch_all'],
                'is_deliverable' => $data['is_deliverable'],
                'is_disabled' => $data['is_disabled'],
                'is_disposable' => $data['is_disposable'],
                'is_inbox_full' => $data['is_inbox_full'],
                'is_role_account' => $data['is_role_account'],
                'mx_records' => $data['mx_records'],
                'score' => $data['score'],
                'syntax_valid' => $data['syntax_valid'],
                'user' => $data['user']
            ]);
        }

        return $mailboxEmail;
    }

    public function getEmailData(string $email): array
    {
        $response = Http::withHeaders([
            'Content-Type' => 'text/plain',
            'apikey' => $this->apiKey
        ])->get('https://api.apilayer.com/email_verification/' . $email);

        return $response->json() ?? [];
    }
}
