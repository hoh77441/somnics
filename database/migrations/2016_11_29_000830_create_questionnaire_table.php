<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Model\Questionnaire;
use App\Model\ComplianceApp;

class CreateQuestionnaireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Questionnaire::TABLE, function (Blueprint $table) {
            $table->integer(Questionnaire::APP_ID)->unsigned()->nullable();
            $table->foreign(Questionnaire::APP_ID)->references(ComplianceApp::ID)->on(ComplianceApp::TABLE);
            
            $table->integer(Questionnaire::EVENING1)->nullable();
            $table->integer(Questionnaire::EVENING2)->nullable();
            $table->dateTime(Questionnaire::EVENING_TIME)->nullable();
            
            $table->integer(Questionnaire::MORNING1)->nullable();
            $table->integer(Questionnaire::MORNING2)->nullable();
            $table->dateTime(Questionnaire::MORNING_TIME)->nullable();
            
            $table->integer(Questionnaire::IS_RE_FILL)->nullable();
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
        Schema::dropIfExists(Questionnaire::TABLE);
    }
}
