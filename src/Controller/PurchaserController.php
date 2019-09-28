<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Purchaser;

/**
 * Purchaser controller.
 */
class PurchaserController extends FOSRestController {
	/**
    * Lists all Purchasers.
    * @Rest\Get("/purchaser")
    *
    * @return Response
    */
	public function getPurchaserAction() {
				
		try {
			// read from purchasers table using doctrine
			$repository = $this->getDoctrine()->getRepository(Purchaser::class);
			$purchasers = $repository->findall();

			// return purchasers
			return $this->handleView($this->view($purchasers));

		} catch (\Exception $e) {
			// set error
			$errorMessage = $e->getMessage();
			return $this->handleView($this->view(['error' => $errorMessage]));
		}

	}

	/**
	 * Create Purchase.
	 * @Rest\Post("/purchaser")
	 *
	 * @return Response
	 */
	public function postPurchaserAction(Request $request) {
				
		try {
			// set name and date now for insert		
			$purchaser = new Purchaser();
			$purchaser->setName($request->get('name'));
			$date = new \DateTime(date('Y-m-d H:i:s'));
			$purchaser->setCreatedDate($date);
			  
			// insert into purchasers table
		    $em = $this->getDoctrine()->getManager();
		    $em->persist($purchaser);
		    $em->flush();

		    // return status
		    return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));

		} catch (\Exception $e) {
			// set error
			$errorMessage = $e->getMessage();
			return $this->handleView($this->view(['error' => $errorMessage]));
		}
	}
}