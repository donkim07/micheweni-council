<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Opportunities\CircularEconomy\WasteListing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MarketplaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create service provider users if they don't exist
        $serviceProviders = [
            [
                'name' => 'Pemba Recyclers Ltd',
                'email' => 'pemba.recyclers@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'EcoClean Services',
                'email' => 'ecoclean@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Green Paper Trading',
                'email' => 'greenpapertrading@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Sustainable Solutions Consulting',
                'email' => 'sustainable.solutions@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Organic Farms Pemba',
                'email' => 'organic.farms@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'EcoEducators Zanzibar',
                'email' => 'ecoeducators@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        ];

        $providerIds = [];
        foreach ($serviceProviders as $providerData) {
            $provider = User::firstOrCreate(
                ['email' => $providerData['email']],
                $providerData
            );
            
            // Assign service_provider role if it exists
            $role = \App\Models\Role::where('name', 'service_provider')->first();
            if ($role) {
                $provider->roles()->syncWithoutDetaching([$role->id]);
            }
            
            $providerIds[] = $provider->id;
        }

        // Create waste listings
        $listings = [
            [
                'title' => 'Bulk Plastic Bottles - 500kg',
                'description' => 'Clean PET plastic bottles, sorted and baled. Available for pickup or delivery within Pemba.',
                'category' => 'recyclable_materials',
                'price' => 750000,
                'price_unit' => 'per ton',
                'location' => 'Micheweni, Pemba',
                'image' => 'images/listings/plastic-bottles.jpg',
                'is_available' => true,
                'user_id' => $providerIds[0],
            ],
            [
                'title' => 'Waste Collection Service - Commercial',
                'description' => 'Professional waste collection service for businesses. Regular schedule, competitive rates.',
                'category' => 'collection_services',
                'price' => 150000,
                'price_unit' => 'monthly',
                'location' => 'Chake Chake, Pemba',
                'image' => 'images/listings/waste-collection.jpg',
                'is_available' => true,
                'user_id' => $providerIds[1],
            ],
            [
                'title' => 'Used Cardboard - 200kg Available',
                'description' => 'Clean cardboard boxes and packaging materials. Perfect for recycling or reuse.',
                'category' => 'recyclable_materials',
                'price' => 50000,
                'price_unit' => 'for lot',
                'location' => 'Micheweni, Pemba',
                'image' => 'images/listings/cardboard.jpg',
                'is_available' => true,
                'user_id' => $providerIds[2],
            ],
            [
                'title' => 'Waste Management Consulting',
                'description' => 'Professional consulting services for businesses looking to improve their waste management practices.',
                'category' => 'consulting_services',
                'price' => 500000,
                'price_unit' => 'per project',
                'location' => 'Zanzibar',
                'image' => 'images/listings/consulting.jpg',
                'is_available' => true,
                'user_id' => $providerIds[3],
            ],
            [
                'title' => 'Composting Equipment - Used',
                'description' => 'Lightly used composting bins and equipment. Perfect for small businesses or community projects.',
                'category' => 'equipment_machinery',
                'price' => 350000,
                'price_unit' => 'negotiable',
                'location' => 'Mkoani, Pemba',
                'image' => 'images/listings/composting-equipment.jpg',
                'is_available' => true,
                'user_id' => $providerIds[4],
            ],
            [
                'title' => 'Waste Sorting Training Workshop',
                'description' => 'Professional training for businesses and communities on effective waste sorting techniques.',
                'category' => 'training_education',
                'price' => 100000,
                'price_unit' => 'per session',
                'location' => 'Micheweni, Pemba',
                'image' => 'images/listings/training.jpg',
                'is_available' => true,
                'user_id' => $providerIds[5],
            ],
        ];

        foreach ($listings as $listingData) {
            WasteListing::firstOrCreate(
                [
                    'title' => $listingData['title'],
                    'user_id' => $listingData['user_id']
                ],
                $listingData
            );
        }
    }
} 