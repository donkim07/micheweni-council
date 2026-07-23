<x-app-layout>
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">{{ __('Waste Collection') }}</h1>
                
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <p class="lead">{{ __('Information about waste collection services in Micheweni.') }}</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">{{ __('Collection Schedule') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Area') }}</th>
                                                    <th>{{ __('Collection Days') }}</th>
                                                    <th>{{ __('Time') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Micheweni Town Center</td>
                                                    <td>Monday, Wednesday, Friday</td>
                                                    <td>7:00 AM - 12:00 PM</td>
                                                </tr>
                                                <tr>
                                                    <td>Northern District</td>
                                                    <td>Tuesday, Thursday</td>
                                                    <td>8:00 AM - 1:00 PM</td>
                                                </tr>
                                                <tr>
                                                    <td>Southern District</td>
                                                    <td>Wednesday, Saturday</td>
                                                    <td>7:00 AM - 12:00 PM</td>
                                                </tr>
                                                <tr>
                                                    <td>Eastern Area</td>
                                                    <td>Monday, Thursday</td>
                                                    <td>9:00 AM - 2:00 PM</td>
                                                </tr>
                                                <tr>
                                                    <td>Western Area</td>
                                                    <td>Tuesday, Friday</td>
                                                    <td>8:00 AM - 1:00 PM</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0">{{ __('Collection Guidelines') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <i class="fas fa-check-circle text-success me-2"></i> 
                                                {{ __('Place waste in proper containers or bags') }}
                                            </li>
                                            <li class="list-group-item">
                                                <i class="fas fa-check-circle text-success me-2"></i> 
                                                {{ __('Separate recyclable materials') }}
                                            </li>
                                            <li class="list-group-item">
                                                <i class="fas fa-check-circle text-success me-2"></i> 
                                                {{ __('Put waste out on the morning of collection day') }}
                                            </li>
                                            <li class="list-group-item">
                                                <i class="fas fa-check-circle text-success me-2"></i> 
                                                {{ __('Keep hazardous waste separate') }}
                                            </li>
                                            <li class="list-group-item">
                                                <i class="fas fa-check-circle text-success me-2"></i> 
                                                {{ __('Ensure containers are not overflowing') }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="mb-0">{{ __('Request Special Collection') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <p>{{ __('Need a special waste collection? Fill out the form below to request a pickup for bulky items or special waste.') }}</p>
                                        
                                        <form class="row g-3 needs-validation" novalidate>
                                            <div class="col-md-6">
                                                <label for="name" class="form-label">{{ __('Full Name') }}</label>
                                                <input type="text" class="form-control" id="name" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                                                <input type="tel" class="form-control" id="phone" required>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="address" class="form-label">{{ __('Address') }}</label>
                                                <input type="text" class="form-control" id="address" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="waste-type" class="form-label">{{ __('Waste Type') }}</label>
                                                <select class="form-select" id="waste-type" required>
                                                    <option value="">{{ __('Choose...') }}</option>
                                                    <option value="bulky">{{ __('Bulky Items (Furniture, Appliances)') }}</option>
                                                    <option value="electronic">{{ __('Electronic Waste') }}</option>
                                                    <option value="construction">{{ __('Construction Debris') }}</option>
                                                    <option value="other">{{ __('Other') }}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="preferred-date" class="form-label">{{ __('Preferred Date') }}</label>
                                                <input type="date" class="form-control" id="preferred-date" required>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="description" class="form-label">{{ __('Description of Waste') }}</label>
                                                <textarea class="form-control" id="description" rows="3" required></textarea>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary">{{ __('Submit Request') }}</button>
                                            </div>
                                        </form>
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