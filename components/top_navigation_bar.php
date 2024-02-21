    <nav class="nav_bar"> <!-- This is the nav bar at the top of the page -->
        <div class="nav_title_container"> <!-- The "nav" tag is used to ensure semantic HTML -->
            <a href="home_page.php" class="text_decoration_none"><h1 class="form_title">Bean and Brew</h1></a>
        </div>

        <div class="nav_links">
        <a href="support.php" class="text_decoration_none">Support</a>
            <a href="baking_lessons.php" class="text_decoration_none">Baking Lessons</a>
            <a href="book_table.php" class="text_decoration_none">Book a space</a>
            <a href="checkout.php" class="text_decoration_none">Checkout</a>
        </div>

        <div class="nav_button_container">
            <?php
            if (isset($_SESSION['user_id'])) {
                echo "";
                } else {echo '<a href="sign_up_page.php"><button class="nav_button">Sign Up</button></a>';} ?>
            <a href="menu.php"><button class="nav_button fill_brown" id="menu_button">Our Menu</button></a>
        </div>

        <?php if (isset($_SESSION['user_id'])) {
                echo '<a href="settings.php"><div class="settings_container">
                <svg width="30" height="30" viewBox="0 0 515 514" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g filter="url(#filter0_d_306_182)">
                    <path d="M163.5 88.7822L183 79.7827L202.022 71.8201C203.569 71.1723 204.689 69.7915 205.003 68.1434L213.868 21.6014C215.395 13.5833 222.405 7.78233 230.567 7.78231L282.244 7.78221C290.49 7.78219 297.547 13.7003 298.984 21.8205L307.582 70.4186C307.839 71.8734 308.877 73.0678 310.282 73.5252L324.574 78.1789C327.853 79.2464 331.041 80.573 334.109 82.1463L349 89.7821" stroke="var(--nav-text-color)" stroke-width="35"/>
                    <path d="M438 203.282L433.864 188.174C432.622 183.637 430.891 179.248 428.701 175.084L422.588 163.46C421.901 162.152 421.99 160.572 422.82 159.35L450.555 118.528C455.189 111.707 454.26 102.544 448.351 96.7921L411.033 60.4696C405.313 54.9024 396.491 54.0641 389.825 58.4544L341.5 90.2822" stroke="var(--nav-text-color)" stroke-width="35"/>
                    <path d="M420 345.282L427.475 333.106C430.304 328.497 432.547 323.553 434.151 318.388L437.732 306.865C438.171 305.454 439.351 304.4 440.802 304.123L489.279 294.869C497.38 293.322 503.202 286.186 503.09 277.94L502.387 225.869C502.279 217.888 496.633 211.056 488.815 209.447L432.139 197.782" stroke="var(--nav-text-color)" stroke-width="35"/>
                    <path d="M306 432.782L327.5 425.782L346.783 417.754C348.028 417.235 349.452 417.379 350.568 418.138L391.587 446.006C398.408 450.64 407.571 449.711 413.323 443.802L449.645 406.484C455.212 400.764 456.051 391.942 451.66 385.276L419.833 336.951" stroke="var(--nav-text-color)" stroke-width="35"/>
                    <path d="M163.5 412.782L174.075 420.374C179.744 424.443 186.03 427.573 192.694 429.643L201.934 432.515C203.345 432.953 204.399 434.133 204.676 435.584L213.93 484.062C215.476 492.162 222.613 497.984 230.858 497.873L282.93 497.169C290.911 497.061 297.742 491.415 299.351 483.598L311.016 426.921" stroke="var(--nav-text-color)" stroke-width="35"/>
                    <path d="M76.0001 298.282L78.093 312.041C79.2384 319.571 81.6983 326.841 85.3604 333.519L89.5422 341.145C90.2525 342.44 90.191 344.022 89.3822 345.258L62.3637 386.558C57.8492 393.459 58.9383 402.604 64.947 408.252L102.893 443.918C108.709 449.384 117.545 450.069 124.133 445.563L171.895 412.896" stroke="var(--nav-text-color)" stroke-width="35"/>
                    <path d="M93 157.782L83.548 178.416L77.5508 197.716C77.1125 199.127 75.9322 200.181 74.481 200.458L26.0035 209.712C17.9035 211.259 12.0812 218.395 12.1927 226.641L12.8917 278.36C13.0017 286.5 18.8669 293.42 26.8789 294.862L82 304.782" stroke="var(--nav-text-color)" stroke-width="35"/>
                    <path d="M205.5 69.7822L186.214 79.4987L168.009 88.2756C166.678 88.9172 165.102 88.773 163.91 87.9006L124.08 58.7576C117.425 53.8882 108.235 54.4971 102.28 60.202L64.9319 95.9859C59.0538 101.618 57.9932 110.626 62.4028 117.469L92.7399 164.548" stroke="var(--nav-text-color)" stroke-width="35"/>
                    <circle cx="256.5" cy="253.282" r="98" stroke="var(--nav-text-color)" stroke-width="35"/>
                    </g>
                    <defs>
                    <filter id="filter0_d_306_182" x="0.69104" y="0.282227" width="513.901" height="513.092" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="4"/>
                    <feGaussianBlur stdDeviation="2"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_306_182"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_306_182" result="shape"/>
                    </filter>
                    </defs>
                </svg>
            </div></a>';
                } else {echo '';} ?>


        <div class="basket_container">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="29" viewBox="0 0 26 29" fill="none">
                    <path d="M1.23097 21.2712L1.23101 10.3253C1.23101 9.22073 2.12644 8.32531 3.23101 8.32531L22.769 8.32531C23.8736
                     8.32531 24.769 9.22074 24.769 10.3253L24.769 21.2712C24.769 24.5849 22.0827 27.2712 18.769 27.2712L7.23099 
                     27.2712C3.91727 27.2713 1.23095 24.585 1.23097 21.2712Z" stroke="var(--nav-text-color)" stroke-width="2"/>
                    <path d="M19.1835 14.8571L19.1834 7.95385C19.1834 4.60649 16.4698 1.89296 13.1224 1.89297V1.89297C9.77506
                    1.89298 7.06149 4.60658 7.06151 7.95395L7.06154 14.8571" stroke="var(--nav-text-color)" stroke-width="2"/>
                </svg>
                <h1 class="basket_num"><?php echo count($_SESSION['item_basket']); ?></h1>
        </div>

        <svg xmlns="http://www.w3.org/2000/svg" width="34" height="27"
        viewBox="0 0 34 27" fill="none" class="burger_icon">
            <rect width="34" height="5" rx="2.5" fill="var(--nav-text-color)"/>
            <rect y="11" width="34" height="5" rx="2.5" fill="var(--nav-text-color)"/>
            <rect y="22" width="34" height="5" rx="2.5" fill="var(--nav-text-color)"/>
        </svg>

    </nav>
