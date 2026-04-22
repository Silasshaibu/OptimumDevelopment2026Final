
<div class="contact-card__image-wrapper">
    <h1 class="form-title">We love working with fun clients</h1>
</div>  


<section class="digitalMarketing contact-card">
  <p class="from-subtle-message">
    Fill out our form below detailing your project and we will get back to you as soon as possible. <br>
    The more specific, the better to start out — 
    but we can help you determine your project goals  face-to-face.
  </p>

  <form class="digitalMarketingForm" id="contactForm">
    <div class="formSections-wrapper">

      <fieldset>
        <legend>Tell Us About Yourself</legend>
        <div class="fun-form-grid">
          <div>
            <label for="yourName">Name</label>
            <input id="yourName" name="yourName" type="text" placeholder="Your Name" required autocomplete="name" />
          </div>

          <div>
            <label for="email">Email*</label>
            <input id="email" name="email" type="email" placeholder="example@email.com" required autocomplete="email" />
          </div>

          <div>
            <label for="yourphone">Phone Number</label>
            <input id="yourphone" name="yourphone" type="tel" placeholder="+1 (555) 555-5555" autocomplete="tel" />
          </div>

          <div>
            <label for="website">Website <span class="optional-text">(Optional)</span></label>
            <input id="website" name="website" type="url" placeholder="https://yourwebsite.com" autocomplete="url" />
          </div>

          <div>
            <label for="budget">Your Budget</label>
            <div class="price-range">
            <!--Price Range slider--> 
              <div class="labels">
                <span id="price-min-label">$2,000</span>
                <span id="price-max-label">$50,000</span>
              </div>

              <div class="slider-container">
                <input type="range" id="min-range" min="2000" max="50000" value="2000" step="500">
                <input type="range" id="max-range" min="2000" max="50000" value="50000" step="500">

                <div class="track"></div>
                <div class="range-fill" id="range-fill"></div>
              </div>
            </div>
          </div>

          <div>
            <label for="howDidYouHearAboutUs">How Did You Hear About Us?</label>
            <select id="howDidYouHearAboutUs" name="howDidYouHearAboutUs" required>
              <option value="" disabled selected>Choose one</option>
              <option value="facebook">From Facebook</option>
              <option value="tiktok">From TikTok</option>
              <option value="friend">From A Friend</option>
              <option value="others">Others</option>
            </select>
          </div>
        </div>

        <div>
          <label for="comments">Your Brief</label>
          <textarea id="comments" name="comments" placeholder="Write your brief"></textarea>
        </div>

        <!-- FILE UPLOAD SECTION -->
        <div class="file-upload-wrapper">
          <label for="briefFiles">Upload Brief Files <span class="optional-text">(Optional)</span></label>
          <div class="file-upload-area" id="fileUploadArea">
            <div class="upload-content">
              <svg class="upload-icon" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="17 8 12 3 7 8"></polyline>
                <line x1="12" y1="3" x2="12" y2="15"></line>
              </svg>
              <p class="upload-text">Click to upload or drag files here</p>
              <p class="upload-limits">JPG, PNG, PDF, ZIP • Max 4MB per file • Up to 5 files. <span id="uploadCounter">(5) upload(s) left</span></p>
            </div>
            <input type="file" id="briefFiles" name="briefFiles[]" multiple accept=".pdf,.zip,.jpg,.jpeg,.png" style="display: none;">
          </div>
          <div id="fileList" class="file-list"></div>
        </div>

        <!-- SERVICES CHECKBOXES -->
        <div>
          <p>What services are you looking for?</p>
          <div class="form-group services-grid">
            <label class="service-option">
              <input type="checkbox" name="services" value="website_design_development">
              <div class="service-text">
                <span class="service-title">Website Design + Development</span>
                <span class="service-description">Create a modern, responsive, high-performing website tailored to your brand and business goals.</span>
              </div>
            </label>

            <label class="service-option">
              <input type="checkbox" name="services" value="app_design_development">
              <div class="service-text">
                <span class="service-title">App Design + Development</span>
                <span class="service-description">Build a sleek and intuitive mobile or web application tailored to your needs.</span>
              </div>
            </label>

            <label class="service-option">
              <input type="checkbox" name="services" value="copywriting">
              <div class="service-text">
                <span class="service-title">Copywriting</span>
                <span class="service-description">Craft compelling content that effectively communicates your brand’s voice.</span>
              </div>
            </label>

            <label class="service-option">
              <input type="checkbox" name="services" value="packaging_design">
              <div class="service-text">
                <span class="service-title">Packaging Design</span>
                <span class="service-description">Design eye-catching packaging that enhances your product’s appeal and brand identity.</span>
              </div>
            </label>

            <label class="service-option">
              <input type="checkbox" name="services" value="branding">
              <div class="service-text">
                <span class="service-title">Branding</span>
                <span class="service-description">Develop a consistent and impactful brand identity for your business.</span>
              </div>
            </label>
          </div>
        </div>

        <button class="btn-primary btn-fullwidth submit" type="submit">Submit</button>
      </fieldset>

    </div>
  </form>
