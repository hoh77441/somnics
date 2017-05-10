<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Model\UserHasConsole;
use App\Model\User;
use App\Model\Console;

class CreateUserHasConsoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(UserHasConsole::TABLE, function (Blueprint $table) {
            $table->integer(UserHasConsole::USER_ID)->unsigned()->nullable();
            $table->foreign(UserHasConsole::USER_ID)->references(User::ID)->on(User::TABLE);
            
            $table->string(UserHasConsole::SERIAL_NO)->nullable();
            $table->foreign(UserHasConsole::SERIAL_NO)->references(Console::SERIAL_NO)->on(Console::TABLE);
            
            $table->dateTime(UserHasConsole::APP_TIME)->nullable();
            
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
        Schema::dropIfExists(UserHasConsole::TABLE);
    }
}
