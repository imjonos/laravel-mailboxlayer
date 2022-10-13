<?php

namespace Nos\Mailboxlayer;

use Illuminate\Support\ServiceProvider;
use Nos\Mailboxlayer\Adapters\GuzzleHttpClientAdapter;
use Nos\Mailboxlayer\Interfaces\Adapters\HttpClientAdapterInterface;
use Nos\Mailboxlayer\Interfaces\Repositories\MailboxEmailRepositoryInterface;
use Nos\Mailboxlayer\Repositories\MailboxEmailRepository;

final class MailboxlayerServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(resource_path('lang/vendor/nos/mailboxlayer'), 'nos.mailboxlayer');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/nos/mailboxlayer'),
        ], 'mailboxlayer.lang');

        $this->publishes([
            __DIR__ . '/../config/mailboxlayer.php' => config_path('mailboxlayer.php'),
        ], 'mailboxlayer.config');

        $this->publishes([
            __DIR__ . '/../database/migrations' => base_path('database/migrations'),
        ], 'mailboxlayer.migrations');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/mailboxlayer.php', 'mailboxlayer');
        $this->app->bind(MailboxEmailRepositoryInterface::class, MailboxEmailRepository::class);
        $this->app->bind(HttpClientAdapterInterface::class, GuzzleHttpClientAdapter::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['mailboxlayer'];
    }
}
