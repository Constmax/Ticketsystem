<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
session_start();
$_SESSION = array();
$msg = '';

if (isset($_POST['email'], $_POST['password'])) {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $msg = 'Bitte füllen sie alle Felder aus!';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM user WHERE email = :email');
        $stmt->execute(array(
            ':email' => $_POST['email']
        ));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($result)){
            $hash = $result['Passwort'];
            if ($_POST['password'] == $hash) {
                //echo 'du hast dich erfolgreich eingeloggt';
                $_SESSION['user_ID'] = $result['User_ID'];
                header('Location: index.php');
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
    <h2>Login</h2>
    <form action="userLogin.php" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" placeholder="" id="email" required>
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="" id="password" required>
        <div class="btns">
            <input type="submit" value="Einloggen">
            <a class="btn" href="userRegistration.php">Registrieren</a>
        </div>

    </form>


    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>