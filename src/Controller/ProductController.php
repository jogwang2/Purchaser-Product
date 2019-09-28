<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Product;

/**
 * Product controller.
 */
class ProductController extends FOSRestController {
	/**
    * Lists all Products.
    * @Rest\Get("/product")
    *
    * @return Response
    */
	public function getProductAction() {
				
		try {
			// read from products table using doctrine
			$repository = $this->getDoctrine()->getRepository(Product::class);
			$products = $repository->findall();

			// return products
			return $this->handleView($this->view($products));

		} catch (\Exception $e) {
			// set error
			$errorMessage = $e->getMessage();
			return $this->handleView($this->view(['error' => $errorMessage]));
		}
	}

	/**
	 * Create Purchase.
	 * @Rest\Post("/product")
	 *
	 * @return Response
	 */
	public function postProductAction(Request $request) {
				
		try {
		
			// set name and date now for insert
			$product = new Product();
			$product->setName($request->get('name'));
			$date = new \DateTime(date('Y-m-d H:i:s'));
			$product->setCreatedDate($date);
			
			// insert into products table
		    $em = $this->getDoctrine()->getManager();
		    $em->persist($product);
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