<?php
use Illuminate\Database\Seeder;

use App\Model\Organization;

class OrganizationSeeder extends Seeder
{
    public function run()
    {
        Organization::create([
            Organization::ID => 1,
            Organization::PARENT_ID => 0,
            Organization::NAME => 'somnics',
            Organization::DISPLAY => 'somnics'
        ]);
        
        Organization::create([
            Organization::ID => 2,
            Organization::PARENT_ID => 1,
            Organization::NAME => 'employee',
            Organization::DISPLAY => 'employee'
        ]);
        
        Organization::create([
            Organization::ID => 3,
            Organization::PARENT_ID => 2,
            Organization::NAME => 'agent',
            Organization::DISPLAY => 'agent'
        ]);
        
        Organization::create([
            Organization::ID => 4,
            Organization::PARENT_ID => 3,
            Organization::NAME => 'hospital',
            Organization::DISPLAY => 'hospital'
        ]);
        
        Organization::create([
            Organization::ID => 5,
            Organization::PARENT_ID => 4,
            Organization::NAME => 'patient',
            Organization::DISPLAY => 'patient'
        ]);
        
        Organization::create([
            Organization::ID => 6,
            Organization::PARENT_ID => 3,
            Organization::NAME => 'care',
            Organization::DISPLAY => 'care'
        ]);
        
        Organization::create([
            Organization::ID => 7,
            Organization::PARENT_ID => 2,
            Organization::NAME => 'clinic',
            Organization::DISPLAY => 'clinic'
        ]);
        
        Organization::create([
            Organization::ID => 8,
            Organization::PARENT_ID => 7,
            Organization::NAME => 'maxis',
            Organization::DISPLAY => 'maxis'
        ]);
        
        Organization::create([
            Organization::ID => 9,
            Organization::PARENT_ID => 8,
            Organization::NAME => 'maxis-patient',
            Organization::DISPLAY => 'patient'
        ]);
    }
}
