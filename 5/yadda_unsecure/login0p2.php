<?php
    session_start();
    require_once('DbH.inc.php');
    $dbh = DbH::getDbH();
    $ltr = '>';
    if (isset($_GET['p'])) {
        $ltr = '<';
    }

    $value = 'something from somewhere';

    setcookie("TestCookie1min", $value, time()+60);
    setcookie("TestCookie2noSpec", $value);  /* expire in 1 hour */
    setcookie("TestCookie3never", $value, 0);
?><!doctype html>
<html>
    <head>
        <title>Login Demo  Page 2 - Read Abstracts</title>
        <meta charset='utf-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    </head>
    <body>
        <h1>Page 2 - You're In - Everbody's Allowed</h1>
<?php
        $next = isset($_SESSION['lastId']) ? $_SESSION['lastId'] : 0;
        $sql = "select *";
        $sql .= " from abstract";
        $sql .= sprintf(" where id %s %s", $ltr, $next);
        $sql .= " limit 1;";
        try {
            $s = $dbh->prepare($sql);
            $s->execute();
        } catch (PDOException $e) {
            die(sprintf("Unexpected error<br/>%s<br/>\n", $e->getMessage()));
        }
        $obj  = $s->fetch(PDO::FETCH_OBJ);
        if ($obj) {
            $_SESSION['lastId'] = $obj->id;
?>
        <table>
            <caption>Abstract / Review</caption>
            <tr>
                <th>Abstract by</th><th>Article</th>
            </tr>
            <tr>
                <td class='left'><?php echo $obj->id;?></td><td><?php echo $obj->authors.": ".$obj->reftitle;?></td>
            </tr>
            <tr>
                <td><?php echo $obj->entered;?></td><td rowspan='2'><?php echo $obj->abstract;?></td>
            </tr>
            <tr>
                <td><?php echo $obj->enteredby;?></td>
            </tr>
        </table>
<?php
        }
?>
        <p>
            <a href='./login0p2.php?p'>Previous</a> or
            <a href='./login0p2.php?n'>Next</a> or
            <a href='./login0.php'>To Front</a>
        </p>
    </body>
</html>
