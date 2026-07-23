<x-app-layout>
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <h1 class="display-5 fw-bold mb-4">{{ __('Accessibility Statement') }}</h1>
                        <p class="lead mb-4">{{ __('Last updated: October 2025') }}</p>
                        
                        <div class="mb-5">
                            <h2 class="h4 mb-3">{{ __('Our Commitment') }}</h2>
                            <p>{{ __('The Micheweni Waste Portal is committed to ensuring digital accessibility for people with disabilities. We are continually improving the user experience for everyone and applying the relevant accessibility standards.') }}</p>
                        </div>
                        
                        <div class="mb-5">
                            <h2 class="h4 mb-3">{{ __('Conformance Status') }}</h2>
                            <p>{{ __('The Web Content Accessibility Guidelines (WCAG) define requirements for designers and developers to improve accessibility for people with disabilities. It defines three levels of conformance: Level A, Level AA, and Level AAA.') }}</p>
                            <p>{{ __('The Micheweni Waste Portal is partially conformant with WCAG 2.1 level AA. Partially conformant means that some parts of the content do not fully conform to the accessibility standard.') }}</p>
                        </div>
                        
                        <div class="mb-5">
                            <h2 class="h4 mb-3">{{ __('Accessibility Features') }}</h2>
                            <p>{{ __('The Micheweni Waste Portal includes the following accessibility features:') }}</p>
                            <ul>
                                <li>{{ __('Semantic HTML structure for better screen reader compatibility') }}</li>
                                <li>{{ __('Keyboard navigation support for all interactive elements') }}</li>
                                <li>{{ __('Color contrast that meets WCAG 2.1 AA standards') }}</li>
                                <li>{{ __('Resizable text without loss of functionality') }}</li>
                                <li>{{ __('Alternative text for images') }}</li>
                                <li>{{ __('ARIA landmarks for improved navigation') }}</li>
                                <li>{{ __('Focus indicators for keyboard users') }}</li>
                            </ul>
                        </div>
                        
                        <div class="mb-5">
                            <h2 class="h4 mb-3">{{ __('Technical Specifications') }}</h2>
                            <p>{{ __('Accessibility of the Micheweni Waste Portal relies on the following technologies to work with the particular combination of web browser and any assistive technologies or plugins installed on your computer:') }}</p>
                            <ul>
                                <li>{{ __('HTML') }}</li>
                                <li>{{ __('CSS') }}</li>
                                <li>{{ __('JavaScript') }}</li>
                                <li>{{ __('WAI-ARIA') }}</li>
                            </ul>
                            <p>{{ __('These technologies are relied upon for conformance with the accessibility standards used.') }}</p>
                        </div>
                        
                        <div class="mb-5">
                            <h2 class="h4 mb-3">{{ __('Limitations and Alternatives') }}</h2>
                            <p>{{ __('Despite our best efforts to ensure accessibility of the Micheweni Waste Portal, there may be some limitations. Below is a description of known limitations, and potential solutions:') }}</p>
                            <ul>
                                <li>{{ __('Data visualizations: Some complex data visualizations may be difficult to interpret using screen readers. We provide alternative text descriptions and data tables where possible.') }}</li>
                                <li>{{ __('PDFs: Legacy PDF documents may not be fully accessible. Please contact us for assistance with any specific document.') }}</li>
                                <li>{{ __('Maps: Interactive map features may be challenging to use with keyboard-only navigation. We provide alternative text-based information for critical map data.') }}</li>
                            </ul>
                        </div>
                        
                        <div class="mb-5">
                            <h2 class="h4 mb-3">{{ __('Feedback and Assistance') }}</h2>
                            <p>{{ __('We welcome your feedback on the accessibility of the Micheweni Waste Portal. Please let us know if you encounter accessibility barriers:') }}</p>
                            <ul>
                                <li>{{ __('Phone: +255 777 123 456') }}</li>
                                <li>{{ __('E-mail: accessibility@wetewasteportal.org') }}</li>
                                <li>{{ __('Visitor address: Micheweni District Office, Main Street, Micheweni, Pemba Island') }}</li>
                                <li>{{ __('Postal address: P.O. Box 150, Micheweni, Pemba Island, Zanzibar, Tanzania') }}</li>
                            </ul>
                            <p>{{ __('We try to respond to feedback within 5 business days.') }}</p>
                        </div>
                        
                        <div>
                            <h2 class="h4 mb-3">{{ __('Assessment Approach') }}</h2>
                            <p>{{ __('The Micheweni Waste Portal assessed the accessibility of this website by the following approaches:') }}</p>
                            <ul>
                                <li>{{ __('Self-evaluation: Internal evaluation using accessibility checkers and manual testing') }}</li>
                                <li>{{ __('User testing: Feedback from users with diverse abilities') }}</li>
                            </ul>
                            <p>{{ __('This statement was created on October 15, 2025, using the W3C Accessibility Statement Generator Tool.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 