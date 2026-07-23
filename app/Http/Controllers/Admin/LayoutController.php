<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunities\CircularEconomy\Content;
use App\Models\Opportunities\CircularEconomy\FormBuilder;
use App\Models\Opportunities\CircularEconomy\Page;
use App\Models\Opportunities\CircularEconomy\Section;
use App\Models\Opportunities\CircularEconomy\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;

class LayoutController extends Controller
{
    /**
     * Show the layout builder
     */
    public function builder($id)
    {
        $page = Page::findOrFail($id);
        
        // Get all sections for this page, ordered by the order field
        $sections = Section::where('page_id', $page->id)
                           ->orderBy('order', 'asc')
                           ->get();
        
        // Get all content for this page to ensure proper previews
        $contents = Content::where('page_id', $page->id)
                          ->orderBy('order', 'asc')
                          ->get();
        
        // Get all form builders for form components
        $formBuilders = \App\Models\Opportunities\CircularEconomy\FormBuilder::where('is_active', true)
                                            ->pluck('title', 'id')
                                            ->toArray();
        
        // Define component types with templates for the component settings UI
        $componentTypes = $this->getComponentTypes();
        
        return view('admin.layout.builder', [
            'page' => $page,
            'sections' => $sections,
            'contents' => $contents,
            'componentTypes' => $componentTypes,
            'formBuilders' => $formBuilders,
        ]);
    }
    
    /**
     * Show the preview interface
     */
    public function preview(Page $page, Request $request)
    {
        // Add preview mode flag to request
        $request->request->add(['preview_mode' => true]);
        
        // Load all form builders for form components
        $formBuilders = \App\Models\Opportunities\CircularEconomy\FormBuilder::where('is_active', true)
                                           ->pluck('title', 'id')
                                           ->toArray();
        
        // Get all sections for this page, ordered by the order field
        $sections = Section::where('page_id', $page->id)
                         ->orderBy('order', 'asc')
                         ->get();
        
        // Get all content for this page, including inactive for preview purposes
        $contents = Content::where('page_id', $page->id)
                          ->orderBy('section')
                          ->orderBy('order', 'asc')
                          ->get();
        
        // Define component types with templates for dynamic template handling
        $componentTypes = $this->getComponentTypes();
        
        return view('admin.layout.preview', [
            'page' => $page,
            'sections' => $sections,
            'contents' => $contents,
            'formBuilders' => $formBuilders,
            'componentTypes' => $componentTypes,
            'preview_mode' => true,
            'request' => $request
        ]);
    }
    
    /**
     * Show the component settings form
     */
    public function componentSettings($id)
    {
        $content = Content::findOrFail($id);
        
        // Get all form builders for form components
        $formBuilders = \App\Models\Opportunities\CircularEconomy\FormBuilder::where('is_active', true)
                                           ->pluck('title', 'id')
                                           ->toArray();
        
        // Define component types with templates for the component settings UI
        $componentTypes = $this->getComponentTypes();
        
        return view('admin.layout.component-settings', [
            'content' => $content,
            'componentTypes' => $componentTypes,
            'formBuilders' => $formBuilders
        ]);
    }
    
