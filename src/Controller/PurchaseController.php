<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Purchase;

/**
 * Purchase controller.
 */
class PurchaseController extends FOSRestController {
	/**
    * Lists all Purchases.
    * @Rest\Get("/purchase")
    *
    * @return Response
    */
	public function getPurchaseAction() {
				
		try {
			// read from purchases table using doctrine
			$repository = $this->getDoctrine()->getRepository(Purchase::class);
			$purchases = $repository->findall();

			// return purchases
			return $this->handleView($this->view($purchases));

		} catch (\Exception $e) {
			// set error
			$errorMessage = $e->getMessage();
			return $this->handleView($this->view(['error' => $errorMessage]));
		}

	}

	/**
	 * Create Purchase.
	 * @Rest\Post("/purchaser-product")
	 *
	 * @return Response
	 */
	public function postPurchaseAction(Request $request) {
				
		try {
			// set name and date now for insert		
			$purchase = new Purchase();
			$purchase->setPurchaserId($request->get('purchaser_id'));
			$purchase->setProductId($request->get('product_id'));
			$date = new \DateTime(date('Y-m-d H:i:s', $request->get('purchase_timestamp')));
			$purchase->setPurchaseTimestamp($date);
			
			// insert into purchases table
		    $em = $this->getDoctrine()->getManager();
		    $em->persist($purchase);
		    $em->flush();

		    // return status
		    return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));

		} catch (\Exception $e) {
			// set error
			$errorMessage = $e->getMessage();
			return $this->handleView($this->view(['error' => $errorMessage]));
		}
	}

	/**
    * Lists all Purchases given purchaser id and date range.
    * @Rest\Get("/purchaser/{purchaserId}/product")
    *
    * @return Response
    */
	public function getPurchasesByPurchaserAction(Request $request, $purchaserId) {
				
		try {
			// $_GET parameters
			$startDate = $request->query->get('start_date');
			$endDate = $request->query->get('end_date');

			// Get conn from entity manager
			$conn = $this->getDoctrine()->getManager()->getConnection();

			$purchase = new Purchase();
			$result = $purchase->getPurchasesByPurchaser($conn, $purchaserId, $startDate, $endDate);

			// return target purchases
			return $this->handleView($this->view($result));

		} catch (\Exception $e) {
			// set error
			$errorMessage = $e->getMessage();
			return $this->handleView($this->view(['error' => $errorMessage]));
		}
	}
}