<?php include("setup.php"); ?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo $nomeAzienda; ?></title>

    <!-- CSS -->
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/simplegrid.css">
    <link rel="stylesheet" href="../css/icomoon.css">
    <link rel="stylesheet" href="../css/lightcase.css">
    <link rel="stylesheet" href="../js/owl-carousel/owl.carousel.css" />
    <link rel="stylesheet" href="../js/owl-carousel/owl.theme.css" />
    <link rel="stylesheet" href="../js/owl-carousel/owl.transitions.css" />
    <link rel="stylesheet" href="../style.css">

    <!-- Google Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,900" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style media="screen">
        #top-header {
            background-color: transparent;
            transition: background-color 0.3s ease;
        }
        .header-scrolled {
            background-color: #071a29 !important;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header id="top-header" class="header-home">
        <div class="grid">
            <div class="col-1-1">
                <div class="content">
                    <?php echo $logo; ?>
                    <nav class="navigation">
                        <input type="checkbox" id="nav-button">

                        <!-- BURGER MENU (commentato, sistemarlo se necessario) -->
                        <!-- <label for="nav-button"></label> -->

                        <ul class="nav-container">
                            <li><a href="#home" class="current">Home</a></li>
                            <li><a href="#who">Chi siamo?</a></li>
                            <li><a href="#services">Servizi</a></li>
                            <li><a href="#team">Team</a></li>
                            <li><a href="#contact">Contattaci</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <section id="home">
      <!-- NON TOGLIERE QUESTA SEZIONE SERVE PER LA NAV -->
    </section>

    <script>
        const topHeader = document.getElementById('top-header');
        const homeSection = document.getElementById('home');

        function checkScroll() {
            const homeBottom = homeSection.offsetTop + homeSection.offsetHeight;
            if (window.scrollY > homeBottom) {
                topHeader.classList.add('header-scrolled');
            } else {
                topHeader.classList.remove('header-scrolled');
            }
        }

        window.addEventListener('scroll', checkScroll);
    </script>

</body>
</html>
