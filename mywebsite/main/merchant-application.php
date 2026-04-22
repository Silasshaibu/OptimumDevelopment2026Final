 
  <header class="hero-section narrow">
    <h1 class="hero-title narrow"> Merchant Application<h1>
  </header>

  <section class="merchantApplicationForm contact-card">
    
  
      <form class="merchantApplicationForm" id="contactForm">         
        <p class="from-subtle-message">
          We aim to respond to all application requests within a <strong>24 hour period Monday-Friday.</strong> 
          <span class="merchantFormBreaker"><br></span> However, if this isn't the case, please be patient as we receive a lot of email every day. 
        </p>

        <!-- Honeypot field - hidden from users, catches bots -->
        <input type="text" name="website" id="website" style="position:absolute;left:-9999px;width:1px;height:1px;" tabindex="-1" autocomplete="off" />
      
      <div class="formSections-wrapper">
            <div class="verticalsplitter"></div>
             <div class="form-section">        
        <!-- CONTACT INFORMATION -->
            <fieldset>
            <legend>Contact Information</legend>

            <label for="surname">Surname</label>
            <input id="surname" name="surname" type="text" placeholder="Last Name" required autocomplete="family-name" />

            <label for="firstName">First Name</label>
            <input id="firstName" name="first_name" type="text" placeholder="First Name" required autocomplete="given-name" />

            <label for="title">Title</label>
            <input id="title" name="title" type="text" placeholder="Mr." autocomplete="honorific-prefix" />

            <label for="phone">Phone*</label>
            <input id="phone" name="phone" type="tel" placeholder="+1 (212) 555-1234" required autocomplete="tel" />

            <label for="company">Company Name</label>
            <input id="company" name="company" type="text" placeholder="Company Name" required autocomplete="organization" />

            <label for="email">Email*</label>
            <input id="email" name="email" type="email" placeholder="example@email.com" required autocomplete="email" />

            <label for="fax">Fax</label>
            <input id="fax" name="fax" type="tel" placeholder="+1 (212) 555-5678" autocomplete="tel-extension" />

            <label for="address1">Address</label>
            <input id="address1" name="address1" type="text" placeholder="123 Main Street" autocomplete="address-line1" />

            <label for="address2">Address Line 2</label>
            <input id="address2" name="address2" type="text" placeholder="Suite 204" autocomplete="address-line2" />

            <div class="address-grid">
                <div>
                     <label for="state">State</label>
            <select id="state" name="state" required>
                <option value="" disabled selected>Select a state</option>
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="SD">South Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
            </select>
                </div>
               
                <div>
                    <label for="city">City</label>
            <select id="city" name="city" disabled required>
                <option value="" disabled selected>Select a city</option>
            </select>

                </div>
            
                <div>
            <label for="zip">Zip Code</label>
              <input 
                id="zip" 
                name="zip"
                type="number" 
                placeholder="90001" 
                min="0" 
                max="99999" 
                required
                pattern="\d{5}" 
                title="Please enter a 5-digit zip code"
            />
                </div>
            
            </div>
            
            </fieldset>
            </div>

            <div class="form-section">
        <!-- BUSINESS INFORMATION -->
            <fieldset>
            <legend>Business Information</legend>

            <label for="businessType">Business Type</label>
            <input id="businessType" name="business_type" type="text" placeholder="e.g., Retail, Food Service" autocomplete="off" />

            <p>Do you currently accept credit cards?</p>
            <div class="form-group">
                <input type="radio" id="acceptYes" name="accept_credit_cards" value="yes" required> Yes
                <input type="radio" id="acceptNo" name="accept_credit_cards" value="no"> No
            </div>

            <p>Have you previously taken credit cards?</p>
            <div class="form-group">
                <input type="radio" id="previousYes" name="previous_credit_cards" value="yes" required> Yes
                <input type="radio" id="previousNo" name="previous_credit_cards" value="no"> No
            </div>

            <label for="monthlyVolume">Estimated Monthly Volume</label>
            <select id="monthlyVolume" name="monthly_volume" required>
                <option value="">Select estimated monthly volume</option>
                <option value="0-4999">$0-$4,999</option>
                <option value="5000-9999">$5,000-$9,999</option>
                <option value="10000-24999">$10,000-$24,999</option>
                <option value="25000-99999">$25,000-$99,999</option>
                <option value="100000+">$100,000+</option>
            </select>

            <label for="comments">Additional Comments</label>
            <textarea id="comments" name="comments" placeholder="Enter any additional information"></textarea>
            </fieldset>

        <button class="btn-primary merchantApplicationForm" type="submit">Submit</button>
            </div>
        </div>
       
      </form>

  </section>

 <!--stylings for contact us form-->
 <link rel="stylesheet" href="<?= $base_url ?>/assets/css/style-guide.css">