    /**
     * Save component settings
     */
    public function saveComponentSettings(Request $request, $id)
    {
        try {
            $content = Content::findOrFail($id);
            $previousTemplateId = $content->template_identifier;
            $newTemplateId = $request->input('template_identifier');
            
            // Handle regular form inputs
            $content->title = $request->input('title');
            $content->type = $request->input('type');
            $content->value = $request->input('value', '');
            $content->template_identifier = $newTemplateId;
            
            // Remove old template field if exists
            if (isset($content->template)) {
                unset($content->template);
            }
            
            // Initialize meta as array
            $metaArray = is_array($content->meta) ? $content->meta : [];
            if (is_object($content->meta)) {
                $metaArray = (array)$content->meta;
            }
            
            // Get template if provided
            $template = null;
            if ($newTemplateId) {
                $template = Template::where('identifier', $newTemplateId)->first();
            }
            
            // If template has changed, apply default settings and content
            if ($previousTemplateId !== $newTemplateId && $template) {
                // Apply default content values if available
                if (!empty($template->default_content)) {
                    foreach ($template->default_content as $key => $value) {
                        // Don't overwrite value field, handled separately
                        if ($key === 'content' && empty($content->value)) {
                            $content->value = $value;
                        } else {
                            $metaArray[$key] = $value;
                        }
                    }
                }
            }
            
            // Process meta fields from request
            foreach ($request->all() as $key => $value) {
                if (strpos($key, 'meta_') === 0) {
                    $metaKey = substr($key, 5);
                    $metaArray[$metaKey] = $value;
                }
            }

            // Handle image uploads
            if ($request->hasFile('image_file')) {
                $file = $request->file('image_file');
                
                if ($file->isValid()) {
                    $path = $file->store('content-images', 'public');
                    $metaArray['image'] = $path;
                    
                    // If this is a card with no title yet, use the filename as title
                    if ($content->type === 'card' && empty($metaArray['title'])) {
                        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $metaArray['title'] = ucwords(str_replace(['-', '_'], ' ', $filename));
                    }
                } else {
                    Log::error('Invalid uploaded file', [
                        'content_id' => $content->id, 
                        'error' => $file->getErrorMessage()
                    ]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid file upload: ' . $file->getErrorMessage()
                    ], 400);
                }
            }
            
            // Handle remove image flag
            if ($request->has('remove_image') && $request->remove_image) {
                if (isset($metaArray['image']) && Storage::disk('public')->exists($metaArray['image'])) {
                    Storage::disk('public')->delete($metaArray['image']);
                }
                
                unset($metaArray['image']);
            }
            
            // Set the meta field to the array (Laravel will handle JSON encoding via casts)
            $content->meta = $metaArray;
            
            // Debug log
            Log::info('Saving component settings', [
                'component_id' => $content->id,
                'template_identifier' => $content->template_identifier,
                'meta_type' => gettype($content->meta),
                'meta' => $content->meta
            ]);
            
            // Save the content
            $content->save();
            
            // Return response based on request type
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => __('Component settings saved successfully'),
                    'component' => $content,
                    'has_image' => isset($metaArray['image'])
                ]);
            } else {
                return redirect()->route('admin.layout.builder', $content->page_id)
                    ->with('success', __('Component settings saved successfully'));
            }
        } catch (\Exception $e) {
            Log::error('Error saving component settings: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => __('Error saving component settings: ') . $e->getMessage()
                ], 500);
            } else {
                return back()->withErrors([__('Error saving component settings') . ': ' . $e->getMessage()]);
            }
        }
    }
    
    /**
     * Show the section settings form
     */
    public function sectionSettings($id)
    {
        $section = Section::findOrFail($id);
        return view('admin.layout.section-settings', compact('section'));
    }
    
    /**
     * Save section settings - Completely fixed approach
     */
    public function saveSectionSettings(Request $request, $id)
    {
        // Find the section or fail with 404
        $section = Section::findOrFail($id);
        $page_id = $section->page_id;
        
        // Store detailed debug information
        Log::info('Section Settings Form Data:', [
            'request_all' => $request->all(),
            'title' => $request->input('title'),
            'identifier' => $request->input('identifier', $section->identifier),
            'type' => $request->input('type', $section->type)
        ]);
        
        try {
            // Force update directly in the database with guaranteed values
            DB::table('sections')
                ->where('id', $section->id)
                ->update([
                    'title' => $request->input('title'),
                    'identifier' => $request->input('identifier', $section->identifier), // Use existing if not provided
                    'type' => $request->input('type', $section->type), // Use existing if not provided
                    'order' => $request->input('order', 0),
                    'is_active' => $request->has('is_active') ? 1 : 0,
                    'background_color' => $request->input('background_color'),
                    'text_color' => $request->input('text_color'),
                    'padding' => $request->input('padding'),
                    'margin' => $request->input('margin'),
                    'css_class' => $request->input('css_class'),
                    'css_style' => $request->input('css_style'),
                    'updated_at' => now()
                ]);
            
            // Process meta data
            $meta = [];
            foreach ($request->all() as $key => $value) {
                if (strpos($key, 'meta_') === 0) {
                    $metaKey = substr($key, 5); // Remove 'meta_' prefix
                    $meta[$metaKey] = $value;
                }
            }
            
            // Update meta data fields
            if (!empty($meta)) {
                DB::table('sections')
                    ->where('id', $section->id)
                    ->update([
                        'meta' => json_encode($meta),
                        'meta_data' => json_encode($meta)
                    ]);
            }
                
            // Flash success message
            return redirect()->route('admin.layout.builder', $page_id)
                ->with('success', 'Section settings saved successfully. Title: ' . $request->input('title'));
                
        } catch (\Exception $e) {
            // Log detailed error
            Log::error('Error saving section settings', [
                'exception' => $e->getMessage(),
                'section_id' => $id,
                'request' => $request->all()
            ]);
            
            // Redirect with error
            return redirect()->back()
                ->with('error', 'Error saving section settings: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Save the layout
     */
    public function saveLayout(Request $request, $pageId)
    {
        $page = Page::findOrFail($pageId);
        
        // Check for specific actions
        if ($request->has('action')) {
            if ($request->action === 'check_section') {
                $sectionIdentifier = $request->section_identifier;
                $section = Section::where('identifier', $sectionIdentifier)->first();
                
                if ($section) {
                    return response()->json(['section_id' => $section->id]);
                } else {
                    return response()->json(['section_id' => null]);
                }
            }
            elseif ($request->action === 'update_section_order') {
                // Handle section order update
                $sectionOrder = $request->section_order ?? [];
                
                DB::beginTransaction();
                try {
                    foreach ($sectionOrder as $index => $sectionId) {
                        $section = Section::where('identifier', $sectionId)->first();
                        if ($section) {
                            $section->order = $index;
                            $section->save();
                        }
                    }
                    
                    DB::commit();
                    return response()->json(['success' => true, 'message' => 'Section order updated successfully']);
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Error updating section order: ' . $e->getMessage());
                    return response()->json(['success' => false, 'message' => 'Error updating section order: ' . $e->getMessage()], 500);
                }
            }
        }
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Get layout data
            $layoutData = $request->layout ?? [];
            $deletedItems = $request->deleted_items ?? [];
            $sectionOrder = $request->section_order ?? [];
            $deletedSections = $request->deleted_sections ?? false;
            $deletedSectionIds = $request->deleted_section_ids ?? [];
            
            // Get existing sections for this page
            $existingSections = Section::where('page_id', $pageId)->get();
            $existingSectionIds = $existingSections->pluck('identifier')->toArray();
            
            // Process explicitly deleted sections first
            if (!empty($deletedSectionIds)) {
                foreach ($deletedSectionIds as $sectionIdentifier) {
                    $section = Section::where('identifier', $sectionIdentifier)->first();
                    if ($section) {
                        // Delete the section and its contents
                        Content::where('section_id', $section->id)->delete();
                        $section->delete();
                    }
                }
            }

            // If sections are being tracked in sectionOrder, remove any that aren't present anymore
            if (!empty($sectionOrder)) {
                foreach ($existingSections as $section) {
                    if (!in_array($section->identifier, $sectionOrder) && !in_array($section->identifier, $deletedSectionIds)) {
                        // Delete the section and its contents
                        Content::where('section_id', $section->id)->delete();
                        $section->delete();
                    }
                }
            } 
            // If all sections were deleted (empty page)
            elseif ($deletedSections) {
                // Delete all sections and contents for this page
                foreach ($existingSections as $section) {
                    Content::where('section_id', $section->id)->delete();
                    $section->delete();
                }
            }
            
            // Process deleted items
            foreach ($deletedItems as $id) {
                Content::destroy($id);
            }
            
            // Process section order if provided
            if (!empty($sectionOrder)) {
                foreach ($sectionOrder as $index => $sectionId) {
                    $section = Section::where('identifier', $sectionId)->first();
                    if ($section) {
                        $section->order = $index;
                        $section->save();
                    }
                }
            }
            
            // Process layout components
            foreach ($layoutData as $componentData) {
                $sectionIdentifier = $componentData['section'] ?? null;
                
                if (!$sectionIdentifier) {
                    continue;
                }
                
                // Find or create section
                $section = Section::firstOrCreate(
                    ['identifier' => $sectionIdentifier],
                    [
                        'page_id' => $page->id,
                        'title' => ucfirst(str_replace('-', ' ', $sectionIdentifier)),
                        'type' => $componentData['section_type'] ?? 'content',
                        'is_active' => true,
                    ]
                );
                
                // Make sure page_id is always set (in case the section already existed)
                if (!$section->page_id) {
                    $section->page_id = $page->id;
                    $section->save();
                }
                
                // Find or create content
                if (isset($componentData['id']) && !str_starts_with($componentData['id'], 'new-')) {
                    // Update existing content
                    $content = Content::find($componentData['id']);
                    
                    if ($content) {
                        $content->page_id = $page->id;
                        $content->section_id = $section->id;
                        $content->section = $sectionIdentifier;
                        $content->type = $componentData['type'] ?? 'text';
                        $content->order = $componentData['order'] ?? 0;
                        $content->column_width = $componentData['column_width'] ?? null;
                        $content->template_identifier = $componentData['template_identifier'] ?? null;
                        
                        // Initialize meta as array
                        $metaArray = is_array($content->meta) ? $content->meta : [];
                        if (is_object($content->meta)) {
                            $metaArray = (array)$content->meta;
                        }
                        
                        // Update meta data
                        if (isset($componentData['meta_data'])) {
                            foreach ($componentData['meta_data'] as $key => $value) {
                                $metaArray[$key] = $value;
                            }
                        }
                        
                        // Set meta field (Laravel will handle JSON encoding via casts)
                        $content->meta = $metaArray;
                        
                        $content->save();
                    }
                } else {
                    // Create new content
                    $content = new Content();
                    $content->page_id = $page->id;
                    $content->section_id = $section->id;
                    $content->section = $sectionIdentifier;
                    $content->title = $componentData['title'] ?? 'New ' . ucfirst($componentData['type'] ?? 'Component');
                    $content->type = $componentData['type'] ?? 'text';
                    $content->order = $componentData['order'] ?? 0;
                    $content->column_width = $componentData['column_width'] ?? null;
                    $content->template_identifier = $componentData['template_identifier'] ?? null;
                    $content->is_active = true;
                    $content->identifier = 'content-' . time() . '-' . mt_rand(1000, 9999);
                    
                    // Initialize meta as array
                    $metaArray = [];
                    
                    // Set default values based on component type
                    if ($content->type == 'text') {
                        $content->value = $componentData['value'] ?? '<p>Add your content here</p>';
                    } elseif ($content->type == 'card') {
                        $content->value = $componentData['value'] ?? '<p>Card content goes here</p>';
                        $metaArray = [
                            'title' => 'Card Title',
                            'subtitle' => 'Card Subtitle',
                            'button_text' => 'Learn More',
                            'button_url' => '#',
                            'button_style' => 'primary'
                        ];
                    } elseif ($content->type == 'button') {
                        $metaArray = [
                            'button_text' => 'Click Me',
                            'button_url' => '#',
                            'button_style' => 'primary',
                            'button_size' => '',
                            'alignment' => 'center'
                        ];
                    } else {
                        $content->value = $componentData['value'] ?? '';
                    }
                    
                    // Add meta data from the request
                    if (isset($componentData['meta_data']) && is_array($componentData['meta_data'])) {
                        foreach ($componentData['meta_data'] as $key => $value) {
                            $metaArray[$key] = $value;
                        }
                    }
                    
                    // Set meta field (Laravel will handle JSON encoding via casts)
                    $content->meta = $metaArray;
                    
                    // Debug log
                    Log::info('Creating new content component', [
                        'title' => $content->title,
                        'type' => $content->type,
                        'meta' => $content->meta
                    ]);
                    
                    $content->save();
                }
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true, 
                'message' => 'Layout saved successfully',
                'page_id' => $page->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving layout: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error saving layout: ' . $e->getMessage()], 500);
        }
    }
    
    /**
     * Get templates for a component type
     */
    public function getTemplates(Request $request)
    {
        $type = $request->type ?? '';
        
        // Get templates from the database for this type
        $templates = \App\Models\Opportunities\CircularEconomy\Template::where('type', $type)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
            
        if ($templates->isEmpty()) {
            return response()->json([]);
        }
        
        // Format the templates for the frontend
        $formattedTemplates = [];
        foreach ($templates as $template) {
            $formattedTemplates[] = [
                'id' => $template->identifier,
                'name' => $template->name,
                'description' => $template->description,
                'thumbnail' => asset($template->thumbnail ? 'storage/' . $template->thumbnail : 'images/templates/default.jpg')
            ];
        }
        
        return response()->json($formattedTemplates);
    }
    
    /**
     * Preview a component in the builder interface
     */
    public function previewComponent(Request $request, $id)
    {
        try {
            // Flag to indicate this is a preview request
            $request->merge(['preview_mode' => true]);
            
            // Get content object
            $content = Content::findOrFail($id);
            
            // If updating type or template, temporarily update on the model (without saving)
            if ($request->has('type')) {
                $content->type = $request->input('type');
            }
            
            if ($request->has('template_identifier')) {
                $content->template_identifier = $request->input('template_identifier');
            } else if ($request->has('template')) {
                $content->template = $request->input('template');
            }
            
            // Update value if provided
            if ($request->has('value')) {
                $content->value = $request->input('value');
            }
            
            // Process all meta fields from request temporarily
            foreach ($request->all() as $key => $value) {
                if (strpos($key, 'meta_') === 0) {
                    $metaKey = substr($key, 5);
                    
                    // Create meta object if it doesn't exist
                    if (empty($content->meta)) {
                        $content->meta = (object)[];
                    }
                    
                    $content->meta->$metaKey = $value;
                }
            }
            
            // Get all form builders for form components
            $formBuilders = \App\Models\Opportunities\CircularEconomy\FormBuilder::where('is_active', true)
                                          ->pluck('title', 'id')
                                          ->toArray();
            
            // Use our TemplateHelper to render the component
            $html = \App\Helpers\TemplateHelper::renderComponent($content, [
                'isPreview' => true,
                'formBuilders' => $formBuilders
            ]);
            
            return response()->json([
                'success' => true,
                'html' => $html
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error generating component preview: ' . $e->getMessage(), [
                'content_id' => $id,
                'exception' => $e
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'html' => '<div class="alert alert-danger">
                             <i class="fas fa-exclamation-triangle me-2"></i>
                             Error generating preview: ' . $e->getMessage() . '
                          </div>'
            ]);
        }
    }
    
    /**
     * Add a component to a section via AJAX
     */
    public function addComponent(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'section_id' => 'required',
                'type' => 'required|string',
                'title' => 'nullable|string',
                'page_id' => 'required|integer',
                'template_identifier' => 'nullable|string'
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Validation failed', 
                    'errors' => $validator->errors()
                ], 422);
            }
            
            // Find the section
            $section = null;
            if (is_numeric($request->section_id)) {
                $section = Section::find($request->section_id);
            } else {
                $section = Section::where('identifier', $request->section_id)->first();
            }
            
            if (!$section) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Section not found'
                ], 404);
            }
            
            // Create a new component
            $content = new Content();
            $content->section_id = $section->id;
            $content->page_id = $request->page_id;
            $content->section = $section->identifier;
            $content->title = $request->title ?? 'New ' . ucfirst($request->type);
            $content->identifier = 'content-' . time() . '-' . mt_rand(1000, 9999);
            $content->type = $request->type;
            $content->template_identifier = $request->template_identifier;
            $content->is_active = true;
            $content->order = Content::where('section_id', $section->id)->max('order') + 1;
            
            // Find the template if template_identifier is provided
            $template = null;
            if (!empty($content->template_identifier)) {
                $template = Template::where('identifier', $content->template_identifier)->first();
            }
            
            // If no template was found but type exists, try to get a default template for this type
            if (!$template) {
                $template = Template::where('type', $content->type)
                    ->where('is_active', true)
                    ->first();
                    
                if ($template) {
                    $content->template_identifier = $template->identifier;
                }
            }
            
            // Prepare meta data
            $metaData = [];
            
            // Apply template default content if available
            if ($template && !empty($template->default_content)) {
                foreach ($template->default_content as $key => $value) {
                    $metaData[$key] = $value;
                }
            }
            
            // Set additional meta data based on component type
            if ($content->type == 'text' && empty($content->value)) {
                $content->value = $metaData['content'] ?? '<p>Add your content here</p>';
            } elseif ($content->type == 'card') {
                if (empty($content->value)) {
                    $content->value = $metaData['content'] ?? '<p>Card content goes here</p>';
                }
            } elseif ($content->type == 'image' && !isset($metaData['alt_text'])) {
                $metaData['alt_text'] = 'Image description';
            }
            
            // Save metadata
            $content->meta = $metaData;
            
            // Save the component
            $content->save();
            
            // Load component template for the response
            $componentHtml = view('admin.layout.component-item', [
                'content' => $content,
                'component' => [
                    'id' => $content->id,
                    'type' => $content->type,
                    'template_identifier' => $content->template_identifier
                ]
            ])->render();
            
            return response()->json([
                'success' => true,
                'message' => 'Component added successfully',
                'component' => [
                    'id' => $content->id,
                    'title' => $content->title,
                    'type' => $content->type,
                    'template_identifier' => $content->template_identifier,
                    'html' => $componentHtml
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error adding component: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error adding component: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get component types with templates
     */
    public function getComponentTypes()
    {
        return [
            'text' => [
                'basic' => 'Basic Text',
                'card' => 'Card Style',
                'quote' => 'Quote/Testimonial',
                'heading' => 'Heading',
                'paragraph' => 'Paragraph',
            ],
            'image' => [
                'standard' => 'Standard Image',
                'rounded' => 'Rounded Image',
                'captioned' => 'Captioned Image',
                'featured' => 'Featured Image',
            ],
            'button' => [
                'primary' => 'Primary Button',
                'secondary' => 'Secondary Button',
                'outline' => 'Outline Button',
                'link' => 'Link Button',
            ],
            'form' => [
                'standard' => 'Standard Form',
                'inline' => 'Inline Form',
                'card' => 'Card Form',
            ],
            'card' => [
                'standard' => 'Standard Card',
                'horizontal' => 'Horizontal Card',
                'overlay' => 'Image Overlay Card',
                'featured' => 'Featured Card',
            ],
            'video' => [
                'standard' => 'Standard Video',
                'fullwidth' => 'Full Width Video',
                'modal' => 'Modal Video',
            ],
            'map' => [
                'standard' => 'Standard Map',
                'fullwidth' => 'Full Width Map',
            ],
            'chart' => [
                'bar' => 'Bar Chart',
                'line' => 'Line Chart',
                'pie' => 'Pie Chart',
                'doughnut' => 'Doughnut Chart',
            ],
            'divider' => [
                'solid' => 'Solid Line',
                'dashed' => 'Dashed Line',
                'dotted' => 'Dotted Line',
                'spacer' => 'Spacer',
            ],
        ];
    }
}
