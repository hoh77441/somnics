<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Model\Organization;

class CreateOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Organization::TABLE, function (Blueprint $table) {
            $table->increments(Organization::ID);
            
            $table->integer(Organization::PARENT_ID)->unsigned()->nullable();
            //$table->foreign(Organization::PARENT_ID)->references(Organization::USER_ID)->on(Organization::TABLE)->onDelete('set null');
            
            $table->string(Organization::NAME)->unique();
            $table->string(Organization::DISPLAY)->nullable();
            
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
        Schema::dropIfExists(Organization::TABLE);
    }
}
