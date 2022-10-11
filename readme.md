# Laravel Email Verification

Validator based on api https://apilayer.com/marketplace/email_verification-api

## Installation

Via Composer

``` bash
$ composer require imjonos/laravel-mailboxlayer

```

## Usage

use Nos\Mailboxlayer\Rules\IsMxRecord;

```
public function rules(): array
{
    return [
        'email' => ['required', new IsMxRecord()],
    ];
}

```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## License

license. Please see the [license file](license.md) for more information.
