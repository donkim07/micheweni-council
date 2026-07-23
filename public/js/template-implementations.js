/**
 * Template implementations for the Micheweni Portal page builder
 * This file contains the implementation for various pre-made templates
 * that can be added to a page through the template gallery
 */

// Check if createComponentHtml function is defined in global scope
if (typeof createComponentHtml !== 'function') {
    // Define a fallback implementation
    function createComponentHtml(component) {
        console.log('Using fallback createComponentHtml function', component);
        
        // Get optional attributes
        const columnWidth = component.column_width || '';
        const template = component.template || '';
        
        // Create data attributes string
        let dataAttrs = `data-id="${component.id}" data-type="${component.type}" data-section="${component.section || ''}"`;
        
        // Add column width if specified
        if (columnWidth) {
            dataAttrs += ` data-column-width="${columnWidth}"`;
        }
        
        // Add template if specified
        if (template) {
            dataAttrs += ` data-template="${template}"`;
        }
        
        // Build component HTML
        return `
            <div class="component-container" ${dataAttrs}>
                <div class="component-header">
                    <div class="component-handle">
                        <i class="fas fa-grip-vertical"></i>
                        <span>${component.title || 'Component'} (${component.type})</span>
                    </div>
                    <div class="component-actions">
                        <button type="button" class="btn btn-sm btn-outline-primary component-settings" title="Component Settings">
                            <i class="fas fa-cog"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-component" title="Remove Component">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="component-body">
                    <div class="component-preview">
                        ${component.content || ''}
                    </div>
                </div>
            </div>
        `;
    }
}

// Feature Cards Template
function addFeatureCardsTemplate(sectionId) {
    // Add heading
    $(`.components-container[data-section="${sectionId}"]`).append(
        createComponentHtml({
            id: 'new-' + Date.now(),
            title: 'Features Heading',
            type: 'text',
            column_width: 12,
            section: sectionId,
            content: '<h2 class="text-center mb-4">Key Features</h2><p class="text-center mb-5">Explore the key features that make our product/service unique.</p>'
        })
    );
    
    // Add feature card 1
    $(`.components-container[data-section="${sectionId}"]`).append(
        createComponentHtml({
            id: 'new-' + (Date.now() + 1),
            title: 'Fast Performance',
            type: 'card',
            column_width: 4,
            section: sectionId,
            content: '<div class="text-center p-4"><div class="feature-icon mb-3"><i class="fas fa-rocket fa-3x text-primary"></i></div><h4>Fast Performance</h4><p>This is a brief description of the feature and how it benefits your users.</p></div>'
        })
    );
    
    // Add feature card 2
    $(`.components-container[data-section="${sectionId}"]`).append(
        createComponentHtml({
            id: 'new-' + (Date.now() + 2),
            title: 'Secure & Safe',
            type: 'card',
            column_width: 4,
            section: sectionId,
            content: '<div class="text-center p-4"><div class="feature-icon mb-3"><i class="fas fa-shield-alt fa-3x text-primary"></i></div><h4>Secure & Safe</h4><p>This is a brief description of the feature and how it benefits your users.</p></div>'
        })
    );
    
    // Add feature card 3
    $(`.components-container[data-section="${sectionId}"]`).append(
        createComponentHtml({
            id: 'new-' + (Date.now() + 3),
            title: 'Easy to Customize',
            type: 'card',
            column_width: 4,
            section: sectionId,
            content: '<div class="text-center p-4"><div class="feature-icon mb-3"><i class="fas fa-cog fa-3x text-primary"></i></div><h4>Easy to Customize</h4><p>This is a brief description of the feature and how it benefits your users.</p></div>'
        })
    );
}

