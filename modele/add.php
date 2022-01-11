<?php
require '../db_conn.php';

if (isset($_POST['iddelete'])) {

    $id = $_POST['iddelete'];

    if (empty($id)) {
        echo 0;
    } else {
        $stmt = $conn->prepare("DELETE FROM todos WHERE id=?");
        $res = $stmt->execute([$id]);
        $stmt->closeCursor();
        header("Location: ../index.php?mess=success");
        exit();
    }
}

if ($_GET['idterminer']) {
    $id = $_GET['idterminer'];

    $stmt = $conn->prepare("UPDATE todos SET etat = ? WHERE id = '$id'");
    $res = $stmt->execute([0]);

    if ($res) {
        $url = 'Location: ../show.php?id=' . $id . '&mess=success';
        header($url);
    } else {
        header("Location: ../index.php");
    }
    $stmt->closeCursor();
    exit();
}

if (isset($_POST['title1'])) {

    $title = $_POST['title1'];
    $description = $_POST['description1'];
    $assigne = $_POST['auteur1'];
    $id = $_POST['id'];

    if (empty($title) || empty($assigne)) {
        $url = 'Location: ../show.php?id=' . $id . '&mess=error';
        header($url);
    } else {
        $stmt = $conn->prepare("UPDATE todos SET title = ?, descrip = ?, auteur = ? WHERE id = '$id'");
        $res = $stmt->execute([$title, $description, $assigne]);

        if ($res) {
            $url = 'Location: ../show.php?id=' . $id . '&mess=success';
            header($url);
        } else {
            header("Location: ../index.php");
        }
        $stmt->closeCursor();
        exit();
    }
}

if (isset($_POST['title'])) {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $assigne = $_POST['auteur'];

    if (empty($title) || empty($assigne)) {
        header("Location: ../index.php?mess=error");
    } else {
        $stmt = $conn->prepare("INSERT INTO todos(title, descrip, auteur, etat) VALUE(?,?,?,?)");
        $res = $stmt->execute([$title, $description, $assigne, 1]);

        if ($res) {
            header("Location: ../index.php?mess=success");
        } else {
            header("Location: ../index.php");
        }
        $stmt->closeCursor();
        exit();
    }
} else {
    header("Location: ../index.php?mess=error");
}
