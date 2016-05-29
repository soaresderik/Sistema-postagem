<?php
    require_once ('../system/config.php');
    require_once ('../system/database.php');
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
    <title>Adicionar Postagem</title>
    <meta charset="UTF-8">
</head>

    <body>
        <h2>AdicionarPostagem | <a href="index.php" title="Voltar">Voltar</a></h2>
        <hr>

        <?php
            if(isset($_POST['publicar']))
            {
                $form['titulo']    = DBEscape(strip_tags(trim($_POST['titulo'])));
                $form['autor']     = DBEscape(strip_tags(trim($_POST['autor'])));
                $form['status']    = DBEscape(strip_tags(trim($_POST['status'])));
                $form['data']      = DBEscape(date('Y-m-d H:i:s'));
                $form['conteudo']  = DBEscape(trim($_POST['conteudo']));

                $form              = DBEscape($form);

                if(empty($form['titulo']))
                    echo 'Preencha o campo titulo!';
                else if(empty($form['autor']))
                    echo 'Preencha o campo Autor!';
                else if(empty($form['status']) && $form['status'] != '0')
                    echo 'Preencha o campo status!';
                else if(empty($form['conteudo']))
                    echo 'Preencha o Conteudo!';
                else
                {
                    $dbCheck = DBRead('posts', "WHERE titulo = '". $form['titulo'] . "'");

                    if($dbCheck)
                        echo 'Desculpe, mas já existe uma postagem com este titulo!';
                    else
                    {
                        if(DBCreate('posts', $form))
                            echo 'Sua Postagem foi enviada com seucesso!';
                        else
                            echo 'Desculpe, ocorreu um erro...';
                    }
                }
                echo '<hr>';
            }
        ?>

        <form action="" method="post">
            <p>
                <label for="titulo">Titulo</label><br>
                <input type="text" name="titulo">
            </p>

            <p>
                <label for="author">Autor</label><br>
                <input type="text" name="autor">
            </p>

            <p>
                <label for="status">status</label><br>

                <select name="status">
                    <option value="1" selected>Ativo</option>
                    <option value="0">Inativo</option>
                </select>
            </p>

            <p>
                <label for="conteudo">Conteúdo</label><br>
                <textarea name="conteudo" cols="50" rows="15"></textarea>
            </p>

            <input type="submit" name="publicar" value="Publicar">
        </form>
    </body>
</html>