
    <!-- Hero -->
    <div class="carousel-window">
        <div class="carousel-wrapper">
            <div class="slide">
                  <div class="textInfo-wrapper">
                    <p class="label-h1">HAND-HELD POS</p>
                        <!--Label can be empty and the height wil still be maintined ALSO you can include the height as well-->
                    </p>
                    <h1 class="heading title display">TABLE SERVICE RESTAURANTS</h1>
                    <p class="display subtitle">The smart Android countertop that eliminates charge to the merchant.</h1>
                         <div class="image-wrapper">
                    <img src="<?= $base_url ?>/assets/images/hero/clover-mini.webp" alt="" width="300px" fetchpriority="high">
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
        @media(min-width:768px){
          .slide{
          background:url(<?= $base_url ?>/assets/images/hero/desktopHero_ValorVP550_1.webp);
          
        }
      }      
    </style>

    <!-- section -->
    <section class="noteDefault grid neutral">
      <!-- 1- Full Blocks-->
      <div class="heading">
        <h2 class="content-title">Full service dining has always been about the experience</h2>
      </div>

      <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark no-display">Auto-Rotate Drying</h3>
          <p class="textInfo">
            Times have changed. But our commitment to our restaurant merchants hasn’t. <br>
            Get the restaurant POS that gives you what you need in these challenging times: 
            online ordering, contactless payments, and real-time reporting.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/clover-mini.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
          />
        </div>
      </div>
    </section>

    <!-- section-->
    <section class="noteDefault grid white">
      <div class="heading">
        <h2 class="content-title">
         Introducing: Scan to Order
        </h2>
      </div>

      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title white no-display">Larger touch screen</h3>
          <p class="textInfo">
            For your guests dining in, we’ve got something special on the POS menu. Introducing our latest feature, Scan to Order.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/clover-mini.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
          />
        </div>
      </div>

      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title white no-display">Receipts with options</h3>
          <p class="textInfo">
            Your guests scan a QR code to browse through your digital menu, then order and pay—all online, from the safety and convenience of their mobile devices.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/clover-mini.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
          />
        </div>
      </div>     
    </section>

    <!-- section-->
    <section class="noteDefault grid dark">
      <div class="heading">
        <h2 class="content-title">
          Two great restaurant POS systems. <br> Both come contactless
        </h2>
      </div>

      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark no-display">Inventory at your fingertips</h3>
          <p class="textInfo">We know running a restaurant is never 9 to 5. From account activation to setting up your menu and beyond, choose from multiple free support options, available how you want, when you need.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/clover-mini.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
          />
        </div>
      </div>
     
    </section>  

    

     
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/singular-hero-style.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/singular.css">
