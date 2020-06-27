<?php include_once "header.php";

$msg = "";
if(isset($_GET['del'])){
    $iddel = str_clean($_GET['del']);
    $stmt = $conn->prepare("DELETE FROM facture WHERE id_fact=?");
    $stmt->bind_param("i", $iddel);
    $res = $stmt->execute();

    if ($res) {
        $msg = "<div class='alert alert-success'>La facture à été bien supprimé</div>";
    } else $msg = "<div class='alert alert-danger'>Erreur de suppression de facture, essayer plus tard</div>";
}

function str_clean($str)
{
    return trim(str_replace("\"", "", str_replace("'", "", $str)));
}

?>

    <div class="container mt-3">
        <div class="content">
            <div class="row">
                <div class="col-12" style="text-align: right !important;" >
                    <img src="images/logo-dark.png" height="140">
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="content">
            <br/>
            <h2 class="title">Mes factures</h2>
            <div class="row" style="overflow-x: scroll">
                <div class="col-12">
                    <?= $msg ?>
                    <table id="factures" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Date</th>
                            <th>Mode de réglement</th>
                            <th>Devise</th>
                            <th>Client</th>
                            <th>Entreprise</th>
                            <th>Adresse</th>
                            <th>Lignes</th>
                            <th>Opérations</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $factures = $conn->query("SELECT *, facture.id_fact as id_fact, count(id_det) as nb FROM facture LEFT JOIN detfacture ON facture.id_fact=detfacture.id_fact GROUP BY facture.id_fact
 ORDER BY facture.id_fact DESC");
                            while($facture = $factures->fetch_array()) :
                        ?>
                            <tr>
                                <td>
                                    <a href="ajouter.php?id=<?= $facture['id_fact'] ?>"><?= $facture['ref_fact'] ?></a>
                                </td>
                                <td><?= $facture['date_fact'] ?></td>
                                <td><?= $facture['mode_fact'] ?></td>
                                <td><?= $facture['devise_fact'] ?></td>
                                <td><?= $facture['nom_fact'] ?></td>
                                <td><?= $facture['company_fact'] ?></td>
                                <td><?= $facture['address_fact'] ?></td>
                                <td style="text-align: center"><?= $facture['nb'] ?></td>
                                <td style="text-align: center">
                                    <a href="facture.php?id=<?= $facture['id_fact'] ?>" target="_blank">imprimer</a>
                                    <br />
                                    <a onclick="return confirm('Etes-vous sûr de supprimer cette facture?')"
                                            href="factures.php?del=<?= $facture['id_fact'] ?>" style="font-weight: bold;font-size: 1.2em;color:red">x</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5"></div>

    <script type="text/javascript">
        setTimeout(function () {
            document.getElementsByClassName("alert")[0].setAttribute('class', "d-none");
        }, 3500);
    </script>

<?php include_once "footer.php"; ?>