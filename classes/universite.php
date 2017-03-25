<?php 
class Universite{
	protected $_ville;
	private $_bu;
	private $_arrUFR:

	private function __construct($ville){
		$this->_ville = $ville;
		$this->_bu = new BU($this);
		$this->_arrUFR = $this->creerUFR();
	}

	public function get($attr){
		return $this->$attr;
	}

	public function set($attr, $val){
		$this->$attr = $val;
		return $this;
	}

	private function creerUFR(){
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
}

class UFR extends Universite{
	private $_nom;
	private $_libelle;
	private $_arrProf; // liste des professeurs travaillant pour cette UFR
	private $_arrCours; // liste des cours dépendant de cette UFR

	private function __construct(Universite $univ, $nom, $lib){

	}
}

class Cours extends UFR{
	private $_nom;
}

//-------------------------------------------
class BU{
	private $_nom;
	private $_arrLivresDispo; 	// liste des livres proposés à l'emprunt
	private $_arrLivresEmprunt; // liste des livres empruntés

	public function __construct(Universite $univ){
		$this->_nom = 'BU'.$univ->get('_ville');
	}
}
?>