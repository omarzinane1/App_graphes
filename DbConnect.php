<?php
$con = new mysqli('localhost', 'root', '', 'analyse_radeej');
if(!$con){
   echo "Vous n'êtes pas connecté à la base de donnée";
}
?>