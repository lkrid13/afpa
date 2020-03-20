<?php
namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(): Response{
        
// commenter après la création en base du premier bien
//        $property = new Property();
//        $property->setTitle('Mon premier bien')
//                ->setPrice(200000)
//                ->setRooms(4)
//                ->setBedrooms(3)
//                ->setDescription('Une petite description')
//                ->setSurface(60)
//                ->setFloor(4)
//                ->setHeat(1)
//                ->setCity('Créteil')
//                ->setAddress('9 rue Marc Seguin')
//                ->setPostalCode('94000');
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($property);
//        $em->flush();
        
    //    $property = $this->repository->findAllVisible();
    //    $property[0]->setSold(true);
//        $em = $this->getDoctrine()->getManager();
//        $em->flush();
    //    $this->em->flush();
        return $this->render('property/index.html.twig',
                ['current_menu' => 'properties']);
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
