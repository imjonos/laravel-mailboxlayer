<?php

namespace Nos\Mailboxlayer\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $email
 * @property bool $can_connect_smtp
 * @property string $domain
 * @property bool $free
 * @property bool $is_catch_all
 * @property bool $is_deliverable
 * @property bool $is_disabled
 * @property bool $is_disposable
 * @property bool $is_inbox_full
 * @property bool $is_role_account
 * @property bool $mx_records
 * @property float $score
 * @property bool $syntax_valid
 * @property string $user
 */
final class MailboxEmail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'can_connect_smtp',
        'domain',
        'free',
        'is_catch_all',
        'is_deliverable',
        'is_disabled',
        'is_disposable',
        'is_inbox_full',
        'is_role_account',
        'mx_records',
        'score',
        'syntax_valid',
        'user'
    ];
}
