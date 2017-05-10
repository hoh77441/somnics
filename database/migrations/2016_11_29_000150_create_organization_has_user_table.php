<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Model\OrganizationHasUser;
use App\Model\Organization;
use App\Model\User;

class CreateOrganizationHasUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(OrganizationHasUser::TABLE, function (Blueprint $table) {
            $table->integer(OrganizationHasUser::ORG_ID)->unsigned()->nullable();
            $table->foreign(OrganizationHasUser::ORG_ID)->references(Organization::ID)->on(Organization::TABLE);
            
            $table->integer(OrganizationHasUser::USER_ID)->unsigned()->nullable();
            $table->foreign(OrganizationHasUser::USER_ID)->references(User::ID)->on(User::TABLE);
            
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
        Schema::dropIfExists(OrganizationHasUser::TABLE);
    }
}
