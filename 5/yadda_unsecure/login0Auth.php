<?php
    session_start();
    require_once('DbH.inc.php');
    $dbh = DbH::getDbH();

    // if there is content in POST authenticate
    // sqlinj vulnerable
    // brute force invulnerable but also manually impossible to login
    if (count($_POST) > 0) {
        $sql = "select uid, realname, pwd";
        $sql .= " from user";
        $sql .= " where uid = '". $_POST['user'] ."'";
        $sql .= " and pwd = '" . password_hash($_POST['password'], PASSWORD_DEFAULT) . "'";
        $sql .= " and activated;";
        try {
            $s = $dbh->prepare($sql);
            $s->execute();
            $obj  = $s->fetch(PDO::FETCH_OBJ);
            if ($obj) {
                $_SESSION['demoLoginId'] = $obj->uid;
                header("Location: ./login1.php?success");
            } else {
                unset($_SESSION['demoLoginId']);
                header("Location: ./login1.php?err=noSuccess");
            }
        } catch (PDOException $e) {
            die(sprintf("Unexpected error<br/>\n", $e->getMessage()));
        }
    } else {
        header("Location: ./login1.php?err=noData");
    }