// Masonry Grid Template
function addMasonryGridTemplate(sectionId) {
    // Add heading
    $(`.components-container[data-section="${sectionId}"]`).append(
        createComponentHtml({
            id: 'new-' + Date.now(),
            title: 'Masonry Heading',
            type: 'text',
            column_width: 12,
            section: sectionId,
            content: '<h2 class="text-center mb-4">Masonry Grid Layout</h2><p class="text-center mb-5">A dynamic grid layout that adapts to different content sizes.</p>'
        })
    );
    
    // Create masonry container
    $(`.components-container[data-section="${sectionId}"]`).append(
        createComponentHtml({
            id: 'new-' + (Date.now() + 1),
            title: 'Masonry Container',
            type: 'text',
            column_width: 12,
            section: sectionId,
            content: '<div class="masonry-grid" id="masonry-' + sectionId + '">' +
                     '<div class="masonry-grid-sizer"></div>' +
                     '</div>'
        })
    );
    
    // Add 6 masonry items with varying heights
    const heights = ['250px', '400px', '300px', '450px', '350px', '280px'];
    const colors = ['primary', 'success', 'info', 'warning', 'danger', 'secondary'];
    
    for (let i = 0; i < 6; i++) {
        $(`.components-container[data-section="${sectionId}"]`).append(
            createComponentHtml({
                id: 'new-' + (Date.now() + i + 2),
                title: 'Masonry Item ' + (i + 1),
                type: 'card',
                template: 'standard',
                section: sectionId,
                meta_data: {
                    title: 'Masonry Item ' + (i + 1),
                    subtitle: 'Grid Element',
                    bg_color: colors[i],
                    text_color: 'white',
                    css_class: 'masonry-item'
                },
                content: '<div style="min-height: ' + heights[i] + ';" class="p-4"><h4>Item ' + (i + 1) + '</h4><p>This is a masonry grid item with custom height and styling.</p></div>'
            })
        );
    }
    
    // Add JavaScript to initialize masonry after layout loads
    $(`.components-container[data-section="${sectionId}"]`).append(
        createComponentHtml({
            id: 'new-' + (Date.now() + 8),
            title: 'Masonry Script',
            type: 'text',
            column_width: 12,
            section: sectionId,
            content: '<script>' +
                     'document.addEventListener("DOMContentLoaded", function() {' +
                     '  const grid = document.getElementById("masonry-' + sectionId + '");' +
                     '  if (grid && typeof Masonry !== "undefined") {' +
                     '    new Masonry(grid, {' +
                     '      itemSelector: ".masonry-item",' +
                     '      columnWidth: ".masonry-grid-sizer",' +
                     '      percentPosition: true' +
                     '    });' +
                     '  }' +
                     '});' +
                     '</script>' +
                     '<style>' +
                     '.masonry-grid { width: 100%; }' +
                     '.masonry-grid-sizer { width: 25%; }' +
                     '.masonry-item { width: 25%; padding: 10px; box-sizing: border-box; }' +
                     '@media (max-width: 991px) { .masonry-grid-sizer, .masonry-item { width: 33.333%; } }' +
                     '@media (max-width: 767px) { .masonry-grid-sizer, .masonry-item { width: 50%; } }' +
                     '@media (max-width: 575px) { .masonry-grid-sizer, .masonry-item { width: 100%; } }' +
                     '</style>'
        })
    );
}

// Call to Action Template
function addCtaTemplate(sectionId) {
    // Add CTA content
    $(`.components-container[data-section="${sectionId}"]`).append(
        createComponentHtml({
            id: 'new-' + Date.now(),
            title: 'CTA Content',
            type: 'text',
            section: sectionId,
            content: '<div class="py-5 text-center"><h2 class="mb-3">Ready to Get Started?</h2><p class="lead mb-4">Join thousands of satisfied customers who have already taken the next step.</p><div class="d-grid gap-2 d-sm-flex justify-content-sm-center"><button type="button" class="btn btn-primary btn-lg px-4 gap-3">Get Started</button><button type="button" class="btn btn-outline-secondary btn-lg px-4">Learn More</button></div></div>'
        })
    );
}