</section>

<!--style for price slider-->
<style>
  /* Loading Spinner */
  .loading-spinner {
    display: inline-block;
    width: 14px;
    height: 14px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 0.8s linear infinite;
    margin-right: 8px;
    vertical-align: middle;
  }

  @keyframes spin {
    to { transform: rotate(360deg); }
  }

  /* Input validation styles */
  input:invalid:not(:placeholder-shown),
  select:invalid:not(:placeholder-shown) {
    border-color: #dc3545;
  }

  input:valid:not(:placeholder-shown),
  select:valid:not(:placeholder-shown) {
    border-color: #28a745;
  }

  /*Price range slider css*/
  .price-range {
  width: 330px;
  width: 100%;
  font-family: sans-serif;
  }

  .price-range input{
    border:none;
  }

  .labels {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    color: #555;
    font-size: 0.875rem;
  }

  .slider-container {
    position: relative;
    height: 40px;
  }

  input[type="range"] {
    position: absolute;
    left: 0; 
    top: 10px; /*Former*/
    top:-7px;
    width: 100%;
    appearance: none;
    background: none;
    z-index: 2;
    pointer-events: none; /* Allows clicking through */
  }

  input[type="range"]::-webkit-slider-thumb {
    pointer-events: auto;
    appearance: none;
    width: 18px;
    height: 18px;
    background: white;
    border: 2px solid var(--color-primary);
    border-radius: 50%;
    cursor: pointer;
  }


  .track {
    position: absolute;
    top: 18px;
    left: 0;
    right: 0;
    height: 4px;
    
    background: #e5e7eb;
    border-radius: 4px;
  }

  .range-fill {
    position: absolute;
    top: 18px;
    height: 4px;
    border-radius: 4px;
    background: var(--color-primary);
  }

  /* File Upload Styles */
  .file-upload-wrapper {
    margin-top: 1.2rem;
  }

  .optional-text {
    font-weight: 400;
    color: #666;
    font-size: 0.875rem;
  }

  .file-upload-area {
    border: 2px dashed #ccc;
    border-radius: 8px;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background-color: #fafafa;
    margin-top: 0.4rem;
  }

  .file-upload-area:hover {
    border-color: var(--color-primary);
    background-color: #f5f9fc;
  }

  .file-upload-area.drag-over {
    border-color: var(--color-primary);
    background-color: #e8f4f8;
  }

  .upload-content {
    pointer-events: none;
  }

  .upload-icon {
    color: var(--color-primary);
    margin-bottom: 0.5rem;
  }

  .upload-text {
    font-size: 1rem;
    color: #333;
    margin: 0.5rem 0;
    font-weight: 500;
  }

  .upload-limits {
    font-size: 0.875rem;
    color: #666;
    margin: 0;
  }

  .file-list {
    margin-top: 1rem;
  }

  .file-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem 1rem;
    background-color: #f8f9fa;
    border: 1px solid #e0e0e0;
    border-radius: 6px;
    margin-bottom: 0.5rem;
  }

  .file-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex: 1;
  }

  .file-icon {
    width: 32px;
    height: 32px;
    color: var(--color-primary);
  }

  .file-details {
    flex: 1;
  }

  .file-name {
    font-weight: 500;
    color: #333;
    font-size: 0.875rem;
  }

  .file-size {
    font-size: 0.75rem;
    color: #666;
  }

  .file-remove {
    background: none;
    border: none;
    color: #dc3545;
    cursor: pointer;
    padding: 0.25rem 0.5rem;
    font-size: 1.25rem;
    line-height: 1;
    transition: color 0.2s;
  }

  .file-remove:hover {
    color: #c82333;
  }

  .file-error {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.5rem;
  }

