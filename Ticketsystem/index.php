<?php
include 'functions.php';
session_start();

if (isset($_POST['Abmelden'])){
    $_SESSION = array();
    header('Location: userLogin.php');
}

if (!isset($_SESSION['user_ID'])) {
    header('Location: userLogin.php');
    exit;
}


// baut verbindung zur datenbank auf
$pdo = pdo_connect_mysql();

$stmt_ticket= $pdo->prepare('SELECT * From tickets INNER JOIN issue on tickets.ticket_ID = issue.ticket_ID WHERE nutzer_ID = :nutzer_ID'); 
$stmt_ticket->execute(array(
    ':nutzer_ID' => $_SESSION['user_ID']
));
$stmt_ticket = $stmt_ticket->fetchall(PDO::FETCH_ASSOC);

//hohlt die Kommentare des Admins aus der Datenbank
$stmt_comment = $pdo -> prepare('SELECT kommentar, erstelldatum, ticket_ID from tickets_comments');
$stmt_comment->execute();
$comments = $stmt_comment->fetchall(PDO::FETCH_ASSOC);
?>

<?=template_header('Tickets')?>

<div class="content home">
    <h1>Tickets</h1>
    <?php 
if(!isset($_GET['id'])):?>
    <p class="paragraph">Willkommen auf der Startseite des Goethe Technik Supports. Wir werden unsere bestes tun um ihr Problem zu beheben
    </p>

    <div class="btns">
        <a href="create.php" class="btn">Erstelle Ticket</a>
        <a href="userLogin.php" class="btn">Abmelden</a>
        <a href="adminLogin.php" class="btn">Admin</a>
    </div>
    <div class="tickets-list">
        <?php foreach($stmt_ticket as $ticket):?>
        <a href="index.php?id=<?=$ticket['ticket_ID']?>" class="ticket">
            <span class="con">
                <?php if ($ticket['StatusTicket'] == 'open'): ?>
                <i class="far fa-clock fa-2x"></i>
                <?php elseif ($ticket['StatusTicket'] == 'resolved'): ?>
                <i class="fas fa-check fa-2x"></i>
                <?php elseif ($ticket['StatusTicket'] == 'closed'): ?>
                <i class="fas fa-times fa-2x"></i>
                <?php endif; ?>
            </span>
            <span class="con">
                <span class="title"><?php $ticket['title']?></span>
                <span class="msg"><?=$ticket['Beschreibung']?></span>
            </span>
            <span class="con created"><?=date('F dS, G:ia', strtotime($ticket['created']))?></span>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php else: ?>
<div class="content view">
    <?php foreach ($stmt_ticket as $tk):?>
    <?php if ($tk['ticket_ID'] == $_GET['id']): ?>
    <div class="ticket">
        <h2><?=htmlspecialchars($tk['title'], ENT_QUOTES)?>
            <span class="<?=$tk['StatusTicket']?>">(<?=$tk['StatusTicket']?>)</span>
        </h2>
        <p class="created"><?=date('f ds, g:ia', strtotime($tk['created']))?></p>
        <?php echo $tk['Beschreibung'] ?>
        <p class="msg"><?php nl2br(htmlspecialchars($tk['Beschreibung'], ENT_QUOTES)); ?></p>
    </div>
    <div class="comments">
        <?php foreach($comments as $comment): ?>
        <?php if ($comment['ticket_ID'] == $_GET['id']): ?>
        <div class="comment">
            <div>
                <i class="fas fa-comment fa-2x"></i>
            </div>
            <p>
                <span><?=date('F dS, G:ia', strtotime($comment['erstelldatum']))?></span>
                <?=nl2br(htmlspecialchars($comment['kommentar'], ENT_QUOTES))?>
            </p>
        </div>
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php endif; ?>
</div>

<?=template_footer()?>