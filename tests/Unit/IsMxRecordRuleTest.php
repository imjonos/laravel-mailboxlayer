<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\TestCase;

final class IsMxRecordRuleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @throws ValidationException
     */
    public function ruleTest(): void
    {
        $validator = Validator::make([
            'email' => 'info@toprogram.ru'
        ], [
            'email' => 'email'
        ]);

        $validator->validate();

        $this->assertTrue(!$validator->fails());
    }
}
