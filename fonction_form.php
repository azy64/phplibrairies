<?php
	/*cette fonction ne retourne que la length d'un tableau*/
	function length($tab){
		$t=0;
		foreach($tab as $k)
			$t++;
		return $t;
	}
	/*cette fonction insere des inputs en precisant un tableau de labels et la balise(les inputs seront inserés dans ces ou cette balise(s)) comme parametre*/
	function inputs($lab,$balise){
		if($balise=="tr" and length($lab)>0){
			foreach($lab as $l){
				echo"<tr><td><label for='".$l."'>".strtoupper($l)."</label></td><td><input type='text' id='".$l."' name='".$l."'style='height:30px;width:220px;'/></td></tr>";
			}
		}
		if($balise==' ' and length($lab)>0){
			foreach($lab as $l){
				echo"<label for='".$l."'>".strtoupper($l)."</label><input type='text' id='".$l."' name='".$l."' style='height:30px;width:220px;'/>";
			}
		}
		if($balise!="tr" and length($lab)>0){
			echo"<".$balise.">";
			foreach($lab as $l){
				echo"<label for='".$l."'>".strtoupper($l)."</label><input type='text' id='".$l."' name='".$l."' style='height:30px;width:220px;'/>";
			}
			echo"</".$balise.">";
		}
	}
	/*cette fonction insere un  seul input sur une page HTML*/
	function input($lab,$balise){
		if($balise=="tr"){
				echo"<tr><td><label for='".$lab."'>".strtoupper($lab)."</label></td><td><input type='text' id='".$lab."' name='".$lab."'style='height:30px;width:220px;'/></td></tr>";
		}
		if($balise==' '){
			echo"<label for='".$lab."'>".strtoupper($lab)."</label><input type='text' id='".$lab."' name='".$lab."' style='height:30px;width:220px;'/>";
		}
		if($balise!="tr"){
			echo"<".$balise.">";
			echo"<label for='".$lab."'>".strtoupper($lab)."</label><input type='text' id='".$lab."' name='".$lab."' style='height:30px;width:220px;'/>";
			echo"</".$balise.">";
		}
	}
	/*ici on separe label et id qui represente aussi le name */
	function inputWith($lab,$id,$balise){
		if($balise=="tr"){
				echo"<tr><td><label for='".$id."'>".strtoupper($lab)."</label></td><td><input type='text' id='".$id."' name='".$id."'style='height:30px;width:220px;'/></td></tr>";
		}
		if($balise==' '){
			echo"<label for='".$id."'>".strtoupper($lab)."</label><input type='text' id='".$id."' name='".$id."' style='height:30px;width:220px;'/>";
		}
		if($balise!="tr"){
			echo"<".$balise.">";
			echo"<label for='".$id."'>".strtoupper($lab)."</label><input type='text' id='".$id."' name='".$id."' style='height:30px;width:220px;'/>";
			echo"</".$balise.">";
		}
	}
	/*cette fonction insere une balise select avec ses élements dans une balise donnée*/
	function selects($label,$values,$balise){
		if(!empty($label) and length($values)>0){
			if($balise=="tr"){
				echo"<tr><td><label for='".$label."'>".strtoupper($label)."</label></td><td><select id='".$label."' name='".$label."'>";
				foreach($values as $el)
					echo"<option>".$el."</option>";
				echo"</select></td></tr>";
			}
			if($balise!="tr"){
				echo"<".$balise.">";
				echo"<label for='".$label."'>".strtoupper($label)."</label><select id='".$label."' name='".$label."'>";
				foreach($values as $el)
					echo"<option>".$el."</option>";
				echo"</select>";
				echo"</".$balise.">";
			}
			if($balise==" "){
				echo"<label for='".$label."'>".strtoupper($label)."</label><select id='".$label."' name='".$label."'>";
				foreach($values as $el)
					echo"<option>".$el."</option>";
				echo"</select>";
			}
		}
	}
	/*ici on separe label et id qui represente aussi le name*/
	function selectWith($label,$id,$values,$balise){
		if(!empty($label) and length($values)>0){
			if($balise=="tr"){
				echo"<tr><td><label for='".$id."'>".strtoupper($label)."</label></td><td><select id='".$id."' name='".$id."'>";
				foreach($values as $el)
					echo"<option>".$el."</option>";
				echo"</select></td></tr>";
			}
			if($balise!="tr"){
				echo"<".$balise.">";
				echo"<label for='".$id."'>".strtoupper($label)."</label><select id='".$id."' name='".$id."'>";
				foreach($values as $el)
					echo"<option>".$el."</option>";
				echo"</select>";
				echo"</".$balise.">";
			}
			if($balise==" "){
				echo"<label for='".$id."'>".strtoupper($label)."</label><select id='".$id."' name='".$id."'>";
				foreach($values as $el)
					echo"<option>".$el."</option>";
				echo"</select>";
			}
		}
	}
	/*fonction avec input mais qui prend 2 tableau comme argument*/
	function inputWithTab($lab,$name,$balise){
		$k=0;
		if($balise=="tr" and length($lab)>0){
			foreach($lab as $l){
				echo"<tr><td><label for='".$name[$k]."'>".strtoupper($l)."</label></td><td><input type='text' id='".$name[$k]."' name='".$name[$k]."'style='height:30px;width:220px;'/></td></tr>";
				$k++;
			}
			
		}
		if($balise==' ' and length($lab)>0){
			foreach($lab as $l){
				echo"<label for='".$name[$k]."'>".strtoupper($l)."</label><input type='text' id='".$name[$k]."' name='".$name[$k]."' style='height:30px;width:220px;'/>";
				$k++;
			}
		}
		if($balise!="tr" and length($lab)>0){
			echo"<".$balise.">";
			foreach($lab as $l){
				echo"<label for='".$name[$k]."'>".strtoupper($l)."</label><input type='text' id='".$name[$k]."' name='".$name[$k]."' style='height:30px;width:220px;'/>";
				$k++;
			}
			echo"</".$balise.">";
		}
	}
	function fileInto($dir,$file,$n){
	//$ext=pathinfo($file);
	//$ext=$ext['extension'];
	//$extension_auth=array('doc','docx','pdf');
	// if(in_array($ext,$extension_auth)){
	// }
		if(is_dir($dir)){
			move_uploaded_file($file[$n]['tmp_name'],$dir ."/". $file[$n]['name']);
		}
		else{
			mkdir($dir);
			move_uploaded_file($file[$n]['tmp_name'],$dir ."/". $file[$n]['name']);
		}
		return $dir ."/". $file[$n]['name'];
}
/*fonction qui retourne le Id d'un tableau-------------------------------*/
function getId($id,$table,$clause,$con){
		$back="";
		$re="select ".$id." from ".$table." ".$clause;
		$res=$con->query($re);
		while($f=$res->fetch()){
			$back=$f[$id];
		}
		return $back;
	}
		//this is an exemple
	/*$id_ent=getId("id_ent","entreprises"," where denomination='".$_POST['den']."'",$conn);
	echo $id_ent."<br>";
	$id_d=getId("id_type","type_cv"," where libele_t='".$_POST['domaine']."'",$conn);
	if(empty($_POST['titre']) or empty($_POST['lieu'])){
		
		echo"<h1>REMPLISSEZ TOUS LES CHAMPS<a href='".$_SERVER['HTTP_REFERER']."'><<<<<<<<<</a> </h1>";
	}*/
	/*cette fonction crée des input text simple càd qui ne sont contenuent que dans des label------*/
	function inputSimple($label=array(),$name=array()){
		$i=0;
		foreach($label as $elm){
			echo"<label for='". $name[$i]."'>".$elm."<input type='text' id='". $name[$i]."' name='". $name[$i]."'/></label>";
			$i++;
		}
	}
	/*cette fonction crée des object des type date ---------*/
	function inputDaten($dateBegin='',$lng='french'/*peut aussi prendre la valeur english*/,$label){
		$debut="";
		if(empty($dateBegin))
			$debut=1920;
		else
			$debut=$dateBegin;
		//$i=$dateBegin;
		if($lng=="french"){
			echo"<label class='date' >".$label." <br><select id='jour' name='jour'>";
			for($k=0;$k<31;$k++){
				echo"<option>".($k+1)."</option>";
			}
			echo"</select> / ";
			echo"<select id='mois' name='mois'>";
			for($k=0;$k<12;$k++){
				echo"<option>".($k+1)."</option>";
			}
			echo"</select> / ";
			echo"<select name='year' id='year'>";
			for($i=$debut;$i<2001;$i++){
				echo"<option>".$i."</option>";
			}
			echo"</select></label>";
		}
		// pour le casou dateBegin est vide et lng est english---------------
		/*elseif($lng=="english"){
			echo"<select name='year' id='year'>";
			for($i=$debut;$i<2001;$i++){
				echo"<option>".$i."</option>";
			}
			echo"</select> / ";
			echo"<select id='mois' name='mois'>";
			for($k=0;$k<12;$k++){
				echo"<option>".($k+1)."</option>";
			}
			echo"</select> / ";
			echo"<label>".$label." <select id='jour' name='jour'>";
			for($k=0;$k<31;$k++){
				echo"<option>".($k+1)."</option>";
			}			
			echo"</select></label>";
		}*/
	}
