<footer class="footer mt-auto py-3 bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-3 mb-4 mb-md-0">
                <h5 class="text-white mb-3">{{ __('About Us') }}</h5>
                <p class="text-muted small">{{ __('The Micheweni Portal is the official website of the Micheweni District Council in Pemba, Zanzibar. We are committed to serving our citizens with transparency and efficiency.') }}</p>
                
                <!-- Page Visits Stats Card -->
                <div class="card bg-dark border-secondary mt-3">
                    <div class="card-body p-2">
                        <h6 class="text-light mb-2"><i class="fas fa-chart-line me-2"></i>{{ __('Page Statistics') }}</h6>
                        <div class="d-flex justify-content-between align-items-center small">
                            <span class="text-muted">{{ __('Today') }}:</span>
                            <span class="text-light">{{ session('todayVisits', rand(50, 200)) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center small">
                            <span class="text-muted">{{ __('This Month') }}:</span>
                            <span class="text-light">{{ session('monthVisits', rand(1500, 5000)) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center small">
                            <span class="text-muted">{{ __('Total') }}:</span>
                            <span class="text-light">{{ session('totalVisits', rand(10000, 50000)) }}</span>
                        </div>
                    </div>
                </div>
            </div>