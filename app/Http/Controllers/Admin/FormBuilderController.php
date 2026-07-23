<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunities\CircularEconomy\FormBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Exception;

class FormBuilderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forms = FormBuilder::withCount('submissions')
            ->orderBy('title')
            ->paginate(15);
            
        return view('admin.form-builders.index', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fieldTypes = $this->getFieldTypes();
        $iconOptions = $this->getIconOptions();
        $colorOptions = $this->getColorOptions();
        
        return view('admin.form-builders.create', compact('fieldTypes', 'iconOptions', 'colorOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Form submission received', ['request' => $request->all()]);
            
            // Ensure fields is parsed as JSON array
            $fields = $request->input('fields');
            
            // Handle fields as JSON string
            if (is_string($fields)) {
                $decodedFields = json_decode($fields, true);
                
                // Check if it's a valid JSON array
                if (json_last_error() !== JSON_ERROR_NONE || !is_array($decodedFields)) {
                    Log::error('Invalid fields JSON', ['fields' => $fields, 'error' => json_last_error_msg()]);
                    throw new Exception('The fields field must be an array.');
                }
                
                // Replace the request input with the decoded array
                $request->merge(['fields' => $decodedFields]);
            } elseif (!is_array($fields)) {
                Log::error('Fields is not an array or string', ['fields' => $fields]);
                throw new Exception('The fields field must be an array.');
            }
            
            Log::info('Fields processed', ['fields' => $request->input('fields')]);
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:form_builders,slug',
                'description' => 'nullable|string',
                'icon' => 'nullable|string|max:50',
                'fields' => 'required|array',
                'fields.*.name' => 'required|string|max:100',
                'fields.*.label' => 'required|string|max:255',
                'fields.*.type' => 'required|string|max:50',
                'fields.*.required' => 'boolean',
                'fields.*.options' => 'nullable|array',
                'fields.*.placeholder' => 'nullable|string|max:255',
                'fields.*.default_value' => 'nullable|string',
                'fields.*.help_text' => 'nullable|string',
                'fields.*.validation' => 'nullable|string',
                'fields.*.conditional' => 'nullable|array',
                'map_enabled' => 'boolean',
                'map_icon' => 'nullable|string|max:50',
                'map_color' => 'nullable|string|max:20',
                'is_active' => 'boolean',
            ]);
            
            // Generate slug if not provided
            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['title']);
            }
            
            // Set default values for checkboxes
            $validated['map_enabled'] = $request->has('map_enabled') ? true : false;
            $validated['is_active'] = $request->has('is_active') ? true : false;
            
            Log::info('Validated data', ['validated' => $validated]);
            
            // Create the form
            $form = FormBuilder::create($validated);
            
            Log::info('Form created successfully', ['form_id' => $form->id]);
            
            // Check if this is an AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => __('Form created successfully.'),
                    'redirect' => route('admin.form-builders.edit', $form->id)
                ]);
            }
            
            return redirect()->route('admin.form-builders.edit', $form->id)
                ->with('success', __('Form created successfully.'));
        } catch (Exception $e) {
            Log::error('Error creating form', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Check if this is an AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating form: ' . $e->getMessage()
                ], 422);
            }
            
            return back()->withInput()->with('error', 'Error creating form: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $form = FormBuilder::with('submissions')->findOrFail($id);
        return view('admin.form-builders.show', compact('form'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $form = FormBuilder::findOrFail($id);
        $fieldTypes = $this->getFieldTypes();
        $iconOptions = $this->getIconOptions();
        $colorOptions = $this->getColorOptions();
        
        return view('admin.form-builders.edit', compact('form', 'fieldTypes', 'iconOptions', 'colorOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $form = FormBuilder::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:form_builders,slug,' . $id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'fields' => 'required|array',
            'fields.*.name' => 'required|string|max:100',
            'fields.*.label' => 'required|string|max:255',
            'fields.*.type' => 'required|string|max:50',
            'fields.*.required' => 'boolean',
            'fields.*.options' => 'nullable|array',
            'fields.*.placeholder' => 'nullable|string|max:255',
            'fields.*.default_value' => 'nullable|string',
            'fields.*.help_text' => 'nullable|string',
            'fields.*.validation' => 'nullable|string',
            'fields.*.conditional' => 'nullable|array',
            'map_enabled' => 'boolean',
            'map_icon' => 'nullable|string|max:50',
            'map_color' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);
        
        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        
        // Set default values for checkboxes
        $validated['map_enabled'] = $request->has('map_enabled');
        $validated['is_active'] = $request->has('is_active');
        
        // Update the form
        $form->update($validated);
        
        return redirect()->route('admin.form-builders.edit', $form)
            ->with('success', __('Form updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $form = FormBuilder::withCount('submissions')->findOrFail($id);
        
        // Optionally check if form has submissions before deleting
        if ($form->submissions_count > 0) {
            return back()->with('warning', __('This form has :count submissions. Delete them first or proceed with caution.', ['count' => $form->submissions_count]));
        }
        
        $form->delete();
        
        return redirect()->route('admin.form-builders.index')
            ->with('success', __('Form deleted successfully.'));
    }
    
    /**
     * Get available field types.
     */
    private function getFieldTypes()
    {
        return [
            'text' => [
                'name' => __('Text'),
                'icon' => 'fa-font',
                'description' => __('Single line text input')
            ],
            'textarea' => [
                'name' => __('Textarea'),
                'icon' => 'fa-paragraph',
                'description' => __('Multi-line text input')
            ],
            'number' => [
                'name' => __('Number'),
                'icon' => 'fa-hashtag',
                'description' => __('Numeric input')
            ],
            'email' => [
                'name' => __('Email'),
                'icon' => 'fa-envelope',
                'description' => __('Email address input')
            ],
            'phone' => [
                'name' => __('Phone'),
                'icon' => 'fa-phone',
                'description' => __('Phone number input')
            ],
            'select' => [
                'name' => __('Select'),
                'icon' => 'fa-caret-down',
                'description' => __('Dropdown selection')
            ],
            'multiselect' => [
                'name' => __('Multi-select'),
                'icon' => 'fa-list-check',
                'description' => __('Multiple selection dropdown')
            ],
            'checkbox' => [
                'name' => __('Checkbox'),
                'icon' => 'fa-check-square',
                'description' => __('Single checkbox')
            ],
            'radio' => [
                'name' => __('Radio'),
                'icon' => 'fa-circle-dot',
                'description' => __('Radio button selection')
            ],
            'date' => [
                'name' => __('Date'),
                'icon' => 'fa-calendar',
                'description' => __('Date picker')
            ],
            'time' => [
                'name' => __('Time'),
                'icon' => 'fa-clock',
                'description' => __('Time picker')
            ],
            'file' => [
                'name' => __('File Upload'),
                'icon' => 'fa-upload',
                'description' => __('File upload field')
            ],
            'image' => [
                'name' => __('Image Upload'),
                'icon' => 'fa-image',
                'description' => __('Image upload with preview')
            ],
            'location' => [
                'name' => __('Location'),
                'icon' => 'fa-map-marker-alt',
                'description' => __('Map location picker')
            ],
            'heading' => [
                'name' => __('Heading'),
                'icon' => 'fa-heading',
                'description' => __('Section heading (not an input)')
            ],
            'divider' => [
                'name' => __('Divider'),
                'icon' => 'fa-minus',
                'description' => __('Section divider (not an input)')
            ],
            'html' => [
                'name' => __('HTML'),
                'icon' => 'fa-code',
                'description' => __('Custom HTML content')
            ],
            'conditional' => [
                'name' => __('Conditional Field'),
                'icon' => 'fa-code-branch',
                'description' => __('Field that shows based on other fields')
            ],
        ];
    }
    
    /**
     * Get available icon options.
     */
    private function getIconOptions()
    {
        return [
            'fa-clipboard' => __('Form'),
            'fa-map-marker-alt' => __('Location'),
            'fa-trash' => __('Waste'),
            'fa-recycle' => __('Recycle'),
            'fa-leaf' => __('Environment'),
            'fa-building' => __('Building'),
            'fa-home' => __('Home'),
            'fa-industry' => __('Industry'),
            'fa-store' => __('Store'),
            'fa-school' => __('School'),
            'fa-hospital' => __('Hospital'),
            'fa-users' => __('Community'),
            'fa-user-hard-hat' => __('Worker'),
            'fa-truck' => __('Transport'),
            'fa-water' => __('Water'),
            'fa-seedling' => __('Plant'),
            'fa-lightbulb' => __('Idea'),
            'fa-exclamation-triangle' => __('Warning'),
        ];
    }
    
    /**
     * Get available color options.
     */
    private function getColorOptions()
    {
        return [
            'primary' => __('Primary'),
            'secondary' => __('Secondary'),
            'success' => __('Green'),
            'danger' => __('Red'),
            'warning' => __('Yellow'),
            'info' => __('Blue'),
            'dark' => __('Black'),
            'light' => __('White'),
        ];
    }
} 