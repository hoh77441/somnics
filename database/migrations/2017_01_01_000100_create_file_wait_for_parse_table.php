<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Model\FileWaitForParse;
use App\Utility\TConstant;

class CreateFileWaitForParseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( Schema::connection(TConstant::fileConnection())->hasTable(FileWaitForParse::TABLE) )
        {
            return;
        }
        
        Schema::connection(TConstant::fileConnection())->create(FileWaitForParse::TABLE, function (Blueprint $table) {
            $table->increments(FileWaitForParse::ID);
            $table->string(FileWaitForParse::FILE_NAME)->nullable();
            $table->string(FileWaitForParse::SERIAL_NO)->nullable();
            $table->string(FileWaitForParse::USER_NAME)->nullable();
            $table->tinyInteger(FileWaitForParse::DONE)->nullable();
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
        Schema::connection(TConstant::fileConnection())->dropIfExists(FileWaitForParse::TABLE);
    }
}
