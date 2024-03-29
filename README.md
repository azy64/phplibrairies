# phplibrairies
Php Libraries is a repository where you can find many useful php librairies , easy to use and can work on all php frameworks: Form Builder, FileUpload, BuildInstance, Fonction Form

### How to use formBuilder
the first step you have to include the php file like:

    require "formBuilder.php"; or with autoload php file.
    
then you have to create an object for its class.
in the following lines i will present you a sample code(example) with slimphp framework and it can be used as well in other Php framework.

```php

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
    
#### here is the code for the twig view

    {% extends "dashbord.twig" %}
    {% block title %}create new Employee{% endblock %}
    {% block contenu %}
        <div>
            <h3>je suis la page create new Employee</h3>
        </div>
        <form action="{{ app.urlFor("createemployee") }}" method="post">
            {{ view|raw }}
            <button class="btn btn-primary">ENREGISTRER</button>
        </form>
    {% endblock %}
 ```   
    
### How to use FileUpload

here is the easiest way to use FileUpload but don't forget to include the specific file with a require or autoload file

```php

    app->map('/createemployer', function ()use($app,$chk,$cntrl) {
        $emp=new \models\Employeurs();

        $form=new formBuilder($emp);
        if($app->request->isPost()){
            //var_dump($app->request->params());
            $file=new FileUpload($_FILES["getLogo"]);

            $emp=$form->getData($app->request->params());
            /*
            *we use upload method to upload file
            *it takes one parameter :the path 
            */
            $file->upload("./logo/".md5(time()));
            /*
            *getPathDest() return the new path where the file is saved
            */
            $namef=$file->getPathDest();
            $emp->setLogo($namef);
           $cntrl->saveEmployeur($emp);

        }
        $form->add("denomination","text","Entreprise's Name")
            ->add("logo","file","Logo")
            ->add("adresse","text","Addresse")
            ->add("position","text","Location")
        ;

    $view=$form->view();
    $contenue=$app->twig->render("createemployer.twig",array("app"=>$app,"view"=>$view));
    echo $contenue;
    })->via("GET","POST")->setName("createemployer");
    
    ```
