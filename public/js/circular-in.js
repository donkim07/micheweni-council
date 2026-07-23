/**
 * CircularIN Platform JavaScript
 * Handles all interactive functionality for the CircularIN platform
 */

document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabs = document.querySelectorAll('.platform-tab');
    const contents = document.querySelectorAll('.platform-content');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            // Remove active class from all tabs and contents
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding content
            this.classList.add('active');
            document.getElementById(tabId + '-content').classList.add('active');
        });
    });
    
    // Create post modal toggle
    const createPostInput = document.querySelector('.create-post-input');
    if (createPostInput) {
        createPostInput.addEventListener('click', function() {
            alert('This feature would open a post creation modal in a real implementation.');
        });
    }
    
    // Product filtering
    const categoryFilters = document.querySelectorAll('.category-filter');
    categoryFilters.forEach(filter => {
        filter.addEventListener('click', function() {
            categoryFilters.forEach(f => f.classList.remove('active'));
            this.classList.add('active');
            
            // In a real implementation, this would filter the products
            const category = this.textContent.trim();
            if (category !== 'All Categories') {
                alert(`Filtering for category: ${category}`);
            }
        });
    });
    
    // Job search functionality
    const searchInputs = document.querySelectorAll('.marketplace-search input');
    const searchButtons = document.querySelectorAll('.marketplace-search button');
    
    searchButtons.forEach((button, index) => {
        button.addEventListener('click', function() {
            const searchValue = searchInputs[index].value.trim();
            if (searchValue) {
                alert(`Searching for: ${searchValue}`);
            }
        });
    });
    
    // Job registration buttons
    const registerButtons = document.querySelectorAll('.event-footer .btn');
    registerButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const eventTitle = this.closest('.event-content').querySelector('.event-title').textContent;
            alert(`Registration for "${eventTitle}" would open in a real implementation.`);
        });
    });
    
    // Follow buttons
    const followButtons = document.querySelectorAll('.btn-outline-primary');
    followButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.textContent.trim() === 'Follow') {
                this.textContent = 'Following';
                this.classList.remove('btn-outline-primary');
                this.classList.add('btn-primary');
            } else if (this.textContent.trim() === 'Following') {
                this.textContent = 'Follow';
                this.classList.remove('btn-primary');
                this.classList.add('btn-outline-primary');
            }
        });
    });
    
    // Post actions
    const postActions = document.querySelectorAll('.post-action');
    postActions.forEach(action => {
        action.addEventListener('click', function() {
            const actionType = this.querySelector('i').className;
            if (actionType.includes('thumbs-up')) {
                this.querySelector('i').classList.toggle('far');
                this.querySelector('i').classList.toggle('fas');
                this.querySelector('i').classList.toggle('text-primary');
            } else if (actionType.includes('comment')) {
                alert('This would open the comments section in a real implementation.');
            } else if (actionType.includes('share')) {
                alert('This would open sharing options in a real implementation.');
            }
        });
    });
}); 