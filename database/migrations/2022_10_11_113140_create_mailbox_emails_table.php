<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateMailboxEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('mailbox_emails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->boolean('can_connect_smtp');
            $table->string('domain');
            $table->boolean('free');
            $table->boolean('is_catch_all');
            $table->boolean('is_deliverable');
            $table->boolean('is_disabled');
            $table->boolean('is_disposable');
            $table->boolean('is_inbox_full');
            $table->boolean('is_role_account');
            $table->boolean('mx_records');
            $table->float('score');
            $table->boolean('syntax_valid');
            $table->string('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('mailbox_emails');
    }
}
