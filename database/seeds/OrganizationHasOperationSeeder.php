<?php
use Illuminate\Database\Seeder;

use App\Model\OrganizationHasOperation;

class OrganizationHasOperationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 6,  //care
            OrganizationHasOperation::OP_NAME => 'inap',
        ]);
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 6,  //care
            OrganizationHasOperation::OP_NAME => 'observer',
        ]);
        
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 5,  //patient
            OrganizationHasOperation::OP_NAME => 'inap',
        ]);
        
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 4,  //hospital
            OrganizationHasOperation::OP_NAME => 'inap',
        ]);
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 4,  //hospital
            OrganizationHasOperation::OP_NAME => 'viewChild',
        ]);
        
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 3,  //agent
            OrganizationHasOperation::OP_NAME => 'inap',
        ]);
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 3,  //agent
            OrganizationHasOperation::OP_NAME => 'viewChild',
        ]);
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 3,  //agent
            OrganizationHasOperation::OP_NAME => 'addOrganization',
        ]);
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 3,  //agent
            OrganizationHasOperation::OP_NAME => 'assignOrganization',
        ]);
        
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 2,  //employee
            OrganizationHasOperation::OP_NAME => 'inap',
        ]);
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 2,  //employee
            OrganizationHasOperation::OP_NAME => 'viewChild',
        ]);
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 2,  //employee
            OrganizationHasOperation::OP_NAME => 'addOrganization',
        ]);
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 2,  //employee
            OrganizationHasOperation::OP_NAME => 'assignOrganization',
        ]);
        
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 7,  //clinic
            OrganizationHasOperation::OP_NAME => 'inap',
        ]);
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 7,  //clinic
            OrganizationHasOperation::OP_NAME => 'viewChild',
        ]);
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 7,  //clinic
            OrganizationHasOperation::OP_NAME => 'addOrganization',
        ]);
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 7,  //clinic
            OrganizationHasOperation::OP_NAME => 'assignOrganization',
        ]);
        
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 8,  //maxis
            OrganizationHasOperation::OP_NAME => 'inap',
        ]);
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 8,  //maxis
            OrganizationHasOperation::OP_NAME => 'viewChild',
        ]);
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 8,  //maxis
            OrganizationHasOperation::OP_NAME => 'addOrganization',
        ]);
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 8,  //maxis
            OrganizationHasOperation::OP_NAME => 'assignOrganization',
        ]);
        
        OrganizationHasOperation::create([
            OrganizationHasOperation::ORG_ID => 9,  //maxis-patient
            OrganizationHasOperation::OP_NAME => 'inap',
        ]);
    }
}
