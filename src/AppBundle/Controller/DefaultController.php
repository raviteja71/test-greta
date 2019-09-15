<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Movies;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\HttpKernel\KernelInterface;
/**
 * Class API Controller
 *  receives all the incoming request and
 *  returns json responses
 *
 */
class DefaultController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * DefaultController constructor.
     *
     * @param EntityManagerInterface $em
     *
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    public function __construct(EntityManagerInterface $em, KernelInterface $ki)
    {

        $this->kernel = $ki;

        $this->em = $em;
    }
    /**
     * This mthod is default
     * @Route("/", name="homepage")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function indexAction(Request $request)
    {

        return new JsonResponse(['status'=>'ok', 'message'=>'Not a valid API call']);
    }

    /**
     * This Method handles the retrieval of the films
     *  based on given query parameters
     * @Route("/init", name="init", methods={"GET"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function initAction(Request $request)
    {
        $rootDir = $this->kernel->getProjectDir();
        $reader = Reader::createFromPath( $rootDir.'/src/AppBundle/Data/movies.csv');

        $results = $reader->fetchAssoc();

        foreach ($results as $row) {
            // do a lookup for existing movie matching some combination of fields
            $movie = $this->em->getRepository('AppBundle:Movies')
                ->findOneBy([
                    'filmName' => $row['Film'],
                    'year' => $row['Year']
                ]);

            if ($movie === null) {
                // create new movies
                $movies = (new Movies())
                    ->setFilmName($row['Film'])
                    ->setGenre($row['Genre'])
                    ->setLeadStudio($row['Lead Studio'])
                    ->setAudienceScore($row['Audience score %'])
                    ->setProfitability($row['Profitability'])
                    ->setRottenTomatoes($row['Rotten Tomatoes %'])
                    ->setWorldwideGross((float) ltrim($row['Worldwide Gross'],"$"))
                    ->setYear($row['Year'])
                ;

                $this->em->persist($movies);
            }
        }

        $this->em->flush();
        
        // initiliaze response
        $response = new Response(
            'Content',
            Response::HTTP_CREATED,
            ['content-type' => 'application/json']
        );
        $response->setContent(new JsonResponse(['response'=>'Successfully Inserted']));

        return $response;
    }

    /**
     * This Method handles the GET Method for given film ID
     * @Route("/index", name="homepage", methods={"GET"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function retriveAction(Request $request)
    {

        //Default limit was 1000, if want more specfy &limit=<val> in url
        $limit = $request->query->get('limit')?$request->query->get('limit'):1000;

        //Default offset was 0, if want more specfy &offset=<val> in url
        $offset = $request->query->get('offset')?$request->query->get('offset'):0;
        $sortOrder = $request->query->get('sort')?$request->query->get('sort'):'ASC';
        $name = $request->query->get('filter');

        // look for multiple Product objects matching the name, ordered by price
        $query = $this->em->getRepository('AppBundle:Movies')
               ->createQueryBuilder('m')
               ->where('m.filmName LIKE :title')
               ->setParameter('title', '%'.$name.'%')
               ->setMaxResults($limit)
               ->setFirstResult($offset)
               ->orderBy('m.filmName', $sortOrder)
               ->getQuery();
        $result = array();
        foreach ($query->getResult() as $movie) { //get the results here
            $result[] = array('id'=>$movie->getId(),'title'=>$movie->getFilmName());
        }
        
        //initiliaze response
        $response = new Response(
            'Content',
            Response::HTTP_OK,
            ['content-type' => 'application/json']
        );
        if(empty($result)) {
            $response->setContent(new JsonResponse(['response'=>'No Matches']));
        } else {
            $response->setContent(new JsonResponse(['response'=>$result]));
        }
        
        return $response;
    }

    /**
     * This Method handles the DELETE Method for given film ID
     * @Route("/entry", name="getEntry", methods={"GET"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function entryAction(Request $request)
    {
        //initiliaze response
        $response = new Response(
            'Content',
            Response::HTTP_OK,
            ['content-type' => 'application/json']
        );

        $id = $request->query->get('id');

        if(null === $id)
            return $response->setContent(new JsonResponse(['error'=>'This operation permitable with Valid movie id parameter']));

        $movie = $this->em->getRepository('AppBundle:Movies')
                ->find($id);

        

        if(null === $movie) {
            $response->setContent(new JsonResponse(['response'=>'No Matches']));
        } else {
            $response->setContent(new JsonResponse(['response'=>$movie->getArray()]));
        }
        
        return $response;
    }

    /**
     * This function handles the DELETE Method for given film ID
     * @Route("/entry", name="deleteEntry", methods={"DELETE"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function removeAction(Request $request)
    {
        //initiliaze response
        $response = new Response(
            'Content',
            Response::HTTP_OK,
            ['content-type' => 'application/json']
        );

        $id = $request->query->get('id');

        if(null === $id)
            return $response->setContent(new JsonResponse(['response'=>'This operation permitable with Valid movie id parameter']));

        $movie = $this->em->getRepository('AppBundle:Movies')
                ->find($id);

        if(null === $movie) {
            $response->setContent(new JsonResponse(['response'=>'Already Removed']));
        } else {
            $filmName = $movie->getFilmName();
            $this->em->remove($movie);
            $this->em->flush();
            $response->setContent(new JsonResponse(['response'=>'Removed '.$filmName.' from List']));
        }

        return $response;
    }
}
