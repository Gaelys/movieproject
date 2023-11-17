<?php
$title ='choisissez le nombre de place';
include 'INC/head.php';
var_dump($_POST);
if (empty($_POST)) {
    header ('Location: index.php');
    die;
}
$idMovieSession = $_POST['idmovie_session'];
$movie = $_POST['movie'];
$idmovie = $_POST['idmovie'];
$quantity = $_POST['quantity'];
$prices = getPrices();
?>
<div>
    Des justificatifs seront demandés pour les tarifs réduits.
</div>
<form method="post" action="where.php">
    <table>
        <tr><th>Place n°</th><th>Choix du prix</th><th></th></tr> 
    <?php
    for ($i=0; $i<$quantity; $i++) {
            ?>
            <tr>
                <td>Place n° <?php echo $i+1;?></td>
                <td>
                    <select name="price<?php echo $i+1;?>">
                        <option value="">Choisissez un prix</option>
                        <?php
                        foreach ( $prices as $price => $index) {
                            ?>
                            <option value="<?php echo $index['idprice'];?>"><?php echo $index['price'] . "€ " .  $index['infos'];?></option>
                        <?php } ?>
                    </select> 
                </td></tr>
                <?php
    }
    ?>
    </table>
    <input type="hidden" name="idmovie" value="<?php echo $idmovie;?>">
    <input type="hidden" name="idmovie_session" value="<?php echo $idMovieSession;?>">
    <input type="hidden" name="quantity" value="<?php echo $quantity;?>">
    <button type="submit">Finaliser</button>
</form>


<?php
include 'INC/foot.php';