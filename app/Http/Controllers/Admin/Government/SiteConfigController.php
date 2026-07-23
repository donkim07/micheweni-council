<?php

namespace App\Http\Controllers\Admin\Government;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Government\SiteConfig;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Traits\FileUploader;

class SiteConfigController extends Controller
{
    use FileUploader;

    /**
     * Display a listing of the site configurations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currentGroup = $request->get('group', 'general');
        $configGroups = SiteConfig::select('config_group')
            ->distinct()
            ->orderBy('config_group')
            ->pluck('config_group');
            
        $configs = SiteConfig::where('config_group', $currentGroup)
            ->orderBy('config_key')
            ->get();
        
        return view('admin.government.site-config.index', compact('configs', 'configGroups', 'currentGroup'));
    }

    /**
     * Show the form for creating a new site configuration.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $group = $request->get('group', 'general');
        return view('admin.government.site-config.create', compact('group'));
    }

    /**
     * Store a newly created site configuration in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'config_key' => 'required|string|max:255',
            'config_value' => 'required',
            'config_group' => 'required|string|max:255',
            'is_json' => 'boolean',
            'description' => 'nullable|string|max:255',
        ]);
        
        SiteConfig::setConfig(
            $request->config_key,
            $request->config_value,
            $request->config_group,
            $request->is_json ? true : false,
            $request->description
        );
        
        return redirect()
            ->route('admin.government.site-config.index', ['group' => $request->config_group])
            ->with('success', 'Configuration added successfully.');
    }

    /**
     * Show the form for editing the specified site configuration.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $config = SiteConfig::findOrFail($id);
        return view('admin.government.site-config.edit', compact('config'));
    }

    /**
     * Update the specified site configuration in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'config_value' => 'required',
            'description' => 'nullable|string|max:255',
        ]);
        
        $config = SiteConfig::findOrFail($id);
        $config->config_value = $config->is_json ? json_encode($request->config_value) : $request->config_value;
        $config->description = $request->description;
        $config->save();
        
        // Clear cache for this key
        Cache::forget("site_config:{$config->config_key}");
        
        return redirect()
            ->route('admin.government.site-config.index', ['group' => $config->config_group])
            ->with('success', 'Configuration updated successfully.');
    }

    /**
     * Remove the specified site configuration from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $config = SiteConfig::findOrFail($id);
        $group = $config->config_group;
        
        // Clear cache for this key
        Cache::forget("site_config:{$config->config_key}");
        
        $config->delete();
        
        return redirect()
            ->route('admin.government.site-config.index', ['group' => $group])
            ->with('success', 'Configuration deleted successfully.');
    }

    /**
     * Show the form for editing contact information.
     *
     * @return \Illuminate\Http\Response
     */
    public function editContact()
    {
        $contactInfo = SiteConfig::getContactInfo();
        
        return view('admin.government.site-config.contact', compact('contactInfo'));
    }

    /**
     * Update the contact information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateContact(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'phones.*' => 'nullable',
            'emails.*' => 'nullable|email',
            'working_hours' => 'required',
        ]);
        
        $contactInfo = [
            'address' => $request->address,
            'phones' => array_filter($request->phones ?? []),
            'emails' => array_filter($request->emails ?? []),
            'working_hours' => $request->working_hours,
        ];
        
        SiteConfig::setConfig('contact_info', $contactInfo, 'contact', true, 'Contact information displayed throughout the site');
        
        return redirect()->back()->with('success', 'Contact information updated successfully.');
    }

    /**
     * Show the form for editing social media links.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSocial()
    {
        $socialLinks = SiteConfig::getSocialLinks();
        
        return view('admin.government.site-config.social', compact('socialLinks'));
    }

    /**
     * Update the social media links.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSocial(Request $request)
    {
        $request->validate([
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'youtube' => 'nullable|url',
        ]);
        
        $socialLinks = [
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'youtube' => $request->youtube,
        ];
        
        SiteConfig::setConfig('social_links', $socialLinks, 'social', true, 'Social media links');
        
        return redirect()->back()->with('success', 'Social media links updated successfully.');
    }

    /**
     * Show the form for editing leadership information.
     *
     * @return \Illuminate\Http\Response
     */
    public function editLeadership()
    {
        $leadership = SiteConfig::getLeadership();
        
        return view('admin.government.site-config.leadership', compact('leadership'));
    }

