
    <!-- Hero -->
    <div class="carousel-window">
        <div class="carousel-wrapper">
            <div class="slide">
                  <div class="textInfo-wrapper">
                    <p class="label-h1">TABLE SERVICE</p>
                        <!--Label can be empty and the height wil still be maintined ALSO you can include the height as well-->
                    </p>
                    <h1 class="heading title display">HYFIN</h1>
                    <p class="display subtitle">

                    Making it easy for you to get paid and convenient for your customers to pay you!  
                    </p>
                         <div class="image-wrapper">
                    <img src="<?= $base_url ?>/assets/images/products/Hyfin-Family/Hyfin-Hero-Banner_Mobile.webp" alt="" width="300px" fetchpriority="high">
                </div>
                    <div class="cta-container-hero">
                       <button class="btn-secondary">BUY NOW</button>
                    </div>   
                </div>               
            </div>
        </div>
    </div>

     <style>

      /*Show desktop image only on desktop*/
      .slide{
         background:url(<?= $base_url ?>/assets/images/products/Hyfin-Family/Hyfin-Hero-Banner.webp);
          
        }
        
        /*Show mobile image only and make background set to none*/
        @media(max-width:768px){
          .slide{
            background: none ;          
        }
      }      
    </style>

   
    <section class="noteDefault grid neutral">
      <!-- 1- Full Blocks-->
      <div class="heading">
        <h2 class="content-title">Benefits</h2> 
      </div>

      <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">
            Automate your receivables and save time 
          </h3>

          <ul class="unorderedClass hyfin">
            <li>
              <strong>Electronic Billing</strong><br>Send invoices in a click through email, text, or via online payment links
            </li>
            <li>
              <strong>Proactive Collections</strong><br>Schedule due dates, reminders, and automatic past due notifications
            </li>
            <li>
              <strong>Predictable Payments</strong><br>Eliminate slow pay with saved payment methods, automatic payments, and recurring payment plans
            </li>
          </ul>         
      </div>

      <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Hyfin-Family/Hyfin-AutomateYourReceivables.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
          />
      </div>

      </div>  
      
       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Save up to 100% on your card processing fees </h3>
          <ul class="unorderedClass hyfin">
            <li>
              <strong>Automatic Dual Pricing</strong><br>Offer your customer the option to pay a lower price if they choose to pay with cash or electronic check
            </li>
             <li>
              <strong>Compliant Surcharging</strong><br>Add a surcharge fee (example 3%) to the transaction if your customer chooses to pay with a credit card
            </li>
            <li>
              <strong>Convenience Fees</strong><br>Add a flat fee (example $2.50) to every transaction regardless of the method of payment
            </li>            
          </ul>         
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Hyfin-Family/Hyfin-SaveUpTo.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
          />
        </div>
      </div> 

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Accelerate your cash flow </h3>
          <ul class="unorderedClass hyfin">
            <li>
              <strong>HYFIN</strong><br>85% of payment requests sent with Hyfin are paid the same day.
            </li>  
             <li>
              <strong>TRADITIONAL</strong><br>On average, it takes up to 28 days for a business to get paid.
            </li>                      
          </ul>         
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Hyfin-Family/Hyfin-AccelerateYourCashFlow.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Automate your receivables and never look back </h3>
          <ul class="unorderedClass hyfin">
            <li>
              Create invoices and schedule payments in one simple step
            </li>  
             <li>
              Automatically apply discounts, fees and sales tax.
            </li>  
            <li>
              Schedule deposits or installments and Hyfin will automatically send requests to your customer to get you paid.
            </li>  
            <li>
              Secure payment links are delivered to your customers via text message and email.
            </li> 
            <li>
              Customize invoices with your logo and colors
            </li>                    
          </ul>         
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Hyfin-Family/Hyfin-CreateInvoice.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
          />
        </div>
      </div>
    </section>

    <section class="noteDefault grid white">
      <div class="heading">
        <h2 class="content-title">Payment Requests</h2> 
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Get paid fast</h3>
          <ul class="unorderedClass hyfin">
            <li>
              Send payment requests directly from the Hyfin app, API, or any of our integraed software vendors to your customers a payment request via text and/or email and get paid fast.
            </li>             
          </ul>         
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Hyfin-Family/Hyfin-PaymentRequest.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
          />
        </div>
      </div>
    </section>

    <section class="noteDefault grid white">
        <div class="heading">
          <h2 class="content-title">Payment Links</h2> 
        </div>
        <!-- 2 Half Blocks -- Payment Links-->
        <div class="body-with-context flex">
          <div class="side text">
            <h3 class="sub-title dark has-display">Create payment links to share in a few clicks. </h3>
            <ul class="unorderedClass hyfin">
              <li>
                Create and share payment links to sell products or services online
              </li>   
              
              <li>
                Single product links with "Buy Now" button
              </li> 

              <li>
                Multi-product page with rapid checkout experience
              </li> 

              <li>
                Add payment links or QR codes to your website, social media or marketing material
              </li> 
            </ul>         
          </div>

          <div class="side image">
            <img
              src="<?= $base_url ?>/assets/images/products/Hyfin-Family/Hyfin-PaymentLinks.webp"
              alt="product-image"
              width="100%"
              height="fit-content"  loading="lazy"
            />
          </div>
        </div>      
    </section>

    <section class="noteDefault grid dark">
      <div class="heading">
        <h2 class="content-title">Recurring Payments</h2> 
      </div>

       <!-- 2 Half Blocks -- Recurring Payments-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Hassle free subscription billing with Hyfin recurring payments. </h3>
          <ul class="unorderedClass hyfin">
            <li>
             Schedule and forget, we will get you paid
            </li>   
            
            <li>
              Send your customers a billing recurring payment request and let them add their payment method securely
            </li> 

            <li>
              Set up payment frequencies and cycles
            </li>             
          </ul>         
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Hyfin-Family/Hyfin-RecurringPayments.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
          />
        </div>
      </div>
    </section>
   
    
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/singular-hero-style.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/singular.css">

    <style>
      .unorderedClass.hyfin li{
        text-align: left;
        list-style-type: disc;
      }

    </style>