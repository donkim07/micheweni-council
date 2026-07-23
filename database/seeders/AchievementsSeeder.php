<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Opportunities\CircularEconomy\Achievement;
use App\Models\Opportunities\CircularEconomy\Country;

class AchievementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing achievements
        Achievement::truncate();
        
        // Get country IDs
        $tanzania = Country::where('name', 'Tanzania')->first();
        $kenya = Country::where('name', 'Kenya')->first();
        $pemba = Country::where('name', 'Pemba')->first();
        
        // Create featured achievements
        $achievements = [
            [
                'title' => 'Pemba reached 72% Circularity this year!',
                'title_sw' => 'Pemba imefikia Uzungukaji wa 72% mwaka huu!',
                'description' => 'A significant improvement from 58% last year, moving us closer to our 2030 goals.',
                'description_sw' => 'Uboreshaji muhimu kutoka 58% mwaka jana, ukitupeleka karibu na malengo yetu ya 2030.',
                'icon' => 'fas fa-award',
                'country_id' => $pemba ? $pemba->id : null,
                'year' => 2023,
                'improvement' => 14,
                'previous_score' => 58,
                'current_score' => 72,
                'is_featured' => true,
                'display_order' => 1
            ],
            [
                'title' => 'Tanzania improved waste collection coverage by 35%',
                'title_sw' => 'Tanzania imeboresha ufikiaji wa ukusanyaji wa taka kwa 35%',
                'description' => 'New infrastructure and community initiatives have expanded waste management services across the country.',
                'description_sw' => 'Miundombinu mpya na miradi ya jamii imepanua huduma za usimamizi wa taka nchi nzima.',
                'icon' => 'fas fa-truck',
                'country_id' => $tanzania ? $tanzania->id : null,
                'year' => 2023,
                'improvement' => 35,
                'previous_score' => 30,
                'current_score' => 65,
                'is_featured' => true,
                'display_order' => 2
            ],
            [
                'title' => 'Kenya launched 50 new recycling centers',
                'title_sw' => 'Kenya imezindua vituo 50 vipya vya kuchakata',
                'description' => 'These facilities will process over 200,000 tons of plastic waste annually.',
                'description_sw' => 'Vituo hivi vitachakata taka za plastiki zaidi ya tani 200,000 kila mwaka.',
                'icon' => 'fas fa-recycle',
                'country_id' => $kenya ? $kenya->id : null,
                'year' => 2023,
                'improvement' => null,
                'previous_score' => null,
                'current_score' => null,
                'is_featured' => true,
                'display_order' => 3
            ],
            [
                'title' => 'Circular design training reaches 500 local businesses',
                'title_sw' => 'Mafunzo ya usanifu wa mzunguko yamefikia biashara 500 za mitaa',
                'description' => 'Local entrepreneurs are adopting circular principles in product development and packaging.',
                'description_sw' => 'Wajasiriamali wa mitaa wanakubali kanuni za mzunguko katika maendeleo ya bidhaa na ufungaji.',
                'icon' => 'fas fa-sync-alt',
                'country_id' => $pemba ? $pemba->id : null,
                'year' => 2023,
                'improvement' => null,
                'previous_score' => null,
                'current_score' => null,
                'is_featured' => false,
                'display_order' => 4
            ],
        ];
        
        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }
    }
}
