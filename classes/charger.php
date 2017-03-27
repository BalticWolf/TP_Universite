<?php 
class ChargerInfos{
	public static function Charger($fname, $obj) {
	// permet de charger des données d'un fichier csv dans un tableau
		$tabObj = array();

		$fp = fopen($fname, 'r');
		while(!feof($fp)) {
			$current = fgets($fp, 255);
			if(substr_count($current, ';') >= 6){
				$item = array_map('trim', explode(';', $current)); // nettoyer les données sources au passage
				switch ($obj) {
					case 'Etudiant':
						$tabObj[] = new Etudiant(new Personne($item[1], $item[2], $item[3], $item[5]), $item[6], $item[4], $item[7]);
						break;
					
					case 'Professeur':
						$tabObj[] = new Professeur(new Personne($item[1], $item[2], $item[3], $item[4]), $item[5], $item[6], $item[7]);
						break;
				}
			}
		}
		fclose($fp);
		return $tabObj;
	}
}

?>