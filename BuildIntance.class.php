<?php
/**
 * Created by PhpStorm.
 * User: AZARIA
 * Date: 20/12/2015
 * Time: 12:21
 */
/*cette classe sert juste à creer des instances d'autre classe à partir des certains arguments qui je vais expliquer ci-dessous*/
 abstract class BuildIntance {
     private $objets=array();
     private $tab=array();
     /*
      * $objetName:est le nom de l'objet à créer
      * la methode build qui se chargera de contruire les objets
      * il prend commme argument:
      * $method:qui est soit POST ou GET
      * $regex:qui est le predicat des noms de variables du formulaire à recupérer
      * $arg: qui est un tableau des parametres de l'objet à associer aux valuers reçues
      * $offset : est la position à laquelle on doit commencer à remplir le tableau, si on ne veux pas tenir compte
      * de la position alors attribuez -1 à l'offset
      */

     public function build($objetName,$method,$regex,array $arg,$offset){
         $this->tab=array();
         $this->objets=array();
         $nbr=$this->Length($arg);
         $k=$offset;
         $mth=$_POST;
         if($method=="get")
             $mth=$_GET;
         //$nbr_data=$this->Length($mth);
         $i=0;
         foreach($mth as $el=>$cont){
             /*si le nombre des parametres de l'objet est atteint
             *alors on met $k à 0 et on cree l'objet en question
              *
             */
             if($offset!=-1 /*and isset($mth[$arg[$offset]])*/){
                 for($t=0;$t<$offset;$t++)
                     $this->tab[$arg[$t]]="";
             }
             if(preg_match("#".strtolower($regex)."_".$arg[$k]."#i",$el)){
               //  echo $el." <=================> ".strtolower($regex)."_".$arg[$k]."<br/>";

               /*  if($k<=$offset){
                    $this->tab[$arg[$k]]="";
                 }*/
                 /*si $i est superieur au offset alors on affecte les valeurs normalement*/
                 if($k<($this->Length($arg)-1) and $k>=$offset){
                    // echo"<br>traitement...<br>";
                    // echo $el." ******************".strtolower($regex)."_".$arg[$k]."<br/>";
                     $this->tab[$arg[$k]]=$mth[$el];
                    // echo $el."<br/>";
                     //echo $cont."<br/>";
                    // echo"<br>voici la valeur de k:".$k."<br>";
                 }
                 if($k===($this->Length($arg)-1)){
                     $this->tab[$arg[$k]]=$mth[$el];
                     $k=$offset-1;
                     //print_r($this->tab);
                    // echo"<br>";
                     $objetName=ucfirst($objetName);
                     $this->objets[]=new $objetName($this->tab);
                    // print_r($this->objets);
                     //print_r($this->objets);
                     $this->tab=array();
                    // echo"<br>voici la valeur de k:".$k."<br>";
                    // echo"<br>----------------------------------fin---------------------------------<br>";
                     //  $this->objets[]=new $objetName($this->tab);
                 }
                 $k++;

             }

             $i++;
         }
         $this->tab=array();
         return $this->objets;
     }
     public function Length(array $tab){
        $len=0;
        foreach($tab as $el)
            $len++;
         return $len;
     }
} 