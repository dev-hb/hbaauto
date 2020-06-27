<?php include_once "config.php"; ?>

    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>HBA AUTO</title>
        <link rel="apple-touch-icon" sizes="57x57" href="images/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="images/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="images/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="images/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="images/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="images/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="images/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="images/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192" href="images/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="images/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
        <link rel="manifest" href="images/favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="images/favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
              integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
              crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
<body>

<div class="header">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand ml-5" href="index.php"><img src="images/logo.png" alt="HBA AUTO" height="40"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="container">
            <div class="col-md-12 collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active" id="page_home">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item" id="page_ajouter">
                        <a class="nav-link" href="ajouter.php">Créer une facture</a>
                    </li>
                    <li class="nav-item" id="page_factures">
                        <a class="nav-link" href="factures.php">Liste des facture</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container header-content">
        <div class="content">
            <div class="row">
                <h1 class="text-light">Bonjour à HBA Auto,</h1>
            </div>
            <div class="row">
                <h3 style="color: #d7d7d7">
                    Cherchez-vous une voiture, trouvez la ici
                </h3>
            </div>
            <div class="row mt-5">
                <a href="factures.php" type="button" class="btn btn-warning btn-lg text-light">
                    Consulter les factures
                </a>
            </div>
            <div class="row mt-5">
                <h1 class="text-light">
                    <?= $conn->query("SELECT count(*) as nb FROM facture")->fetch_array()['nb'] ?>
                    <span style="font-size: .7em;color:#d9d9d9">
                        factures enregistrés
                    </span>
                </h1>
            </div>
        </div>
    </div>
</div>

<?php include_once "footer.php"; ?>