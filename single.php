<?php
require_once ('system/config.php');
require_once ('system/database.php');

if(!isset($_GET['id']) || empty($_GET['id']))
    header('Location: index.php');
else
{
    $id = DBEscape(strip_tags(trim($_GET['id'])));
    $post = DBread('posts', "WHERE id = '{$id}' LIMIT 1");

    if(!$post)
        header('Location: index.php');
    else
        $post = $post[0];

        $upVisitas = array(
          'visitas' => $post['visitas'] + 1
        );

        DBUpDate('posts', $upVisitas, "id = '{$id}'");

}
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
    <title><?php echo (!$post)?'Erro 404' : $post['titulo']; ?></title>
</head>
<body>

    <h1>
        <?php echo (!$post)?'Erro 404' : $post['titulo']; ?>
    </h1>

    <?php if($post): ?>

    <p>
        por <b> <?php echo $post['autor']; ?></b>
        em <b> <?php echo date('d/m/Y', strtotime($post['data'])); ?></b>
        Visitas <b> <?php echo $post['visitas']; ?></b>
    </p>
    <hr>

     <p>
       <?php echo nl2br($post['conteudo']); ?>
     </p>

    <?php endif; ?>



</body>
</html>