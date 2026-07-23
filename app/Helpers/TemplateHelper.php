<?php

namespace App\Helpers;

use App\Models\Opportunities\CircularEconomy\Template;
use App\Models\Opportunities\CircularEconomy\Content;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

class TemplateHelper
{
    /**
     * Render a component with its template
     *
     * @param Content $content The content to render
     * @param array $options Additional options for rendering
     * @return string The rendered HTML
     */
    public static function renderComponent(Content $content, array $options = []): string
    {
        try {
            // Get the component type
            $type = $content->type;
            
            // Get the template if specified
            $template = null;
            $templateData = [];
            
            if ($content->template_identifier) {
                $template = Template::where('identifier', $content->template_identifier)->first();
                
                if ($template) {
                    $templateData = [
                        'template' => $template,
                        'settings' => $template->getDefaultSettings(),
                        'defaultContent' => $template->getDefaultContent()
                    ];
                }
            }
            
            // Set options for the view
            $viewOptions = array_merge([
                'content' => $content,
                'templateData' => $templateData,
                'isPreview' => $options['isPreview'] ?? false
            ], $options);
            
            // Try to use template-specific view first
            if ($content->template_identifier) {
                $templatePath = "templates.components.{$content->template_identifier}";
                if (View::exists($templatePath)) {
                    return View::make($templatePath, $viewOptions)->render();
                }
            }
            
            // Then try template type view
            $typePath = "templates.components.{$type}";
            if (View::exists($typePath)) {
                return View::make($typePath, $viewOptions)->render();
            }
            
            // Check if the component view exists
            $viewPath = "admin.layout.components.{$type}";
            if (View::exists($viewPath)) {
                return View::make($viewPath, $viewOptions)->render();
            } else {
                // Fallback to default component
                return View::make('admin.layout.components.default', $viewOptions)->render();
            }
        } catch (\Exception $e) {
            Log::error('Error rendering component: ' . $e->getMessage(), [
                'content_id' => $content->id ?? 'unknown',
                'type' => $content->type ?? 'unknown',
                'template_identifier' => $content->template_identifier ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Return error message in development, empty in production
            if (config('app.debug')) {
                return '<div class="alert alert-danger">Error rendering component: ' . e($e->getMessage()) . '</div>';
            }
            
            return '<div class="alert alert-info">This component cannot be displayed.</div>';
        }
    }
    
    /**
     * Get template data for a content
     *
     * @param Content $content The content object
     * @return array Template data
     */
    public static function getTemplateData(Content $content): array
    {
        if (empty($content->template_identifier)) {
            return [];
        }
        
        $template = Template::where('identifier', $content->template_identifier)->first();
        
        if (!$template) {
            return [];
        }
        
        return [
            'template' => $template,
            'settings' => $template->getDefaultSettings(),
            'defaultContent' => $template->getDefaultContent()
        ];
    }
    
    /**
     * Get CSS classes for a component
     *
     * @param Content $content The content
     * @return string CSS classes
     */
    public static function getCssClasses(Content $content): string
    {
        $classes = [];
        
        // Add component type
        $classes[] = $content->type . '-component';
        
        // Add template identifier if available
        if ($content->template_identifier) {
            $classes[] = $content->template_identifier;
            
            // Add template classes if available
            if ($content->template && $content->template->css_classes) {
                $classes[] = $content->template->css_classes;
            }
        }
        
        // Add custom CSS class if defined
        if (isset($content->meta->css_class)) {
            $classes[] = $content->meta->css_class;
        }
        
        return implode(' ', $classes);
    }
    
    /**
     * Get inline styles for a component
     *
     * @param Content $content The content
     * @return string Inline CSS styles
     */
    public static function getInlineStyles(Content $content): string
    {
        $styleArray = [];
        
        // Add margin if defined
        if ($content->margin) {
            $styleArray[] = "margin: {$content->margin}";
        }
        
        // Add padding if defined
        if ($content->padding) {
            $styleArray[] = "padding: {$content->padding}";
        }
        
        // Add custom CSS style if defined
        if (isset($content->meta->css_style)) {
            $styleArray[] = $content->meta->css_style;
        }
        
        return implode('; ', $styleArray);
    }
} 