<?php
$title ='te';
include 'INC/head.php';
if (!empty($_POST)) {
    if (isset($_POST['ok'])) {
        echo "ok";
    }
}
?>

<form method="post">
      <div class="form-check form-switch">
        <input class="form-check-input" name="ok" type="checkbox" id="flexSwitchCheckDefault">
        <label class="form-check-label" for="flexSwitchCheckDefault" name="ok">Default switch checkbox input</label>
      </div>
      <input type="submit"></input>
</form>