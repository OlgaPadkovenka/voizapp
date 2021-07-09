<?php
include 'header.php';

//var_dump($_POST);

if (isset($_POST['email']) AND isset($_POST['pswrd']) AND !empty($_POST['email'])) {

    $pwd = password_hash($_POST['pswrd'], PASSWORD_DEFAULT);
    //var_dump($pwd);

    try {

        $request = $bdd->prepare('INSERT INTO user
        (user_email, user_pswd)
        VALUES (?, ?)');

$request->execute([
//ici on indique les valeurs des ?
//ca identique avec name du formulaire

$_POST['email'],
//$_POST['pswrd'] comme utilisateur a rentré le mot de passe
$pwd //mot de passe hashé
]);

//je récupère l'info de user inregistré
$request = $bdd->prepare('SELECT
user_id,
user_firstname,
user_lastname,
user_email,
user_picture,
user_num_adrs,
user_birth,
user_pseudo,
user_date_create,
id_address
FROM user
WHERE user_email = ?');

$request->execute([
    $_POST['email']
]);

$user = $request->fetch();

//var_dump($user);

$_SESSION['user'] = $user;

    } catch (Exception $e) {

        var_dump($e->getMessage());
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1 class="text-center">S'inscrire</h1>

    <div class="w-25 mx-auto">
        <form action="" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="pswrd" class="form-label">Password</label>
                <input name="pswrd" type="password" class="form-control" id="pswrd">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
    </div>
</body>

</html>

<?php
include 'footer.php';
?>