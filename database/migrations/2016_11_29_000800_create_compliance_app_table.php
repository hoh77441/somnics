<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Model\ComplianceApp;
use App\Model\User;

class CreateComplianceAppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ComplianceApp::TABLE, function (Blueprint $table) {
            $table->increments(ComplianceApp::ID);
            $table->integer(ComplianceApp::USER_ID)->unsigned()->nullable();
            $table->foreign(ComplianceApp::USER_ID)->references(User::ID)->on(User::TABLE);
            
            $table->string(ComplianceApp::SERIAL_NO);
            $table->string(ComplianceApp::APP_VERSION)->nullable();
            
            $table->dateTime(ComplianceApp::START);
            $table->dateTime(ComplianceApp::END)->nullable();
            $table->integer(ComplianceApp::TREATMENT)->nullable();
            $table->integer(ComplianceApp::LEAKAGE)->nullable();
            $table->integer(ComplianceApp::CONSOLE_TREATMENT)->nullable();
            $table->integer(ComplianceApp::CONSOLE_LEAKAGE)->nullable();
            $table->integer(ComplianceApp::TIME_ZONE)->nullable();
            
            $table->double(ComplianceApp::LATITUDE)->nullable();
            $table->double(ComplianceApp::LONGITUDE)->nullable();
            $table->tinyInteger(ComplianceApp::IS_NEW_ASSIGN)->nullable();
            
            $table->dateTime(ComplianceApp::CONSOLE_START)->nullable();
            $table->dateTime(ComplianceApp::ARCHIVE_DATE)->nullable();
            
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
        Schema::dropIfExists(ComplianceApp::TABLE);
    }
}
