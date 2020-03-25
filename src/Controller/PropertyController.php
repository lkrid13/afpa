<?php
namespace App\Controller;

use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Description of PropertyController
 *
 * @author didier
 */
class PropertyController extends AbstractController {

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var PropertyRepository
     */
    private $repository;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em) {
        
        $this->repository = $repository;
        $this->em = $em;
    }

    
    /**
     * @Route("/biens", name="property.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response{
        
        // Créer une entité qui va représenter notre recherche
        //     prix maximum, nombre de pièces
        // Créer un formulaire
        // gérer le traitement dans le controller (handleRequest ...)
        // passer l'entité qui représente la recherche à la méthode findAllVisibleQuery($searchData)
        
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);
        
        $properties = $paginator->paginate(
                $this->repository->findAllVisibleQuery($search),
                $request->query->getInt('page', 1),
                9);
        
        return $this->render('property/index.html.twig',
                ['current_menu' => 'properties',
                 'properties' => $properties,
                 'form' => $form->createView()
                ]);
    }
    
    /**
     * @Route("/biens/{slug}.{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Property $property
     * @return Response
     */
    public function show(Property $property, string $slug): Response {
    //public function show($slug, $id): Response {    
    //    $property = $this->repository->find($id);
        if ($property->getSlug() !== $slug){
            return $this->redirectToRoute('property.show',
                    [
                        'id' => $property->getId(),
                        'slug' => $property->getSlug()
                    ], 301);    // rediection permanente
        }
        return $this->render('property/show.html.twig',
           ['property' => $property,
            'current_menu' => 'properties'
           ]); 
 
    }
}
