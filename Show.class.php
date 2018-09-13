<?php
/**
 * Created by PhpStorm.
 * User: AZARIA
 * Date: 02/01/2016
 * Time: 14:55
 */
require_once("fonction_form.php");
class Show {
    /*est le nom de la table à partir de laquelle on doit afficher les champs*/
    private $table=null;
    private $con=null;
    /*le tableau qui contiendra tous les champs à  afficher*/
    private $tableFields=array();
    /*le tableau qui contiendra les indices de champs à ne pas afficher*/
    private $tableForbiddenFields=array();
    /*le tableau qui contiendra tous les commentaires de champs afin de savoir le type du champ*/
    private $tableCommentFields=array();
    /*tableau qui contiendra les labels des champs,si ce n'est pas defini ils prendront les nom des champs de la table*/
    private $tableLabelFields=array();
    public function __construct($con){
        $this->con=$con;
    }
    /**
     * @return mixed
     */
    public function getCon()
    {
        return $this->con;
    }

    /**
     * @param mixed $con
     */
    public function setCon($con)
    {
        $this->con = $con;
    }

    /**
     * @return null
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param null $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }
    public function getField()
    {
        $r = $this->con->query("SHOW FULL COLUMNS FROM " . $this->getTable() . "");
        while ($f = $r->fetch(PDO::FETCH_ASSOC)) {
            $this->tableFields[] = $f["Field"];
            $this->tableCommentFields[$f["Field"]] = $f["Comment"];
        }
    }
    /*cette fonction doit recevoir un tableau d'entier qui represente les indices des champs à ne pas afficher*/
    public function setForbiddenElements(array $value)
    {
        $this->tableForbiddenFields[] = 0;
        if (length($value) != 0) {
            foreach ($value as $el) {
                $this->tableForbiddenFields[] = $el;
            }
        }
    }
    /* cette fonction recupere le nom de labels à afficher*/
    /*noter que la taille du tableau en argument doit etre egale à celle du tableau des champs*/
    public function setLabel(array $label){
        $this->tableLabelFields=$label;
    }
    public function showResult($field,$value){
        $this->getField();
        $r=$this->con->query("select * from ".$this->table." where ".$field."='".$value."'");
      /*  echo"<br>----------------------------------------------------------------------<br>";
        print_r($this->tableFields);
        echo"<br>----------------------------------------------------------------------<br>";*/
        $b=0;
        while($f=$r->fetch(PDO::FETCH_ASSOC)){
            $i=0;
            foreach($this->tableFields as $champs){
                if (!in_array($i, $this->tableForbiddenFields)) {
                    $id = $this->table . "_" . $champs;
                    if (length($this->tableLabelFields) != 0) {
                        if ($this->tableCommentFields[$champs] == "text" or $this->tableCommentFields[$champs] == "string")
                            inputText($this->tableLabelFields[$i], $id.$b, "style='width:95%;' value='".$f[$champs]."'");
                        if ($this->tableCommentFields[$champs] == "date")
                            inputdate($this->tableLabelFields[$i], $id.$b, "style='width:95%;' value='".$f[$champs]."'");
                        if ($this->tableCommentFields[$champs] == "integer" or $this->tableCommentFields[$champs] == "entier")
                            inputNumber($this->tableLabelFields[$i], $id.$b, "style='width:95%;' value='".$f[$champs]."'");
                        if (preg_match("#pass\-text#",$this->tableCommentFields[$champs]))
                            inputText($this->tableLabelFields[$i], $id.$b, "style='width:95%;' value='".$f[$champs]."'");
                        if ($this->tableCommentFields[$champs] == "mail" or $this->tableCommentFields[$champs] == "email")
                            inputMail($this->tableLabelFields[$i], $id.$b, "style='width:95.1%;' value='".$f[$champs]."'");
                        if (preg_match("#select#",$this->tableCommentFields[$champs])){
                            $str=$this->tableCommentFields[$champs];
                            $vall=$f[$champs];
                            $tag=$champs;
                            // $str=preg_split("")
                            $tout=array();
                            $tab=preg_split("#\(#",$str);
                            $tab1=$tab[1];
                            $tab2=preg_split("#\)#",$tab1);
                            $condit = "";
                            $table="";
                            if (preg_match("#\-#", $tab2[0])) {
                               // echo"<br>je suis là et ça marche <br>";
                                $tab2 = preg_split("#\-#", $tab2[0]);
                                $len = length($tab2);
                                $table = $tab2[0];
                                $field = $tab2[1];
                                if ($len > 2)
                                    $condit = $tab2[2];
                                $req = "select " . $field . " from " . $table . " ";
                                $rr = $this->con->query($req);

                                while ($ff = $rr->fetch(PDO::FETCH_ASSOC)) {
                                    $tout[] = $ff[$field];
                                }
                            }
                            if (preg_match("#\,#", $tab2[0])) {
                                $kab=preg_split("#\,#", $tab2[0]);
                                $tout=$kab;

                            }
                            /*la cible nous permet de recuperer la valeur du champ qui est en place*/
                            $cible="";
                           // echo $tag." et sa valeur ".$vall;
                            if(preg_split("#^strict$#",$condit)){
                                $req="select *  from ".$this->table." where ".$tag."='".$vall."'";
                               // echo $req;
                                $rr=$this->con->query($req);
                                while($ff=$rr->fetch(PDO::FETCH_ASSOC)){
                                    $cible=$ff[$field];
                                   // echo $ff[$field];
                                   // break;
                                }
                            }
                            if(!preg_split("#strict#",$condit)){
                                $req="select *  from ".$table." where ".$tag."='".$vall."'";
                                // echo $req;
                                $rr=$this->con->query($req);
                                while($ff=$rr->fetch(PDO::FETCH_ASSOC)){
                                    $cible=$ff[$field];
                                    // echo $ff[$field];
                                    // break;
                                }
                            }

                            $val=array_search($cible,$tout);
                            /*if($val!==0 or $val<0)
                                $val=" ";*/
                            selection($this->tableLabelFields[$i],$id.$b,$tout,$val);
                            // inputNumber($this->tableLabelFields[$i], $id.$b, "style='width:110px;'");
                        }
                    }
                }
                $i++;
            }
            $b++;
        }
        /*à la fin on retourne l'enregistrement que nous venons d'afficher ou de recuperer*/
        $rob=$this->con->query("select * from ".$this->table." where ".$field."='".$value."'");
        $fob=$rob->fetch(PDO::FETCH_ASSOC);
        //print_r($fob);
        return $fob;
    }
} 