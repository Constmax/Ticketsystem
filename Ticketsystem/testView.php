<?php 
include 'functions.php';
session_start();

$pdo = pdo_connect_mysql();

$user_id = '1';

var_dump($_SESSION);
// hohlt alle Tickets aus der Datenbank
$stmt_ticket= $pdo->prepare('SELECT * From tickets WHERE nutzer_ID = :nutzer_ID'); 
$stmt_ticket->execute(array(
    ':nutzer_ID' => $_SESSION['user_ID']
));
$stmt_ticket = $stmt_ticket->fetchall(PDO::FETCH_ASSOC);

// hohlt alle Beschreibungen aus der Datenbank
$stmt_description = $pdo -> prepare('SELECT Beschreibung from issue WHERE user_ID = :user_ID');
$stmt_description->execute(array(
    ':user_ID' => $_SESSION['user_ID']
));
$stmt_description = $stmt_description->fetchall(PDO::FETCH_ASSOC);

//hohlt die Kommentare des Admins aus der Datenbank
$stmt_comment = $pdo -> prepare('SELECT kommentar, erstelldatum from tickets_comments');
$stmt_comment->execute();
$comments = $stmt_comment->fetchall(PDO::FETCH_ASSOC);

header('Locatin: testView.php?id=' . $user_id);
$counter = 0;
?>

<?=template_header('hilfe bei der fehlerfindung')?>
<div class="content view">

    <?php foreach ($stmt_ticket as $tk):?>

    <h2><?=htmlspecialchars($tk['title'], ENT_QUOTES)?>
        <span class="<?=$tk['StatusTicket']?>">(<?=$tk['StatusTicket']?>)</span>
    </h2>

    <div class="ticket">
        <p class="created"><?=date('f ds, g:ia', strtotime($tk['created']))?></p>
        <p class="msg"><?=htmlspecialchars($stmt_description[$counter]['Beschreibung'])?></p>
    </div>
    <?php $counter++; endforeach;?>

    <div class="comments">
        <?php foreach($comments as $comment): ?>
        <div class="comment">
            <div>
                <i class="fas fa-comment fa-2x"></i>
            </div>
            <p>
                <span><?=date('F dS, G:ia', strtotime($comment['erstelldatum']))?></span>
                <?=nl2br(htmlspecialchars($comment['kommentar'], ENT_QUOTES))?>
            </p>
        </div>
        <?php endforeach; ?>

        <div class="btns">
            <a href="Location: testView.php?id=" class="btn">Teste URL Parameter</a>
        </div>
    </div>
    <?=template_footer()?>