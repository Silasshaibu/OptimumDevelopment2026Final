
    <!-- Hero -->
    <div class="carousel-window">
        <div class="carousel-wrapper">           
     
            <div class="slide">
                  <div class="textInfo-wrapper">
                    <p class="label-h1">TABLE SERVICE</p>
                        <!--Label can be empty and the height wil still be maintined ALSO you can include the height as well-->
                    </p>
                    <h1 class="heading title display">SWIPE SIMPLE</h1>
                    <p class="display subtitle">Simple enough to get you up and running in minutes. Powerful enough to save you time and money on day one.</h1>
                         <div class="image-wrapper">
                    <img src="<?= $base_url ?>/assets/images/products/SwipeSimple-Family/Tap-to-pay_mobile.webp" alt="" width="300px">
                  </div>

                  <div class="cta-container-hero">
                      <button id="swipeSimpleMegaMenuToggle" class="btn-secondary swipeSimple-mega-menuHeroBtn" aria-expanded="false">
                        View Products

                        <!-- <span class="unionMegaMenu-icon arrow-right">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon unionMegaMenu arrow-right">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                          </svg>
                        </span>

                        <span class="unionMegaMenu-icon arrow-long-right">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon unionMegaMenu arrow-long-right">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                          </svg>
                        </span> -->
                      </button>  
                  </div>               
              </div>
        </div>
    </div>  
    </div>

    


   <!-- section -->
  <section class="noteDefault grid neutral swipesimple">
      

      <div id="swipeSimpleMegaMenu" class="swipesimple-mega-menu">
      <button class="swipesimple-mega-menu__close" aria-label="Close menu">×</button>
      <div class="swipesimple-mega-menu__grid"></div>
    </div>

      <section class="swipesimple-sections"></section>  
  </section>
  
  
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

   
 

    
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/singular-hero-style.css">
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/singular.css">
  
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/swipesimple.css">    
  <script src="<?= $base_url ?>/assets/js/swipesimple-menu.js"></script>
