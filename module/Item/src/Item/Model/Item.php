<?php

namespace Item\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Item implements InputFilterAwareInterface {
	public $item_id;
	public $name;
	public $description;
	public $status;
	public $inputFilter;
	public function exchangeArray($data) {
		$this->item_id = (isset ( $data ['item_id'] )) ? $data ['item_id'] : null;
		$this->name = (isset ( $data ['name'] )) ? $data ['name'] : null;
		$this->description = (isset ( $data ['description'] )) ? $data ['description'] : null;
		$this->status = (isset ( $data ['status'] )) ? $data ['status'] : null;
	}
	
	// Add the following method:
	public function getArrayCopy() {
		return get_object_vars ( $this );
	}
	
	// Add content to this method:
	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception ( "Not used" );
	}
	public function getInputFilter() {
		if (! $this->inputFilter) {
			$inputFilter = new InputFilter ();
			
			$inputFilter->add ( array (
					'name' => 'item_id',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'Int' 
							) 
					) 
			) );
			
			$inputFilter->add ( array (
					'name' => 'name',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					),
					'validators' => array (
							array (
									'name' => 'StringLength',
									'options' => array (
											'encoding' => 'UTF-8',
											'min' => 1,
											'max' => 100 
									) 
							) 
					) 
			) );
			
			$inputFilter->add ( array (
					'name' => 'description',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					),
					'validators' => array (
							array (
									'name' => 'StringLength',
									'options' => array (
											'encoding' => 'UTF-8',
											'min' => 1,
											'max' => 100 
									) 
							) 
					) 
			) );
			
			$inputFilter->add ( array (
					'name' => 'status',
					'required' => false
			) );
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
}