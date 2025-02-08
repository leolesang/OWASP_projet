<?php


//%0a pour bypass 
//${IFS} pour les espaces ! 
//python3${IFS}-c${IFS}"print(open('/var/www/html/php/login.php').readlines())"

if (!isset($_GET['ip'])) {
    die("Veuillez fournir une adresse IP.");
}

$ip = $_GET['ip'];


if (preg_match('/[&|>;`>]/', $ip)) {
    die("Caractères interdits détectés !");
}

$blacklist = array("cmp","xargs","find","nl","file","read","printf","dd"," ", "strings", "ls", "cat", "xxd", "tac", "awk", "sed", "cut", "id", "more", "less", "tail", "head", "pwd", "rm" , "cd", "mkdir", "whoami");

foreach ($blacklist as $forbidden) {
    if (preg_match('/\b' . preg_quote($forbidden, '/') . '\b/', strtolower($ip))) {
        die("Mot interdit détecté !");
    }
}

$output = shell_exec("ping -c 2" . $ip);
echo "<pre>$output</pre>";
?>