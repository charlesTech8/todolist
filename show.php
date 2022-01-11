<?php
require 'db_conn.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>To-Do List</title>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <div class="main-section">
        <a href="index.php" style="color: white; font-size:20px;">Accueil</a>
            <?php
            $todos = $conn->query("SELECT * FROM todos WHERE id = '$id'");
            ?>
            <div class="show-todo-section">
                <?php if ($todos->rowCount() <= 0) { ?>
                    <div class="todo-item">
                        <div class="empty">
                            <p style="color: blueviolet;">VIDE</p>
                        </div>
                    </div>
                <?php } ?>

                <?php while ($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                    <div class="todo-item">
                        <form method="POST" action="modele/add.php">
                            <input type="hidden" name="iddelete" value="<?= $todo['id'] ?>">
                            <button type="submit" class="remove-to-do">x</button>
                        </form>
                        <h2> <?= $todo['title'] ?></h2>
                        <hr>
                        <h3>Description</h3>
                        <p style="padding-left: 20px;">
                            <?= nl2br($todo['descrip']) ?>
                        </p>
                        <small style="border-top: 2px solid black;">Assigné à : <strong> <?= $todo['auteur'] ?></strong> // Crée: <?= $todo['date_time'] ?> <?php if( $todo['etat'] == 1){ ?> <a href="modele/add.php?idterminer=<?= $todo['id'] ?> "><button style="background-color:crimson; color:black; border-radius:10%; width:65px; height:25px;">Terminer</button></a><?php } ?> </small>
                    </div>
            </div>
            <?php
                    if ($todo['etat'] == 1) {
            ?>
                <div class="add-section">
                    <form action="modele/add.php" method="POST">
                        <?php if (isset($_GET['mess']) && $_GET['mess'] == 'error') { ?>
                            <p style="text-align: center; color:brown;">Veillez remplir tout les champs</p>
                        <?php } ?>
                        <input type="text" name="title1" value="<?= $todo['title'] ?>" />
                        <textarea name="description1" rows="2" placeholder=""><?= $todo['descrip'] ?></textarea>
                        <input type="auteur" name="auteur1" value="<?= $todo['auteur'] ?>" />
                        <input type="hidden" name="id" value="<?= $todo['id'] ?>">
                        <button type="submit">Update</button>
                    </form>
                </div>
            <?php
                    } else {
            ?>
                <div class="todo-item">
                    <div class="empty">
                        <p style="color: crimson;">Terminé</p>
                    </div>
                </div>
            <?php
                    }
            ?>
        <?php } ?>
        </div>
    </body>

    </html>
<?php
}
