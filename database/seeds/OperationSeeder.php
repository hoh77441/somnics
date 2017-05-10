<?php
use Illuminate\Database\Seeder;

use App\Model\Operation;

class OperationSeeder extends Seeder
{
    public function run()
    {
        Operation::create([
            Operation::NAME => 'inap',
            Operation::DISPLAY => 'iNap',
        ]);
        
        Operation::create([
            Operation::NAME => 'viewChild',
            Operation::DISPLAY => 'View Child',
        ]);
        
        Operation::create([
            Operation::NAME => 'addOrganization',
            Operation::DISPLAY => 'Add Organization',
        ]);
        
        Operation::create([
            Operation::NAME => 'assignOrganization',
            Operation::DISPLAY => 'Assign Organization',
        ]);
        
        Operation::create([
            Operation::NAME => 'observer',
            Operation::DISPLAY => 'Observer',
        ]);
    }
}
