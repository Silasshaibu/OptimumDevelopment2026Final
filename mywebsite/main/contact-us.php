    <!-- Content body -->
    <header class="hero-section narrow">
        <h1 class="hero-title narrow">Love to hear from you. Get in touch.<h1>
    </header>
    
    <section class="digitalMarketing contact-card">
    <p class="from-subtle-message">
        Whether you have a question, want to start a project or simply want to connect. <br class="breakLine">
    Feel free to send us a message in the contact form.
    </p>

    <form class="digitalMarketingForm" id="contactForm">
        <div class="formSections-wrapper">

        <fieldset>
            <legend>Tell Us About Yourself</legend>
            <div class="fun-form-grid">
            <div>
                <label for="yourFirstName">First Name</label>
                <input id="yourFirstName" name="firstName" type="text" placeholder="Your First Name" required autocomplete="given-name" />
            </div>

            <div>
                <label for="yourLastName">Last Name</label>
                <input id="yourLastName" name="lastName" type="text" placeholder="Your Last Name" required autocomplete="family-name" />
            </div>

            <div>
                <label for="email">Email*</label>
                <input id="email" name="email" type="email" placeholder="example@email.com" required autocomplete="email" />
            </div>

            <div>
                <label for="yourphone">Phone Number</label>
                <input id="yourphone" name="yourphone" type="tel" placeholder="+1 (555) 123-4567" autocomplete="tel" />
            </div>

            <div>
                <label for="company">Company (Optional)</label>
                <input id="company" name="company" type="text" placeholder="Your Company Name" autocomplete="organization" />
            </div>         

            <div>
                <label for="howDidYouHearAboutUs">How Did You Hear About Us?</label>
                <select id="howDidYouHearAboutUs" name="howDidYouHearAboutUs" required>
                <option value="" disabled selected>From Facebook</option>
                <option value="facebook">From Facebook</option>
                <option value="tiktok">From TikTok</option>
                <option value="friend">From A Friend</option>
                <option value="others">Others</option>
                </select>
            </div>
            </div>

            <div>
            <label for="comments">Tell Us More</label>
            <textarea id="comments" name="comments" placeholder="Let us know how we may assist you. We are fun to talk to."></textarea>
            </div>

            <!-- Honeypot field for spam protection -->
            <input type="text" name="website" id="website" style="position:absolute;left:-9999px;" tabindex="-1" autocomplete="off" />
            
            <label for="submitFormPolicyChecked" style="font-size: .8rem; font-weight: 400; color:#6e6b6b">
            <input id="submitFormPolicyChecked" type="checkbox" name="submitFormPolicyChecked" required> By submitting this form, I acknowledge receipt of the <a class="terms-link" href="<?= $base_url ?>/privacy-policy">Optimum-payments Policy</a>.
            </label>
            <button class="btn-primary btn-fullwidth" type="submit">Submit</button>
        </fieldset>

        </div>
    </form>
    </section>

    <!--stylings for contact us form-->
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/contact-us.css">

    <!--script for form-->
    <script>
    // Phone formatting with +1 prefix (like merchant application form)
    const phoneInput = document.getElementById('yourphone');
    
    phoneInput.addEventListener('focus', function() {
        if (this.value === '') {
            this.value = '+1 ';
        }
    });
    
    phoneInput.addEventListener('input', function(e) {
        let value = this.value;
        
        // Always keep +1 prefix
        if (!value.startsWith('+1 ')) {
            this.value = '+1 ';
            return;
        }
        
        // Remove non-digits after +1 prefix
        let prefix = '+1 ';
        let numbers = value.substring(3).replace(/\D/g, '');
        
        // Limit to 10 digits
        if (numbers.length > 10) {
            numbers = numbers.substring(0, 10);
        }
        
        this.value = prefix + numbers;
    });
    
    phoneInput.addEventListener('keydown', function(e) {
        // Prevent deleting +1 prefix
        if ((e.key === 'Backspace' || e.key === 'Delete') && this.selectionStart <= 3) {
            e.preventDefault();
        }
    });
    
    phoneInput.addEventListener('click', function() {
        // Prevent cursor from being placed before +1
        if (this.selectionStart < 3) {
            this.setSelectionRange(this.value.length, this.value.length);
        }
    });
    
    phoneInput.addEventListener('blur', function() {
        let numbers = this.value.substring(3).replace(/\D/g, '');
        
        // Validate 10 digits on blur
        if (numbers.length > 0 && numbers.length !== 10) {
            alert('Phone number must be exactly 10 digits (US format)');
            this.focus();
        }
    });
    
    // Honeypot detection
    const honeypot = document.getElementById('website');
    let honeypotFilled = false;
    
    honeypot.addEventListener('input', function() {
        honeypotFilled = true;
    });
    
    // Form submission
    document.getElementById('contactForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        if (!e.target.checkValidity()) {
            e.target.reportValidity();
            return;
        }
        
        // Check honeypot
        if (honeypotFilled || honeypot.value !== '') {
            console.log('Spam detected');
            alert('Form submitted successfully!'); // Fake success for bots
            return;
        }
        
        // Validate phone number if provided
        const phone = phoneInput.value;
        if (phone && phone !== '+1 ') {
            const phoneDigits = phone.substring(3).replace(/\D/g, '');
            if (phoneDigits.length !== 10) {
                alert('Phone number must be exactly 10 digits');
                phoneInput.focus();
                return;
            }
        }

        const submitBtn = e.target.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Submitting...';
        
        try {
            const formData = new FormData(e.target);
            console.log('Submitting to:', '<?= $base_url ?>/_system/submit_contact.php');
            console.log('Form data:', Object.fromEntries(formData.entries()));
            
            const response = await fetch('<?= $base_url ?>/_system/submit_contact.php', {
                method: 'POST',
                body: formData
            });
            
            console.log('Response status:', response.status);
            const responseText = await response.text();
            console.log('Response text:', responseText);
            
            let result;
            try {
                result = JSON.parse(responseText);
            } catch (parseError) {
                console.error('JSON parse error:', parseError);
                alert('Server error: ' + responseText.substring(0, 200));
                return;
            }
            
            if (result.success) {
                alert('Thank you for contacting us! We will get back to you shortly.');
                e.target.reset();
            } else {
                alert(result.message || 'An error occurred. Please try again.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Network error: ' + error.message);
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });
    </script>