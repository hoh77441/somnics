<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Model\UserHasMobile;
use App\Model\User;
use App\Model\Mobile;

class CreateUserHasMobileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(UserHasMobile::TABLE, function (Blueprint $table) {
            $table->integer(UserHasMobile::USER_ID)->unsigned()->nullable();
            $table->foreign(UserHasMobile::USER_ID)->references(User::ID)->on(User::TABLE);
            
            $table->string(UserHasMobile::TOKEN)->nullable();
            $table->foreign(UserHasMobile::TOKEN)->references(Mobile::TOKEN)->on(Mobile::TABLE);
            
            $table->dateTime(UserHasMobile::APP_TIME)->nullable();
            
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
        Schema::dropIfExists(UserHasMobile::TABLE);
    }
}
