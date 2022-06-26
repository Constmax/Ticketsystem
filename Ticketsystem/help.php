<?php

include 'functions.php';
$pdo = pdo_connect_mysql();

?>

<?=template_header('Hilfe bei der Fehlerfindung')?>
<div class="content">
    <h2>Technik im Westgebäude</h2>
    <iframe
        src="https://goethegymnasiumbensheim-my.sharepoint.com/personal/constantin_janz_ggb_kbs_schule/_layouts/15/Doc.aspx?sourcedoc={0221e3ab-f334-4f1a-a87e-1d670ebe4ac8}&amp;action=embedview&amp;wdAr=1.7777777777777777"
        width="720px" height="500px" frameborder="0">Dies ist ein eingebettetes <a target="_blank"
            href="https://office.com">Microsoft Office</a>-Dokument, unterstützt von <a target="_blank"
            href="https://office.com/webapps">Office</a>.</iframe>
    <h2>Technik im Hauptgebäude</h2>
    <iframe
        src="https://goethegymnasiumbensheim-my.sharepoint.com/personal/constantin_janz_ggb_kbs_schule/_layouts/15/Doc.aspx?sourcedoc={51771ca4-06d9-43b6-abf5-28f204bae07c}&amp;action=embedview&amp;wdAr=1.7777777777777777&amp;wdEaaCheck=1"
        width="720px" height="500px" frameborder="0">Dies ist ein eingebettetes <a target="_blank"
            href="https://office.com">Microsoft Office</a>-Dokument, unterstützt von <a target="_blank"
            href="https://office.com/webapps">Office</a>.</iframe>
    <div class="btns">
        <a class="btn" href="create.php">Zurück</a>
    </div>
</div>
<?=template_footer()?>