<?php
/**
 * Created by PhpStorm.
 * User: AZARIA
 * Date: 08/08/2016
 * Time: 09:39
 */
if(session_status()==PHP_SESSION_NONE)
    session_start();
$_SESSION['formBuilder']=array();

class formBuilder {
    private $obj=null;
    private $tabRow=array();
    private $tabCnt=array();
    private $auxil=null;
    protected $tableObject=array();
    protected $tmp_file="./logfile.txt";
    function __construct($obej){
        $this->obj=$obej;
        //$this->tmp_file=md5(time());
    }
    public function add($property,$field,$label=null,array $select=null){
        $this->tabCnt[]=$property;
        $this->tabCnt[]=$field;
        $this->tabCnt[]=$label;
        $this->tabCnt[]=$select;
        $this->tabRow[]=$this->tabCnt;
        $this->tabCnt=array();
        return $this;
    }
    public function view(){
        $content="";
        $txt="";
        //$meth="get";
        foreach($this->tabRow as $ligne){
            $meth="get".ucfirst($ligne[0]);
            //echo $meth;
            if(method_exists($this->obj,$meth)){
                if($ligne[1]=="text" or $ligne[1]=="date" or $ligne[1]=="email" or $ligne[1]=="password" or $ligne[1]=="number")
                    $content.="<label>".$ligne[2]."<input type='".$ligne[1]."' value='".call_user_func(array($this->obj,$meth))."' id='".$meth."' name='".$meth."' required ></label>";

                if($ligne[1]=="file")
                    $content.="<label>".$ligne[2]."<input type='".$ligne[1]."' value='".call_user_func(array($this->obj,$meth))."' id='".$meth."' name='".$meth."' value='uploader' required ></label>";

                if($ligne[1]=="textarea")
                    $content.="<label>".$ligne[2]."<textarea id='".$meth."' name='".$meth."' required >".call_user_func(array($this->obj,$meth))."</textarea></label> ";

                if($ligne[1]=="datetime"){
                    $var=call_user_func(array($this->obj,$meth));

                    $content.="<label>".$ligne[2]."<input type='date' value='".($var!=null?$var->format("Y-m-d"):"")."' id='".$meth."' name='".$meth."' required ></label>";

                }

                /* if($ligne[1]=="date")
                     $content.="<label>".$ligne[2]."<input type='".$ligne[1]."' id='".$meth."' name='".$meth."' required ></label>";*/

                if($ligne[1]=="select"){
                    //  if(!empty($this->auxilary_select) or $this->auxilary_select!=null){
                    $content.="<label>".$ligne[2]."<select name='".$meth."' id='".$meth."' >";
                    foreach($ligne[3] as $op){
                        $result=call_user_func(array($this->obj,$meth));
                       // var_dump($result);
                        if($result==trim($op))
                            $content.="<option selected='selected'>".$op."</option>";
                        else
                            $content.="<option>".$op."</option>";
                    }
                    $content.="</select></label>";
                }
                /**
                 * si le type de champs est un object
                 * alors on doit avoir neccessairement avoir un tableau à la fin
                 * voici la structure des argument de la methode lorsque c'est un object:
                 * add("Personne","object","label",array(
                 *    "nom"=>array("label"=>"nom","type"=>"text","class"=>"btn","id"=>"monId"),
                 *     "sexe"=>array("label"=>"sexe","type"=>"select","value"=>array("M","F")
                 * ))
                 **/
                if($ligne[1]=="object"){
                    $content.="<h3>".$ligne[2]."</h3><hr>";
                    $txt.=$ligne[0].",";
                    $get="get";
                    $ob=call_user_func(array($this->obj,$meth));
                    //var_dump($ob);
                    foreach($ligne[3] as $attribute=>$value){

                        if(method_exists($ob,$get.ucfirst($attribute))){
                            if($value["type"]=="text" or $value["type"]=="date" or $value["type"]=="email" or $value["type"]=="password" or $value["type"]=="number")
                                $content.="<label for='".$meth."->".$get.ucfirst($attribute)."'>".$value["label"]."<input type='".$value["type"]."' value='".call_user_func(array($ob,$get.ucfirst($attribute)))."' id='".$meth."->".$get.ucfirst($attribute)."' name='".$meth."->".$get.ucfirst($attribute)."' required ></label>";

                            if($value["type"]=="file")
                                $content.="<label for='".$meth."->".$get.ucfirst($attribute)."'>".$value["label"]."<input type='".$value["type"]."' value='".call_user_func(array($ob,$get.ucfirst($attribute)))."' id='".$meth."->".$get.ucfirst($attribute)."' name='".$meth."->".$get.ucfirst($attribute)."' value='uploader' required ></label>";

                            if($value["type"]=="textarea")
                                $content.="<label for='".$meth."->".$get.ucfirst($attribute)."'>".$value["label"]."<textarea id='".$meth."->".$get.ucfirst($attribute)."' name='".$meth."->".$get.ucfirst($attribute)."' required >".call_user_func(array($ob,$get.ucfirst($attribute)))."</textarea></label> ";


                            if($value["type"]=="select"){
                                $content.="<label for='".$meth."->".$get.ucfirst($attribute)."'>".$value["label"]."<select name='".$meth."->".$get.ucfirst($attribute)."' id='".$meth."->".$get.ucfirst($attribute)."' >";
                                foreach($value["value"] as $op){
                                    $result=call_user_func(array($ob,$get.ucfirst($attribute)));
                                    // var_dump($result);
                                    if($result==trim($op))
                                        $content.="<option selected='selected'>".$op."</option>";
                                    else
                                        $content.="<option>".$op."</option>";
                                }
                                $content.="</select></label>";
                            }
                        }

                    }
                }


            }
        }
        $f=fopen($this->tmp_file,"w+");
        fputs($f,$txt,strlen($txt));
        fclose($f);
        return $content;
    }
    public function getData(array $post){
        if(empty($post))return null;
        $k_post=$post;
        foreach($k_post as $p=>$val){
            if(method_exists($this->obj,$p)){
                $meth=preg_split("#get#",$p);
                $meth="set".$meth[1];
                //var_dump($meth);
                if(method_exists($this->obj,$meth)){
                    call_user_func(array($this->obj,$meth),$val);
                    unset($p);

                }
            }


            //var_dump($this->obj);
        }
        if(file_exists($this->tmp_file)){
            $str=file_get_contents($this->tmp_file);
            $this->tableObject=preg_split("#,#",$str);
           unset($this->tableObject[count($this->tableObject)-1]);
            unlink($this->tmp_file);
        }
        foreach($this->tableObject as $other){
            echo"////////////////////////////////////////////////////";
            foreach($k_post as $p=>$val){
                $patter_ob="get".ucfirst($other);
                if(preg_match("#\->#",$p)){
                    //var_dump($p);
                    $class=preg_split("#\->#",$p);
                   //var_dump($class[0]);
                    $obb=call_user_func(array($this->obj,$class[0]));
                    //var_dump($obb);
                    if(method_exists($obb,$class[1]) and preg_match("#".$patter_ob."#",$class[0])){
                        $meth=preg_split("#get#",$class[1]);
                        $meth="set".$meth[1];
                        //var_dump($meth);
                        $tmp=call_user_func(array($this->obj,$patter_ob));
                        call_user_func(array($tmp,$meth),$val);
                        call_user_func(array($this->obj,"set".ucfirst($other)),$tmp);

                    }
                }

            }
        }

        return $this->obj;
    }

} 