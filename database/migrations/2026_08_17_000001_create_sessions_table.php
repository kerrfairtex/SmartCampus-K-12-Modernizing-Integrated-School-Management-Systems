<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration
{
    /**
     * Sessions stored in Postgres instead of the ephemeral container
     * filesystem (Railway wipes storage/ on every restart/redeploy, which
     * silently breaks file-backed sessions -> CSRF 419 / login failures).
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
