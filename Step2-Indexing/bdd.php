<?php
try{
  $bdd = new PDO('pgsql:host=url;dbname=database', 'login', 'password');
}
catch (Exception $e)
{
  die('Erreur : ' . $e->getMessage());
}
?>
