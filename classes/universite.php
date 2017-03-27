<?php 
class Universite{
	private $_ville;
	private $_bu;
	private $_arrUFR;

	public function __construct($ville){
		$this->_ville = $ville;
		$this->_bu = new BU($this);
		$this->_arrUFR = $this->listerUFR();
	}

	public function get($attr){
		return $this->$attr;
	}

	public function set($attr, $val){
		$this->$attr = $val;
		return $this;
	}

	private function listerUFR(){
		$tabUFR = array();

		$tabUFR[] = new UFR($this, 'DSP', 'Droit et Sciences Politiques');
		$tabUFR[] = new UFR($this, 'LNG', 'Langues et Cultures Etrangères');
		$tabUFR[] = new UFR($this, 'MED', 'Médecine et Techniques Médicales');
		$tabUFR[] = new UFR($this, 'SCI', 'Sciences et Techniques');
		$tabUFR[] = new UFR($this, 'HIS', 'Histoire');
		$tabUFR[] = new UFR($this, 'LET', 'Lettres et Langue');
		$tabUFR[] = new UFR($this, 'DSP', 'Droit et Sciences Politiques');

		return $tabUFR;
	}

	public function __toString(){
		return "Universite de ".$this->_ville."<br/>";
	}
}

class UFR{
	private $_univ;		// utilité à confirmer
	private $_nom;
	private $_libelle;
	private $_arrCours; // liste des cours dépendant de cette UFR

	public function __construct(Universite $univ, $nom, $lib){
		$this->_univ = $univ;
		$this->_nom = $nom;
		$this->_libelle = $lib;
		$this->_arrCours = $this->listerCours($this->_nom);
	}

	public function get($attr){
		return $this->$attr;
	}

	public function set($attr, $val){
		$this->$attr = $val;
		return $this;
	}

	private function listerCours($ufr){			// cette méthode liste les cours appartenant à une UFR donnée
		$listeCours = array(); 					// constitue l'ensemble des cours dépendant d'une UFR donnée
		$fp = fopen('data/cours.csv', 'r');
		while(!feof($fp)){
			$current = fgets($fp, 255);
			if(substr_count($current, ';') == 2){
				$item = explode(';', $current);
				if($item[2] == $ufr){ 			// on ne sélectionne que les cours de l'UFR
					$listeCours[] = new Cours($this, $item[1]);
				}
			}
		}
		fclose($fp);
		return $listeCours;
	}
}

class Cours{
	private $_ufr;
	private $_nom;
	private $_arrEtudiants;		// liste des étudiants apprenant cette matière (on pourra en déduire l'UFR et l'université de rattachement)
	private $_arrProfesseurs; 	// liste des professeurs enseignant cette matière (on pourra en déduire l'UFR et l'université de rattachement)

	public function __construct(UFR $ufr, $nom){
		$this->_ufr = $ufr;		// utilité à confirmer
		$this->_nom = $nom;
		$this->_arrEtudiants = array();
		$this->_arrProfesseurs = array();
	}

	public function get($attr){
		return $this->$attr;
	}

	public function set($attr, $val){
		$this->$attr = $val;
		return $this;
	}

	public function ajouterPersonne($objPers){
		switch (get_class($objPers)) {
			case 'Etudiant':
				$this->_arrEtudiants[] = $objPers; // permet d'ajouter un étudiant à _arrEtudiants
				break;

			case 'Professeur':
				$this->_arrProfesseurs[] = $objPers; // permet d'ajouter un professeur à _arrProfesseurs
				break;
		}
	}
}

//-------------------------------------------
class BU{
	private $_nom;
	private $_arrLivresDispo; 	// liste des livres proposés à l'emprunt
	private $_arrLivresEmprunt; // liste des livres empruntés

	public function __construct(Universite $univ){
		$this->_nom = 'BU_'.$univ->get('_ville');
		$this->_arrLivresDispo = $this->listerLivres();
		$this->_arrLivresEmprunt = array();
	}

	public function get($attr){
		return $this->$attr;
	}

	public function set($attr, $val){
		$this->$attr = $val;
		return $this;
	}
	
	public function emprunterLivre(Etudiant $etud, Livre $livre, $dateEmprunt){
		if (!in_array($livre, $this->_arrLivresEmprunt)){
			$this->_arrLivresEmprunt[] = array($etud, $dateEmprunt, null); // null = date de remise
			$this->_arrLivresDispo = array_diff($this->_arrLivresDispo, $this->_arrLivresEmprunt); // la iste de livres dispo est emputée de la liste de livres empruntés
		}
	}

	public function rendreLivre(Etudiant $etud, Livre $livre, $dateRendu){
		// y'a encore du boulot sur cette méthode.
	}

	private function listerLivres(){			// cette méthode liste les cours appartenant à une UFR donnée
		$listeLivre = array(); 					// constitue l'ensemble des cours dépendant d'une UFR donnée
		$fp = fopen('data/livres.csv', 'r');
		while(!feof($fp)){
			$current = fgets($fp, 255);
			if(substr_count($current, ';') == 3){
				$item = explode(';', $current);
				$listeLivre[] = new Livre($this, $item[0], $item[1], $item[2], $item[3]); // toutes les BU ont les mêmes livres
			}
		}
		fclose($fp);
		return $listeLivre;
	}

	public function getLivres($attr){
		$result = '';
		foreach($this->$attr as $livre){
			$result .= $livre."<br/>";
		}
		return $result;
	}

	public function __toString(){
		return $this->_nom."<br/>";
	}
}

class Livre{
	//private $_bu;
	private $_titre;
	private $_auteur;
	private $_dateParution;
	private $_numSerie;

	public function __construct(BU $bu, $titre, $auteur, $dateParu, $nSerie){
		//$this->_bu = $bu;
		$this->_titre = $titre;
		$this->_auteur = $auteur;
		$this->_dateParution = $dateParu;
		$this->_numSerie = $nSerie;
	}

	public function get($attr){
		return $this->$attr;
	}

	public function set($attr, $val){
		$this->$attr = $val;
		return $this;
	}

	public function __toString(){
		return $this->_titre." ".$this->_numSerie;
	}
}
?>