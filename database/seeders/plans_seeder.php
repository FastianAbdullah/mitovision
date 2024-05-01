<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;
use Nette\Utils\Floats;

class plans_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $plans = ['Free','Gold','Platinum'];

        $price = ['0','25','50'];

        for($id = 1; $id<4; $id++)
        {
            Plan::create([
                'id' => $id,
                'plan' => $plans[$id-1],
                'price'=> $price[$id-1]
                ]
            );      
        }
        
    }
}
