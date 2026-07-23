/**
 * Opportunity Management JavaScript Functions
 */
$(document).ready(function() {
    // Handle save opportunity button clicks
    $('.save-opportunity').on('click', function() {
        var button = $(this);
        var opportunityId = button.data('id');
        
        $.ajax({
            url: saveOpportunityUrl,
            method: 'POST',
            data: {
                id: opportunityId,
                _token: csrfToken
            },
            success: function(response) {
                if (response.action === 'saved') {
                    button.data('saved', 'true');
                    button.find('i').removeClass('fa-bookmark-o').addClass('fa-bookmark');
                    button.find('span').text(savedText);
                    
                    // Show success notification
                    toastr.success(response.message);
                } else {
                    button.data('saved', 'false');
                    button.find('i').removeClass('fa-bookmark').addClass('fa-bookmark-o');
                    button.find('span').text(saveText);
                    
                    // Show info notification
                    toastr.info(response.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    // Redirect to login if not authenticated
                    window.location.href = loginUrl;
                } else {
                    // Show error notification
                    toastr.error('An error occurred. Please try again.');
                }
            }
        });
    });
}); 