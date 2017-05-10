<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Model\Console;

class CreateConsoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Console::TABLE, function (Blueprint $table) {
            $table->string(Console::SERIAL_NO)->primary();
            //$table->primary(Console::SERIAL_NO);
            $table->string(Console::ADDRESS)->nullable();
            $table->string(Console::MODEL)->nullable();
            
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
        Schema::dropIfExists(Console::TABLE);
    }
}
