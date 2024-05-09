<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Database\Factories\CategoryFactory;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Foundation',
            'Lipstick',
            'Eyeshadow Palette',
            'Mascara',
            'Skincare',
        ];
    
        foreach ($categories as $category) {
            CategoryFactory::new()->create([
                'category_name' => $category,
            ]);
        }
    }
    
}

