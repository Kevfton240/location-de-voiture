<!-- ======= Contact Section ======= -->
<section id="contact" class="contact">
      <div class="container">

        <div class="section-title">
          <span>Contact <i class="bi bi-envelope-check"></i></span>
          <h2>Contact <i class="bi bi-envelope-check"></i></h2>
          <p>Une question ? Contactez nous, nous nous ferons unplaisir de vous répondre. Et dans les mailleurs délais !</p>
        </div>

        <div class="row" data-aos="fade-up">
          <div class="col-lg-6">
            <div class="info-box mb-4">
              <i class="bx bx-map"></i>
              <h3>Nos locaux</h3>
              <p>12 avenue de la grande armée, 75016 Paris</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="info-box  mb-4">
              <i class="bx bx-envelope"></i>
              <h3>Email</h3>
              <p>contact@goldenlocation.com</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="info-box  mb-4">
              <i class="bx bx-phone-call"></i>
              <h3>Téléphone</h3>
              <p>+33 9 12 34 56 78</p>
            </div>
          </div>

        </div>

        <div class="row" data-aos="fade-up">

          <div class="col-lg-6 ">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.099632843464!2d2.290149215674979!3d48.875377179289266!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66fed0362c409%3A0x123242577bab3090!2s12%20Av.%20de%20la%20Grande%20Arm%C3%A9e%2C%2075017%20Paris!5e0!3m2!1sfr!2sfr!4v1642594189534!5m2!1sfr!2sfr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
          </div>

          <div class="col-lg-6">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Saisissez votre nom" required>
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Saisissez votre Email" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Objet" required>
              </div>
              <div class="form-group mt-3">
                <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Patientez</div>
                <div class="error-message"></div>
                <div class="sent-message">Votre message à bien été envoyer. Merci !</div>
              </div>
              <div class="text-center"><button type="submit">Envoyer</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-4 col-md-6">
            <div class="footer-info">
              <h3>Golden Location</h3>
              <p>
                12 avenue de la grande armée, 75016 Paris<br><br>
                <strong>Téléphone:</strong> +33 9 12 34 56 78<br>
                <strong>Email:</strong> contact@goldenlocation.com<br>
              </p>
              <div class="social-links mt-3">
                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Lien utiles</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#hero">Accueil</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">A porpos de nous</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#services">Services</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#vehicule">Les véhicules</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#tarif">Tarif</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="<?php URL ?>mentions_legale.php">Mentiion légale</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="<?php URL ?>mentions_conf.php">Mention de confidentialitée</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Ne ratez rien !</h4>
            <p>Abonnez-vous à notre Newsletter pour vous tenir informés de toutes les nouveautées !</p>
            <form action="" method="post">
              <input type="email" name="email" placeholder="Votre Email"><input type="submit" value="Subscribe">
            </form>

          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Golden Loacation</span></strong>. All Rights Reserved
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="<?= URL ?>assets/vendor/aos/aos.js"></script>
  <script src="<?= URL ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= URL ?>assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="<?= URL ?>assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<?= URL ?>assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="<?= URL ?>assets/js/main.js"></script>

</body>

</html>
