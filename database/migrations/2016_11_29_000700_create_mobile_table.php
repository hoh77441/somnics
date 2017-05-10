<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Model\Mobile;

class CreateMobileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Mobile::TABLE, function (Blueprint $table) {
            $table->string(Mobile::TOKEN)->primary();
            //$table->primary(Mobile::TOKEN);
            $table->string(Mobile::OS)->nullable();
            $table->string(Mobile::OS_VERSION)->nullable();
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
        Schema::dropIfExists(Mobile::TABLE);
    }
}
