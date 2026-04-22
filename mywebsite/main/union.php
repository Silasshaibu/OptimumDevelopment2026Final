
    <!-- Hero -->
    <div class="carousel-window">
        <div class="carousel-wrapper">           
           
            <div class="slide">
                  <div class="textInfo-wrapper">
                    <p class="label-h1">POINT OF SALE</p>
                        <!--Label can be empty and the height wil still be maintined ALSO you can include the height as well-->
                    </p>
                    <h1 class="heading title display">UNION</h1>
                    <p class="display subtitle">The only point of sale built exclusively for high volume hospitality</p>
                         <div class="image-wrapper">
                    <img src="<?= $base_url ?>/assets/images/products/Union-Device.webp" alt="" width="300px">
                  </div>
                    <div class="cta-container-hero">
                        <!-- UNION HERO VIEW PRODUCTS BUTTON -->
                    <button id="unionMegaMenuToggle" class="btn-secondary union-mega-menuHeroBtn" aria-expanded="false">
                      View Products

                      <span class="unionMegaMenu-icon arrow-right">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon unionMegaMenu arrow-right">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                      </span>

                      <span class="unionMegaMenu-icon arrow-long-right">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon unionMegaMenu arrow-long-right">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                        </svg>
                      </span>
                    </button>

                    <!-- UNION MEGA MENU -->
                    <div id="unionMegaMenu" class="union-mega-menu">
                      <button class="union-mega-menu__close" aria-label="Close menu">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon unionMegaMenu close-icon">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                      </button>

                      <div id="unionMegaMenuLeft" class="union-mega-menu__left"></div>
                      <div id="unionMegaMenuRight" class="union-mega-menu__right"></div>
                    </div>



                    </div>   
                </div>               
            </div>
        </div>
    </div> 

    <style>
      /*Show desktop image only on desktop*/
        @media(min-width:768px){
          .slide{
          background:url(<?= $base_url ?>/assets/images/hero/DesktopHero_Union.webp);
          
        }
      }      
    </style>
       

    <!-- section -- Point of Sale -->
    <section class="union-pos-grid noteDefault grid neutral">
      <!-- 1- Full Blocks-->
      <div id="union-pos-point-of-sale" class="union-pos-grid-item heading">
        <h2 class="content-title">Point of Sale</h2>
      </div>

      <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">The only point of sale built exclusively for high volume hospitality</h3>
          <p class="textInfo">
            Manage orders, sales, and payments in one place with powerful cloud-based software, transparent payment processing, and plenty more under the hood.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/pos_at_bar.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Built for speed and efficiency</h3>
          <p class="textInfo">
            The only cloud-based software system designed by industry experts, built specifically for the needs of high-volume bars and restaurants.
          </p>
          <p class="textInfo">
            Time is critical for busy bars, Union has features such as the ability to support 1,000+ tabs with no lag time, an offline mode that allows funds capture and one button push to close all tabs at the end of the night.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/Group-23328-1024x590.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Easy to learn. Even easier to use</h3>
          <p class="textInfo">
            Union’s intuitive interface ensures a smooth onboarding process, allowing new team members to quickly become proficient with minimal training.
          </p>
          <p class="textInfo">
            The simplified navigation ensures stress-free daily use, even during peak hours and high-pressure situations.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/Group-23329-981x1024.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Inventory management made easy</h3>
          <p class="textInfo">
            Live 86 countdown on individual items or modifiers.
          </p>
          <p class="textInfo">
            Real-time data on stock levels allows businesses to keep track of products that are selling well and those that are not.
          </p>
          <p class="textInfo">
            Real-time data on stock levels allows businesses to keep track of products that are selling well and those that are not.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/Group-23330-1024x652.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Drive more revenue</h3>
          <p class="textInfo">
            Union’s efficiency and speed not only means more drinks, ordered faster, it means happier customers and bigger tips.
          </p>
          <p class="textInfo">
            Bars that see the biggest increase in revenue adopt our Guest-led ordering (28% increase) and Union Recommendations, Offers and Rewards (75% increase). Together this suite creates the best guest experience for your customers.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/Group-23346-1024x745.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">24/7 Customer Support at no additional fee</h3>
          <p class="textInfo">
            Every Union customer has a dedicated account manager that is located in their city on call to answer questions, provide support, and offer recommendations.
          </p>
          <p class="textInfo">
            Our team will meet with you in person for installations, training and periodic check-ins.
          </p>
          <p class="textInfo">
            Use our 24/7 support line to speak to a live US-based person anytime day or night. 
          </p>
          <p class="textInfo">
            Our team is always awake when you are. No fees, ever.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/customer-support-1.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>


    </section>

    <!-- section -- Guest Led Ordering -->
    <section class="union-pos-grid noteDefault grid dark">
      <!-- 1- Full Blocks-->
      <div id="union-pos-guest-led-ordering" class="union-pos-grid-item heading">
        <h2 class="content-title">Guest Led Ordering</h2>
      </div>

      <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Drive a 28% increase in sales and tips with elevated guest experiences</h3>
          <p class="textInfo">
            Give customers the ability to lead their experience and eliminate unnecessary wait time.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/step-1.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Serve more drinks, less wait time</h3>
          <p class="textInfo">
            Customers do not want to wait. With guest-led ordering, customers can instantly order from their smartphones and drinks are delivered 6 minutes faster than traditional face-to-face ordering.
          </p>
          <p class="textInfo">
            No app download is required. Guests just scan a QR code to order. With Apple or Google pay, customers do not even have to enter credit card information.
          </p>
          <p class="textInfo">
            Guests can close their tab, tip at their convenience, and leave as soon as they are ready.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/retro-mock-1024x747.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Offer guests Rewards funded by Union</h3>
          <p class="textInfo">
            Rewards is your secret weapon for boosting sales, tips, and repeat visits—without lifting a finger. Our guest-led ordering experience offers your customers instant rewards fully-funded by us and automated based on their drink preferences. When guests unlock a reward, they get an instant credit off their tab, while you get the full price for every item sold. Through our proprietary guest-led rewards experience, guests spend more (on average 30% more), leave higher tips for your staff, and visit your establishment more frequently. 
          </p>
          
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/Union-Last-Handheld-Img-1024x623.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Unlock more efficient staff</h3>
          <p class="textInfo">
            When staff does not need to focus on entering orders and dropping checks, they can cover 3x the tables than they could with traditional ordering.
          </p>
          <p class="textInfo">
            Guest-led ordering seamlessly integrates with Union’s point of sale, meaning a guest can open a tab and order a drink from their smartphone and their server can easily add to that order or close them out.
          </p>          
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/Group-23346-1024x745.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Engage guests anytime, anyday</h3>
          <p class="textInfo">
            Automatically showcase the most relevant food and beverage options based on the time of day and week.
          </p>
          <p class="textInfo">
            Bid farewell to manual updates and keep your guests engaged with an ever-changing menu that reflects brunch, lunch, happy hour, and dinner specials.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/Group-23345-1024x813.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Generate happier, more loyal customers</h3>
          <p class="textInfo">
            Waiting is the number one driver of poor reviews. With guest-led ordering, guests receive their orders 80% faster compared to when ordering with a server, and servers can focus more on hospitality and customer service.
          </p>          
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/Union_Venues_HalfWidthRounded_HappyGuests_1140x800-1024x719.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

        <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Make more money with less waiting and greater efficiency</h3>
          <p class="textInfo">
            Bars that adopt guest-led ordering see average check sizes increase by 28%.
          </p> 
          <p class="textInfo">
            Elevated guest experiences lead to significant increases in spending. When guests can order at will, with no waiting, they order more frequently and spend more, driving both revenue and tips.
          </p> 
        </div>          
        
        

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/phone-hand-1024x1024.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>
        <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">“We could not have delivered to the insane increase in volume during the final World Cup game without Guest-Led Ordering with Union” <span class="author-name">Vu, Owner @ The Phoenix</span></h3>
          <p class="textInfo">
            By moving to Union’s Guest-Led ordering, The Phoenix has been able to service more customers and deliver great service – increasing their average check size by $15 and staff tips by 25%. 
          </p>          
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/phoenix-mock-1024x683.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>


    </section>

     <!-- section -- POS Rewards Loyalty -->
    <section class="union-pos-grid noteDefault grid neutral loyalty-union-blue">
      <!-- 1- Full Blocks-->
      <div id="union-pos-rewards-loyalty" class="union-pos-grid-item heading">
        <h2 class="content-title">POS Rewards Loyalty</h2>
      </div>      

      <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Instant Credits for Guests, Full Price for Bar & Staff</h3>
          <p class="textInfo">
            Union’s guest-led digital experience includes automated rewards, fully funded by Union, that will transform your guest’s loyalty and experience without work or costs on your part. These rewards are designed to enhance the experience for Union app users.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/step-4.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

      <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">How it work:</h3>
          <p class="textInfo"> <strong>Automated Rewards:</strong>
            Union’s guest-led mobile experience offers unique rewards based on your venue’s product availability and guest behavior to creating a personalized and engaging experience to enhance the Union app experience and drive guest-led adoption at your venue. 
          </p>
          <p class="textInfo"><strong>Instant Credits for Guests:</strong>
            When guests earn a reward, they receive an instant credit that reduces their total tab, enhancing their experience. 
          </p>
          <p class="textInfo"> <strong>Full Price for Your Venue:</strong>
            Union instantly funds 100% of the reward amount, ensuring your venue receives the full price for the drink.
          </p>
        </div>

        <div class="side image union-primary-blue">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/2023_3_6_Offers_Recs-2.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

      

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">The Power of Union Rewards</h3>
          <p class="textInfo">
            Data consistently shows that when guests can order at their convenience and receive rewards through Union’s guest-led experience, they:
          </p>
          <ul>
            <li>Spend more at your venue</li>
            <li>Leave higher tips for your staff</li>
            <li>Visit your establishment more frequently</li>
          </ul>
          <p class="textInfo">
            By implementing a guest-led experience at your venue, you can take full advantage of Union Rewards. Union Rewards will help you create a more engaging and rewarding experience for your guests while also driving increased revenue and customer loyalty for your venue.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/A-Frame-1024x683.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Embrace the Future with Guest-Led</h3>
          <p class="textInfo">
            Become Union powered today and unlock what the future holds for high-volume bars nationally. Unlike other POS platform, Union is a purpose built platform for high-volume hospitality to help make operators and staff more money.
          </p>          
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/Union-Last-Handheld-Img-1024x623.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>
    </section>
    
    <!-- section -- POS Digital Menus -->
    <section class="union-pos-grid noteDefault grid dark">
      <!-- 1- Full Blocks-->
      <div id="union-pos-digital-menus" class="union-pos-grid-item heading">
        <h2 class="content-title">POS Digital Menus</h2>
      </div>

      <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Your Menu in Real Time</h3>
          <p class="textInfo">
            Instantly modify your menu while enticing guests with elite presentation.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/step-2.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Boost revenue with strategic upselling and promotions</h3>
          <p class="textInfo">
            Highlight popular and high-margin items with large, beautiful photos.
          </p>
          <p class="textInfo">
            Promote special offers and limited-time deals.
          </p>
          <p class="textInfo">
            Encourage upselling with enticing visuals and descriptions.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/good-juice-1024x926.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Live inventory management keeps menu item status fresh</h3>
          <p class="textInfo">
            Items that are 86’d or set to countdown status on the point of sale get immediately updated in the guest app for seamless menu management. 
          </p>
          
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/inventory-management-1024x601.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Guests save their favorite items for later tonight, or next week's visit</h3>
          <p class="textInfo">
            Customers can save their favorite items from your digital menu, with all of their favorite modifiers in-tact.
          </p>
          <p class="textInfo">
            Items can easily be added to guest-led orders, now or later.
          </p>          
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/saved-items-1024x846.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">“Our guests sit down and immediately see our live updated cocktail offerings.” <span class="author-name">Steve, Operator @ The Tipsy Alchemist</span></h3>
          <p class="textInfo">
            The Tipsy Alchemist uses digital menus to create a modern and engaging guest experience
          </p>
          <p class="textInfo">
            Dynamically updates with all 86’d and countdown items.
          </p>
          <p class="textInfo">
            Menu section availability automatically changes based on day and time.
          </p>
          <p class="textInfo">
            Showcases beautiful imagery of their best cocktails.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/tipsy2-2-1-e1710951775171.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>
    </section>

     <!-- section -- POS Kitchen Display System -->
    <section class="union-pos-grid noteDefault grid neutral">
      <!-- 1- Full Blocks-->
      <div id="union-pos-kds" class="union-pos-grid-item heading">
        <h2 class="content-title">Union KitchenHub</h2>
      </div>      

      <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">All your third-party orders, synced with POS</h3>
          <p class="textInfo">
            Say goodbye to delivery tablets. Union KitchenHub brings third party orders straight into Union—no more double entry, no more missed tickets.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/Untitled-design-26-1536x1288.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

      <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">One menu, everywhere</h3>
          <p class="textInfo">
            Edit your menu once in Union and publish it to all your delivery platforms. No more duplicate updates, mismatched pricing, or wrong modifiers—what’s live in Union is live everywhere.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/tipsy2-2-1-e1710951775171.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Never miss a ticket again</h3>
          <p class="textInfo">
            All third-party orders appear in your POS and KDS like any other tab. Forget about lost tablets or late entries—your staff sees every order where they already work.
          </p>          
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/KitchenHub-Tickets-1024x858.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">In control when it counts</h3>
          <p class="textInfo">
            If your kitchen’s slammed, just pause delivery or extend prep times directly from Union. You decide how much your team can handle, keeping service smooth on both sides of the bar.
          </p>          
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/KitchenHub-Pause-3-1-1024x858.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Protect your margins</h3>
          <p class="textInfo">
            Set delivery markups and automate taxes to offset third-party fees. Union KitchenHub helps you stay profitable without extra admin work or duplicate menus.
          </p>          
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/KITCHENHUB-12-1024x858.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Simplify service</h3>
          <p class="textInfo">
            Fewer devices. Fewer mistakes. Happier staff. By bringing delivery into Union, you eliminate manual re-entry and keep your team focused on guests, not gadgets.
          </p>          
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/KITCHENHUB-11-1024x858.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>
     

   
    </section>

    <!-- section -- POS Featured Brands -->
    <section class="union-pos-grid noteDefault grid dark">
      <!-- 1- Full Blocks-->
      <div id="union-pos-featured-brands" class="union-pos-grid-item heading">
        <h2 class="content-title">UNION'S FEATURED BRANDS</h2>
      </div>

      <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark no-display"></h3>
          <p class="textInfo">
            Featured Brands are prominently showcased within the Union App experience, enhancing their visibility and consistently generating higher sales for venues that carry them and incorporate them into their menus. Brands change regularly and are market specific, so we encourage you to stay up to date by checking this page frequently and monitoring communications in your portal and emails.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/good-juice-1024x926.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Add Featured Brands to your menu in seconds</h3>
          <p class="textInfo">
           Watch this quick walkthrough to see how to add any Feature Brand instantly to your menu to boost sales.
          </p>
          
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/good-juice-1024x926.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       


    </section>

     <!-- section -- POS Pocket Handheld -->
    <section class="union-pos-grid noteDefault grid neutral">
      <!-- 1- Full Blocks-->
      <div id="union-pos-handheld" class="union-pos-grid-item heading">
        <h2 class="content-title">Union Pocket – Handheld POS</h2>
      </div>      

      <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">The fastest, easiest and most reliable card-reader free handheld is here.</h3>
          <p class="textInfo">
            Create a headache free, seamless table-side experience with Union Pocket, now supporting Tap to Pay on iPhone.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/iphone-Mockups-for-Marketing-copy-2-1536x1536.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

      <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Increase your efficiency by taking orders at the table</h3>
          <p class="textInfo"> 
            Save time by eliminating the need to go back and forth to a terminal just to input orders. 
          </p>
          <ul>
            <li>Allow staff to serve more tables</li>
            <li>Create happier guests through reduced wait times</li>
            <li>Increase table turnover</li>
          </ul>
          <p class="textInfo"> <strong>Full Price for Your Venue:</strong>
            Incorporate Union Pocket on iPhone into your business model and make more money.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/1.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">No More Clunky Handhelds</h3>
          <p class="textInfo"> 
            Can your current handheld easily fit in your pocket? We didn’t think so. With Union Pocket, you can:
          </p>
          <ul>
            <li>Efficiently add to, or edit orders</li>
            <li>Transfer tables and approve adjustments</li>
            <li>Split checks and accept payments</li>
          </ul>
          <p class="textInfo"> 
            The best POS on the market, conveniently located in a sleek, lightweight and familiar device that fits easily into a pocket. 
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/all-tables-screen.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Accept secure payments WITHOUT a card reader</h3>
          <p class="textInfo">
            Tired of faulty card readers and awkward tipping interactions? Revamp your payment experience by accepting:
          </p>  
          <ul>
            <li>Tap to Pay on iPhone – Guest taps their card, smartphone, or wearable onto NFC within the iPhone.</li>
            <li>Scan to Pay – Guest uses personal mobile device to scan QR code for swift transactions.</li>
            <li>Guest-Led digital payment – Letting the guest pay how and when they want through their personal mobile device.</li>
          </ul>
          <p class="textInfo">
            Welcome to a seamless payment experience that will take your guest satisfaction to a whole new level.
          </p>         
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/Untitled-design-22.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">BYOD:Bring Your Own Device</h3>
          <p class="textInfo"> Cut expenses by avoiding pricey hardware that often doesn’t meet your venue’s needs.</p>
          <ul>
            <li>Union Pocket is compatible with any iPhone 12 and later models</li>
            <li>iPhone 12 devices can be purchased refurbished for as little as $200 from various online retailers.</li>
            <li>We can assist merchants with procurement, or they may provide their own compatible devices.</li>
          </ul>
          <p class="textInfo">
            The Union Pocket software installs directly from the App Store, allowing merchants to activate instantly and begin processing payments within minutes. No more hurdles and headaches. 
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/All-checks-screen_custom-mock-up-1024x683.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Connect a Guest-Led model to a streamlined tableside service</h3>
          <p class="textInfo">
            Union Pocket seamlessly integrates with our Guest-Led model.
          </p> 
          <ul>
            <li>Customers scan a QR code to open tabs, view menus, and even place orders from their phone</li>
            <li>Enable staff to check-in, answer questions, and efficiently add to orders</li>
            <li>When guests are ready to leave, they can easily pay their checks</li>
          </ul>
          <p class="textInfo">
            Proven to increase operational efficiency and drive higher revenue. To find out more, click the link below.
          </p>            
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/phone-hand-1024x1024.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>
    </section>
    
    <!-- section -- POS Waitlist -->
    <section class="union-pos-grid noteDefault grid dark">
      <!-- 1- Full Blocks-->
      <div id="union-pos-waitlist" class="union-pos-grid-item heading">
        <h2 class="content-title">Waitlist</h2>
      </div>

      <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Improve guest & table management</h3>
          <p class="textInfo">
            No more long lines, frustrated customers, or disorganized seating arrangements.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/Waitlist-2.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Guests can open their tab and order while they wait</h3>
          <p class="textInfo">
            Guest checks can open tabs before they are seated via QR code/NFC, allowing them to order from the bar or save desired menu items while they wait and track their place in line.
          </p>
          <p class="textInfo">
            Staff instantly know the guest by name and any other notes that have been collected, including potentially favorite drink
          </p>
          <p class="textInfo">
            Checks can be transferred to tables when they are ready to be seated also sharing any notes with the next server.
          </p>
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/youroonthewiatlist-1024x1024.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Get hosts and servers on the same page</h3>
          <ul>
            <li>Take advantage of instant communication between staff</li>
            <li>Easily assign tables, balancing server workloads</li>
            <li>Streamlined seating process for a better guest experience</li>
          </ul>
          
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/waitlist-management-1024x865.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">Notify customers when they are ready to be seated</h3>
          <ul>
            <li>Transfer guest checks right from the tablet. </li>
            <li>Trigger text notifications to customers when tables are ready.</li>
          </ul>        
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/Frame-23738-1024x1024.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
            loading="lazy"
            loading="lazy"
          />
        </div>
      </div>

       <!-- 2 Half Blocks-->
      <div class="body-with-context flex">
        <div class="side text">
          <h3 class="sub-title dark has-display">"Guests can open a tab and order while they are waiting for their table.”<span class="author-name">Tim Short – Owner @ Woodin Creek Kitchen & Tap</span></h3>
          <p class="textInfo">
            Woodin Creek in Redmond Washington uses Union Waitlist for guest management.
          </p>
          <p class="textInfo">
            Customers can get in line, track their place in line, view menu, open their tabs, order for pick up at the bar and even get rewards. 
          </p>
          
        </div>

        <div class="side image">
          <img
            src="<?= $base_url ?>/assets/images/products/Union-Family/waitlist_graphic-1-1024x808.webp"
            alt="product-image"
            width="100%"
            height="fit-content"  loading="lazy"
            loading="lazy"
            loading="lazy"
          />
        </div>
      </div>
    </section>

    <style>
      .side.image.union-primary-blue{
        background-color: blue;
      }

      section div.side.text ul{
        color: #333;
        text-align: left;
        font-size: var(--font-size-18, 18px);
        font-style: normal;
        font-weight: var(--font-weight-700, 700);
        line-height: var(--line-height-21_6, 21.6px);
      }

      section.dark div.side.text ul{
        color: #777777ff;
      }
    </style>

    
        
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/singular-hero-style.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/singular.css">

    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/union-megaMenu.css">
    <script src="<?= $base_url ?>/assets/js/union-megaMenu.js"></script>
