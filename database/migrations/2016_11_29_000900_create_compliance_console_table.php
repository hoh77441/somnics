<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Model\ComplianceConsole;
use App\Model\Console;
use App\Model\User;
use App\Model\ComplianceApp;

class CreateComplianceConsoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ComplianceConsole::TABLE, function (Blueprint $table) {
            $table->increments(ComplianceConsole::ID);
            
            $table->string(ComplianceConsole::SERIAL_NO)->nullable();
            $table->foreign(ComplianceConsole::SERIAL_NO)->references(Console::SERIAL_NO)->on(Console::TABLE);
            
            $table->integer(ComplianceConsole::USER_ID)->unsigned()->nullable();
            $table->foreign(ComplianceConsole::USER_ID)->references(User::ID)->on(User::TABLE);
            
            $table->integer(ComplianceConsole::APP_ID)->unsigned()->nullable();
            //$table->foreign(ComplianceConsole::APP_ID)->references(ComplianceApp::ID)->on(ComplianceApp::TABLE);  //for assign 0
            
            $table->dateTime(ComplianceConsole::START)->nullable();
            $table->dateTime(ComplianceConsole::END)->nullable();
            $table->integer(ComplianceConsole::TREATMENT)->nullable();
            $table->integer(ComplianceConsole::LEAKAGE)->nullable();
            $table->integer(ComplianceConsole::TIME_ZONE)->nullable();
            
            $table->dateTime(ComplianceConsole::ARCHIVE_DATE)->nullable();
            $table->integer(ComplianceConsole::APP_OR_CONSOLE)->nullable();
            $table->integer(ComplianceConsole::MATCH_APP_TIME)->nullable();
            
            $table->unique(array(ComplianceConsole::SERIAL_NO, ComplianceConsole::START));
            
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
        Schema::dropIfExists(ComplianceConsole::TABLE);
    }
}