    /**
     * Update the leadership information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateLeadership(Request $request)
    {
        $request->validate([
            'commissioner_name' => 'required',
            'commissioner_title' => 'required',
            'commissioner_image' => 'nullable|image|max:2048',
            'commissioner_email' => 'required|email',
            'commissioner_phone' => 'required',
            'commissioner_office' => 'required',
            'commissioner_bio' => 'required',
            
            'director_name' => 'required',
            'director_title' => 'required',
            'director_image' => 'nullable|image|max:2048',
            'director_email' => 'required|email',
            'director_phone' => 'required',
            'director_office' => 'required',
            'director_bio' => 'required',
        ]);
        
        $leadership = SiteConfig::getLeadership();
        
        // Handle commissioner image upload
        if ($request->hasFile('commissioner_image')) {
            $leadership['commissioner']['image'] = $this->uploadFile(
                $request->file('commissioner_image'),
                'government/leaders',
                $leadership['commissioner']['image'] ?? null
            );
        }
        
        // Handle director image upload
        if ($request->hasFile('director_image')) {
            $leadership['director']['image'] = $this->uploadFile(
                $request->file('director_image'),
                'government/leaders',
                $leadership['director']['image'] ?? null
            );
        }
        
        // Update commissioner details
        $leadership['commissioner']['name'] = $request->commissioner_name;
        $leadership['commissioner']['title'] = $request->commissioner_title;
        $leadership['commissioner']['email'] = $request->commissioner_email;
        $leadership['commissioner']['phone'] = $request->commissioner_phone;
        $leadership['commissioner']['office'] = $request->commissioner_office;
        $leadership['commissioner']['bio'] = $request->commissioner_bio;
        
        // Update director details
        $leadership['director']['name'] = $request->director_name;
        $leadership['director']['title'] = $request->director_title;
        $leadership['director']['email'] = $request->director_email;
        $leadership['director']['phone'] = $request->director_phone;
        $leadership['director']['office'] = $request->director_office;
        $leadership['director']['bio'] = $request->director_bio;
        
        SiteConfig::setConfig('leadership', $leadership, 'leadership', true, 'Leadership information for Commissioner and Director');
        
        return redirect()->back()->with('success', 'Leadership information updated successfully.');
    }

    /**
     * Show the form for editing stats/counters.
     *
     * @return \Illuminate\Http\Response
     */
    public function editStats()
    {
        $stats = SiteConfig::getStats();
        $statsIcons = SiteConfig::getConfig('stats_icons', [
            'population' => 'fa-users',
            'businesses' => 'fa-store',
            'schools' => 'fa-school',
            'health_centers' => 'fa-hospital'
        ]);
        $statsNames = SiteConfig::getConfig('stats_names', []);
        
        return view('admin.government.site-config.stats', compact('stats', 'statsIcons', 'statsNames'));
    }

    /**
     * Update the stats/counters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStats(Request $request)
    {
        $validatedData = $request->validate([
            'stats' => 'required|array',
            'stats.*.name' => 'required|string|max:255',
            'stats.*.value' => 'required|numeric',
            'stats.*.icon' => 'nullable|string|max:255',
            'stats.*.key' => 'required|string|max:255',
        ]);

        $stats = [];
        $statsIcons = [];
        $statNames = []; // To store display names

        foreach ($validatedData['stats'] as $stat) {
            // Use the existing key if provided and not empty
            $key = !empty($stat['key']) && $stat['key'] !== 'undefined' ? $stat['key'] : Str::snake($stat['name']);
            
            // Store the value with the key
            $stats[$key] = (int)$stat['value'];
            
            // Store the display name with the same key
            $statNames[$key] = $stat['name'];
            
            // Store the icon with the same key
            $statsIcons[$key] = $stat['icon'];
        }

        // Save the stats, names and icons to the site configuration
        SiteConfig::setConfig('stats', $stats, 'stats', true, 'Statistics counters for homepage');
        SiteConfig::setConfig('stats_icons', $statsIcons, 'stats', true, 'Icons for statistics counters');
        SiteConfig::setConfig('stats_names', $statNames, 'stats', true, 'Display names for statistics counters');

        return redirect()->route('admin.government.site-config.edit-stats')
            ->with('success', 'Statistics updated successfully.');
    }

    /**
     * Show the form for editing about information.
     *
     * @return \Illuminate\Http\Response
     */
    public function editAbout()
    {
        $aboutInfo = [
            'mission' => SiteConfig::getConfig('mission_statement'),
            'vision' => SiteConfig::getConfig('vision_statement'),
            'core_values' => SiteConfig::getConfig('core_values', [], true),
        ];
        
        return view('admin.government.site-config.about', compact('aboutInfo'));
    }

    /**
     * Update the about information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAbout(Request $request)
    {
        $request->validate([
            'mission' => 'required|string',
            'vision' => 'required|string',
            'core_values' => 'nullable|array',
            'core_values.*.title' => 'required|string|max:255',
            'core_values.*.icon' => 'nullable|string|max:255',
            'core_values.*.description' => 'required|string',
        ]);
        
        // Save mission statement
        SiteConfig::setConfig('mission_statement', $request->mission, 'about', false, 'Organization mission statement');
        
        // Save vision statement
        SiteConfig::setConfig('vision_statement', $request->vision, 'about', false, 'Organization vision statement');
        
        // Save core values
        $coreValues = [];
        if ($request->has('core_values')) {
            foreach ($request->core_values as $value) {
                if (!empty($value['title']) && !empty($value['description'])) {
                    $coreValues[] = [
                        'title' => $value['title'],
                        'icon' => $value['icon'] ?? 'fas fa-star',
                        'description' => $value['description'],
                    ];
                }
            }
        }
        
        SiteConfig::setConfig('core_values', $coreValues, 'about', true, 'Organization core values');
        
        return redirect()->back()->with('success', 'About information updated successfully.');
    }
} 