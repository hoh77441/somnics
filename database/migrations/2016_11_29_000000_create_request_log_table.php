<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Model\RequestLog;

class CreateRequestLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(RequestLog::TABLE, function (Blueprint $table) {
            $table->increments(RequestLog::ID);
            $table->string(RequestLog::FROM)->nullable();
            $table->string(RequestLog::TASK)->nullable();
            $table->string(RequestLog::SUB_TASK)->nullable();
            $table->text(RequestLog::MESSAGE)->nullable();
            $table->text(RequestLog::RESULT)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(RequestLog::TABLE);
    }
}
