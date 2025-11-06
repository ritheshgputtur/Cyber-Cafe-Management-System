<!-- footer.php -->
<footer class="bg-dark text-white pt-5 pb-3 mt-auto border-top border-secondary">
    <div class="container">
        <div class="row gy-4">

            <!-- Brand & Description -->
            <div class="col-md-4">
                <h5 class="text-info fw-bold">CCMS</h5>
                <p class="text- small text-white">
                    Cyber Cafe Management System — your complete digital assistant for bookings, monitoring, and user
                    control.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-md-2">
                <h6 class="fw-bold text-uppercase mb-3">Quick Links</h6>
                <ul class="list-unstyled small">
                    <li><a href="dashboard.php" class="text-white text-decoration-none d-block py-1">Dashboard</a></li>
                    <li><a href="book_computer.php" class="text-white text-decoration-none d-block py-1">Bookings</a>
                    </li>
                    <li><a href="profile.php" class="text-white text-decoration-none d-block py-1">Profile</a></li>
                    <li><a href="contact.php" class="text-white text-decoration-none d-block py-1">Contact</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-md-3">
                <h6 class="fw-bold text-uppercase mb-3">Contact Us</h6>
                <p class="small mb-1"><i class="fa fa-envelope me-2 text-warning"></i>ccms@cybercafe.com</p>
                <p class="small mb-1"><i class="fa fa-phone me-2 text-warning"></i>+91 98765 43210</p>
                <p class="small"><i class="fa fa-map-marker-alt me-2 text-warning"></i>Mangalore, Karnataka</p>
            </div>

            <!-- Social Media -->
            <div class="col-md-3">
                <h6 class="fw-bold text-uppercase mb-3">Follow Us</h6>
                <div class="d-flex gap-3">
                    <a href="#" class="text-white fs-5"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white fs-5"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white fs-5"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white fs-5"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>

        <hr class="border-secondary my-4">
        <div class="text-center small">
            © <?= date("Y") ?> <strong>Cyber Cafe Management System</strong>
        </div>
    </div>
</footer>