<?php include_once 'config.php';

if (isset($_GET['id'])) if (!is_numeric($_GET['id'])) die("L'identifiat 'id' doit être un entier!!");

$stmt = $conn->prepare("SELECT * FROM facture WHERE id_fact = ?");
$stmt->bind_param("i", $_GET['id']);
$res = $stmt->execute();
$facture = $stmt->get_result()->fetch_object();

?>
<style>
    body {
        font-family: Verdana, Tahoma;
    }
    .clear{clear: both}
    .company-name {
        font-weight: bold;
        font-size: 22pt;
        display: block;
    }

    .company-address {
        margin-top: 10px;
        display: block;
        font-weight: bold;
        font-size: 12pt;
    }

    .company-phone {
        display: block
    }

    header .hr {
        width: 100%;
        height: 4px;
        background-color: #000;
        margin-top: 10px;
    }

    .page {
        margin-top: 20px;
    }

    .left {
        width: 49%;
        display: inline-block
    }

    .right {
        width: 49%;
        display: inline-block
    }

    .box {
        border: 1px solid #000000;
        border-radius: 15px;
        width: 80%;
        padding: 10px;
    }

    .client {
        font-weight: bold
    }

    .second {
        margin-top: 60px;
    }
</style>

<header style="text-align: center">
    <span class="company-name"><?= COMPANY_NAME ?></span>
    <span class="company-address"><?= COMPANY_DESCRIPTION ?></span>
    <span class="company-phone"><?= COMPANY_PHONE ?></span>

    <img src="images/black.png" class="hr"/>
</header>

<div class="page">
    <div class="first">
        <div class="left">
            <div class="box">
                Facture
                <hr color="#000000" size="1"/>
                Référence : <?= $facture->ref_fact ?><br/>
                Date : <?= (new DateTime($facture->date_fact))->format("d/m/Y") ?> <br/>
                Mode de réglement : <?= $facture->mode_fact ?><br/>
                Document libellé en : <?= $facture->devise_fact ?>
            </div>
        </div>
        <div class="right">
            <img src="images/logo-dark.png" height="60" style="float: right"><br/>
            <span class="client"><?= $facture->nom_fact ?></span><br/>
            <span><?= $facture->company_fact ?></span><br/>
            <span><?= $facture->address_fact ?></span><br/>
        </div>
    </div>

    <div class="second">
        <div class="top">
            <span class="car"><?= $facture->car_fact ?></span><br/>
            <span class="km">Kms : <?= $facture->km_fact ?></span><br/><br/>
        </div>
        <div class="center">
            <table border="1" cellspacing="0" cellpadding="4" width="100%">
                <caption><small style="font-size: 0.8em;float: left">N° TVA INTRACOMMUNAUTAIRE</small></caption>
                <thead>
                <tr>
                    <td>Référence</td>
                    <td>Désignation</td>
                    <td>Quantité</td>
                    <td>Prix unitaire</td>
                    <td>% TVA</td>
                    <td>% Rem.</td>
                    <td>Montant TTC</td>
                </tr>
                </thead>
                <tbody>
                <?php
                $stmt = $conn->prepare("SELECT * FROM detfacture WHERE id_fact = ?");
                $stmt->bind_param("i", $_GET['id']);
                $stmt->execute();
                $details = $stmt->get_result();
                $ht = 0;
                while ($detail = $details->fetch_object()):
                    $mt = $detail->qtt_det * $detail->prix_det;
                    $ht += $mt;
                    ?>
                    <tr>
                        <td><?= $detail->ref_det ?></td>
                        <td><?= $detail->designation_det ?></td>
                        <td style="text-align: right"><?= $detail->qtt_det ?></td>
                        <td style="text-align: right"><?= $detail->prix_det ?></td>
                        <td style="text-align: right"><?= $detail->tva_det ?></td>
                        <td style="text-align: right"><?= $detail->rem_det ?></td>
                        <td style="text-align: right"><?= $mt ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            <small>
                <?= UNDER_TABLE_DESCRIPTION ?>
            </small>
            <br />
            <br />
            <table border="1" cellspacing="0" cellpadding="6" style="float: right" width="45%">
                <tbody>
                    <tr>
                        <td style="text-align: right">Total HT Net</td>
                        <td style="text-align: center"><?= $ht ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right">TVA</td>
                        <td style="text-align: center"><?= $ht * .2 ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right">Total TTC</td>
                        <td style="text-align: center"><?= $ht * 1.2 ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right">Net à payer en <?= $facture->devise_fact ?></td>
                        <th style="text-align: center"><?= $ht * 1.2 ?></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="clear"></div>

<footer><br />
    <span>
        passer un delai de cinq jour les pieces ne seront ni reprises ni echangees
    </span>
</footer>

<script type="text/javascript">
    setTimeout(function () {
        window.print();
        window.close();
    }, 300);
</script>