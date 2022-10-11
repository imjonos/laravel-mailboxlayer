<?php

namespace Nos\Mailboxlayer\Services;

use Exception;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Container\BindingResolutionException;
use LogicException;
use Nos\BaseService\BaseService;
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
     * @throws Exception|GuzzleException
     */
    public function getByEmail(string $email): MailboxEmail
    {
        $mailboxEmail = $this->getRepository()->findByEmail($email);
        if (!$mailboxEmail) {
            $data = $this->getEmailData($email);

            $mailboxEmail = $this->create([
                'email' => $data['email'] ?? '',
                'can_connect_smtp' => (int) ($data['can_connect_smtp'] ?? 0),
                'domain' => $data['domain'] ?? '',
                'free' => (int) ($data['free'] ?? 0),
                'is_catch_all' => (int) ($data['is_catch_all'] ?? 0),
                'is_deliverable' => (int) ($data['is_deliverable'] ?? 0),
                'is_disabled' => (int) ($data['is_disabled'] ?? 0),
                'is_disposable' => (int) ($data['is_disposable'] ?? 0),
                'is_inbox_full' => (int) ($data['is_inbox_full'] ?? 0),
                'is_role_account' => (int) ($data['is_role_account'] ?? 0),
                'mx_records' => (int) ($data['mx_records'] ?? 0),
                'score' => $data['score'] ?? 0,
                'syntax_valid' => (int) ($data['syntax_valid'] ?? 0),
                'user' => $data['user'] ?? ''
            ]);
        }

        return $mailboxEmail;
    }

    /**
     * @throws GuzzleException
     */
    public function getEmailData(string $email): array
    {
        $params = [
            'headers' => [
                'Content-Type' => 'text/plain',
                'apikey' => $this->apiKey
            ]
        ];

        $client = new GuzzleHttpClient();
        $response = $client->get('https://api.apilayer.com/email_verification/' . $email, $params);

        if ($response->getStatusCode() !== 200) {
            throw new LogicException('API request issue!');
        }

        return json_decode((string) $response->getBody(), true);
    }
}
