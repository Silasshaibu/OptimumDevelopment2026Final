
    <!-- Hero -->
    <div class="carousel-window">
        <div class="carousel-wrapper">
            <div class="slide">
                  <div class="textInfo-wrapper">
                    <p class="label-h1">HAND-HELD POS</p>
                        <!--Label can be empty and the height wil still be maintined ALSO you can include the height as well-->
                    </p>
                    <h1 class="heading title display">RETAIL BUSINESS</h1>
                    <p class="display subtitle">A great solution for any retail merchant, large or small. Our innovative retail payment solutions are complete, reliable and designed to secure your success whether your business is a small local retail outlet, regional franchise organization or a national chain store operation. Get superior support, competitive rates, expanded payment options, comprehensive reporting packages, and fast transaction processing, clearing, and settlement.</h1>
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
      .slide{
         background:url(<?= $base_url ?>/assets/images/hero/desktopHero_SwipeSimple_1.webp);
          
        }
        
        /*Show mobile image only and make background set to none*/
        @media(max-width:768px){
          .slide{
            background: none ;          
        }
      }      
    </style>



  <!-- section -->
    <section class="noteDefault grid neutral">
      <!-- 1- Full Blocks-->
      <div class="heading">
        <h2 class="content-title">Retail POS systems designed to streamline your store</h2>
      
        <p style="text-align:center; padding-top:2rem;" class="textInfo">
              Run your entire shop on a single smart POS. Manage inventory and keep track of stock. Accept payments at the touch of a button. Handle returns and exchanges. Oversee your staff and run sales reports.
        </p>
      </div>
        


      <!-- 2 Half Blocks-->
      <div class="body-with-context grid">
        <div class="side text single-col">
          <dotlottie-player
            class="lottie-on-view"
            src="<?= $base_url ?>/assets/lottie/ComponentFolder.json"
            background="transparent"
            speed="1"
            style="width: 200px; height: auto;"
          ></dotlottie-player>
          <div>
            <h5 class="sub-title dark has-display">OPTIMIZE YOUR INVENTORY</h5>
            <p class="textInfo">
            Let your Clover retail POS keep track of your entire inventory with real time updates and low-stock alerts.
            </p>
          </div>  
          
        </div>

        <div class="side text single-col">
            <dotlottie-player
              class="lottie-on-view"
              src="<?= $base_url ?>/assets/lottie/Culinery.json"
              background="transparent"
              speed="1"
              style="width: 200px; height: auto;"
            ></dotlottie-player>
            <div>
              <h5 class="sub-title dark has-display">CLOSE OUT FASTER</h5>
              <p class="textInfo">
                Clover’s powerful retail software takes payments in seconds, with most deposits arriving in your bank account in just one day.
              </p>
            </div>
        </div>

        <div class="side text single-col">
            <dotlottie-player
              class="lottie-on-view"
              src="<?= $base_url ?>/assets/lottie/BonAppetite.json"
              background="transparent"
              speed="1"
              style="width: 200px; height: auto;"
            ></dotlottie-player>
            <div>
              <h5 class="sub-title dark has-display">SELL MORE</h5>
              <p class="textInfo">
                Run promotions, deals, and discounts to keep customers coming back.
              </p>
            </div>
        </div> 
      </div> 
      
    </section>

   
      <!-- section-->
    <section class="noteDefault grid white">
      <div class="heading">
        <h2 class="content-title">
         Run a light retail shop
        </h2>
        <h3 style="text-align:center;" class="sub-title white has-display">  Manage your inventory  </h3>
      </div>
        
      <div class="body-with-context flex">
        <div class="side text">          
           <h3 class="sub-title white has-display">Create SKUs and variants </h3>           
              <p class="textInfo">
                You can also set up automatic tax rates to be applied to all your sales.
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
          <h3 class="sub-title white has-display">Get low-stock alerts</h3>
          <p class="textInfo">
            Never miss a sale again because you’re out of stock. Clover will notify you when your inventory is running low.
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
          <h3 class="sub-title white has-display">Add and update items</h3>
          <p class="textInfo">
            Scan and instantly add to or update your inventory with a barcode scanner.
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

      

      <h3 style="text-align:center;" class="sub-title white has-display">  Easier payments and exchanges  </h3>

      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title white has-display">Take every kind of payment</h3>
          <p class="textInfo">
            Accept credit, debit, and gift cards, as well as NFC and mobile payments. You can also set up automatic tax rates to be applied to all your sales.
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
          <h3 class="sub-title white has-display">Take payments without WiFi</h3>
          <p class="textInfo">
           No WiFi? No problem. Accept payments in offline mode and process them when you’re back online.
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
          <h3 class="sub-title white has-display">Process returns fast</h3>
          <p class="textInfo">
            Your Clover system runs your refunds fast, even on orders with multiple payments. An app lets you offer store credit.
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

      <h3 style="text-align:center;" class="sub-title white has-display">  Oversee your whole staff  </h3>

      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title white has-display">Know who sells the most</h3>
          <p class="textInfo">
            Keep track of sales numbers to reward your top people; set up team commissions.
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
          <h3 class="sub-title white has-display">Set login permissions</h3>
          <p class="textInfo">
           Control who can access sensitive data like financial statements.
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
          <h3 class="sub-title white has-display">Schedule team shifts</h3>
          <p class="textInfo">
           Anticipate busy times on a daily, weekly, or monthly basis and plan your employees’ shifts accordingly.
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

      <h3 style="text-align:center;" class="sub-title white has-display">  Keep customers coming back  </h3>

      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title white has-display">Send targeted promotions</h3>
          <p class="textInfo">
            Run promotions, offers, and discounts via text or email. You can even display special offers along the bottom of printed or digital receipts.
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
          <h3 class="sub-title white has-display">Launch a robust rewards program</h3>
          <p class="textInfo">
          Turn one-time customers into loyal fans with special deals that only unlock with repeat visits.
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
          <h3 class="sub-title white has-display">Get feedback directly from customers</h3>
          <p class="textInfo">
           Give your customers a simple way to share their feedback quickly and privately so you can improve your business.
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

      <h3 style="text-align:center;" class="sub-title white has-display">  Anytime‑anywhere access  </h3>

      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title white has-display">Anytime‑anywhere access</h3>
          <p class="textInfo">
           Use your Clover dashboard, iOS app, or Android app to track sales and other stats in real time. Run end-of-day reports for an instant snapshot of your numbers.
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

      <h3 style="text-align:center;" class="sub-title white has-display">  Accessories tailor-made for retail  </h3>

      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title white has-display">Accessories tailor-made for retail</h3>
          <p class="textInfo">
           Build the right retail POS system for your business. Add Clover-approved accessories like a barcode scanner or a lockable cash drawer.
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

      <style>
        .body-with-context.grid{
          display: grid;
          grid-template-columns: repeat(3, 1fr);
          gap:2rem;
          align-items: stretch;
        }

        .side.text.single-col{
          display: grid;
          grid-template-rows: repeat(2, 150px);
          row-gap:1rem;
        }

        .side.text.single-col img{
          width:200px;
        }

        

        h5.sub-title.dark.has-display{
          line-height: 1.5rem;
          height:50px;
          font-size:1rem;

        }

        @media(max-width:1024px){
          .body-with-context.grid{
          display: grid;
          grid-template-columns: repeat(2, 1fr);
          gap:2rem;
          }

        }
      </style>

      <script>
        // Play Lottie animations once when they come into view
        document.addEventListener('DOMContentLoaded', function() {
          const lottieObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
              if (entry.isIntersecting) {
                const player = entry.target;
                lottieObserver.unobserve(player); // Only play once
                
                // Wait for player to be ready
                if (typeof player.play === 'function') {
                  player.play();
                } else {
                  player.addEventListener('ready', () => player.play(), { once: true });
                }
              }
            });
          }, { threshold: 0.3 });

          document.querySelectorAll('.lottie-on-view').forEach(player => {
            lottieObserver.observe(player);
          });
        });
      </script>