<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Nos\Mailboxlayer\Rules\IsMxRecord;
use Tests\TestCase;

final class IsMxRecordRuleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     * @throws ValidationException
     */
    public function test_rule(): void
    {
        $validator = Validator::make([
            'email' => 'info@toprogram.ru'
        ], [
            'email' => new IsMxRecord()
        ]);

        $validator->validate();

        $this->assertTrue(!$validator->fails());
    }
}
