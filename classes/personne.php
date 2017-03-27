<?php
class Personne{
	protected $_id; // identifiant unique d'une personne
	protected $_nom;
	protected $_prenom;
	protected $_adresse;
	protected $_age;

	protected function __construct($id, $nom, $prenom, $adresse, $age){
		$this->_id = $id;
		$this->_nom = $nom;
		$this->_prenom = $prenom;
		$this->_adresse = $adresse;
		$this->_age = $age;
	}

	protected function getInfoFromFile($fname, $id){ 
	// permet de renvoyer des infos d'une personne grâce à son ID, sous forme d'un tableau
	// l'intérêt est de retirer les données nécessaires aux constructeurs de personnes d'un fichier csv

		$personne = array();
		$fp = fopen($fname, 'r');
		while(!feof($fp)){
			$current = trim(fgets($fp, 255));
			if(substr_count($current, ';') >= 6){
				$item = array_map('trim', explode(';', $current)); // nettoyer les données sources au passage
				if($item[0] == $id){
					$personne = $item;
					break;
				}
			}
		}
		fclose($fp);
		return $personne;
	}

	public function get($attr){
		return $this->$attr;
	}

	public function set($attr, $val){
		$this->$attr = $val;
		return $this;
	}

	protected function setCours(UFR $ufr){		
	// permet de définir la liste des cours relatives à la personne
		$coursUFR = $ufr->get('_arrCours');		// liste des cours de l'UFR
		$nb_coursUFR = count($coursUFR);
		
		$cours = array();						// ensemble des cours relatifs à la personne
		$nbCours = rand(1, $nb_coursUFR); 		// nombre de matières (tiré au sort) relatifs à la personne 

		while(count($cours) < $nbCours){						// tant qu'on n'a pas attribué le nb de cours choisis
			$coursHasard = $coursUFR[rand(0, $nbCours - 1)]; 	// on pioche un cours de l'UFR au hasard
			if(!in_array($coursHasard, $cours)){ 				// si le cours n'est pas déjà dans le tableau
				$cours[] = $coursHasard; 						// on l'ajoute
				$coursHasard->ajouterPersonne($this);			// puis on alimente le tableau de personnes du cours
			}
		}
		return $cours;
	}

	protected function getUniv($ville){
		foreach(Universite::getUniv() as $univ){
			if($univ->get('_ville') == $ville) return $univ;
		}
	}

	protected function getUFR(Universite $univ, $nomUfr){
		foreach ($univ->get('_arrUFR') as $ufr){
			if($ufr->get('_nom') == $nomUfr) return $ufr; 
		}
	}

	public function __toString(){
		return $this->get('_prenom')." ".$this->get('_nom')." (".get_class($this)." ".$this->get('_id').")<br/>";
	}
} 

class Etudiant extends Personne{
	protected $_coefFam; 		// coefficient familial
	protected $_fraisInscr; 	// frais d'inscription, dépendant du coefficient familial
	protected $_univ; 			// université à laquelle est rattaché l'étudiant
	protected $_ufr; 			// Cursus dans lequel est inscrit l'étudiant
	protected $_arrLivres; 		// liste des livres empruntés par l'étudiant
	protected $_arrCours;		// liste des cours suivis par l'étudiant

	public function __construct($id){
		$etud = parent::getInfoFromFile('data/etudiants.csv', $id);
		parent::__construct($etud[0], $etud[1], $etud[2], $etud[3], $etud[5]);
		$this->_coefFam = $etud[6];
		$this->_fraisInscr = $this->calculFrais($this->_coefFam);
		$this->_univ = parent::getUniv($etud[4]);
		$this->_ufr = parent::getUFR($this->_univ, $etud[7]);
		$this->_arrLivres = array();
		$this->_arrCours = parent::setCours($this->_ufr);
	}

	private function calculFrais($cf){
	// les frais de scolarité se calculent sur la base du coefficient familial
	// un $cf non-numérique donnera des frais de scolarité égaux à -1
		if (is_numeric($cf)){
			if($cf <= 12620) 	return 0.00;
			if($cf <= 13190) 	return 100.00;
			if($cf <= 15640) 	return 125.50;
			if($cf <= 24740) 	return 189.00;
			if($cf <= 31810) 	return 233.25;
			if($cf <= 39970)	return 275.60;
			if($cf <= 48360) 	return 432.15;
			if($cf <= 55790) 	return 560.40;
			if($cf <= 92970) 	return 789.60;
			if($cf <= 127860) 	return 1325.00;
			if($cf <= 151250) 	return 1698.50;
			if($cf <= 172040) 	return 2796.00;
			if($cf <= 195000) 	return 3845.90;
			else 				return 12589.00;
		}
		else return -1;
	}
}

class Professeur extends Personne{
	protected $_salaire;
	protected $_ufr; 		// Cursus auquel le professeur est rattaché 
	protected $_univ;		// université à laquelle est rattaché le professeur
	protected $_arrCours; 	// liste de cours qu'enseigne le professeur
	protected $_arrVilles; 	// liste de villes où enseigne le professeur
	
	public function __construct($id){
		$prof = parent::getInfoFromFile('data/professeurs.csv', $id);
		parent::__construct($prof[0], $prof[1], $prof[2], $prof[3], $prof[4]); // $id, $nom, $prenom, $adresse, $age
		$this->_salaire = $prof[5];
		$this->_univ = parent::getUniv($prof[6]);
		$this->_ufr = parent::getUFR($this->_univ, $prof[7]);
		$this->_arrVilles = $this->setVilles($prof[6]);
		$this->_arrCours = parent::setCours($this->_ufr);
	}

	private function setVilles($ville){		
	// permet de définir au hasard une liste de villes dans lesquelles le professeur va enseigner
		
		$villes = array('Nantes', 'Saint-Nazaire', 'Rennes'); 	// ensemble des villes possibles
		$villesProf = array($ville);							// ensemble des villes dans lesquelles va enseigner le prof
		$nb_villes = rand(1, 3); 								// on tire au hasard un nombre de villes
		
		while(count($villesProf) < $nb_villes){			// tant que ce nombre tiré au hasard n'est pas atteint,
			$villeHasard = $villes[rand(0, 2)]; 		// on tire une ville au sort,
			if(!in_array($villeHasard, $villesProf)){ 	// si le prof n'y enseigne pas déjà,
				$villesProf[] = $villeHasard; 			// on ajoute cette ville
			}
		}
		return $villesProf;
	}

	public function getVilles(){		// retourne la liste des villes dans lesquelles enseigne le prof
		$result = '';
		foreach($this->_arrVilles as $ville){
			$result .= $ville."<br/>";
		}
		return $result;
	}
}

?>