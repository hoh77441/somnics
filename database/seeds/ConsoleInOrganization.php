<?php
use Illuminate\Database\Seeder;

use App\Model\ConsoleAssignToOrganization;

class ConsoleBeAssignedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConsoleAssignToOrganization::create([
            ConsoleAssignToOrganization::ORG_ID => 9,  //maxis-patient
            ConsoleAssignToOrganization::SERIAL_NO => 'R0315J20014',
            ConsoleAssignToOrganization::HAS_ASSIGNED => 0
        ]);
        ConsoleAssignToOrganization::create([
            ConsoleAssignToOrganization::ORG_ID => 9,  //maxis-patient
            ConsoleAssignToOrganization::SERIAL_NO => 'R0315K30035',
            ConsoleAssignToOrganization::HAS_ASSIGNED => 0
        ]);
        ConsoleAssignToOrganization::create([
            ConsoleAssignToOrganization::ORG_ID => 9,  //maxis-patient
            ConsoleAssignToOrganization::SERIAL_NO => 'R0315L20031',
            ConsoleAssignToOrganization::HAS_ASSIGNED => 0
        ]);
        ConsoleAssignToOrganization::create([
            ConsoleAssignToOrganization::ORG_ID => 9,  //maxis-patient
            ConsoleAssignToOrganization::SERIAL_NO => 'R0315K30023',
            ConsoleAssignToOrganization::HAS_ASSIGNED => 0
        ]);
        ConsoleAssignToOrganization::create([
            ConsoleAssignToOrganization::ORG_ID => 9,  //maxis-patient
            ConsoleAssignToOrganization::SERIAL_NO => 'R0316E40017',
            ConsoleAssignToOrganization::HAS_ASSIGNED => 0
        ]);
        ConsoleAssignToOrganization::create([
            ConsoleAssignToOrganization::ORG_ID => 9,  //maxis-patient
            ConsoleAssignToOrganization::SERIAL_NO => 'R0316E40018',
            ConsoleAssignToOrganization::HAS_ASSIGNED => 0
        ]);
        ConsoleAssignToOrganization::create([
            ConsoleAssignToOrganization::ORG_ID => 9,  //maxis-patient
            ConsoleAssignToOrganization::SERIAL_NO => 'R0316A40018',
            ConsoleAssignToOrganization::HAS_ASSIGNED => 0
        ]);
        ConsoleAssignToOrganization::create([
            ConsoleAssignToOrganization::ORG_ID => 9,  //maxis-patient
            ConsoleAssignToOrganization::SERIAL_NO => 'R0315J20002',
            ConsoleAssignToOrganization::HAS_ASSIGNED => 0
        ]);
        ConsoleAssignToOrganization::create([
            ConsoleAssignToOrganization::ORG_ID => 9,  //maxis-patient
            ConsoleAssignToOrganization::SERIAL_NO => 'R0315L20005',
            ConsoleAssignToOrganization::HAS_ASSIGNED => 0
        ]);
        ConsoleAssignToOrganization::create([
            ConsoleAssignToOrganization::ORG_ID => 9,  //maxis-patient
            ConsoleAssignToOrganization::SERIAL_NO => 'R0316E40019',
            ConsoleAssignToOrganization::HAS_ASSIGNED => 0
        ]);
        ConsoleAssignToOrganization::create([
            ConsoleAssignToOrganization::ORG_ID => 9,  //maxis-patient
            ConsoleAssignToOrganization::SERIAL_NO => 'R0315L20032',
            ConsoleAssignToOrganization::HAS_ASSIGNED => 0
        ]);
    }
}