// Split Call to Action Template
function addSplitCtaTemplate(sectionId) {
    // Add a two-column layout for the split CTA
    $(`.components-container[data-section="${sectionId}"]`).append(
        createComponentHtml({
            id: 'new-' + Date.now(),
            title: 'Split CTA',
            type: 'text',
            section: sectionId,
            content: '<div class="row align-items-center">' +
                     '  <div class="col-lg-6 pe-lg-5">' +
                     '    <h2 class="display-5 fw-bold mb-4">Take Your Business to the Next Level</h2>' +
                     '    <p class="lead mb-4">Our solutions help businesses streamline operations, improve customer experiences, and drive growth. Join thousands of satisfied customers today.</p>' +
                     '    <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-0">' +
                     '      <button type="button" class="btn btn-primary btn-lg px-4 me-md-2 fw-bold">Get Started</button>' +
                     '      <button type="button" class="btn btn-outline-secondary btn-lg px-4">Learn More</button>' +
                     '    </div>' +
                     '  </div>' +
                     '  <div class="col-lg-6">' +
                     '    <div class="bg-light rounded-4 p-5 text-center shadow-sm">' +
                     '      <div class="feature-icon bg-primary bg-gradient text-white rounded-circle mb-4 mx-auto" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">' +
                     '        <i class="fas fa-chart-line fa-2x"></i>' +
                     '      </div>' +
                     '      <h3 class="fw-bold mb-3">See Results Fast</h3>' +
                     '      <p class="mb-4">Our clients typically see measurable improvements within the first 30 days.</p>' +
                     '      <div class="row text-start g-4 mt-3">' +
                     '        <div class="col-6">' +
                     '          <div class="d-flex align-items-center">' +
                     '            <i class="fas fa-check-circle text-success me-2"></i>' +
                     '            <span>24/7 Support</span>' +
                     '          </div>' +
                     '        </div>' +
                     '        <div class="col-6">' +
                     '          <div class="d-flex align-items-center">' +
                     '            <i class="fas fa-check-circle text-success me-2"></i>' +
                     '            <span>Free Setup</span>' +
                     '          </div>' +
                     '        </div>' +
                     '        <div class="col-6">' +
                     '          <div class="d-flex align-items-center">' +
                     '            <i class="fas fa-check-circle text-success me-2"></i>' +
                     '            <span>No Hidden Fees</span>' +
                     '          </div>' +
                     '        </div>' +
                     '        <div class="col-6">' +
                     '          <div class="d-flex align-items-center">' +
                     '            <i class="fas fa-check-circle text-success me-2"></i>' +
                     '            <span>Cancel Anytime</span>' +
                     '          </div>' +
                     '        </div>' +
                     '      </div>' +
                     '    </div>' +
                     '  </div>' +
                     '</div>'
        })
    );
}

// FAQ Accordion Template
function addFaqAccordionTemplate(sectionId) {
    // Add heading
    $(`.components-container[data-section="${sectionId}"]`).append(
        createComponentHtml({
            id: 'new-' + Date.now(),
            title: 'FAQ Heading',
            type: 'text',
            section: sectionId,
            content: '<h2 class="text-center mb-5">Frequently Asked Questions</h2>'
        })
    );
    
    // Add accordion content
    $(`.components-container[data-section="${sectionId}"]`).append(
        createComponentHtml({
            id: 'new-' + (Date.now() + 1),
            title: 'FAQ Accordion',
            type: 'text',
            section: sectionId,
            content: `<div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqOne">Question 1?</button>
                    </h2>
                    <div id="faqOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">Answer to question 1 goes here.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo">Question 2?</button>
                    </h2>
                    <div id="faqTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">Answer to question 2 goes here.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqThree">Question 3?</button>
                    </h2>
                    <div id="faqThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">Answer to question 3 goes here.</div>
                    </div>
                </div>
            </div>`
        })
    );
}

// Team Members Template
function addTeamMembersTemplate(sectionId) {
    // Add heading
    $(`.components-container[data-section="${sectionId}"]`).append(
        createComponentHtml({
            id: 'new-' + Date.now(),
            title: 'Team Heading',
            type: 'text',
            column_width: 12,
            section: sectionId,
            content: '<h2 class="text-center mb-5">Meet Our Team</h2>'
        })
    );
    
    // Add team members
    for (let i = 1; i <= 3; i++) {
        $(`.components-container[data-section="${sectionId}"]`).append(
            createComponentHtml({
                id: 'new-' + (Date.now() + i),
                title: 'Team Member ' + i,
                type: 'card',
                column_width: 4,
                section: sectionId,
                content: `<div class="text-center"><img src="https://via.placeholder.com/300x300" class="rounded-circle mb-3" width="150" height="150" alt="Team Member"><h4>Team Member ${i}</h4><p class="text-muted">Position</p><p>Brief description about this team member.</p></div>`
            })
        );
    }
}

