<?php
	require_once ("modele_affiche_bdd.php"); 
?>
<!DOCTYPE html>
<html>
<head>
	<title>XML-PDO</title>
</head>
<body>
	<h1> TP numéro 2 : mise en oeuvre de XML et PDO </h1> 

	<br/>
	<form method="post" action="">
		<input type="submit" name="bdd_visualiser" value ="Lecture des données de la BDD">
		<input type="submit" name="toXml" value="Export BDD to XMl">
		<input type="submit" name="toBdd" value="Charger les données de XML vers BDD">
	</form>

	<?php
		if (isset ($_POST['bdd_visualiser']))
		{
			$lesEquipes = Modele :: selectAllEquipes(); 
			 
			$nomEquipe = $lesEquipes[0]["designation"];
			echo "<br>Division : ".$lesEquipes[0]['division']; 
			echo "<br>Nom Equipe : ".$lesEquipes[0]['designation']." Couleur : ".$lesEquipes[0]['couleur']."<br/>";
			echo "<table border = 1>"; 
			foreach ($lesEquipes as $uneEquipe)
			{
				
				if ($nomEquipe != $uneEquipe['designation'])
				{
					echo "</table>";
					echo "<br>Division : ".$uneEquipe['division']; 
					echo "<br>Nom Equipe : ".$uneEquipe['designation']." Couleur : ".$uneEquipe['couleur']."<br/>";
					echo "<table border = 1>"; 
					$nomEquipe = $uneEquipe['designation'];
				}
				echo "
				<td> ".$uneEquipe['nom']."</td>
				<td> ".$uneEquipe['prenom']."</td>
				<td> ".$uneEquipe['poste']."</td>
				<td> ".$uneEquipe['numero']."</td>
				</tr>";
				
			}
			 
		}
		if (isset ($_POST["toXml"]))
		{
			$fichier = fopen ("xml_foot.xml","w"); 
			 
			$lesEquipes = Modele :: selectAllEquipes(); 
			 
			$nomEquipe = $lesEquipes[0]["designation"];
			$chaine = "<?xml version='1.0' encoding='UTF-8'?> \n";
			$chaine .= "<listeequipe>";
			$chaine .= "<equipe>\n"; 
			$chaine .= "\t<division>". $lesEquipes[0]['division']."</division>\n"; 
			$chaine .= "\t<designation>". $lesEquipes[0]['designation']."</designation>\n"; 
			$chaine .= "\t<couleur>". $lesEquipes[0]['couleur']."</couleur>\n"; 
			 
			 
			foreach ($lesEquipes as $uneEquipe)
			{
				
				if ($nomEquipe != $uneEquipe['designation'])
				{
					$chaine .="</equipe>\n";
					$chaine .= "<equipe>\n"; 
					$chaine .= "\t<division>". $uneEquipe['division']."</division>\n"; 
					$chaine .= "\t<designation>". $uneEquipe['designation']."</designation>\n"; 
					$chaine .= "\t<couleur>". $uneEquipe['couleur']."</couleur>\n"; 
					$nomEquipe = $uneEquipe['designation'];
				}
				$chaine .="<joueur>\n";
				$chaine .="\t<nom>".$uneEquipe['nom']."</nom>\n";
				$chaine .="\t<prenom>".$uneEquipe['prenom']."</prenom>\n";
				$chaine .="\t<poste>".$uneEquipe['poste']."</poste>\n";
				$chaine .="\t<numero>".$uneEquipe['numero']."</numero>\n";
				$chaine .="</joueur>\n";
			}
			$chaine .="</equipe>\n";
			$chaine .= "</listeequipe>";
			fputs ($fichier, $chaine); 
			fclose ($fichier);  
		}
		if (isset ($_POST["toBdd"]))
		{
			 
			$xml = simplexml_load_file("xml_foot.xml");

			foreach ($xml->equipe as   $uneEquipe) {
				echo "<br> ---------------------------------";
				echo "<br/> Désignation : ".$uneEquipe->designation;
				echo "<br/> Division : ".$uneEquipe->division;
				echo "<br/> Couleur : ".$uneEquipe->couleur;

				$tab = array ("designation"=>$uneEquipe->designation, 
								"couleur"=>$uneEquipe->couleur, 
								"division"=>$uneEquipe->division); 
				Modele :: insertEquipe ($tab);

				echo "<br> --------- Liste des joueurs ------";
				
			}
			   
		}
	?>

</body>
</html>