/*-------------------------------------ici commence les fonctions qui implementent chaque objet d'un formulaire----------------------------*/
	function selection($label=" ",$id="",$value=array(),$selected=""){
		echo"<label>".$label."<select id='".$id."' name='".$id."'>";
        $i=0;
        $k=0;
        if(!empty($selected))
            $i=$selected;
		foreach($value as $elm){
            if($k==$i)
                echo"<option selected='selected'>".trim($elm)."</option>";
            else
			    echo"<option>".$elm."</option>";
            $k++;
		}
		echo"</select></label>";
	}
	function inputText($label=" ",$id="",$attribute=" ",$default=" "){
		echo"<label for='".$id."' >".$label."<input type='text' id='".$id."' name='".$id."' placeholder='".$default."' $attribute/> </label>";
	}
	function inputTextArea($label=" ",$id=""){
		echo"<label for='".$id."' >".$label."<textarea id='".$id."' name='".$id."'> </textarea></label>";
	}
	function inputPass($label=" ",$id="",$attribute=" ",$default=" "){
		echo"<label for='".$id."' >".$label."<input type='password' id='".$id."' name='".$id."' placeholder='".$default."' ".$attribute."/> </label>";
	}
	function inputdate($label=" ",$id="",$attribute=" ",$default=" "){
		echo"<label for='".$id."' >".$label."<input type='date' id='".$id."' name='".$id."' placeholder='".$default."' $attribute/> </label>";
	}
	function inputNumber($label=" ",$id="",$attribute=" ",$default=" "){
		echo"<label for='".$id."' >".$label."<input type='number' id='".$id."' name='".$id."' placeholder='".$default."' $attribute/> </label>";
	}
    function inputMail($label=" ",$id="",$attribute=" ",$default=" "){
        echo"<label for='".$id."' >".$label."<input type='email' id='".$id."' name='".$id."' placeholder='".$default."' $attribute/> </label>";
    }
	function putIn($tab,$champ,$value,$connexion){
		$str="insert into ".$tab."".$champ." values(".$value.")";
		$connexion->exec($str);
	}
    function inputButton($label=" ",$id="",$attribute=" "){
        echo"<input type='submit' id='".$id."' name='".$id."' value='".$label." $attribute/>";
    }
    function Button($label=" ",$id="",$attribute=" "){
        echo"<button id='".$id."'  $attribute >".$label."</button>";
    }
    function inputCheck($label=" ",$id="",$attribute=" "){
        echo"<label for='".$id."' >".$label."<input type='checkbox' id='".$id."' name='".$id."'  $attribute/> </label>";
    }
	//----------------------------------------fonction qui permet d'enregistrer les donnée dans une table dynamiquement-------------------------------
	function Insert($tab,$value,$connexion,$wth=" "){
		$champs="(";
		$req="";
		$q="SHOW COLUMNS FROM ".$tab;
		$result=$connexion->query($q);
		while($f=$result->fetch()){
			$champs.=$f['Field'].",";
		}
		$pos=strrpos($champs,",");
		//echo $champs." ".$pos."<br>";
		$champs=substr($champs,0,$pos);
		$champs.=")";
		//echo $champs."<br>";
		if($wth=="1")
			$req="INSERT INTO ".$tab."".$champs." VALUES(".$value.")";
		else
			$req="INSERT INTO ".$tab."".$champs." VALUES(' ',".$value.")";
		$connexion->exec($req);
	}
	//--------------------------------------------------------------------------------------------------------------------------------------------------
	function getLastId($tab,$connexion){
		$id="";
		$q="SHOW COLUMNS FROM ".$tab;
		$champ="";
		$result=$connexion->query($q);
		while($f=$result->fetch()){
			$champ=$f['Field'];
			break;
		}
		$req="SELECT COUNT(".$champ.") as nb FROM ".$tab;
		$res=$connexion->query($req);
		while($f=$res->fetch()){
			$id=$f['nb'];
			break;
		}
		return $id;
	}
	//---------------------cette fonction retourne un table qui contient tous les champs de la table passé en parametre----------------------------------------
function getColumns($tab,$tabreturn,$con){
	$req="SHOW COLUMNS FROM ".$tab;
	$res=$con->query($req);
	$i=0;
	while($f=$res->fetch()){
		if($i>0){ //to give up the id of table-------------------
			$tabreturn[$i-1]=$f['Field'];
		}
		$i++;
	}
	return $tabreturn;
}
?>