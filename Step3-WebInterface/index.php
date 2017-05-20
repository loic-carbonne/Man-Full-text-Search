<?php
include('bdd.php');
$weightA = 1;
if (isset($_GET['weightA']))$weightA = $_GET['weightA'];
$weightB = 0.5;
if (isset($_GET['weightB']))$weightB = $_GET['weightB'];
$weightC = 0.1;
if (isset($_GET['weightC']))$weightC = $_GET['weightC'];
$weightD = 0.05;
if (isset($_GET['weightD']))$weightD = $_GET['weightD'];
$normalisation = 0;
if (isset($_GET['normalisation']))$normalisation = $_GET['normalisation'];
$limit = 10;
$offset = 0;
$withResume = true;
if (isset($_GET['weightA']) && !isset($_GET['withResume']) )$withResume = false;
$requete = "";
if (isset($_GET['requete']))$requete = $_GET['requete'];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Module de recherche dans le man</title>
        <link rel="stylesheet" type="text/css" href="css_file.css">
    </head>
    <body>
<form action="index.php" method="get">
  <a href="index.php">RESET</a></br>
  <input type="checkbox" id="isCustomParam" onChange="if(this.checked){document.getElementById('customparam').style.display = 'block';}else{document.getElementById('customparam').style.display = 'none';}"> Paramètre personnalisés ?</br>
  <div id="customparam" style="display:none">
  A <input type="number" step="0.01" name="weightA" value="<?php echo $weightA; ?>" >
  B <input type="number" step="0.01" name="weightB" value="<?php echo $weightB; ?>" >
  C <input type="number" step="0.01" name="weightC" value="<?php echo $weightC; ?>" >
  D <input type="number" step="0.01" name="weightD" value="<?php echo $weightD; ?>" ></br>
  Normalisation <input type="number" name="normalisation" value="<?php echo $normalisation; ?>" ></br>
  Avec résumé <input type="checkbox" name="withResume" <?php if ($withResume)echo "checked"; ?>></br>
  </div>
  <input type="text" name="requete" onfocus="this.select();" value="<?php echo $requete; ?>" autocomplete="off" autofocus>
  <input type="submit" value="submit">
</form>

<?php
  if (isset($_GET['requete']) && $_GET['requete']!="") {
    $requete = str_replace ("'"," ",$_GET['requete']);
    while (strpos($requete, "  ")!==false) {
      $requete = str_replace ("  "," ",$requete);
    }

    $requete = str_replace (" "," | ",$requete);

    $query = "SELECT nom, ".($withResume?"ts_headline(texte_html,to_tsquery('$requete'),'StartSel=<b>, StopSel=</b>, MaxWords=8, MinWords=3, ShortWord=2, HighlightAll=FALSE')":"' '")." AS resume, texte_html ,".
      "ts_rank('{".$weightD.",".$weightC.",".$weightB.",".$weightA."}',texte_vectorise,to_tsquery('$requete'),$normalisation) AS rank ".
      "FROM pages WHERE texte_vectorise @@ to_tsquery('$requete') order by rank desc LIMIT $limit OFFSET $offset";
      //echo $query;
    $reponse = $bdd->query($query);

    echo '<div class="menu"><p>Voici les 10 premières entrées :</p>';
    while ($donnees = $reponse->fetch())
    {
      echo '<a href="#'.$donnees['nom'].'" >'.$donnees['nom'].'</a>:'.$donnees['rank'].'<br />'.$donnees['resume'].'...<br />';
    }
    echo "</div>";
    $reponse = $bdd->query($query);

    echo '<div class="container"><p>Voici en html :</p>';
    while ($donnees = $reponse->fetch())
    {
      echo '<h1 id="'.$donnees['nom'].'">'.$donnees['nom']."</h1>".$donnees['texte_html'] . '<br />';
    }
    echo '</div>';
  }else{
    echo "Veuillez entrez votre requete";
  }
?>

    </body>
</html>