// Feedback Form Template
function addFeedbackFormTemplate(sectionId) {
    // Add heading
    $(`.components-container[data-section="${sectionId}"]`).append(
        createComponentHtml({
            id: 'new-' + Date.now(),
            title: 'Feedback Form Heading',
            type: 'text',
            column_width: 12,
            section: sectionId,
            content: '<h2 class="text-center mb-4">We Value Your Feedback</h2><p class="text-center mb-5">Please take a moment to share your thoughts and help us improve our services.</p>'
        })
    );
    
    // Add form component with the feedback form configuration
    $(`.components-container[data-section="${sectionId}"]`).append(
        createComponentHtml({
            id: 'new-' + (Date.now() + 1),
            title: 'Feedback Form',
            type: 'form',
            template: 'card',
            column_width: 12,
            section: sectionId,
            meta_data: {
                submit_button_text: 'Submit Feedback',
                submit_button_style: 'primary',
                success_message: 'Thank you for your feedback! We appreciate your input.',
                enable_captcha: true,
                css_class: 'feedback-form shadow-lg'
            }
        })
    );
    
    // Add additional styling for the form
    $(`.components-container[data-section="${sectionId}"]`).append(
        createComponentHtml({
            id: 'new-' + (Date.now() + 2),
            title: 'Feedback Form Styling',
            type: 'text',
            column_width: 12,
            section: sectionId,
            content: '<style>' +
                     '.feedback-form { max-width: 800px; margin: 0 auto; }' +
                     '.feedback-form .form-control:focus { box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25); border-color: #86b7fe; }' +
                     '.feedback-form .form-control { transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; }' +
                     '.feedback-form .btn-hover-effect:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); }' +
                     '</style>'
        })
    );
}

