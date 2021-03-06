<?php
include_once ("ressources/handle_db.php");
if (!isset($_SESSION)) {
    session_start();
}
function check_error_form_change($check_pw)
{
  $error = TRUE;

  if (!isset($_POST['fname']) || !isset($_POST['lname']) || !isset($_POST['email']) || !isset($_POST['oldpw'])
  || !isset($_POST['newpw']) || $_POST['fname'] === "" || $_POST['lname'] === "" || $_POST['email'] === ""){
    $error = "Tous les champs obligatoires doivent être remplis.";
    return ($error);
  }
  if (preg_match("/^.+@.+\..+$/", $_POST['email']) == FALSE && $_POST['email'] !== 'admin') {
    $error = "L'adresse email n'est pas valide.";
    return ($error);
  }
  else if (preg_match("/^[0-9]+\s+.+\s+.+\s?$/", $_POST['address']) == FALSE && $_POST['address'] !== 'admin') {
    $error = "L'adresse n'est pas valide.";
    return ($error);
  }
  else if (preg_match("/^[0-9]{5}$/", $_POST['postal_code']) == FALSE ) {
    $error = "Le code postal n'est pas valide.";
    return ($error);
  }
  else if (preg_match("/^\+?[0-9]+$/", $_POST['phone']) == FALSE) {
    $error = "Le numéro de téléphone n'est pas valide.";
    return ($error);
  }
  else if (isset($_POST['oldpw']) && hash("whirlpool", $_POST['oldpw']) !== $check_pw['passwd']) {
    $error = "Ancien mot de passe erroné.\n";
    return ($error);
  }
  else if (isset($_POST['oldpw']) ) {
    if (strlen($_POST['newpw']) < 5) {
      $error = "Le nouveau mot de passe doit faire au moins 5 caractères.";
      return ($error);
    }
    else if (preg_match('~[0-9]+~', $_POST['newpw']) == FALSE) {
      $error = "Le nouveau mot de passe doit comporter au moins un chiffre.";
      return ($error);
    }
  }
  return ($error);
}
if (isset($_POST['submit']) && $_POST['submit'] == "Change")
{
  $query = query("SELECT passwd FROM `user` WHERE email = '$_SESSION[user_email]'");
  if (mysqli_num_rows($query) > 0)
    $check_pw = mysqli_fetch_assoc($query);
  $error = check_error_form_change($check_pw);
  if ($error === TRUE)
  {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    if (isset($_POST['oldpw']))
      $oldpw = $_POST['oldpw'];
    if (isset($_POST['newpw']))
      $newpw = $_POST['newpw'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];
    $phone = $_POST['phone'];
    $change = "UPDATE `user` SET passwd ='" . hash('whirlpool', $_POST['newpw']) . "', fname = '$fname', lname = '$lname', email = '$email', address = '$address', city = '$city', postal_code = '$postal_code', phone = '$phone' WHERE email = '$_SESSION[user_email]'";
    query($change);
    $_SESSION['user_email'] = $_POST['email'];
    echo "Votre compte a été modifié avec succès.\n";
  }
  else
    echo $error."\n";
    
}
if (isset($_POST['submit']) && $_POST['submit'] === "Delete")
{
  if ($_SESSION["logged_in"] === TRUE)
  {
    $delete = "DELETE FROM `user` WHERE email = '$_SESSION[user_email]'";
    query($delete);
    $_SESSION['user_email'] = NULL;
    $_SESSION['user_id'] = NULL;
    $_SESSION["logged_in"] = FALSE;
    echo "Votre compte a été supprimé avec succès.\n";    
    header("Location: index.php");
  }
  else
    echo "Aucun compte n'est actuallement connecté.\n";
}
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === TRUE)
{
      ?>
      <form method="post" id="change_account">
        <fieldset>
          <?php
          $ret = query("SELECT * FROM `user` WHERE email = '$_SESSION[user_email]'");
          if (mysqli_num_rows($ret) > 0) {
            while($row = mysqli_fetch_assoc($ret)) {
              echo <<<EOL
          <h1>Modifiez votre compte</h1>
          <label for="fname">Prénom : </label><input id="fname" name="fname" type="text" value="$row[fname]"/><br/>
          <label for="lname">Nom : </label><input id="lname" name="lname" type="text" value="$row[lname]"/><br/>
          <label for="email">E-mail : </label><input id="email" name="email" type="text" value="$row[email]"/><br/>
          <label for="oldpw">Ancien mot de passe : </label><input id="oldpw" type="password" name="oldpw"/><br/>
          <label for="newpw">Nouveau mot de passe : </label><input id="newpw" type="password" name="newpw"/><br/>
          <label for="address">Adresse : </label><input id="address" name ="address" type="text" value="$row[address]"/><br/>
          <label for="city">Ville : </label><input id="city" name ="city" type="text" value="$row[city]"/><br/>
          <label for="postal_code">Code postal : </label><input id="postal_code" name="postal_code" type="text" value="$row[postal_code]"/><br/>
          <label for="phone">Téléphone : </label><input id="phone" name="phone" type="tel" value="$row[phone]"/><br/>
          <input type="submit" class="submit" name="submit" value="Change" ><br/>
EOL
?>
</fieldset>
</form>
<?php
     }
    }
}
else
  echo "Aucun utilisateur n'est actuellement connecté.\n";
?>