<?php
	class Modele 
	{
		private static $unPdo; 

		public static function connexion (){
			try{
			Modele :: $unPdo = new PDO ("mysql:host=localhost:8889;dbname=foot","root", "root");
			}
			catch (PDOException $exp)
			{
			echo "Erreur de connexion à la base de données";
			}
		}

		public static function selectAllEquipes (){

			Modele :: connexion(); 
			if (Modele :: $unPdo  != null)
			{
				$requete = "select division, designation,couleur , nom,prenom,poste, numero from Equipe, joueur
					where Equipe.idequipe=joueur.idequipe order by designation"; 
				
			$select = Modele :: $unPdo->prepare ($requete);
			$select->execute ();
			return $select->fetchALL();
			}
			else
			{
			return null;
			}
		}
		public static function insertEquipe ($tab){
			Modele :: connexion(); 
			if (Modele :: $unPdo != null)
			{
			$requete = "insert into equipe values (null, :designation, :couleur, :division); "; 
			$donnees = array(":designation"=>$tab['designation'], 
							 ":couleur"=>$tab['couleur'], 
							 ":division"=>$tab['division']);
			 
			$select = Modele :: $unPdo->prepare ($requete);
			$select->execute ($donnees);
			}
			 
		}
		public static function insertJoueur ($tab){
			Modele :: connexion(); 
			if (Modele :: $unPdo != null)
			{
			$requete = "insert into joueur values (null, :nom, :prenom,:poste, :numero, :idequipe); "; 
			$donnees = array(":nom"=>$tab['nom'], 
							 ":prenom"=>$tab['prenom'], 
							 ":poste"=>$tab['poste'], 
							 ":numero"=>$tab['numero'], 
							 ":idequipe"=>$tab['idequipe']);
			$select = Modele :: $unPdo->prepare ($requete);
			$select->execute ($donnees);
			}
		}
	}
	
?>