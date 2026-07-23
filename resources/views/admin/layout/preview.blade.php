<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $page->title }} - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --body-bg: #ffffff;
            --body-color: #212529;
            --border-radius: 0.375rem;
            --box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--body-color);
            background-color: var(--body-bg);
        }
        
        /* Section styles */
        .section {
            padding: 3rem 0;
            position: relative;
            overflow: hidden;
        }
        
        /* Component styles */
        .component {
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }
        
        .component:hover {
            transform: translateY(-2px);
        }
        
        /* Hero sections */
        .hero-section {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 5rem 0;
            position: relative;
        }
        
        .hero-section h1 {
            font-weight: 700;
            margin-bottom: 1.5rem;
            font-size: 2.5rem;
        }
        
        .hero-section .lead {
            font-size: 1.25rem;
            font-weight: 300;
            margin-bottom: 2rem;
        }
        
        /* Content sections */
        .content-section {
            background-color: var(--body-bg);
        }
        
        /* Column layouts */
        .columns-2 .row > div,
        .columns-3 .row > div,
        .columns-4 .row > div {
            margin-bottom: 2rem;
        }
        
        /* Card styles */
        .card {
            border-radius: var(--border-radius);
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
        }
        
        .card:hover {
            box-shadow: var(--box-shadow);
        }
        
        .card-img-top {
            height: 180px;
            object-fit: cover;
        }
        
        .card-title {
            font-weight: 600;
            margin-bottom: 0.75rem;
        }
        
        /* CTA section */
        .cta-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #0143a3 100%);
            color: white;
            padding: 4rem 0;
            text-align: center;
        }
        
        .cta-section h2 {
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .cta-section .btn {
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }
        
        /* Grid section */
        .grid-section {
            background-color: var(--light-color);
        }
        
        /* Form section */
        .form-section {
            background-color: var(--body-bg);
        }
        
        .form-control {
            border-radius: var(--border-radius);
            padding: 0.75rem 1rem;
        }
        
        /* Button styling */
        .btn {
            border-radius: var(--border-radius);
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #0143a3 100%);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #0b5ed7 0%, #0143a3 100%);
            border-color: #0a58ca;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }
        
        /* Image styles */
        .image-component img {
            max-width: 100%;
            height: auto;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .image-component img:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .image-rounded img {
            border-radius: 50%;
        }
        
        /* Text components */
        .text-component h2, 
        .text-component h3, 
        .text-component h4 {
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .text-component p {
            margin-bottom: 1.5rem;
        }
        
        .text-component ul, 
        .text-component ol {
            margin-bottom: 1.5rem;
            padding-left: 1.5rem;
        }
        
        /* Divider */
        .divider-component {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(0,0,0,0.1), transparent);
            margin: 3rem 0;
        }
        
        /* Testimonial/Quote styles */
        blockquote {
            background-color: rgba(13, 110, 253, 0.05);
            border-left: 4px solid var(--primary-color);
            padding: 1.5rem;
            margin: 1.5rem 0;
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
        }
        
        blockquote p {
            font-style: italic;
            margin-bottom: 0.5rem;
        }
        
        blockquote footer {
            font-size: 0.875rem;
            color: var(--secondary-color);
        }
        
        /* Feature item */
        .feature-item {
            display: flex;
            margin-bottom: 1.5rem;
        }
        
        .feature-icon {
            flex-shrink: 0;
            width: 3rem;
            height: 3rem;
            background-color: rgba(13, 110, 253, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: var(--primary-color);
        }
        
        /* Role visibility */
        .admin-only {
            position: relative;
            border: 2px dashed var(--danger-color);
            border-radius: var(--border-radius);
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .admin-only::before {
            content: 'Admin Only';
            position: absolute;
            top: -0.75rem;
            right: 1rem;
            background: var(--danger-color);
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: var(--border-radius);
            font-weight: 600;
        }
        
        .editor-only {
            position: relative;
            border: 2px dashed var(--warning-color);
            border-radius: var(--border-radius);
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .editor-only::before {
            content: 'Editor Only';
            position: absolute;
            top: -0.75rem;
            right: 1rem;
            background: var(--warning-color);
            color: var(--dark-color);
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: var(--border-radius);
            font-weight: 600;
        }
        
        .user-only {
            position: relative;
            border: 2px dashed var(--success-color);
            border-radius: var(--border-radius);
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .user-only::before {
            content: 'User Only';
            position: absolute;
            top: -0.75rem;
            right: 1rem;
            background: var(--success-color);
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: var(--border-radius);
            font-weight: 600;
        }

        /* Card overlay styles */
        .card-overlay {
            position: relative;
            overflow: hidden;
            border-radius: var(--border-radius);
        }

        .card-overlay .card-img {
            transition: all 0.5s ease;
        }

        .card-overlay:hover .card-img {
            transform: scale(1.05);
        }

        .card-overlay .card-img-overlay {
            background: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.7));
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        /* Masonry section */
        .masonry-section .masonry-grid {
            column-count: 3;
            column-gap: 1.5rem;
        }

        @media (max-width: 992px) {
            .masonry-section .masonry-grid {
                column-count: 2;
            }
        }

        @media (max-width: 576px) {
            .masonry-section .masonry-grid {
                column-count: 1;
            }
        }

        .masonry-section .masonry-item {
            display: inline-block;
            margin-bottom: 1.5rem;
            width: 100%;
        }

        /* Animation classes */
        .animate-fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }

        .animate-slide-up {
            animation: slideUp 0.8s ease-in-out;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes slideInRight {
            from { transform: translateX(50px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="container-fluid px-0">
        @php
            $sections = $page->contents->pluck('section')->unique();
            $userRole = request()->query('role', 'admin');
        @endphp
        
        @foreach($sections as $sectionName)
            @php
                $sectionContents = $page->contents->where('section', $sectionName)->sortBy('order');
                $sectionObj = App\Models\Section::where('identifier', $sectionName)->first();
                $sectionType = $sectionObj ? $sectionObj->type : 'content';
                
                // Fallback to content meta_data if section object is not found
                if (!$sectionObj && $sectionContents->isNotEmpty()) {
                    $firstContent = $sectionContents->first();
                    $meta = is_array($firstContent->meta) ? $firstContent->meta : 
                           (is_object($firstContent->meta) ? (array)$firstContent->meta : []);
                    $sectionType = $meta['section_type'] ?? 'content';
                }
                
                // Section CSS
                $sectionStyle = '';
                if ($sectionObj) {
                    if ($sectionObj->background_color) {
                        $sectionStyle .= "background-color: {$sectionObj->background_color}; ";
                    }
                    if ($sectionObj->text_color) {
                        $sectionStyle .= "color: {$sectionObj->text_color}; ";
                    }
                    if ($sectionObj->padding) {
                        $sectionStyle .= "padding: {$sectionObj->padding}; ";
                    }
                    if ($sectionObj->margin) {
                        $sectionStyle .= "margin: {$sectionObj->margin}; ";
                    }
                    if ($sectionObj->css_style) {
                        $sectionStyle .= $sectionObj->css_style;
                    }
                }
            @endphp
            
            <div class="section {{ $sectionType }}-section {{ $sectionObj ? $sectionObj->css_class : '' }} animate-fade-in" 
                 id="{{ $sectionName }}" 
                 style="{{ $sectionStyle }}">
                <div class="container">
                    {{-- Display section components based on section type --}}
                    @if(view()->exists('templates.sections.' . $sectionType))
                        @include('templates.sections.' . $sectionType, [
                            'section' => $sectionObj,
                            'contents' => $sectionContents,
                            'userRole' => $userRole
                        ])
                    @elseif($sectionType == 'hero')
                        <div class="row align-items-center">
                            <div class="col-md-10 mx-auto text-center">
                                @foreach($sectionContents as $content)
                                    @php
                                        $meta = is_array($content->meta) ? $content->meta : 
                                              (is_object($content->meta) ? (array)$content->meta : []);
                                        $visibilityRoles = explode(',', $meta['visibility_roles'] ?? 'admin,editor,user,guest');
                                        $visibilityClass = '';
                                        
                                        if (!in_array('guest', $visibilityRoles) && in_array('admin', $visibilityRoles) && !in_array('editor', $visibilityRoles) && !in_array('user', $visibilityRoles)) {
                                            $visibilityClass = 'admin-only';
                                        } elseif (!in_array('guest', $visibilityRoles) && in_array('editor', $visibilityRoles) && !in_array('user', $visibilityRoles)) {
                                            $visibilityClass = 'editor-only';
                                        } elseif (!in_array('guest', $visibilityRoles) && in_array('user', $visibilityRoles)) {
                                            $visibilityClass = 'user-only';
                                        }
                                        
                                        // Check if the component should be visible to the current role
                                        $shouldDisplay = in_array($userRole, $visibilityRoles) || $userRole == 'admin';
                                        
                                        // Get CSS classes
                                        $cssClass = $meta['css_class'] ?? '';
                                        $cssStyle = $meta['css_style'] ?? '';
                                    @endphp
                                    
                                    @if($shouldDisplay)
                                        <div class="component {{ $content->type }}-component {{ $visibilityClass }} {{ $cssClass }} animate-slide-up" 
                                             id="component-{{ $content->id }}"
                                             style="{{ $cssStyle }}">
                                            @include('admin.layout.components.render', ['content' => $content, 'isPreview' => true])
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @elseif($sectionType == 'columns-2')
                        <div class="row">
                            @foreach($sectionContents as $content)
                                @php
                                    $meta = is_array($content->meta) ? $content->meta : 
                                          (is_object($content->meta) ? (array)$content->meta : []);
                                    $visibilityRoles = explode(',', $meta['visibility_roles'] ?? 'admin,editor,user,guest');
                                    $visibilityClass = '';
                                    
                                    if (!in_array('guest', $visibilityRoles) && in_array('admin', $visibilityRoles) && !in_array('editor', $visibilityRoles) && !in_array('user', $visibilityRoles)) {
                                        $visibilityClass = 'admin-only';
                                    } elseif (!in_array('guest', $visibilityRoles) && in_array('editor', $visibilityRoles) && !in_array('user', $visibilityRoles)) {
                                        $visibilityClass = 'editor-only';
                                    } elseif (!in_array('guest', $visibilityRoles) && in_array('user', $visibilityRoles)) {
                                        $visibilityClass = 'user-only';
                                    }
                                    
                                    // Check if the component should be visible to the current role
                                    $shouldDisplay = in_array($userRole, $visibilityRoles) || $userRole == 'admin';
                                    
                                    // Column width (if specified)
                                    $columnWidth = $meta['column_width'] ?? 'col-md-6';
                                    if (is_numeric($columnWidth)) {
                                        $columnWidth = 'col-md-' . $columnWidth;
                                    }
                                    
                                    // Get CSS classes
                                    $cssClass = $meta['css_class'] ?? '';
                                    $cssStyle = $meta['css_style'] ?? '';
                                @endphp
                                
                                @if($shouldDisplay)
                                    <div class="{{ $columnWidth }}">
                                        <div class="component {{ $content->type }}-component {{ $visibilityClass }} {{ $cssClass }} animate-slide-up" 
                                             id="component-{{ $content->id }}"
                                             style="{{ $cssStyle }}">
                                            @include('admin.layout.components.render', ['content' => $content, 'isPreview' => true])
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @elseif($sectionType == 'columns-3')
                        <div class="row">
                            @foreach($sectionContents as $content)
                                @php
                                    $meta = is_array($content->meta) ? $content->meta : 
                                          (is_object($content->meta) ? (array)$content->meta : []);
                                    $visibilityRoles = explode(',', $meta['visibility_roles'] ?? 'admin,editor,user,guest');
                                    $visibilityClass = '';
                                    
                                    if (!in_array('guest', $visibilityRoles) && in_array('admin', $visibilityRoles) && !in_array('editor', $visibilityRoles) && !in_array('user', $visibilityRoles)) {
                                        $visibilityClass = 'admin-only';
                                    } elseif (!in_array('guest', $visibilityRoles) && in_array('editor', $visibilityRoles) && !in_array('user', $visibilityRoles)) {
                                        $visibilityClass = 'editor-only';
                                    } elseif (!in_array('guest', $visibilityRoles) && in_array('user', $visibilityRoles)) {
                                        $visibilityClass = 'user-only';
                                    }
                                    
                                    // Check if the component should be visible to the current role
                                    $shouldDisplay = in_array($userRole, $visibilityRoles) || $userRole == 'admin';
                                    
                                    // Column width (if specified)
                                    $columnWidth = $meta['column_width'] ?? 'col-md-4';
                                    if (is_numeric($columnWidth)) {
                                        $columnWidth = 'col-md-' . $columnWidth;
                                    }
                                    
                                    // Get CSS classes
                                    $cssClass = $meta['css_class'] ?? '';
                                    $cssStyle = $meta['css_style'] ?? '';
                                @endphp
                                
                                @if($shouldDisplay)
                                    <div class="{{ $columnWidth }}">
                                        <div class="component {{ $content->type }}-component {{ $visibilityClass }} {{ $cssClass }} animate-slide-up" 
                                             id="component-{{ $content->id }}"
                                             style="{{ $cssStyle }}">
                                            @include('admin.layout.components.render', ['content' => $content, 'isPreview' => true])
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @elseif($sectionType == 'masonry')
                        <div class="masonry-grid">
                            @foreach($sectionContents as $content)
                                @php
                                    $meta = is_array($content->meta) ? $content->meta : 
                                          (is_object($content->meta) ? (array)$content->meta : []);
                                    $visibilityRoles = explode(',', $meta['visibility_roles'] ?? 'admin,editor,user,guest');
                                    $visibilityClass = '';
                                    
                                    if (!in_array('guest', $visibilityRoles) && in_array('admin', $visibilityRoles) && !in_array('editor', $visibilityRoles) && !in_array('user', $visibilityRoles)) {
                                        $visibilityClass = 'admin-only';
                                    } elseif (!in_array('guest', $visibilityRoles) && in_array('editor', $visibilityRoles) && !in_array('user', $visibilityRoles)) {
                                        $visibilityClass = 'editor-only';
                                    } elseif (!in_array('guest', $visibilityRoles) && in_array('user', $visibilityRoles)) {
                                        $visibilityClass = 'user-only';
                                    }
                                    
                                    // Check if the component should be visible to the current role
                                    $shouldDisplay = in_array($userRole, $visibilityRoles) || $userRole == 'admin';
                                    
                                    // Get CSS classes
                                    $cssClass = $meta['css_class'] ?? '';
                                    $cssStyle = $meta['css_style'] ?? '';
                                @endphp
                                
                                @if($shouldDisplay)
                                    <div class="masonry-item animate-fade-in">
                                        <div class="component {{ $content->type }}-component {{ $visibilityClass }} {{ $cssClass }}" 
                                             id="component-{{ $content->id }}"
                                             style="{{ $cssStyle }}">
                                            @include('admin.layout.components.render', ['content' => $content, 'isPreview' => true])
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="row">
                            @foreach($sectionContents as $content)
                                @php
                                    $meta = is_array($content->meta) ? $content->meta : 
                                          (is_object($content->meta) ? (array)$content->meta : []);
                                    $visibilityRoles = explode(',', $meta['visibility_roles'] ?? 'admin,editor,user,guest');
                                    $visibilityClass = '';
                                    
                                    if (!in_array('guest', $visibilityRoles) && in_array('admin', $visibilityRoles) && !in_array('editor', $visibilityRoles) && !in_array('user', $visibilityRoles)) {
                                        $visibilityClass = 'admin-only';
                                    } elseif (!in_array('guest', $visibilityRoles) && in_array('editor', $visibilityRoles) && !in_array('user', $visibilityRoles)) {
                                        $visibilityClass = 'editor-only';
                                    } elseif (!in_array('guest', $visibilityRoles) && in_array('user', $visibilityRoles)) {
                                        $visibilityClass = 'user-only';
                                    }
                                    
                                    // Check if the component should be visible to the current role
                                    $shouldDisplay = in_array($userRole, $visibilityRoles) || $userRole == 'admin';
                                    
                                    // Column width (if specified)
                                    $columnWidth = $meta['column_width'] ?? 'col-12';
                                    if (is_numeric($columnWidth)) {
                                        $columnWidth = 'col-md-' . $columnWidth;
                                    }
                                    
                                    // Get CSS classes and style
                                    $cssClass = $meta['css_class'] ?? '';
                                    $cssStyle = $meta['css_style'] ?? '';
                                @endphp
                                
                                @if($shouldDisplay)
                                    <div class="{{ $columnWidth }}">
                                        <div class="component {{ $content->type }}-component {{ $visibilityClass }} {{ $cssClass }} animate-slide-up" 
                                             id="component-{{ $content->id }}"
                                             style="{{ $cssStyle }}">
                                            @include('admin.layout.components.render', ['content' => $content, 'isPreview' => true])
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add animated entry for components when they come into view
        document.addEventListener('DOMContentLoaded', function() {
            // Function to check if element is in viewport
            function isInViewport(element) {
                const rect = element.getBoundingClientRect();
                return (
                    rect.top >= 0 &&
                    rect.left >= 0 &&
                    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                );
            }
            
            // Apply animation to elements that are initially in view
            const animatedElements = document.querySelectorAll('.animate-fade-in, .animate-slide-up, .animate-slide-in-right');
            
            animatedElements.forEach(element => {
                if (isInViewport(element)) {
                    element.style.opacity = '1';
                } else {
                    element.style.opacity = '0';
                }
            });
            
            // Apply animation as elements come into view
            window.addEventListener('scroll', function() {
                animatedElements.forEach(element => {
                    if (isInViewport(element)) {
                        element.style.opacity = '1';
                    }
                });
            });
        });
    </script>
</body>
</html> 