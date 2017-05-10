<?php
use Illuminate\Database\Seeder;

use App\Model\OrganizationHasUser;

class OrganizationHasUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrganizationHasUser::create([
            OrganizationHasUser::ORG_ID => 1,  //somnics
            OrganizationHasUser::USER_ID => 1,  //admin1
        ]);
        
        OrganizationHasUser::create([
            OrganizationHasUser::ORG_ID => 2,   //employee
            OrganizationHasUser::USER_ID => 2,  //employee1
        ]);
        
        OrganizationHasUser::create([
            OrganizationHasUser::ORG_ID => 3,   //agent
            OrganizationHasUser::USER_ID => 3,  //agent1
        ]);
        
        OrganizationHasUser::create([
            OrganizationHasUser::ORG_ID => 3,   //agent
            OrganizationHasUser::USER_ID => 4,  //agent2
        ]);
        
        OrganizationHasUser::create([
            OrganizationHasUser::ORG_ID => 4,   //hospital
            OrganizationHasUser::USER_ID => 5,  //hospital1
        ]);
        
        OrganizationHasUser::create([
            OrganizationHasUser::ORG_ID => 6,   //care
            OrganizationHasUser::USER_ID => 6,  //care1
        ]);
        
        OrganizationHasUser::create([
            OrganizationHasUser::ORG_ID => 7,   //clinic
            OrganizationHasUser::USER_ID => 7,  //HELEN
        ]);
        
        OrganizationHasUser::create([
            OrganizationHasUser::ORG_ID => 8,   //maxis
            OrganizationHasUser::USER_ID => 8,  //MAXIS
        ]);
        
        OrganizationHasUser::create([
            OrganizationHasUser::ORG_ID => 8,   //maxis
            OrganizationHasUser::USER_ID => 9,  //GD
        ]);
        
        OrganizationHasUser::create([
            OrganizationHasUser::ORG_ID => 8,   //maxis
            OrganizationHasUser::USER_ID => 10,  //MUSLUM
        ]);
    }
}
