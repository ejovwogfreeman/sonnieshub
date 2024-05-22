<?php

include('./partials/header.php');

?>

<section id="page-header" class="about-header">
    <h2>#let's_talk</h2>
    <p>LEAVE A MESSAGE, We love to hear from you!</p>
</section>

<section id="contact-details" class="section-p1">
    <div class="details">
        <span>GET IN TOUCH</span>
        <h2>Visit one of our agency locations or contact us today.</h2>
        <h3>Head Office</h3>
        <div>
            <li>
                <i class="fas fa-map"></i>
                <p>Lahore, Pakistan 54840</p>
            </li>
            <li>
                <i class="fas fa-envelope"></i>
                <p>connectwithmawais@gmail.com</p>
            </li>
            <li>
                <i class="fas fa-phone-alt"></i>
                <p>+92-321-4655990
            </li>
            <li>
                <i class="fas fa-clock"></i>
                <p>Monday to Saturday: 9:00 AM to 16:00 PM</p>
            </li>
        </div>
    </div>
    <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d217759.48983392344!2d74.1943055256652!3d31.483156882376644!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39190483e58107d9%3A0xc23abe6ccc7e2462!2sLahore%2C%20Punjab%2C%20Pakistan!5e0!3m2!1sen!2s!4v1676498542792!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</section>

<section id="form-details">
    <form action="">
        <span>LEAVE A MESSAGE</span>
        <h2>We love to hear from you</h2>
        <input type="text" placeholder="Your Name">
        <input type="text" placeholder="E-mail">
        <input type="text" placeholder="Subject">
        <textarea name="" id="" cols="30" rows="10" placeholder="Your Message"></textarea>
        <button class="normal">Submit</button>
    </form>
    <div class="people">
        <div>
            <img src="images/people/1.png" alt="">
            <p><span>John Doe</span> Senior Marketing Manager<br>Phone: +000 123 000 77 88<br>Email: contact@example.com</p>
        </div>
        <div>
            <img src="images/people/2.png" alt="">
            <p><span>William Smith</span> Senior Marketing Manager<br>Phone: +000 123 000 77 88<br>Email: contact@example.com</p>
        </div>
        <div>
            <img src="images/people/3.png" alt="">
            <p><span>Emma Stone</span> Senior Marketing Manager<br>Phone: +000 123 000 77 88<br>Email: contact@example.com</p>
        </div>
    </div>
</section>

<section id="newsletter" class="section-p1 section-m1">
    <div class="newstext">
        <h4>Sign Up For Newsletter</h4>
        <p>Get E-mail updates about our latest shop and <span>special offers.</span></p>
    </div>
    <div class="form">
        <input type="text" placeholder="Your email address">
        <button class="normal">Sign Up</button>
    </div>
</section>

<?php

include('./partials/footer.php');

?>