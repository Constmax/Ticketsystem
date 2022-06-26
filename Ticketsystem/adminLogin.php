<?php
include 'functions.php';
$pdo = pdo_connect_mysql();

$msg = '';


// bereitet die Daten für die Datenbank vor
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// pull passord and email out of the table user and check if they are the same as the one in the form
if (isset($_POST['email'], $_POST['password'])) {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $msg = 'Bitte füllen sie alle Felder aus!';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM user WHERE Email = :email and Rechte = "admin"');
        $stmt->execute(array(
            ':email' => $_POST['email']
        ));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($result)){
            $hash = $result['Passwort'];
            if ($_POST['password'] == $hash) {
                echo 'du hast dich erfolgreich eingeloggt';
                $_SESSION['email'] = $result['Email'];
                header('Location: admin.php');
            } else {
                $msg = 'Email oder Passwort falsch!';
            }
        } else {
            $msg = 'Sie haben nicht die nötigen Berechtigungen';
        }
    }
}
?>

<?=template_header('Login')?>
<div class="content create">
    <h1>Login</h1>
    <form action="adminLogin.php" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" placeholder="" id="email" required>
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="" id="password" required>
        <input class="btn" type="submit" value="Einloggen">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>