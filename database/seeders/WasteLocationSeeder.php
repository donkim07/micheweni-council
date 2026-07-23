<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Opportunities\CircularEconomy\WasteLocation;

class WasteLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing waste locations
        WasteLocation::truncate();
        
        // Create waste locations
        $locations = [
            [
                'name' => 'Micheweni Central Collection Center',
                'description' => 'Main waste collection and sorting facility for Micheweni district',
                'latitude' => -5.055833,
                'longitude' => 39.726944,
                'address' => 'Micheweni Town Center, Pemba',
                'type' => 'collection_point',
                'contact_phone' => '+255 777 123456',
                'contact_email' => 'micheweni.collection@example.com',
                'image' => 'images/locations/micheweni-central.jpg',
                'operating_hours' => json_encode(['Mon-Fri: 8:00-17:00', 'Sat: 9:00-15:00', 'Sun: Closed']),
                'accepted_materials' => json_encode(['Plastic', 'Paper', 'Glass', 'Metal', 'Organic']),
                'is_active' => true
            ],
            [
                'name' => 'Chake Chake Recycling Center',
                'description' => 'Specialized facility for processing recyclable materials',
                'latitude' => -5.253333,
                'longitude' => 39.770556,
                'address' => 'Chake Chake, Pemba',
                'type' => 'recycling_center',
                'contact_phone' => '+255 777 789012',
                'contact_email' => 'chakechake.recycling@example.com',
                'image' => 'images/locations/chake-recycling.jpg',
                'operating_hours' => json_encode(['Mon-Fri: 9:00-16:00', 'Sat: 10:00-14:00', 'Sun: Closed']),
                'accepted_materials' => json_encode(['Plastic', 'Paper', 'Metal']),
                'is_active' => true
            ],
            [
                'name' => 'Mkoani Transfer Station',
                'description' => 'Waste transfer station for southern Pemba',
                'latitude' => -5.369444,
                'longitude' => 39.653889,
                'address' => 'Mkoani, Pemba',
                'type' => 'transfer_station',
                'contact_phone' => '+255 777 345678',
                'contact_email' => 'mkoani.transfer@example.com',
                'image' => 'images/locations/mkoani-transfer.jpg',
                'operating_hours' => json_encode(['Mon-Fri: 8:00-17:00', 'Sat-Sun: Closed']),
                'accepted_materials' => json_encode(['Mixed Waste', 'Bulky Items']),
                'is_active' => true
            ],
            [
                'name' => 'Kengeja Collection Point',
                'description' => 'Local collection point for rural communities',
                'latitude' => -5.4025,
                'longitude' => 39.753611,
                'address' => 'Kengeja, Pemba',
                'type' => 'collection_point',
                'contact_phone' => '+255 777 456789',
                'contact_email' => null,
                'image' => 'images/locations/kengeja-collection.jpg',
                'operating_hours' => json_encode(['Mon-Fri: 8:00-15:00', 'Sat-Sun: Closed']),
                'accepted_materials' => json_encode(['Plastic', 'Paper', 'Organic']),
                'is_active' => true
            ],
            [
                'name' => 'Pemba Composting Facility',
                'description' => 'Organic waste processing and composting center',
                'latitude' => -5.206944,
                'longitude' => 39.788889,
                'address' => 'Ole, Pemba',
                'type' => 'composting_facility',
                'contact_phone' => '+255 777 567890',
                'contact_email' => 'pemba.composting@example.com',
                'image' => 'images/locations/pemba-composting.jpg',
                'operating_hours' => json_encode(['Mon-Sat: 7:00-16:00', 'Sun: Closed']),
                'accepted_materials' => json_encode(['Organic', 'Green Waste']),
                'is_active' => true
            ],
            [
                'name' => 'Micheweni Hazardous Waste Facility',
                'description' => 'Specialized facility for handling hazardous waste materials',
                'latitude' => -5.063333,
                'longitude' => 39.736111,
                'address' => 'Micheweni Industrial Area, Pemba',
                'type' => 'hazardous_waste',
                'contact_phone' => '+255 777 678901',
                'contact_email' => 'micheweni.hazardous@example.com',
                'image' => 'images/locations/micheweni-hazardous.jpg',
                'operating_hours' => json_encode(['Mon-Fri: 9:00-15:00', 'Sat-Sun: Closed']),
                'accepted_materials' => json_encode(['Batteries', 'Electronics', 'Chemicals', 'Medical Waste']),
                'is_active' => true
            ],
            [
                'name' => 'Micheweni Collection Point',
                'description' => 'Northern Pemba waste collection point',
                'latitude' => -4.973611,
                'longitude' => 39.818056,
                'address' => 'Micheweni, Pemba',
                'type' => 'collection_point',
                'contact_phone' => '+255 777 890123',
                'contact_email' => 'micheweni.collection@example.com',
                'image' => 'images/locations/micheweni-collection.jpg',
                'operating_hours' => json_encode(['Mon-Fri: 8:00-16:00', 'Sat: 9:00-13:00', 'Sun: Closed']),
                'accepted_materials' => json_encode(['Plastic', 'Paper', 'Glass', 'Metal']),
                'is_active' => true
            ],
            [
                'name' => 'Pemba Marine Waste Center',
                'description' => 'Specialized center for processing marine and coastal waste',
                'latitude' => -5.227778,
                'longitude' => 39.818056,
                'address' => 'Coastal Area, Pemba',
                'type' => 'specialized_facility',
                'contact_phone' => '+255 777 901234',
                'contact_email' => 'marine.waste@example.com',
                'image' => 'images/locations/marine-waste.jpg',
                'operating_hours' => json_encode(['Mon-Fri: 8:00-16:00', 'Sat-Sun: Closed']),
                'accepted_materials' => json_encode(['Fishing Nets', 'Plastics', 'Marine Debris']),
                'is_active' => true
            ],
        ];
        
        foreach ($locations as $location) {
            WasteLocation::create($location);
        }
    }
} 