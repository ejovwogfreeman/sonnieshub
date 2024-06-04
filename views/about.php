<?php

// Start session
// session_start();

include('./partials/header.php');

?>

<section id="page-header" class="about-header">
  <h2>#KnowUs</h2>
  <p>Lorem ipsusm dolor sit amet, consectelur</p>
</section>

<section id="about-head" class="section-p1">
  <img src="images/about/a6.jpg" alt="" />
  <div>
    <h2>Who We Are?</h2>
    <p>
      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
      eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
      minim veniam, quis nostrud exercitation ullamco laboris nisi ut
      aliquip ex ea commodo consequat. Duis autterirure dolor in
      reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
      pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
      culpa qui officia deserunt mollit anim id est laborum.
    </p>
    <abbr title="">Create stunning images with as much or as little control as fa-you
      like thanks to a choice of Basic and Creative modes.
    </abbr>
    <br /><br />
    <marquee bgcolor="#ccc" loop="-1" scrollamount="5" width="100%">Create stunning images with as much or as little control as you like
      thanks to a choice of Basic and Creative modes.
    </marquee>
  </div>
</section>

<section id="about-app" class="section-p1">
  <h1>Download our <a href="#">App</a></h1>
  <div class="video">
    <video autoplay muted loop src="images/about/1.mp4"></video>
  </div>
</section>

<section id="feature" class="section-p1">
  <div class="fe-box">
    <img src="images/features/f1.png" alt="" />
    <h6>Free Shipping</h6>
  </div>
  <div class="fe-box">
    <img src="images/features/f2.png" alt="" />
    <h6>Online Order</h6>
  </div>
  <div class="fe-box">
    <img src="images/features/f3.png" alt="" />
    <h6>Save Money</h6>
  </div>
  <div class="fe-box">
    <img src="images/features/f4.png" alt="" />
    <h6>Promotions</h6>
  </div>
  <div class="fe-box">
    <img src="images/features/f5.png" alt="" />
    <h6>Happy Sell</h6>
  </div>
  <div class="fe-box">
    <img src="images/features/f6.png" alt="" />
    <h6>F24/7 Support</h6>
  </div>
</section>

<section id="newsletter" class="section-p1 section-m1">
  <div class="newstext">
    <h4>Sign Up For Newsletter</h4>
    <p>
      Get E-mail updates about our latest shop and
      <span>special offers.</span>
    </p>
  </div>
  <div class="form">
    <input type="text" placeholder="Your email address" />
    <button class="normal">Sign Up</button>
  </div>
</section>

<?php

include('./partials/footer.php');

?>