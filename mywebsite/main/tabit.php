
    <!-- Hero -->
    <div class="carousel-window">
        <div class="carousel-wrapper">            
         
            <div class="slide">
                <div class="textInfo-wrapper">
                    <p class="label-h1">TABLE SERVICE</p>
                        <!--Label can be empty and the height wil still be maintined ALSO you can include the height as well-->
                    </p>
                    <h1 class="heading title display">TABIT</h1>
                    <p class="display subtitle">A fully integrated suite of products to handle all aspects of restaurant operations.</p>
                         <div class="image-wrapper">
                    <img src="<?= $base_url ?>/assets/images/MobileMenuImages/mobileHero_Tabit.webp" alt="" width="300px" fetchpriority="high">
                </div>
                    <div class="cta-container-hero">
                      <button id="tabitMegaMenuToggle" class="btn-secondary tabit-mega-menuHeroBtn" aria-expanded="false">
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

    <style>
      /*Show desktop image only on desktop*/
        @media(min-width:768px){
          .slide{
          background:url(<?= $base_url ?>/assets/images/hero/desktopHero_Tabit_2.webp);
          
        }
      }
      
    </style>

    <!-- section -->
    <section class="noteDefault grid neutral tabit">
        

        <div id="tabitMegaMenu" class="tabit-mega-menu">
          <button class="tabit-mega-menu__close" aria-label="Close menu">×</button>
          <div class="tabit-mega-menu__grid"></div>
        </div>

        <section class="tabit-sections"></section>  
    </section>

    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/singular-hero-style.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/singular.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/tabit.css">
    <script src="<?= $base_url ?>/assets/js/tabit-menu.js"></script>
    

