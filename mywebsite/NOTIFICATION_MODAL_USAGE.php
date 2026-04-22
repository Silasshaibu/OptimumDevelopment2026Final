<?php
/**
 * Notification Modal Usage Examples
 * 
 * This file demonstrates how to use the notification modal system
 * in your form handlers and other PHP files.
 */

// Example 1: Success notification after form submission
// In your form handler (e.g., submit_contact.php, submit_review.php, etc.)

// After successful form submission:
header("Location: /contact-us?notification=true&type=success&message=" . urlencode("Thank you! Your message has been sent successfully. We'll get back to you soon."));
exit;

// Example 2: Error notification
header("Location: /contact-us?notification=true&type=error&message=" . urlencode("An error occurred. Please try again later or contact us directly at (800) 770-5520"));
exit;

// Example 3: Warning notification
header("Location: /merchant-application?notification=true&type=warning&message=" . urlencode("Please review your information and ensure all required fields are filled."));
exit;

// Example 4: Info notification
header("Location: /?notification=true&type=info&message=" . urlencode("Your session has expired. Please log in again."));
exit;

// =====================================================
// Using JavaScript directly (for AJAX or client-side)
// =====================================================
?>

<script>
// Success notification
showNotificationModal(
    'success',
    'Success!',
    'Your form has been submitted successfully!'
);

// Error notification
showNotificationModal(
    'error',
    'Error',
    'An error occurred. Please try again later or contact us directly at (800) 770-5520'
);

// Warning notification
showNotificationModal(
    'warning',
    'Warning',
    'Please check your input and try again.'
);

// Info notification
showNotificationModal(
    'info',
    'Notice',
    'This is an informational message.'
);

// =====================================================
// Example: Using with form validation
// =====================================================
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Perform validation
    const email = document.getElementById('email').value;
    if (!email) {
        showNotificationModal(
            'error',
            'Validation Error',
            'Please enter your email address.'
        );
        return;
    }
    
    // If validation passes, submit the form
    this.submit();
});
</script>
