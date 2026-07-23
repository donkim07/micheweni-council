@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Home Page Configuration Guide') }}</h5>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> {{ __('Back to Dashboard') }}
                    </a>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle me-2"></i>{{ __('Overview') }}</h5>
                        <p>{{ __('This guide will help you set up the content blocks needed to fully customize the home page. The home page is divided into several sections, each of which can be managed through the Content Management system.') }}</p>
                    </div>

                    <div class="table-responsive mt-4">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('Section') }}</th>
                                    <th>{{ __('Identifier') }}</th>
                                    <th>{{ __('Content Type') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ __('Hero Section') }}</td>
                                    <td><code>hero</code> (section identifier)</td>
                                    <td>{{ __('HTML or Image') }}</td>
                                    <td>{{ __('Main heading and introductory text at the top of the home page. Can include an image.') }}</td>
                                    <td>
                                        <a href="{{ route('admin.contents.create', ['section' => 'hero', 'page_id' => $homePage->id ?? null]) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus"></i> {{ __('Create') }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Services Heading') }}</td>
                                    <td><code>home_services_heading</code></td>
                                    <td>{{ __('HTML') }}</td>
                                    <td>{{ __('Heading and subheading for the Services section.') }}</td>
                                    <td>
                                        <a href="{{ route('admin.contents.create', ['identifier' => 'home_services_heading']) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus"></i> {{ __('Create') }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Featured Services') }}</td>
                                    <td><code>featured</code> (section identifier)</td>
                                    <td>{{ __('HTML or Image') }}</td>
                                    <td>{{ __('Service cards displayed in the services section. Create multiple content blocks with this section identifier.') }}</td>
                                    <td>
                                        <a href="{{ route('admin.contents.create', ['section' => 'featured']) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus"></i> {{ __('Create') }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Map Section Heading') }}</td>
                                    <td><code>home_map_heading</code></td>
                                    <td>{{ __('HTML') }}</td>
                                    <td>{{ __('Heading and description for the waste management map section.') }}</td>
                                    <td>
                                        <a href="{{ route('admin.contents.create', ['identifier' => 'home_map_heading']) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus"></i> {{ __('Create') }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('News Section Heading') }}</td>
                                    <td><code>home_news_heading</code></td>
                                    <td>{{ __('HTML') }}</td>
                                    <td>{{ __('Heading and subheading for the Latest News section.') }}</td>
                                    <td>
                                        <a href="{{ route('admin.contents.create', ['identifier' => 'home_news_heading']) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus"></i> {{ __('Create') }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('About Section') }}</td>
                                    <td><code>about</code> (section identifier)</td>
                                    <td>{{ __('HTML or Image') }}</td>
                                    <td>{{ __('Content for the About section on the home page.') }}</td>
                                    <td>
                                        <a href="{{ route('admin.contents.create', ['section' => 'about']) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus"></i> {{ __('Create') }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Call to Action') }}</td>
                                    <td><code>home_cta</code></td>
                                    <td>{{ __('HTML with meta data') }}</td>
                                    <td>{{ __('The call-to-action section at the bottom of the home page. Includes title, content, and button links.') }}</td>
                                    <td>
                                        <a href="{{ route('admin.contents.create', ['identifier' => 'home_cta']) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus"></i> {{ __('Create') }}
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <h5>{{ __('Meta Data Configuration') }}</h5>
                        <p>{{ __('Some content blocks support additional configuration through the meta data field. This is stored as JSON and can include:') }}</p>
                        
                        <div class="card mb-3">
                            <div class="card-header">{{ __('Featured Content Meta Data') }}</div>
                            <div class="card-body">
                                <pre class="bg-light p-3 rounded"><code>{
    "link": "https://example.com/learn-more",
    "button_text": "Learn More"
}</code></pre>
                            </div>
                        </div>
                        
                        <div class="card mb-3">
                            <div class="card-header">{{ __('Call to Action Meta Data') }}</div>
                            <div class="card-body">
                                <pre class="bg-light p-3 rounded"><code>{
    "primary_button": "Contact Us",
    "primary_button_link": "/contact",
    "secondary_button": "Resources",
    "secondary_button_link": "/resources"
}</code></pre>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning mt-4">
                        <h5><i class="fas fa-exclamation-triangle me-2"></i>{{ __('Important Notes') }}</h5>
                        <ul class="mb-0">
                            <li>{{ __('For content blocks with section identifiers (hero, featured, about), you can create multiple content blocks - the system will use the first active one or all of them (for featured).') }}</li>
                            <li>{{ __('For content blocks with specific identifiers (home_services_heading, etc.), create exactly one content block with that identifier.') }}</li>
                            <li>{{ __('To make changes to existing content, go to Content Management → List All and find the content block you want to edit.') }}</li>
                            <li>{{ __('Remember to set the Status to Active for content blocks you want to display.') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 