// Booking Form Template
function addBookingFormTemplate(sectionId) {
    // Add heading
    $(`.components-container[data-section="${sectionId}"]`).append(
        createComponentHtml({
            id: 'new-' + Date.now(),
            title: 'Booking Form Heading',
            type: 'text',
            column_width: 12,
            section: sectionId,
            content: '<h2 class="text-center mb-4">Book Your Appointment</h2><p class="text-center mb-5">Select your preferred date and time, and we\'ll get back to you to confirm your booking.</p>'
        })
    );
    
    // Add a two-column layout with form and info
    $(`.components-container[data-section="${sectionId}"]`).append(
        createComponentHtml({
            id: 'new-' + (Date.now() + 1),
            title: 'Booking Form Layout',
            type: 'text',
            column_width: 12,
            section: sectionId,
            content: '<div class="row g-5">' +
                     '  <div class="col-lg-7">' +
                     '    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">' +
                     '      <div class="card-header bg-primary text-white py-3">' +
                     '        <h5 class="mb-0 fw-bold"><i class="fas fa-calendar-check me-2"></i>Book Now</h5>' +
                     '      </div>' +
                     '      <div class="card-body p-4">' +
                     '        <form class="booking-form" id="bookingForm">' +
                     '          <div class="row g-3">' +
                     '            <div class="col-md-6">' +
                     '              <label class="form-label">First Name <span class="text-danger">*</span></label>' +
                     '              <input type="text" class="form-control" required>' +
                     '            </div>' +
                     '            <div class="col-md-6">' +
                     '              <label class="form-label">Last Name <span class="text-danger">*</span></label>' +
                     '              <input type="text" class="form-control" required>' +
                     '            </div>' +
                     '            <div class="col-md-6">' +
                     '              <label class="form-label">Email <span class="text-danger">*</span></label>' +
                     '              <input type="email" class="form-control" required>' +
                     '            </div>' +
                     '            <div class="col-md-6">' +
                     '              <label class="form-label">Phone <span class="text-danger">*</span></label>' +
                     '              <input type="tel" class="form-control" required>' +
                     '            </div>' +
                     '            <div class="col-md-6">' +
                     '              <label class="form-label">Preferred Date <span class="text-danger">*</span></label>' +
                     '              <input type="date" class="form-control" required>' +
                     '            </div>' +
                     '            <div class="col-md-6">' +
                     '              <label class="form-label">Preferred Time <span class="text-danger">*</span></label>' +
                     '              <select class="form-select" required>' +
                     '                <option value="">Select a time</option>' +
                     '                <option>Morning (9AM - 12PM)</option>' +
                     '                <option>Afternoon (12PM - 5PM)</option>' +
                     '                <option>Evening (5PM - 8PM)</option>' +
                     '              </select>' +
                     '            </div>' +
                     '            <div class="col-12">' +
                     '              <label class="form-label">Service Type <span class="text-danger">*</span></label>' +
                     '              <select class="form-select" required>' +
                     '                <option value="">Select a service</option>' +
                     '                <option>Service 1</option>' +
                     '                <option>Service 2</option>' +
                     '                <option>Service 3</option>' +
                     '              </select>' +
                     '            </div>' +
                     '            <div class="col-12">' +
                     '              <label class="form-label">Additional Notes</label>' +
                     '              <textarea class="form-control" rows="3"></textarea>' +
                     '            </div>' +
                     '            <div class="col-12 mt-4">' +
                     '              <button type="submit" class="btn btn-primary btn-lg w-100">Book Appointment</button>' +
                     '            </div>' +
                     '          </div>' +
                     '        </form>' +
                     '      </div>' +
                     '    </div>' +
                     '  </div>' +
                     '  <div class="col-lg-5">' +
                     '    <div class="card bg-light border-0 rounded-4 h-100">' +
                     '      <div class="card-body p-4">' +
                     '        <h4 class="fw-bold mb-4">Business Hours</h4>' +
                     '        <ul class="list-unstyled mb-5">' +
                     '          <li class="d-flex justify-content-between mb-2 pb-2 border-bottom">' +
                     '            <span>Monday - Friday</span>' +
                     '            <span class="fw-bold">9:00 AM - 8:00 PM</span>' +
                     '          </li>' +
                     '          <li class="d-flex justify-content-between mb-2 pb-2 border-bottom">' +
                     '            <span>Saturday</span>' +
                     '            <span class="fw-bold">10:00 AM - 6:00 PM</span>' +
                     '          </li>' +
                     '          <li class="d-flex justify-content-between mb-2 pb-2 border-bottom">' +
                     '            <span>Sunday</span>' +
                     '            <span class="fw-bold">Closed</span>' +
                     '          </li>' +
                     '        </ul>' +
                     '        <h4 class="fw-bold mb-4">Contact Information</h4>' +
                     '        <ul class="list-unstyled">' +
                     '          <li class="d-flex mb-3">' +
                     '            <i class="fas fa-map-marker-alt text-primary me-3 mt-1"></i>' +
                     '            <span>123 Main Street, City, State 12345</span>' +
                     '          </li>' +
                     '          <li class="d-flex mb-3">' +
                     '            <i class="fas fa-phone text-primary me-3 mt-1"></i>' +
                     '            <span>(123) 456-7890</span>' +
                     '          </li>' +
                     '          <li class="d-flex mb-3">' +
                     '            <i class="fas fa-envelope text-primary me-3 mt-1"></i>' +
                     '            <span>booking@example.com</span>' +
                     '          </li>' +
                     '        </ul>' +
                     '      </div>' +
                     '    </div>' +
                     '  </div>' +
                     '</div>'
        })
    );
    
    // Add validation script
    $(`.components-container[data-section="${sectionId}"]`).append(
        createComponentHtml({
            id: 'new-' + (Date.now() + 2),
            title: 'Booking Form Script',
            type: 'text',
            column_width: 12,
            section: sectionId,
            content: '<script>' +
                     'document.addEventListener("DOMContentLoaded", function() {' +
                     '  const form = document.getElementById("bookingForm");' +
                     '  if (form) {' +
                     '    form.addEventListener("submit", function(event) {' +
                     '      event.preventDefault();' +
                     '      alert("Form submission is disabled in preview mode. In production, this would submit the booking request.");' +
                     '    });' +
                     '  }' +
                     '});' +
                     '</script>'
        })
    );
} 