</style>

<!--script for slider-->
<script>
  const minInput = document.getElementById("min-range");
const maxInput = document.getElementById("max-range");

const minLabel = document.getElementById("price-min-label");
const maxLabel = document.getElementById("price-max-label");

const fill = document.getElementById("range-fill");

const minGap = 1;
const min = +minInput.min;
const max = +maxInput.max;

function updateSlider() {
  let minVal = +minInput.value;
  let maxVal = +maxInput.value;

  // Prevent crossing
  if (maxVal - minVal <= minGap) {
    if (event.target === minInput) {
      minInput.value = maxVal - minGap;
    } else {
      maxInput.value = minVal + minGap;
    }
  }

  minVal = +minInput.value;
  maxVal = +maxInput.value;

  const minPercent = ((minVal - min) / (max - min)) * 100;
  const maxPercent = ((maxVal - min) / (max - min)) * 100;

  fill.style.left = minPercent + "%";
  fill.style.width = (maxPercent - minPercent) + "%";

  minLabel.textContent = "$" + minVal;
  maxLabel.textContent = "$" + maxVal;
}

minInput.addEventListener("input", updateSlider);
maxInput.addEventListener("input", updateSlider);

updateSlider(); // initial render

</script>

<!-- File Upload Script -->
<script>
  let selectedFiles = [];
  const MAX_FILE_SIZE = 4 * 1024 * 1024; // 4MB in bytes
  const MAX_FILES = 5;
  const ALLOWED_TYPES = ['application/pdf', 'application/zip', 'application/x-zip-compressed', 'image/jpeg', 'image/jpg', 'image/png'];
  const ALLOWED_EXTENSIONS = ['.pdf', '.zip', '.jpg', '.jpeg', '.png'];

  const fileUploadArea = document.getElementById('fileUploadArea');
  const fileInput = document.getElementById('briefFiles');
  const fileList = document.getElementById('fileList');

  // Click to upload
  fileUploadArea.addEventListener('click', () => {
    fileInput.click();
  });

  // File input change
  fileInput.addEventListener('change', (e) => {
    handleFiles(e.target.files);
  });

  // Drag and drop
  fileUploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    fileUploadArea.classList.add('drag-over');
  });

  fileUploadArea.addEventListener('dragleave', () => {
    fileUploadArea.classList.remove('drag-over');
  });

  fileUploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    fileUploadArea.classList.remove('drag-over');
    handleFiles(e.dataTransfer.files);
  });

  function handleFiles(files) {
    const errors = [];
    const newFiles = Array.from(files);

    // Check total file count
    if (selectedFiles.length + newFiles.length > MAX_FILES) {
      showMessage(`You can only upload up to ${MAX_FILES} files per brief submission`, 'error');
      return;
    }

    newFiles.forEach(file => {
      // Check file size
      if (file.size > MAX_FILE_SIZE) {
        errors.push(`${file.name} exceeds 4MB limit`);
        return;
      }

      // Check file type
      const fileExt = '.' + file.name.split('.').pop().toLowerCase();
      if (!ALLOWED_TYPES.includes(file.type) && !ALLOWED_EXTENSIONS.includes(fileExt)) {
        errors.push(`${file.name} is not a supported format`);
        return;
      }

      // Check for duplicates
      if (selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
        errors.push(`${file.name} is already added`);
        return;
      }

      selectedFiles.push(file);
    });

    if (errors.length > 0) {
      showMessage('Some files were not added:\n\n• ' + errors.join('\n• '), 'error');
    }

    renderFileList();
  }

  function renderFileList() {
    if (selectedFiles.length === 0) {
      fileList.innerHTML = '';
      updateUploadCounter();
      return;
    }

    fileList.innerHTML = selectedFiles.map((file, index) => `
      <div class="file-item">
        <div class="file-info">
          <svg class="file-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
            <polyline points="13 2 13 9 20 9"></polyline>
          </svg>
          <div class="file-details">
            <div class="file-name">${file.name}</div>
            <div class="file-size">${formatFileSize(file.size)}</div>
          </div>
        </div>
        <button type="button" class="file-remove" onclick="removeFile(${index})" title="Remove file">&times;</button>
      </div>
    `).join('');
    
    updateUploadCounter();
  }

  function updateUploadCounter() {
    const remaining = MAX_FILES - selectedFiles.length;
    const counter = document.getElementById('uploadCounter');
    if (counter) {
      counter.textContent = `(${remaining}) upload(s) left`;
    }
  }

  function removeFile(index) {
    selectedFiles.splice(index, 1);
    renderFileList();
  }

  function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
  }
