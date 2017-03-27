<?php 
require_once('classes/personne.php');
require_once('classes/universite.php');

function main(){
/*	$professeur1 = new Professeur(154);
	print $professeur1;
	echo "<br/>";*/

	$etudiant1 = new Etudiant(281);
	print $etudiant1;
	print "Coef Familial : ".$etudiant1->get('_coefFam')."<br/>";
	print "Frais inscription : ".$etudiant1->get('_fraisInscr')."<br/>";
	echo "<br/>";
/*
	$univNantes = new Universite('Nantes');
	$univRennes = new Universite('Rennes');
	$univNazaire = new Universite('Saint-Nazaire');
	print $univNantes;
	print $univRennes;
	print $univNazaire;

	print $univNantes->get('_bu');
	print $univNantes->get('_bu')->getLivres('_arrLivresDispo');
	print $univNantes->get('_bu')->getLivres('_arrLivresEmprunt');*/
}

main();
?>