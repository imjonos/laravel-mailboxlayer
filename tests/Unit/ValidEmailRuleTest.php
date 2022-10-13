<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Nos\Mailboxlayer\Rules\ValidEmail;
use Tests\TestCase;

final class ValidEmailRuleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     * @throws ValidationException
     */
    public function test_rule(): void
    {
        $validator = Validator::make([
            'email' => 'info@toprogram.ru'
        ], [
            'email' => new ValidEmail()
        ]);

        $validator->validate();

        $this->assertTrue(!$validator->fails());
    }
}
