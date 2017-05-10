<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Model\OrganizationHasOperation;
use App\Model\Organization;
use App\Model\Operation;

class CreateOrganizationHasOperationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(OrganizationHasOperation::TABLE, function (Blueprint $table) {
            $table->integer(OrganizationHasOperation::ORG_ID)->unsigned()->nullable();
            $table->foreign(OrganizationHasOperation::ORG_ID)->references(Organization::ID)->on(Organization::TABLE);
            
            $table->string(OrganizationHasOperation::OP_NAME)->nullable();
            $table->foreign(OrganizationHasOperation::OP_NAME)->references(Operation::NAME)->on(Operation::TABLE);
            
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
        Schema::dropIfExists(OrganizationHasOperation::TABLE);
    }
}
