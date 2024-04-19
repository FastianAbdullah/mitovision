<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PricingModel;
use Nette\Utils\Floats;

class pricing_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $plans = [
            'Platinum',
            'Gold',
            'Silver'
        ];

        for($id = 2; $id<4; $id++){
            PricingModel::create([
                'pid' => $id,
                'Plan' => $plans[$id-1],
                ]
            );      
        }
        
    }
}
