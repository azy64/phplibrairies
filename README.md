# phplibrairies
Php Libraries is a repository where you can find many utils php librairies , simple to use and can function on all php frameworks: Form Builder, FileUpload, BuildInstance, Fonction Form

#How to use formBuilder
the first you have to include the php file like:
require "formBuilder.php";
and after you have to instance an object for this class
in the following lines i will present you a sample(example) with slimphp framework but it's the same for all framework.



$app->map('/createemployee',function()use($app,$cntrl) {

    $emp=new \models\Employes();
    $employeur=new \models\Employeurs();
    $timesheet=new \models\Timesheet();
    $emp->setEmployeur($employeur);
    $form=new formBuilder($emp);
    /*
    *if it's a post request so we catch the formdata
    */
    if($app->request->isPost()){

        $emp=$form->getData($app->request->params());
        $cntrl->saveEmploye($emp);
    }
    $form->add("nom","text","your name")
        ->add("prenom","text","your last name")
        ->add("postnom","text","your first name")
        ->add("sexe","select","your gender",array("M","F"))
        ->add("mat","text","your matricule")
        ->add("dateBirth","datetime","your birthday")
        /*
        *if the property is an object you can do it like that:
        */
        
        /*->add("employeur","object","Entreprise",array(
            "denomination"=>array("type"=>"text","label"=>"Entreprise's Name"),
            "position"=>array("type"=>"text","label"=>"Location"),
            "adresse"=>array("type"=>"select","label"=>"Address","value"=>array("KTX my Dinh 2","CAU GIAU 2"))
        ))*/
        ->add("employeur","select","Entreprise",$cntrl->getEmployeurs())
        /*->add("timesheet","object","Timesheet",array(
            "dateStart"=>array("type"=>"date","label"=>"Start Date"),
            "dateEnd"=>array("type"=>"date","label"=>"End Date"))
        )*/;
    $view=$form->view();
    $contenue=$app->twig->render("createemployee.twig",array("app"=>$app,"view"=>$view));
    echo $contenue;
    // return $app->render("index.php");
})->via("GET","POST")->setName("createemployee");
