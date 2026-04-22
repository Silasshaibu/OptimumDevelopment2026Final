
    <!-- Hero -->
    <div class="carousel-window">
        <div class="carousel-wrapper">
            <div class="slide">
                  <div class="textInfo-wrapper">
                    <p class="label-h1">SERVICE BUSINESS</p>
                        <!--Label can be empty and the height wil still be maintined ALSO you can include the height as well-->
                    </p>
                    <h1 class="heading title display">ECOMMERCE BUSINESS</h1>
                    <p class="display subtitle">At Optimum Payments, we are at the forefront of offering Internet merchant account solutions to E-Commerce merchants.</h1>
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
        <h2 class="content-title">Help grow your business online, manage it all in one place</h2>
      
        <p style="text-align:center; padding-top:2rem;" class="textInfo">
              Use Clover’s eCommerce solutions to help you grow your business online.  Integrate Clover with your existing website, or let us help you build a new one. With Clover, you can manage it all in one place through the Clover® Dashboard.
        </p>
      </div>
        


      <!-- 2 Half Blocks-->
      <div class="body-with-context grid">
        <div class="side text single-col">
          <dotlottie-player
            class="lottie-on-view"
            src="<?= $base_url ?>/assets/lottie/TimerClock.json"
            background="transparent"
            speed="1"
            style="width: 200px; height: auto;"
          ></dotlottie-player>
          <div>
            <h5 class="sub-title dark has-display">EVERYTHING IN SYNC</h5>
            <p class="textInfo">
            Increase productivity with an eCommerce solution that synchronizes orders, inventory, and customer data across all channels.
            </p>
          </div>  
          
      </div>

      <div class="side text single-col">
          <dotlottie-player
            class="lottie-on-view"
            src="<?= $base_url ?>/assets/lottie/HandSpark.json"
            background="transparent"
            speed="1"
            style="width: 200px; height: auto;"
          ></dotlottie-player>
          <div>
            <h5 class="sub-title dark has-display">TAILORED TO YOUR NEEDS</h5>
            <p class="textInfo">
              Sell products and accept online payments, create an online menu, or enable online appointment bookings.
            </p>
          </div>
      </div>

      <div class="side text single-col">
          <dotlottie-player
            class="lottie-on-view"
            src="<?= $base_url ?>/assets/lottie/Security.json"
            background="transparent"
            speed="1"
            style="width: 200px; height: auto;"
          ></dotlottie-player>
          <div>
            <h5 class="sub-title dark has-display">SECURE PAYMENTS</h5>
            <p class="textInfo">
              Sell products and accept online payments, create an online menu, or enable online appointment bookings.
            </p>
          </div>
      </div>

      <div class="side text single-col">
          <dotlottie-player
            class="lottie-on-view"
            src="<?= $base_url ?>/assets/lottie/SearchFilter.json"
            background="transparent"
            speed="1"
            style="width: 200px; height: auto;"
          ></dotlottie-player>
          <div>
          <h5 class="sub-title dark has-display">UNIFIED DASHBOARD</h5>
          <p class="textInfo">
            Enjoy peace of mind knowing your data and your customers’ data are more safe and secure.
          </p>
          </div>
      </div>

      
      
    </section>

    <!-- section-->
    <section class="noteDefault grid white">
      <div class="heading">
        <h2 class="content-title">
          Use Clover’s online payment system with our small business eCommerce partners
        </h2>
      </div>

      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title white no-display">Larger touch screen</h3>
          <p class="textInfo">
           Clover and our eCommerce platform partners, Ecwid and BigCommerce, help you reach more customers through your own website, as well as through public marketplaces such as Instagram, Facebook, Amazon, eBay, and Etsy.
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

 

    
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/style-guide.css" /> 
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/singular-hero-style.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/singular.css">
      
      <style>
        .body-with-context.grid{
          display: grid;
          grid-template-columns: repeat(4, 1fr);
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
