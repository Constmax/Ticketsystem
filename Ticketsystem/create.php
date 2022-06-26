<?php
include 'functions.php';
session_start();
$pdo = pdo_connect_mysql();

$msg = '';
// leite den Nutzer zu seinen erstellten Tickets und zeige den Status sowie die Kommentare des Admin an
if (isset($_POST['Anliegen'], $_POST['Beschreibung'], $_POST['Raum'], $_POST['Gerät'])) {
    if (empty($_POST['Anliegen']) || empty($_POST['Beschreibung']) || empty($_POST['Raum']) || empty($_POST['Gerät'])) {
        $msg = 'Bitte füllen sie alle Felder aus!';
    } else {
        $fkc = $pdo -> prepare('SET FOREIGN_KEY_CHECKS=0');
        $fkc -> execute();
        // fügt neue Eintrag in die Datenbank
        $status = 'open';
        $stmt = $pdo->prepare('INSERT INTO tickets (title, StatusTicket, nutzer_ID) VALUES (:title, :StatusTicket, :nutzer_ID)');
        $stmt -> execute(array(
            ':title' => $_POST['Anliegen'],
            ':StatusTicket' => $status,
            ':nutzer_ID' => $_SESSION['user_ID']
        ));
        // hohlt die id von dem ersten Ticket
        $stmt2 = $pdo->prepare('SELECT ticket_ID FROM tickets WHERE nutzer_ID = :nutzer_ID ORDER BY created  desc LIMIT 1');
        $stmt2 -> execute(array(
            ':nutzer_ID' => $_SESSION['user_ID']
        ));
        $ticket_ID = $stmt2->fetch();
        $ticket_ID = $ticket_ID['ticket_ID'];

        // fügt neue Eintrag in issue hinzu inklusive der Ticket_ID
        $stmt3 = $pdo -> prepare('INSERT INTO issue (Raum, Gerät, Beschreibung, ticket_ID) VALUES(?, ?, ?, ?)');
        $stmt3 -> execute(array(
                $_POST['Raum'],
                $_POST['Gerät'],
                $_POST['Beschreibung'],
                $ticket_ID
        ));
        $stmt4 = $pdo->prepare('SELECT Fehler_ID FROM issue ORDER BY Fehler_ID  desc LIMIT 1');
        $stmt4 -> execute();

        $fehler_ID = $stmt4->fetch();

        $stmt5 = $pdo->prepare('update tickets set fehler_ID = ? where fehler_ID = 0');
        $stmt5 -> execute(array(
                $fehler_ID['Fehler_ID']
        ));
        header('Location: index.php');

    }
}
?>


<?=template_header('Bitte erstelle hier dein Ticket')?>
<div class="content create">
    <h1>Erstellen sie hier ihr Ticket</h1>
    <form action="create.php" method="POST">
        <label for="Anliegen">Anliegen</label>
        <input type="text" name="Anliegen" placeholder="Anliegen" id="Anliegen">
        <label for="Raum">Betroffener Raum</label>
        <input type="text" name="Raum" placeholder="101" id="Raum">
        <label for="gerät">Betroffenes Gerät</label>
        <input type="text" name="Gerät" placehodler="Beamer" id="gerät">
        <label for="Beschreibung">Beschreibung</label>
        <textarea name="Beschreibung" placeholder="Beschreibe dein Problem hier" id="Beschreibung"></textarea>
        <div class="btns">
            <input type="submit" class="btn" value="Abschicken">
            <a href="help.php" class="btn">Hilfe</a>
        </div>
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>


<?=template_footer()?>