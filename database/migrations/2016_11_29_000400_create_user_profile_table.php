<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Model\UserProfile;
use App\Model\User;

class CreateUserProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(UserProfile::TABLE, function (Blueprint $table) {
            $table->integer(UserProfile::USER_ID)->unsigned()->nullable();
            $table->foreign(UserProfile::USER_ID)->references(User::ID)->on(User::TABLE);
            
            $table->string(UserProfile::KEY);
            $table->string(UserProfile::VALUE)->nullable();
            
            //$table->unique(array(UserProfile::USER_ID, UserProfile::KEY));
            
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
        Schema::dropIfExists(UserProfile::TABLE);
    }
}
