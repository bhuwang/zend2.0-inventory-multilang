<?php
namespace Item\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class ItemForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('item');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'item_id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $select = new Element\Select('status');
        $select->setLabel('Item Status');
        $select->setValueOptions(array(
        		'0' => 'Out of Stock',
        		'1' => 'In Stock',
        ));
        $this->add($select);
        
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Name',
            ),
        ));
        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Description',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add',
                'id' => 'submitbutton',
            ),
        ));
    }
}