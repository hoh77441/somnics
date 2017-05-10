<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Model\ConsoleAssignToOrganization;
use App\Model\Organization;
use App\Model\Console;

class CreateConsoleAssignToOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ConsoleAssignToOrganization::TABLE, function (Blueprint $table) {
            $table->integer(ConsoleAssignToOrganization::ORG_ID)->unsigned()->nullable();
            $table->foreign(ConsoleAssignToOrganization::ORG_ID)->references(Organization::ID)->on(Organization::TABLE);
            
            $table->string(ConsoleAssignToOrganization::SERIAL_NO)->nullable();
            //$table->foreign(ConsoleAssignToOrganization::SERIAL_NO)->references(Console::SERIAL_NO)->on(Console::TABLE);
            
            $table->integer(ConsoleAssignToOrganization::HAS_ASSIGNED)->nullable();
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
        Schema::dropIfExists(ConsoleAssignToOrganization::TABLE);
    }
}
