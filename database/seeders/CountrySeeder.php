<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Opportunities\CircularEconomy\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Let's ensure we have a Country model first
        if (!class_exists('App\Models\Country')) {
            $this->createCountryModel();
        }
        
        // Instead of truncating, which would violate foreign key constraints,
        // we'll use a safer approach: delete all records and reset the ID sequence
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Country::query()->delete();
        DB::statement('ALTER TABLE countries AUTO_INCREMENT = 1;');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Insert country data with circularity scores
        $countries = [
            [
                'name' => 'Finland',
                'code' => 'FI',
                'flag' => 'images/flags/finland.png',
                'circularity_score' => 87,
                'region' => 'Europe',
                'waste_per_capita' => 565,
                'circular_material_use_rate' => 12.3,
                'waste_properly_treated' => 98,
                'is_featured' => true,
                'ranking' => 1,
            ],
            [
                'name' => 'Netherlands',
                'code' => 'NL',
                'flag' => 'images/flags/netherlands.png',
                'circularity_score' => 85,
                'region' => 'Europe',
                'waste_per_capita' => 520,
                'circular_material_use_rate' => 28.5,
                'waste_properly_treated' => 97,
                'is_featured' => true,
                'ranking' => 2,
            ],
            [
                'name' => 'Germany',
                'code' => 'DE',
                'flag' => 'images/flags/germany.png',
                'circularity_score' => 81,
                'region' => 'Europe',
                'waste_per_capita' => 615,
                'circular_material_use_rate' => 11.9,
                'waste_properly_treated' => 96,
                'is_featured' => true,
                'ranking' => 3,
            ],
            [
                'name' => 'Kenya',
                'code' => 'KE',
                'flag' => 'images/flags/kenya.png',
                'circularity_score' => 72,
                'region' => 'East Africa',
                'waste_per_capita' => 295,
                'circular_material_use_rate' => 8.7,
                'waste_properly_treated' => 65,
                'is_featured' => true,
                'ranking' => 4,
            ],
            [
                'name' => 'Tanzania',
                'code' => 'TZ',
                'flag' => 'images/flags/tanzania.png',
                'circularity_score' => 65,
                'region' => 'East Africa',
                'waste_per_capita' => 260,
                'circular_material_use_rate' => 7.5,
                'waste_properly_treated' => 58,
                'is_featured' => true,
                'ranking' => 5,
            ],
            [
                'name' => 'Rwanda',
                'code' => 'RW',
                'flag' => 'images/flags/rwanda.png',
                'circularity_score' => 68,
                'region' => 'East Africa',
                'waste_per_capita' => 242,
                'circular_material_use_rate' => 7.9,
                'waste_properly_treated' => 62,
                'is_featured' => false,
                'ranking' => 6,
            ],
            [
                'name' => 'Uganda',
                'code' => 'UG',
                'flag' => 'images/flags/uganda.png',
                'circularity_score' => 56,
                'region' => 'East Africa',
                'waste_per_capita' => 225,
                'circular_material_use_rate' => 6.8,
                'waste_properly_treated' => 47,
                'is_featured' => false,
                'ranking' => 7,
            ],
            [
                'name' => 'Pemba',
                'code' => 'PMB',
                'flag' => 'images/flags/tanzania.png', // Use Tanzania flag for now
                'circularity_score' => 72,
                'region' => 'East Africa',
                'waste_per_capita' => 245,
                'circular_material_use_rate' => 8.1,
                'waste_properly_treated' => 66,
                'is_featured' => true,
                'ranking' => 8,
                'is_local' => true
            ],
        ];
        
        foreach ($countries as $country) {
            Country::create($country);
        }
    }

    /**
     * Create the Country model if it doesn't exist
     */
    private function createCountryModel()
    {
        $modelPath = app_path('Models/Country.php');
        $directory = dirname($modelPath);
        
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        
        $modelContent = <<<'MODEL'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'code',
        'flag',
        'circularity_score',
        'region',
        'waste_per_capita',
        'circular_material_use_rate',
        'waste_properly_treated',
        'is_featured',
        'ranking',
        'is_local'
    ];
    
    protected $casts = [
        'circularity_score' => 'float',
        'waste_per_capita' => 'float',
        'circular_material_use_rate' => 'float',
        'waste_properly_treated' => 'float',
        'is_featured' => 'boolean',
        'ranking' => 'integer',
        'is_local' => 'boolean'
    ];
}
MODEL;
        
        file_put_contents($modelPath, $modelContent);
    }
} 