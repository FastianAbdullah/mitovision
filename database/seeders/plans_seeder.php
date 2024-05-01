<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;
//use Nette\Utils\Floats;

class plans_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Name of plans
        $plans = [
            'Free',
            'Gold',
            'Platinum'
        ];

        //description of each service.
        $descriptions = [
            'Ideal for medical professionals new to mitosis detection, our Basic Plan offers essential tools to begin your diagnostic journey.',
            'Elevate your diagnostic capabilities, designed to empower medical professionals with advanced features.',
            'For medical professionals seeking diagnostic excellence, our Platinum Plan offers elite features.'
        ];

        //headings of each paragraph in services
        $headings = [
            'Reliable Detection Results',
            'Enhanced Detection Accuracy',
            'Precision-Driven Detection'
        ];

        //Images count of each plan
        $max_images = [
            5,
            25,
            50
        ];

        $price = ['0',
        '25',
        '50'
        ];

        for($id = 1; $id<4; $id++)
        {
            Plan::create([
                'id' => $id,
                'plan' => $plans[$id-1],
                'price'=> $price[$id-1],
                'description' => $descriptions[$id - 1],
                'heading' => $headings[$id - 1],
                'max_images' => $max_images[$id - 1]  
                ]
            );      
        }
        
    }
}