</script>

<!--script for form-->
<script>
  // Validation Functions
  function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  function validatePhone(phone) {
    if (!phone) return true; // Optional field
    const digits = phone.replace(/^\+1\s*/, '').replace(/\D/g, '');
    return digits.length === 10;
  }

  function formatPhoneWithPrefix(value) {
    const prefix = '+1 ';
    let digits = value.replace(/^\+1\s*/, '').replace(/\D/g, '').slice(0, 10);

    if (digits.length === 0) {
      return '';
    }

    if (digits.length <= 3) {
      return `${prefix}(${digits}`;
    }

    if (digits.length <= 6) {
      return `${prefix}(${digits.slice(0, 3)}) ${digits.slice(3)}`;
    }

    return `${prefix}(${digits.slice(0, 3)}) ${digits.slice(3, 6)}-${digits.slice(6)}`;
  }

  function composeInternationalPhone() {
    const phoneField = document.getElementById('yourphone');
    const formatted = formatPhoneWithPrefix(phoneField.value || '');
    phoneField.value = formatted;
    return formatted;
  }

  function validateURL(url) {
    if (!url) return true; // Optional field
    try {
      new URL(url);
      return true;
    } catch {
      return false;
    }
  }

  function normalizeWebsiteValue(rawUrl) {
    const url = (rawUrl || '').trim();

    // Treat untouched protocol stubs as empty optional value.
    if (!url || url === 'https://' || url === 'http://') {
      return '';
    }

    // If user enters domain without protocol, normalize to https.
    if (!/^https?:\/\//i.test(url)) {
      return `https://${url}`;
    }

    return url;
  }

  function showMessage(message, type) {
    const titles = {
      success: 'Success!',
      error: 'Error'
    };
    showNotificationModal(type, titles[type] || 'Notice', message);
  }

  function validateForm(formData) {
    const errors = [];
    
    // Name validation
    const name = formData.get('yourName');
    if (!name || name.trim().length < 2) {
      errors.push('Please enter your full name');
    }
    
    // Email validation
    const email = formData.get('email');
    if (!email || !validateEmail(email)) {
      errors.push('Please enter a valid email address');
    }
    
    // Phone validation
    const phone = composeInternationalPhone();
    if (phone && !validatePhone(phone)) {
      errors.push('Please enter a valid phone number');
    }
    
    // Website validation
    const website = normalizeWebsiteValue(formData.get('website'));
    if (website && !validateURL(website)) {
      errors.push('Please enter a valid website URL (e.g., https://example.com)');
    }
    
    // Services validation
    const services = formData.getAll('services');
    if (services.length === 0) {
      errors.push('Please select at least one service');
    }
    
    // Referral source validation
    const referralSource = formData.get('howDidYouHearAboutUs');
    if (!referralSource) {
      errors.push('Please tell us how you heard about us');
    }
    
    return errors;
  }

  document.getElementById('contactForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    // Collect form data
    const formData = new FormData(e.target);
    
    // Keep phone value synchronized in normalized +1 format
    const fullPhone = composeInternationalPhone();
    const normalizedWebsite = normalizeWebsiteValue(formData.get('website'));
    document.getElementById('website').value = normalizedWebsite;

    // Client-side validation
    const errors = validateForm(formData);
    if (errors.length > 0) {
      showMessage('Please fix the following errors:\n\n• ' + errors.join('\n• '), 'error');
      return;
    }

    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="loading-spinner"></span> Submitting...';

    // Prepare form data with files
    const submissionData = new FormData();
    submissionData.append('name', formData.get('yourName'));
    submissionData.append('email', formData.get('email'));
    submissionData.append('phone', fullPhone);
    submissionData.append('website', normalizedWebsite);
    submissionData.append('budget_min', parseInt(document.getElementById('min-range').value));
    submissionData.append('budget_max', parseInt(document.getElementById('max-range').value));
    submissionData.append('referral_source', formData.get('howDidYouHearAboutUs'));
    submissionData.append('comments', formData.get('comments'));
    
    // Add services as JSON array
    formData.getAll('services').forEach(service => {
      submissionData.append('services[]', service);
    });
    
    // Add files
    selectedFiles.forEach((file, index) => {
      submissionData.append('brief_files[]', file);
    });

    try {
      const response = await fetch('<?= $base_url ?>/_system/submit_digital_brief.php', {
        method: 'POST',
        body: submissionData
      });

      const result = await response.json();

      if (result.success) {
        showMessage('✓ ' + result.message, 'success');
        e.target.reset();
        selectedFiles = [];
        renderFileList();
        updateSlider(); // Reset slider display
      } else {
        if (result.errors) {
          showMessage('Please fix the following errors:\n\n• ' + result.errors.join('\n• '), 'error');
        } else {
          showMessage('✗ ' + result.message, 'error');
        }
      }
    } catch (error) {
      showMessage('An error occurred. Please try again later or contact us directly at (800) 770-5520', 'error');
      console.error('Submission error:', error);
    } finally {
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalBtnText;
    }
  });

  // Real-time validation feedback
  document.getElementById('email').addEventListener('blur', function() {
    if (this.value && !validateEmail(this.value)) {
      this.style.borderColor = '#dc3545';
    } else {
      this.style.borderColor = '';
    }
  });

  // Phone field formatting with fixed +1 prefix (US-only)
  const phoneField = document.getElementById('yourphone');

  phoneField.addEventListener('focus', function(e) {
    if (!e.target.value) {
      e.target.value = '+1 ';
    }
    setTimeout(() => {
      e.target.setSelectionRange(e.target.value.length, e.target.value.length);
    }, 0);
  });

  phoneField.addEventListener('input', function(e) {
    e.target.value = formatPhoneWithPrefix(e.target.value);
  });

  phoneField.addEventListener('keydown', function(e) {
    const cursorPos = e.target.selectionStart || 0;
    if ((e.key === 'Backspace' || e.key === 'Delete') && cursorPos <= 3) {
      e.preventDefault();
    }
    if (e.key === 'ArrowLeft' && cursorPos <= 3) {
      e.preventDefault();
    }
  });

  phoneField.addEventListener('click', function(e) {
    if ((e.target.selectionStart || 0) < 3 && e.target.value.startsWith('+1 ')) {
      e.target.setSelectionRange(3, 3);
    }
  });

  phoneField.addEventListener('blur', function() {
    if (this.value === '+1 ') {
      this.value = '';
      this.style.borderColor = '';
      return;
    }

    const fullPhone = composeInternationalPhone();
    if (fullPhone && !validatePhone(fullPhone)) {
      this.style.borderColor = '#dc3545';
    } else {
      this.style.borderColor = '';
    }
  });

  // Website field (optional)
  const websiteField = document.getElementById('website');

  document.getElementById('website').addEventListener('blur', function() {
    const normalized = normalizeWebsiteValue(this.value);
    this.value = normalized;
    if (normalized && !validateURL(normalized)) {
      this.style.borderColor = '#dc3545';
    } else {
      this.style.borderColor = '';
    }
  });
</script>


<link rel="stylesheet" href="<?= $base_url ?>/assets/css/digital-service-brief-form.css">