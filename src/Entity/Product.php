<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
*@ORM\Entity
*@ORM\Table(name="products")
*/
class Product {

	/**
	*@ORM\Column(type="integer")
	*@ORM\Id
	*@ORM\GeneratedValue(strategy="AUTO")
	*/
	private $id;

	/**
	*@ORM\Column(type="string",length=255)
	*
	*/
	private $name;

	/**
	*@ORM\Column(type="datetime")
	*/
	private $created_date;

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
	public function getName() {
		return $this->name;
	}

	/**
	*@param mixed $name
	*/
	public function setName($name) {
		$this->name=$name;
	}

	/**
	*@return mixed
	*/
	public function getCreatedDate() {
		return $this->created_date;
	}

	/**
	*@param mixed $created_date
	*/
	public function setCreatedDate($created_date) {
		$this->created_date=$created_date;
	}
}