<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Model\MonitorDate;
use App\Utility\TConstant;

class CreateMonitorDateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( Schema::connection(TConstant::fileConnection())->hasTable(MonitorDate::TABLE) )
        {
            return;
        }
        
        Schema::connection(TConstant::fileConnection())->create(MonitorDate::TABLE, function (Blueprint $table) {
            $table->increments(MonitorDate::ID);
            $table->string(MonitorDate::SERIAL_NO)->nullable();
            $table->dateTime(MonitorDate::ARCHIVE_DATE)->nullable();
            
            $table->dateTime(MonitorDate::END)->nullable();
            
            $table->double(MonitorDate::AVERAGE_PRESSURE)->nullable();
            $table->double(MonitorDate::MIN_PRESSURE)->nullable();
            $table->double(MonitorDate::MAX_PRESSURE)->nullable();
            
            $table->double(MonitorDate::AVERAGE_BATTERY)->nullable();
            $table->double(MonitorDate::MIN_BATTERY)->nullable();
            $table->double(MonitorDate::MAX_BATTERY)->nullable();
            
            $table->integer(MonitorDate::TREATMENT)->nullable();
            $table->integer(MonitorDate::LEAKAGE)->nullable();
            $table->integer(MonitorDate::SEALING)->nullable();
            
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
        Schema::connection(TConstant::fileConnection())->dropIfExists(MonitorDate::TABLE);
    }
}
