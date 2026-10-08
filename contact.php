<?php
include 'config.php';
include 'includes/header.php';
?>

<link rel="stylesheet" href="css/contact.css">

<!-- ================= HERO ================= -->

<section class="contact-hero">

    <div class="contact-overlay"></div>

    <div class="hero-content">

        <h1>Contact Us</h1>

        <p>

            We are always here to help you with appointments,
            medical enquiries, and emergency healthcare services.

        </p>

        <div class="breadcrumb">

            <a href="index.php">Home</a>

            <span> / </span>

            <span>Contact</span>

        </div>

    </div>

</section>

<!-- ================= CONTACT INFO ================= -->

<section class="contact-info">

    <h2 class="section-title">

        Get In Touch

    </h2>

    <div class="contact-grid">

        <div class="contact-card">

            <i class="fa-solid fa-location-dot"></i>

            <h3>Hospital Address</h3>

            <p>

                No. 25, JLB Road<br>

                Mysuru, Karnataka - 570005

            </p>

        </div>

        <div class="contact-card">

            <i class="fa-solid fa-phone"></i>

            <h3>Call Us</h3>

            <p>

                +91 9876543210<br>

                +91 9988776655

            </p>

        </div>

        <div class="contact-card">

            <i class="fa-solid fa-envelope"></i>

            <h3>Email</h3>

            <p>

                info@zynovexahospital.com<br>

                support@zynovexahospital.com

            </p>

        </div>

        <div class="contact-card">

            <i class="fa-solid fa-clock"></i>

            <h3>Working Hours</h3>

            <p>

                Monday - Saturday<br>

                8:00 AM - 8:00 PM<br>

                Emergency: 24×7

            </p>

        </div>

    </div>

</section>

<!-- ================= CONTACT FORM ================= -->

<section class="contact-section">

    <div class="contact-wrapper">

        <div class="contact-form">

            <h2>Send Us a Message</h2>

            <form>

                <input type="text" placeholder="Full Name" required>

                <input type="email" placeholder="Email Address" required>

                <input type="text" placeholder="Phone Number" required>

                <input type="text" placeholder="Subject">

                <textarea rows="6" placeholder="Your Message"></textarea>

                <button type="submit">

                    <i class="fa-solid fa-paper-plane"></i>

                    Send Message

                </button>

            </form>

        </div>

        <div class="contact-map">

            <iframe
                src="https://www.google.com/maps?q=Mysuru,Karnataka&output=embed"
                loading="lazy"
                allowfullscreen>
            </iframe>

        </div>

    </div>

</section>

<!-- ================= EMERGENCY ================= -->

<section class="emergency">

    <h2>Need Immediate Medical Assistance?</h2>

    <p>

        Our emergency medical team is available 24 hours a day,
        7 days a week.

    </p>

    <a href="tel:+919876543210">

        <i class="fa-solid fa-phone"></i>

        Call Emergency

    </a>

</section>

<?php
include 'includes/footer.php';
?>