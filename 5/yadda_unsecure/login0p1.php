<?php
    session_start();
    $_SESSION['lastId'] = 0;
    if (!
        (isset($_SESSION['demoLoginId']) &&
                    $_SESSION['demoLoginId'] != '') ) {
        header("Location: ./login0.php?err=notAllowed");
        exit();
    }
?><!doctype html>
<html>
    <head>
        <title>Login Requirement  Page 1 - Create Abstracts/Reviews</title>
        <meta charset='utf-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    </head>
    <body>
        <h1>Page 1 - You're In, Create Abstracts/Reviews</h1>
        <form action='login0InsertAbstract.php' method='post'>
            <table>
                <tr>
                    <td>Reviewer:</td>
                    <td><input type='text' name='user' value='<?php echo $_SESSION['demoLoginId'];?>' readonly/></td>
                </tr>
                <tr>
                    <td>Article Authors:</td>
                    <td><input type='text' name='authors' placeholder="Comma separated list of authors" length='60' maxsize='128'/></td>
                </tr>
                <tr>
                    <td>Article Title:</td>
                    <td><input type='text' name='title' placeholder="Title of article goes here" length='60' maxsize='64'/></td>
                </tr>
                <tr>
                    <td>Review:</td>
                    <td><textarea name='abs' placeholder="Enter an abstract/review here..." rows='10' cols='64'></textarea></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><input type='submit' value='Yeehah'/></td>
                </tr>
            </table>
        </form>
        <p>
            Done, go back to
            <a href='./login0.php'>Front page</a>
        </p>
    </body>
</html>
