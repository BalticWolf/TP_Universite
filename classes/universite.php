<?php 
class Universite{
	protected $_ville;

	protected function __construct($ville){
		$this->_ville = $ville;
	}

	public function get($attr){
		return $this->$attr;
	}

	public function set($attr, $val){
		$this->$attr = $val;
		return $this;
	}
}

class UFR extends Universite{
	private $_nom;
}
//-------------------------------------------
class BU{
	private $_nom;
	private $_arrLivresDispo; // liste des livres proposés à l'emprunt

	public function __construct(Universite $univ){
		$this->_nom = 'BU'.$univ->get('_ville');
	}
}
?>