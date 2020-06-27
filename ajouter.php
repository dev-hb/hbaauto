<?php include_once "header.php";

$msg = $msg1 = "";
if (isset($_POST['dofacture']) || isset($_POST['doedit'])) {

    $ref = str_clean($_POST['ref']);
    $date = str_clean($_POST['date']);
    $mode = str_clean($_POST['mode']);
    $devise = str_clean($_POST['devise']);
    $nom = str_clean($_POST['nom']);
    $company = str_clean($_POST['company']);
    $address = str_clean($_POST['address']);
    $car = str_clean($_POST['car']);
    $km = str_clean($_POST['km']);
}
if (isset($_POST['dofacture'])) {
    $stmt = $conn->prepare("INSERT INTO facture (ref_fact, date_fact, devise_fact, mode_fact, nom_fact, company_fact, address_fact, car_fact, km_fact) 
    VALUE(?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssi", $ref, $date, $devise, $mode, $nom, $company, $address, $car, $km);
    $res = $stmt->execute();
    if ($res) {
        $iid = $stmt->insert_id;
        $msg = "<div class='alert alert-success'>La facture à été bien créé, accès à la facture dans 3s</div>";
        echo "<script type='text/javascript'>
                setTimeout(function() {
                  window.location = 'ajouter.php?id=$iid'
                }, 3500)
            </script>";
    } else $msg = "<div class='alert alert-danger'>Erreur de création de facture, essayer plus tard</div>";
}

if (isset($_POST['doedit'])) {
    $id = str_clean($_GET['id']);
    $stmt = $conn->prepare("UPDATE facture SET ref_fact=?, date_fact=?, devise_fact=?, mode_fact=?, nom_fact=?, company_fact=?, address_fact=?, car_fact=?, km_fact=? WHERE id_fact=?");
    $stmt->bind_param("ssssssssii", $ref, $date, $devise, $mode, $nom, $company, $address, $car, $km, $id);
    $res = $stmt->execute();
    if ($res) {
        $msg = "<div class='alert alert-success'>La facture à été bien modifié</div>";
    } else $msg = "<div class='alert alert-danger'>Erreur de modification de facture, essayer plus tard</div>";
}

function str_clean($str)
{
    return trim(str_replace("\"", "", str_replace("'", "", $str)));
}

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM facture WHERE id_fact=?");
    $id = str_clean($_GET['id']);
    $stmt->bind_param("i", $id);
    $res = $stmt->execute();
    $facture = $stmt->get_result()->fetch_object();
}

if (isset($_POST['addligne'])) {
    $id = str_clean($_GET['id']);
    $refdet = str_clean($_POST['refdet']);
    $designation = str_clean($_POST['designation']);
    $qtt = str_clean($_POST['qtt']);
    $prix = str_clean($_POST['prix']);
    $tva = str_clean($_POST['tva']);
    $rem = str_clean($_POST['rem']);

    $stmt = $conn->prepare("INSERT INTO detfacture (ref_det, designation_det, qtt_det, prix_det, tva_det, rem_det, id_fact) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiiiii", $refdet, $designation, $qtt, $prix, $tva, $rem, $id);
    $res = $stmt->execute();
    if ($res) {
        $msg1 = "<div class='alert alert-success'>La ligne de facture à été bien créé</div>";
    } else $msg1 = "<div class='alert alert-danger'>Erreur de création de la ligne du facture, essayer plus tard</div>";
}

if (isset($_GET['id']) && isset($_GET['del'])) {
    $stmt = $conn->prepare("DELETE FROM detfacture WHERE id_det=?");
    $stmt->bind_param("i", $_GET['del']);
    $res = $stmt->execute();

    if ($res) {
        $msg1 = "<div class='alert alert-success'>La ligne de facture à été bien supprimé</div>";
    } else $msg1 = "<div class='alert alert-danger'>Erreur de suppression de la ligne du facture, essayer plus tard</div>";
}

?>

<div class="container mt-5">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <?php if(isset($_GET["id"])) : ?>
                    <a href="facture.php?id=<?= $_GET['id'] ?>" target="_blank" class="btn btn-success">Imprimer cette facture</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="container mt-1">
    <div class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">
                        Générer une nouvelle facture
                    </div>

                    <?= $msg ?>

                    <form method="POST">
                        <div class="card-body">
                            <h5 class="card-title">Les informations relative à la facture</h5>
                            <div class="form-group">
                                <input type="text" class="form-control" name="ref"
                                       <?= isset($_GET['id']) ? "value='" . $facture->ref_fact . "'" : "" ?>
                                       placeholder="Enterer la référence de la facture" required>
                            </div>
                            <div class="form-group">
                                <input type="date" class="form-control" name="date"
                                       <?= isset($_GET['id']) ? "value='" . $facture->date_fact . "'" : "" ?>
                                       placeholder="Date" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="mode"
                                       <?= isset($_GET['id']) ? "value='" . $facture->mode_fact . "'" : "" ?>
                                       placeholder="Mode de réglement" required>
                            </div>
                            <div class="form-group">
                                <select name="devise" class="form-control" required>
                                    <option value="-1" disabled selected>Séléctionner un devise</option>
                                    <option value="Euro"
                                            <?= isset($_GET['id']) ? ($facture->devise_fact == 'Euro' ? 'selected' : '') : "" ?>>
                                        Euro
                                    </option>
                                    <option value="Dollar"
                                            <?= isset($_GET['id']) ? ($facture->devise_fact == 'Dollar' ? 'selected' : '') : "" ?>>
                                        Dollar
                                    </option>
                                    <option value="Dh"
                                            <?= isset($_GET['id']) ? ($facture->devise_fact == 'Dh' ? 'selected' : '') : "" ?>>
                                        Dh
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" name="car" class="form-control"
                                       <?= isset($_GET['id']) ? "value='" . $facture->car_fact . "'" : "" ?>
                                       placeholder="Nom de la voiture" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="km" class="form-control"
                                       <?= isset($_GET['id']) ? "value='" . $facture->km_fact . "'" : "" ?>
                                       placeholder="Kélométrage" required>
                            </div>
                            <br/>
                            <h6>Informations client</h6>
                            <div class="form-group">
                                <input type="text" name="nom" class="form-control"
                                       <?= isset($_GET['id']) ? "value='" . $facture->nom_fact . "'" : "" ?>
                                       placeholder="Nom complet" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="company" class="form-control"
                                       <?= isset($_GET['id']) ? "value='" . $facture->company_fact . "'" : "" ?>
                                       placeholder="Entreprise" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="address" class="form-control"
                                       <?= isset($_GET['id']) ? "value='" . $facture->address_fact . "'" : "" ?>
                                       placeholder="Adresse" required>
                            </div>
                            <?php if (!isset($_GET['id'])) : ?>
                                <button type="submit" name="dofacture" class="btn btn-primary">Créer la facture</button>
                            <?php else : ?>
                                <button type="submit" name="doedit" class="btn btn-warning">Enregistrer les
                                    modifications
                                </button>
                            <?php endif ?>
                        </div>
                    </form>
                    <div class="card-footer text-muted">
                        consulter les factures créé <a href="factures.php">ici</a>
                    </div>
                </div>
            </div>

            <?php if (isset($_GET['id'])) : ?>
                <div class="col-md-8">
                    <div class="col-md-12">
                        <form method="post" action="ajouter.php?id=<?= $_GET['id'] ?>">
                            <div class="card">
                                <div class="card-header">
                                    Détails de la facture
                                </div>
                                <div class="card-body">
                                    <?= $msg1 ?>
                                    <h5 class="card-title">Ajouter une ligne de commande</h5>
                                    <div class="form-group">
                                        <input type="text" class="form-control"
                                               name="refdet"
                                               placeholder="Enterer la référence de la ligne">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="designation"
                                               placeholder="Désignation" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="qtt" placeholder="Quantité"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="prix" placeholder="Prix unitaire"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="tva" placeholder="TVA" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="rem" placeholder="Rem." required>
                                    </div>

                                    <span class="d-block" style="color:#789">
                                Remplir tous les informations ci-dessus puis cliquer sur "Ajouter" pour ajouter la ligne de commande
                                à la liste.
                            </span> <br/>
                                    <button type="reset" class="btn btn-default float-left">Effaçer</button>
                                    <button type="submit" name="addligne" class="btn btn-primary float-right">Ajouter
                                    </button>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="card">
                            <div class="card-header" id="addligne">
                                Lignes de commande
                            </div>
                            <div class="card-body" style="overflow-x: scroll">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <td>Réf.</td>
                                        <td>Désignation</td>
                                        <td>Qte</td>
                                        <td>P.U</td>
                                        <td>TVA</td>
                                        <td>Rem.</td>
                                        <td>Montant</td>
                                        <td>Opération</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $stmt = $conn->prepare("SELECT * FROM detfacture WHERE id_fact=?");
                                    $stmt->bind_param("i", $_GET['id']);
                                    $stmt->execute();
                                    $lignes = $stmt->get_result();
                                    $mtt = 0;
                                    while ($ligne = $lignes->fetch_object()) :
                                        $mt = $ligne->prix_det * $ligne->qtt_det;
                                        $mtt+=$mt;
                                    ?>
                                        <tr>
                                            <td><?= $ligne->ref_det ?></td>
                                            <td><?= $ligne->designation_det ?></td>
                                            <td><?= $ligne->qtt_det ?></td>
                                            <td><?= $ligne->prix_det ?></td>
                                            <td><?= $ligne->tva_det ?></td>
                                            <td><?= $ligne->rem_det ?></td>
                                            <td><?= $mt ?></td>
                                            <td style="text-align: center">
                                                <a href="ajouter.php?id=<?= $_GET['id'] . "&del=" . $ligne->id_det ?>#addligne">
                                                    <span class="fa fa-close text-danger"
                                                          style="font-weight: bold;font-size: 1.1em"
                                                          onclick="return confirm('Etes-vous sûr de supprimer cette ligne?')">x</span>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile;
                                    //   echo "<tr><td colspan='8' style='text-align: center'>Aucune ligne de facture trouvé</td></tr>";

                                    ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="7" style="text-align: right">Total HT Net</th>
                                            <th style="text-align: center"><?= $mtt ?></th>
                                        </tr>
                                        <tr>
                                            <th colspan="7" style="text-align: right">TVA</th>
                                            <th style="text-align: center"><?= $mtt*0.2 ?></th>
                                        </tr>
                                        <tr>
                                            <th colspan="7" style="text-align: right">Total TTC</th>
                                            <th style="text-align: center"><?= $mtt*1.2 ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
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

