<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // // Create default user
        // \App\Models\User::factory()->create([
        //     'name' => 'Admin User',
        //     'email' => 'admin@example.com',
        //     'password' => bcrypt('password'),
        // ]);

        // Run other seeders
        $this->call([
            // Migration seeders first
            CountrySeeder::class,
            
            // Page and content seeders
            HomePageSeeder::class,
            AssessmentPageSeeder::class,
            DashboardPageSeeder::class,
            ResourceHubSeeder::class,
            TemplateSeeder::class,
            
            // Data seeders last (they depend on other data)
            AchievementsSeeder::class,
            WasteLocationSeeder::class,
            MarketplaceSeeder::class,
            
            // Site configuration
            SiteConfigSeeder::class,
        ]);

        // Add this line to the run method
        $this->call(GovernmentDataSeeder::class);

        // Create admin role and permissions
        $adminRole = Role::create(['name' => 'admin', 'display_name' => 'Administrator']);
        
        $permissions = [
            'manage_users',
            'manage_roles',
            'manage_permissions',
            'manage_news',
            'manage_pages',
            'manage_content',
            'manage_waste_locations',
            'manage_categories',
            'manage_site_config'
        ];
        
        foreach ($permissions as $permName) {
            $permission = Permission::create([
                'name' => $permName,
                'display_name' => ucwords(str_replace('_', ' ', $permName))
            ]);
            
            // Attach permission to admin role
            $adminRole->permissions()->attach($permission);
        }
        
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        
        // Assign admin role to admin user
        $admin->roles()->attach($adminRole);
    }
}
