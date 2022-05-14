<?php
die();

if ((isset($_GET['p']) && $_GET['p'] == "muku126") || ($argc > 1 && $argv[1] == "muku")) {
    /* for($i = 2000;$i < 2018;$i++) {
      $res = @mkdir("./Strona/Aktualności/".$i, 0777, true);
      echo("Mkdir "."./Strona/Aktualności/".$i." : ".($res? "true" : "false")."\n<br />");
      } */

    $mysql = mysqli_connect("asksolidvn268.mysql.db:3306", "asksolidvn268", "2RB5eUNgubJv", "asksolidvn268");

    if (!$mysql) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    $mysql->set_charset("utf8");

    $tables = array(
        "idjxp_content",
        "jom_content",
        "jos_content"
    );
    $out = array();
    foreach ($tables as $i => $table) {
        $result = mysqli_query($mysql, "SELECT * FROM " . $table);
        while ($r = mysqli_fetch_assoc($result)) {
            $out[$table][] = $r;
        }
    }

    print json_encode($out);

    mysqli_close($mysql);
}
