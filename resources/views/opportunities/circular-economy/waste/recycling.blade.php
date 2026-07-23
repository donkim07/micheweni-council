<x-app-layout>
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">{{ __('Recycling Centers') }}</h1>
                
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <p class="lead">{{ __('Information about recycling facilities and programs in Micheweni.') }}</p>
                        
                        <div class="row mt-4">
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100">
                                    <img src="{{ asset('images/recycling-center.jpg') }}" class="card-img-top" alt="{{ __('Recycling Center') }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ __('Micheweni Main Recycling Center') }}</h5>
                                        <p class="card-text">{{ __('The main recycling facility serving the Micheweni area. This facility accepts a wide range of recyclable materials.') }}</p>
                                        
                                        <div class="mb-3">
                                            <strong>{{ __('Location:') }}</strong> Micheweni Town, Near Central Market
                                        </div>
                                        
                                        <div class="mb-3">
                                            <strong>{{ __('Operating Hours:') }}</strong><br>
                                            {{ __('Monday - Friday:') }} 8:00 AM - 5:00 PM<br>
                                            {{ __('Saturday:') }} 9:00 AM - 2:00 PM<br>
                                            {{ __('Sunday:') }} Closed
                                        </div>
                                        
                                        <div class="mb-3">
                                            <strong>{{ __('Contact:') }}</strong><br>
                                            Phone: +255 123 456 789<br>
                                            Email: recycling@micheweni.gov.tz
                                        </div>
                                        
                                        <a href="{{ route('opportunities.circular-economy.waste.map') }}" class="btn btn-success">
                                            <i class="fas fa-map-marker-alt me-2"></i> {{ __('View on Map') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0">{{ __('Accepted Materials') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <h6 class="text-success">
                                                        <i class="fas fa-recycle me-2"></i> {{ __('Paper Products') }}
                                                    </h6>
                                                    <ul class="list-unstyled ps-4">
                                                        <li>{{ __('Newspapers') }}</li>
                                                        <li>{{ __('Magazines') }}</li>
                                                        <li>{{ __('Office paper') }}</li>
                                                        <li>{{ __('Cardboard') }}</li>
                                                    </ul>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <h6 class="text-success">
                                                        <i class="fas fa-recycle me-2"></i> {{ __('Metal') }}
                                                    </h6>
                                                    <ul class="list-unstyled ps-4">
                                                        <li>{{ __('Aluminum cans') }}</li>
                                                        <li>{{ __('Steel cans') }}</li>
                                                        <li>{{ __('Scrap metal') }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <h6 class="text-success">
                                                        <i class="fas fa-recycle me-2"></i> {{ __('Plastic') }}
                                                    </h6>
                                                    <ul class="list-unstyled ps-4">
                                                        <li>{{ __('PET bottles') }}</li>
                                                        <li>{{ __('HDPE containers') }}</li>
                                                        <li>{{ __('Plastic bags') }}</li>
                                                    </ul>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <h6 class="text-success">
                                                        <i class="fas fa-recycle me-2"></i> {{ __('Glass') }}
                                                    </h6>
                                                    <ul class="list-unstyled ps-4">
                                                        <li>{{ __('Bottles') }}</li>
                                                        <li>{{ __('Jars') }}</li>
                                                        <li>{{ __('Broken glass') }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">{{ __('Recycling Tips') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0">
                                                        <i class="fas fa-water fs-3 text-primary me-3"></i>
                                                    </div>
                                                    <div>
                                                        <h6>{{ __('Clean Materials') }}</h6>
                                                        <p>{{ __('Rinse containers before recycling to remove food residue.') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0">
                                                        <i class="fas fa-sort fs-3 text-primary me-3"></i>
                                                    </div>
                                                    <div>
                                                        <h6>{{ __('Sort Properly') }}</h6>
                                                        <p>{{ __('Separate different types of materials to improve recycling efficiency.') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0">
                                                        <i class="fas fa-compress-alt fs-3 text-primary me-3"></i>
                                                    </div>
                                                    <div>
                                                        <h6>{{ __('Flatten Boxes') }}</h6>
                                                        <p>{{ __('Flatten cardboard boxes to save space and make transportation easier.') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 