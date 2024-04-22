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
            'Free',
            'Gold',
            'Platinum'
        ];

        for($id = 1; $id<4; $id++){
            PricingModel::create([
                'id' => $id,
                'plan' => $plans[$id-1],
                ]
            );      
        }
        
    }
}
