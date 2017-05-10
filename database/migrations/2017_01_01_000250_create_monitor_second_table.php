<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Model\MonitorSecond;
use App\Model\MonitorDate;
use App\Utility\TConstant;

class CreateMonitorSecondTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( Schema::connection(TConstant::fileConnection())->hasTable(MonitorSecond::TABLE) )
        {
            return;
        }
        
        Schema::connection(TConstant::fileConnection())->create(MonitorSecond::TABLE, function (Blueprint $table) {
            $table->increments(MonitorSecond::ID);
            $table->integer(MonitorSecond::MONITOR_ID)->unsigned()->nullable();
            $table->foreign(MonitorSecond::MONITOR_ID)->references(MonitorDate::ID)->on(MonitorDate::TABLE);
            
            //$table->string(MonitorSecond::SERIAL_NO)->nullable();
            $table->dateTime(MonitorSecond::TIME)->nullable();
            
            $table->double(MonitorSecond::PRESSURE)->nullable();
            $table->double(MonitorSecond::BATTERY)->nullable();
            $table->integer(MonitorSecond::STATUS)->nullable();
            
            $table->tinyInteger(MonitorSecond::IS_BATTERY_OK)->nullable();
            $table->tinyInteger(MonitorSecond::IS_TREATING)->nullable();
            $table->tinyInteger(MonitorSecond::IS_LEAKING)->nullable();
            $table->tinyInteger(MonitorSecond::IS_FULL)->nullable();
            $table->tinyInteger(MonitorSecond::IS_WRONG)->nullable();
            
            $table->unique(array(MonitorSecond::MONITOR_ID, MonitorSecond::TIME));
            
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
        Schema::connection(TConstant::fileConnection())->dropIfExists(MonitorSecond::TABLE);
    }
}
