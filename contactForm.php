<?php include("setup/setup.php") ?>

<div class="wrap contact" id="contact">
    <div class="grid grid-pad" >
        <h2>Contattaci</h2>
        <div class="col-1-2" >
            <div class="content address">
                <h3>Parliamo un pò!</h3>
                <p>Cerchi un'opportunità di collaborazione? Siamo un call center in crescita e sempre alla ricerca di nuovi talenti. Compila il form e ti risponderemo presto per discutere delle possibilità di lavorare insieme!</p>
                <address>
                    <div>
                        <div class="box-icon">
                            <i class="icon-location"></i>
                        </div>
                        <span>Indirizzo:</span>
                        <br>
                        <a href="https://www.google.com/maps/place/StarCall/@39.353293,16.237603,16z/data=!3m1!4b1!4m6!3m5!1s0x133f99905fbf999b:0xe4094318db9b26c8!8m2!3d39.353293!4d16.237603!16s%2Fg%2F11h9z7_jg8?entry=ttu&g_ep=EgoyMDI0MTIwNC4wIKXMDSoASAFQAw%3D%3D" target="_blank">
                          <?php echo $indirizzo ?>
                        </a>
                    </div>

                    <div>
                        <div class="box-icon">
                            <i class="icon-clock"></i>
                        </div>
                        <span>Orario Lavorativo:</span>
                        <pre>Lunedì - Venerdì dalle 9:30 alle 20:30
                   Sabato dalle 10:00 alle 15:00</pre>
                    </div>

                    <div>
                        <div class="box-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <span>Email:</span>
                        <br>
                        <pre><a href="mailto:<?php echo $email; ?>" target="_blank"><?php echo $email; ?></a>
                   <a href="mailto:<?php echo $emailP; ?>" target="_blank"><?php echo $emailP; ?></a>
                        </pre>
                    </div>
                </address>
            </div>
        </div>
        <br>
         <div class="col-1-2 pleft-25" >
            <div class="content contact-form">
              <form class="form" action="setup/contactProcess.php" method="POST">
                  <input type="text" name="name" class="comment-name" placeholder="Nome*" required>
                  <input type="email" name="email" class="comment-email" placeholder="Email*" required>
                  <input type="text" name="subject" class="comment-subject" placeholder="Oggetto*" required>
                  <textarea name="message" class="required comment-text" placeholder="Messaggio..." required></textarea>
                  <input type="submit" value="Invia Messaggio" class="btn submit comment-submit">
              </form>
            </div>
        </div>
    </div>
</div>
<!-- End Contact Section -->
