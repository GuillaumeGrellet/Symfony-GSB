<?php
namespace Pg\GsbFraisBundle\Controller;

require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use PdoGsb;
class Advert

{

  private $id;
  private $author;
  private $content;
  private $date;

  

  public function __construct()

  {

    $this->date = new \Datetime();

  }

  public function getId()

  {

    return $this->id;

  }


  public function setAuthor($author)

  {

    $this->author = $author;


    return $this;

  }


  public function getAuthor()

  {

    return $this->author;

  }


  public function setContent($content)

  {

    $this->content = $content;


    return $this;

  }


  public function getContent()

  {

    return $this->content;

  }


  public function setDate($date)

  {

    $this->date = $date;


    return $this;

  }


  public function getDate()

  {

    return $this->date;

  }

}

class ListeVehiculesController extends Controller
{
    public function indexAction(Request $request)
    {

        $session= $this->container->get('request')->getSession();
        $login =  $session->get('login');
        $mdp =  $session->get('mdp');
        
        $pdo = $this->get('pg_gsb_frais.pdo');
         $ListeVehiculesVisiteurs= $pdo->getListeVehicules($login, $mdp);
     /* $refvisiteur = $ListeVehiculesVisiteurs['refvisiteur'];
       $immat = $ListeVehiculesVisiteurs['immat'];
       $marque = $ListeVehiculesVisiteurs['marque'];
       $couleur = $ListeVehiculesVisiteurs['couleur'];*/

       $test = $pdo->gettest();
    // On crée un objet Advert

    $advert = new Advert();

    // On crée le FormBuilder grâce au service form factory

    $formBuilder = $this->get('form.factory')->createBuilder('form', $advert);

    // On ajoute les champs de l'entité que l'on veut à notre formulaire

    $formBuilder
      ->add('date',      'date')
      //->add('title',     'text')
      ->add('content',   'textarea')
      ->add('author',    'text')
      //->add('published', 'checkbox')
      ->add('save',      'submit')

    ;

    // Pour l'instant, pas de candidatures, catégories, etc., on les gérera plus tard


    // À partir du formBuilder, on génère le formulaire

    $form = $formBuilder->getForm();


    //    $form = $this->createForm(new testType());
        
        if ($this->get('request')->getMethod() == 'POST')
        {
            $form->bind($this->get('request'));
            var_dump($form->getData());
            
            
           
        }


        // On fait le lien Requête <-> Formulaire

    // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur

    //$form->handleRequest($request);


    // On vérifie que les valeurs entrées sont correctes

    // (Nous verrons la validation des objets en détail dans le prochain chapitre)

    //  $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');


      // On redirige vers la page de visualisation de l'annonce nouvellement créée

   
    


            return $this->render('PgGsbFraisBundle:ListeVehicules:ListeVehicules.html.twig', array(
                    'ListeVehiculesVisiteurs'=>$ListeVehiculesVisiteurs, 'test' => $test, 'form' => $form->createView(),
                    ));
            
        
        


    }




}
