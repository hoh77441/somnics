<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Model\UserCareUsers;
use App\Model\User;

class CreateUserCareUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(UserCareUsers::TABLE, function (Blueprint $table) {
            $table->integer(UserCareUsers::USER_ID)->unsigned()->nullable();
            $table->foreign(UserCareUsers::USER_ID)->references(User::ID)->on(User::TABLE);
            
            $table->integer(UserCareUsers::BE_CARED_ID)->unsigned()->nullable();
            $table->foreign(UserCareUsers::BE_CARED_ID)->references(User::ID)->on(User::TABLE);
            
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
        Schema::dropIfExists(UserCareUsers::TABLE);
    }
}
