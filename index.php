<?php 
require 'db_conn.php';
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
       <div class="add-section">
          <form action="modele/add.php" method="POST">
             <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                <p style="text-align: center; color:brown;">Veillez remplir tout les champs</p>
             <?php } ?>
             <input type="text" name="title" placeholder="What do you need to do?" />
             <textarea name="description" rows="2" placeholder="Description ..."></textarea>
             <input type="auteur" name="auteur" placeholder="Assigné à ..." />
              <button type="submit">Ajouter &nbsp; <span>&#43;</span></button>
          </form>
       </div>
       <?php 
          $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
       ?>
       <div class="show-todo-section">
            <?php if($todos->rowCount() <= 0){ ?>
                <div class="todo-item">
                    <div class="empty">
                        <p style="color: blueviolet;">LISTE VIDE ... Ajouter</p>
                    </div>
                </div>
            <?php } ?>

            <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="todo-item">
                    <form method="POST" action="modele/add.php">
                        <input type="hidden" name="iddelete" value="<?= $todo['id'] ?>" >
                        <button type="submit" class="remove-to-do">x</button>
                    </form>
                    <p class="check-box">
                        <a href="show.php?id=<?= $todo['id'] ?>"><h2> <?= $todo['title'] ?></h2></a>
                    </p>
                    <small>Assigné à : <strong> <?= $todo['auteur'] ?></strong> // Crée: <?= $todo['date_time'] ?> </small> 
                </div>
            <?php } ?>
       </div>
    </div>
</body>
</html>