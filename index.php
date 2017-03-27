<?php 
require_once('classes/personne.php');
require_once('classes/universite.php');

function main(){
	$univNantes = new Universite('Nantes');
	$univRennes = new Universite('Rennes');
	$univNazaire = new Universite('Saint-Nazaire');

	$professeur1 = new Professeur(154);
	print $professeur1;
//	print $professeur1->getVilles();
	echo "<br/>";

/*	$etudiant1 = new Etudiant(281);
	print $etudiant1;
	echo "<br/>";*/

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