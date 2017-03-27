<?php 
require_once('classes/personne.php');
require_once('classes/universite.php');

function main(){
	$professeur1 = new Professeur(154);
	print $professeur1;
}

main();
?>