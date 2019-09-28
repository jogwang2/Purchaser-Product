<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
*@ORM\Entity
*@ORM\Table(name="purchases")
*/
class Purchase {

	/**
	*@ORM\Column(type="integer")
	*@ORM\Id
	*@ORM\GeneratedValue(strategy="AUTO")
	*/
	private $id;

	/**
	*@ORM\Column(type="integer")
	*
	*/
	private $purchaser_id;

	/**
	*@ORM\Column(type="integer")
	*/
	private $product_id;

	/**
	*@ORM\Column(type="datetime")
	*/
	private $purchase_timestamp;

	/**
	*@return mixed
	*/
	public function getId() {
		return$this->id;
	}

	/**
	*@param mixed $id
	*/
	public function setId($id) {
		$this->id=$id;
	}

	/**
	*@return mixed
	*/
	public function getPurchaserId() {
		return $this->purchaser_id;
	}

	/**
	*@param mixed $purchaser_id
	*/
	public function setPurchaserId($purchaser_id) {
		$this->purchaser_id=$purchaser_id;
	}

	/**
	*@return mixed
	*/
	public function getProductId() {
		return $this->product_id;
	}

	/**
	*@param mixed $product_id
	*/
	public function setProductId($product_id) {
		$this->product_id=$product_id;
	}

	/**
	*@return mixed
	*/
	public function getPurchaseTimestamp() {
		return $this->purchase_timestamp;
	}

	/**
	*@param mixed $purchase_timestamp
	*/
	public function setPurchaseTimestamp($purchase_timestamp) {
		$this->purchase_timestamp=$purchase_timestamp;
	}


	public function getPurchasesByPurchaser($conn, $purchaserId, $startDate, $endDate) {

		// Check startDate; if null/empty assign '0000-00-00 00:00:00'
		if(isset($startDate)) {
			$newStartDate = $startDate.' 00:00:00';
		} else {
			$newStartDate = '0000-00-00 00:00:00';
		}

		// Check endDate; if null/empty assign '9999-12-31 23:59:59'
		if(isset($endDate)) {
			$newEndDate = $endDate.' 23:59:59';
		} else {
			$newEndDate = '9999-12-31 23:59:59';
		}

		// Prepare SQL
		$sql = '
			SELECT DATE(a.purchase_timestamp) AS date, b.name
			FROM purchases a
			LEFT JOIN products b
			ON a.product_id = b.id
			WHERE a.purchaser_id = :purchaserId
			AND a.purchase_timestamp >= :startDate
			AND a.purchase_timestamp <= :endDate
			ORDER BY date DESC
		';
		
		try {

			// execute query
			$stmt = $conn->prepare($sql);
			$stmt->execute(array(
				'purchaserId' => $purchaserId,
				'startDate' => $newStartDate,
				'endDate' => $newEndDate
			));

			// format fetched data
			$data = $stmt->fetchAll();
			$result = $this->processFetchedData($data);

			// return result
			return $result;

		} catch (Exception $e) {
			
			// return error message
			return array(
				'status' => 'NG',
				'message' => $e->getMessage()
			);
		}
	}

	private function processFetchedData($data) {

		$result = array();
		
		foreach($data as $value) {

			$product = ['product' => $value['name']];

			$result['purchases'][$value['date']][] = $product;

		}

		return $result;
	}
}