<link rel="stylesheet" href="<?= $base_url ?>/assets/css/merchant-application.css">


<!--script for form-->
  <script>
    // Phone number formatting with fixed +1 prefix
    function formatPhoneWithPrefix(value) {
      // Always start with +1
      const prefix = '+1 ';
      
      // Remove +1 and all non-digit characters
      let digits = value.replace(/^\+1\s*/, '').replace(/\D/g, '');
      
      // Limit to 10 digits
      digits = digits.slice(0, 10);
      
      // Format as +1 (XXX) XXX-XXXX
      if (digits.length === 0) {
        return prefix;
      } else if (digits.length <= 3) {
        return `${prefix}(${digits}`;
      } else if (digits.length <= 6) {
        return `${prefix}(${digits.slice(0, 3)}) ${digits.slice(3)}`;
      } else {
        return `${prefix}(${digits.slice(0, 3)}) ${digits.slice(3, 6)}-${digits.slice(6)}`;
      }
    }

    // Extract just the digits from formatted phone
    function extractDigits(value) {
      return value.replace(/^\+1\s*/, '').replace(/\D/g, '');
    }

    // Validate phone number (exactly 10 digits)
    function validatePhoneNumber(value) {
      const digits = extractDigits(value);
      return digits.length === 10;
    }

    // Phone input auto-formatting
    const phoneInput = document.getElementById('phone');
    
    // Set initial value
    if (!phoneInput.value) {
      phoneInput.value = '+1 ';
    }

    phoneInput.addEventListener('focus', (e) => {
      if (!e.target.value || e.target.value === '') {
        e.target.value = '+1 ';
      }
      // Move cursor after +1 
      setTimeout(() => {
        e.target.setSelectionRange(3, 3);
      }, 0);
    });

    phoneInput.addEventListener('input', (e) => {
      const cursorPos = e.target.selectionStart;
      const formatted = formatPhoneWithPrefix(e.target.value);
      e.target.value = formatted;
      
      // Prevent cursor from going before +1 
      if (cursorPos < 3) {
        e.target.setSelectionRange(3, 3);
      }
      
      // Remove custom validity if valid
      if (validatePhoneNumber(formatted)) {
        e.target.setCustomValidity('');
      }
    });

    phoneInput.addEventListener('keydown', (e) => {
      const cursorPos = e.target.selectionStart;
      
      // Prevent deleting +1 prefix
      if ((e.key === 'Backspace' || e.key === 'Delete') && cursorPos <= 3) {
        e.preventDefault();
      }
      
      // Prevent moving cursor before +1 
      if ((e.key === 'ArrowLeft' || e.key === 'Home') && cursorPos <= 3) {
        e.preventDefault();
        e.target.setSelectionRange(3, 3);
      }
    });

    phoneInput.addEventListener('blur', (e) => {
      if (e.target.value === '+1 ') {
        e.target.value = '';
      }
      if (e.target.value && !validatePhoneNumber(e.target.value)) {
        e.target.setCustomValidity('Please enter a valid 10-digit phone number');
        e.target.reportValidity();
      } else {
        e.target.setCustomValidity('');
      }
    });

    // Fax input auto-formatting (same logic but optional)
    const faxInput = document.getElementById('fax');

    faxInput.addEventListener('focus', (e) => {
      if (!e.target.value || e.target.value === '') {
        e.target.value = '+1 ';
      }
      setTimeout(() => {
        e.target.setSelectionRange(3, 3);
      }, 0);
    });

    faxInput.addEventListener('input', (e) => {
      const cursorPos = e.target.selectionStart;
      const formatted = formatPhoneWithPrefix(e.target.value);
      e.target.value = formatted;
      
      if (cursorPos < 3) {
        e.target.setSelectionRange(3, 3);
      }
      
      if (!e.target.value || e.target.value === '+1 ' || validatePhoneNumber(formatted)) {
        e.target.setCustomValidity('');
      }
    });

    faxInput.addEventListener('keydown', (e) => {
      const cursorPos = e.target.selectionStart;
      
      if ((e.key === 'Backspace' || e.key === 'Delete') && cursorPos <= 3) {
        e.preventDefault();
      }
      
      if ((e.key === 'ArrowLeft' || e.key === 'Home') && cursorPos <= 3) {
        e.preventDefault();
        e.target.setSelectionRange(3, 3);
      }
    });

    faxInput.addEventListener('blur', (e) => {
      if (e.target.value === '+1 ') {
        e.target.value = '';
      }
      if (e.target.value && e.target.value !== '+1 ' && !validatePhoneNumber(e.target.value)) {
        e.target.setCustomValidity('Please enter a valid 10-digit fax number');
        e.target.reportValidity();
      } else {
        e.target.setCustomValidity('');
      }
    });

    // Zip code validation
    const zipInput = document.getElementById('zip');
    zipInput.addEventListener('input', (e) => {
        e.target.value = e.target.value.replace(/\D/g,'').slice(0,5);
    });

    // State → City mapping
    const stateCities = {
      "AL": ["Birmingham", "Montgomery", "Mobile", "Huntsville", "Tuscaloosa"],
      "AK": ["Anchorage", "Fairbanks", "Juneau", "Sitka", "Ketchikan"],
      "AZ": ["Phoenix", "Tucson", "Mesa", "Chandler", "Scottsdale", "Glendale"],
      "AR": ["Little Rock", "Fort Smith", "Fayetteville", "Springdale", "Jonesboro"],
      "CA": ["Los Angeles", "San Diego", "San Jose", "San Francisco", "Fresno", "Sacramento", "Long Beach", "Oakland", "Bakersfield", "Anaheim"],
      "CO": ["Denver", "Colorado Springs", "Aurora", "Fort Collins", "Lakewood", "Boulder"],
      "CT": ["Bridgeport", "New Haven", "Stamford", "Hartford", "Waterbury"],
      "DE": ["Wilmington", "Dover", "Newark", "Middletown", "Smyrna"],
      "FL": ["Jacksonville", "Miami", "Tampa", "Orlando", "St. Petersburg", "Hialeah", "Tallahassee", "Fort Lauderdale", "Port St. Lucie"],
      "GA": ["Atlanta", "Augusta", "Columbus", "Macon", "Savannah", "Athens"],
      "HI": ["Honolulu", "Pearl City", "Hilo", "Kailua", "Waipahu"],
      "ID": ["Boise", "Meridian", "Nampa", "Idaho Falls", "Pocatello"],
      "IL": ["Chicago", "Aurora", "Rockford", "Joliet", "Naperville", "Springfield"],
      "IN": ["Indianapolis", "Fort Wayne", "Evansville", "South Bend", "Carmel"],
      "IA": ["Des Moines", "Cedar Rapids", "Davenport", "Sioux City", "Iowa City"],
      "KS": ["Wichita", "Overland Park", "Kansas City", "Olathe", "Topeka"],
      "KY": ["Louisville", "Lexington", "Bowling Green", "Owensboro", "Covington"],
      "LA": ["New Orleans", "Baton Rouge", "Shreveport", "Lafayette", "Lake Charles"],
      "ME": ["Portland", "Lewiston", "Bangor", "South Portland", "Auburn"],
      "MD": ["Baltimore", "Frederick", "Rockville", "Gaithersburg", "Bowie", "Annapolis"],
      "MA": ["Boston", "Worcester", "Springfield", "Cambridge", "Lowell"],
      "MI": ["Detroit", "Grand Rapids", "Warren", "Sterling Heights", "Ann Arbor", "Lansing"],
      "MN": ["Minneapolis", "St. Paul", "Rochester", "Duluth", "Bloomington"],
      "MS": ["Jackson", "Gulfport", "Southaven", "Hattiesburg", "Biloxi"],
      "MO": ["Kansas City", "St. Louis", "Springfield", "Columbia", "Independence"],
      "MT": ["Billings", "Missoula", "Great Falls", "Bozeman", "Helena"],
      "NE": ["Omaha", "Lincoln", "Bellevue", "Grand Island", "Kearney"],
      "NV": ["Las Vegas", "Henderson", "Reno", "North Las Vegas", "Sparks"],
      "NH": ["Manchester", "Nashua", "Concord", "Derry", "Rochester"],
      "NJ": ["Newark", "Jersey City", "Paterson", "Elizabeth", "Edison", "Trenton"],
      "NM": ["Albuquerque", "Las Cruces", "Rio Rancho", "Santa Fe", "Roswell"],
      "NY": ["New York City", "Buffalo", "Rochester", "Yonkers", "Syracuse", "Albany"],
      "NC": ["Charlotte", "Raleigh", "Greensboro", "Durham", "Winston-Salem", "Fayetteville"],
      "ND": ["Fargo", "Bismarck", "Grand Forks", "Minot", "West Fargo"],
      "OH": ["Columbus", "Cleveland", "Cincinnati", "Toledo", "Akron", "Dayton"],
      "OK": ["Oklahoma City", "Tulsa", "Norman", "Broken Arrow", "Lawton"],
      "OR": ["Portland", "Salem", "Eugene", "Gresham", "Hillsboro"],
      "PA": ["Philadelphia", "Pittsburgh", "Allentown", "Erie", "Reading", "Harrisburg"],
      "RI": ["Providence", "Warwick", "Cranston", "Pawtucket", "East Providence"],
      "SC": ["Columbia", "Charleston", "North Charleston", "Mount Pleasant", "Rock Hill"],
      "SD": ["Sioux Falls", "Rapid City", "Aberdeen", "Brookings", "Watertown"],
      "TN": ["Nashville", "Memphis", "Knoxville", "Chattanooga", "Clarksville"],
      "TX": ["Houston", "San Antonio", "Dallas", "Austin", "Fort Worth", "El Paso", "Arlington", "Corpus Christi", "Plano"],
      "UT": ["Salt Lake City", "West Valley City", "Provo", "West Jordan", "Orem"],
      "VT": ["Burlington", "South Burlington", "Rutland", "Barre", "Montpelier"],
      "VA": ["Virginia Beach", "Norfolk", "Chesapeake", "Richmond", "Newport News", "Alexandria"],
      "WA": ["Seattle", "Spokane", "Tacoma", "Vancouver", "Bellevue", "Kent"],
      "WV": ["Charleston", "Huntington", "Morgantown", "Parkersburg", "Wheeling"],
      "WI": ["Milwaukee", "Madison", "Green Bay", "Kenosha", "Racine"],
      "WY": ["Cheyenne", "Casper", "Laramie", "Gillette", "Rock Springs"]
    };

    const stateSelect = document.getElementById('state');
    const citySelect = document.getElementById('city');

    stateSelect.addEventListener('change', (e) => {
      const cities = stateCities[e.target.value] || [];
      citySelect.innerHTML = '<option value="" disabled selected>Select a city</option>';
      if (cities.length) {
        cities.forEach(city => {
          const opt = document.createElement('option');
          opt.value = city;
          opt.textContent = city;
          citySelect.appendChild(opt);
        });
        citySelect.disabled = false;
      } else {
        citySelect.disabled = true;
      }
    });

    // Form submission
    document.getElementById('contactForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      if (!e.target.checkValidity()) {
        e.target.reportValidity();
        return;
      }

      // Honeypot check - if filled, it's a bot
      const honeypot = document.getElementById('website');
      if (honeypot.value !== '') {
        console.log('Bot detected - honeypot filled');
        return; // Silently reject
      }

      const submitBtn = e.target.querySelector('button[type="submit"]');
      const originalBtnText = submitBtn.innerHTML;
      submitBtn.disabled = true;
      submitBtn.innerHTML = 'Submitting...';

      const data = Object.fromEntries(new FormData(e.target).entries());
      
      // Remove honeypot from data before sending
      delete data.website;

      try {
        const response = await fetch('<?= $base_url ?>/_system/submit_merchant_application.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(data)
        });

        console.log('Response status:', response.status);
        const responseText = await response.text();
        console.log('Response text:', responseText);
        
        const result = JSON.parse(responseText);

        if (result.success) {
          alert('📧 ' + result.message + '\n\nPlease also check your spam folder if you don\'t see it in your inbox.');
          e.target.reset();
          citySelect.disabled = true;
        } else {
          if (result.errors) {
            alert('Please fix the following errors:\n\n• ' + result.errors.join('\n• '));
          } else {
            alert('✗ ' + result.message);
          }
        }
      } catch (error) {
        alert('An error occurred. Please try again later or contact us at (800) 770-5520');
        console.error('Submission error:', error);
      } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
      }
    });
  </script>