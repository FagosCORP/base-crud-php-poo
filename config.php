<?php
spl_autoload_register(function ($nomeClasse) {

    $nomeClasse = str_replace("\\", '/', $nomeClasse);
    $dirClass = 'class';
    $directorySeparator = DIRECTORY_SEPARATOR;
    $filename = "{$dirClass}{$directorySeparator}{$nomeClasse}.php";

    if (file_exists($filename)) {
        require_once($filename);
    }
});
