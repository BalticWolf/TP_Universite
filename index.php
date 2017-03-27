<?php 
require_once('classes/charger.php');
require_once('classes/personne.php');
require_once('classes/universite.php');

function main(){
	$univNantes = new Universite('Nantes');
	$univRennes = new Universite('Rennes');
	$univNazaire = new Universite('Saint-Nazaire');

	$tabEtudiants   = ChargerInfos::Charger("data/etudiants.csv", "Etudiant");
	$tabProfesseurs = ChargerInfos::Charger("data/professeurs.csv", "Professeur");

	print $tabProfesseurs[2];
	echo "<br/>";

	print $tabEtudiants[15];
	echo "<br/>";

/*	print "Coef Familial : ".$etudiant1->get('_coefFam')."<br/>";
	print "Frais inscription : ".$etudiant1->get('_fraisInscr')."<br/>";
	echo "<br/>";*/


/*	print $univNantes;
	print $univRennes;
	print $univNazaire;*/
//	print $univNantes->getUFR();
//	print $univNantes->getUFR('SCI');

/*	print $univNantes->get('_bu');
	print $univNantes->get('_bu')->getLivres('_arrLivresDispo');
	print $univNantes->get('_bu')->getLivres('_arrLivresEmprunt');*/
}

main();
?>