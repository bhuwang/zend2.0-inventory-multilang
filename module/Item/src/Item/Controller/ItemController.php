<?php

namespace Item\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Item\Model\Item;
use Item\Form\ItemForm;

class ItemController extends AbstractActionController {
	protected $translator;
	protected $itemTable;

    public function getTranslator()
    {
        if (!$this->translator)
        {
            $sm = $this->getServiceLocator();
            $this->translator = $sm->get('translator');
        }
        return $this->translator;
    }
	
	public function indexAction() {
		return new ViewModel ( array (
				'items' => $this->getItemTable ()->fetchAll () 
		) );
	}
	public function addAction() {
		$form = new ItemForm ();
		$form->get ( 'submit' )->setValue ( $this->getTranslator()->translate('add'));
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$item = new Item ();
			$form->setInputFilter ( $item->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$item->exchangeArray ( $form->getData () );
				$item->status=1;
				$this->getItemTable ()->saveItem ( $item );
				return $this->redirect ()->toRoute ( 'item' );
			}
		}
		return array (
				'form' => $form 
		);
	}
	public function editAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if (! $id) {
			return $this->redirect ()->toRoute ( 'item', array (
					'action' => 'add' 
			) );
		}
		$item = $this->getItemTable ()->getItem ( $id );
		$form = new ItemForm ();
		$form->bind ( $item );
		$form->get ( 'submit' )->setAttribute ( 'value', $this->getTranslator()->translate('edit'));
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->setInputFilter ( $item->getInputFilter () );
			$form->setData ( $request->getPost () );
			
			if ($form->isValid ()) {
				$this->getItemTable ()->saveItem ( $form->getData () );
				
				// Redirect to list of items
				return $this->redirect ()->toRoute ( 'item' );
			}
		}
		
		return array (
				'id' => $id,
				'form' => $form 
		);
	}
	
	public function deleteAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if (! $id) {
			return $this->redirect ()->toRoute ( 'item' );
		}
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$del = $request->getPost ( 'del', 'No' );
			
			if ($del == $this->getTranslator()->translate('yes')) {
				$id = ( int ) $request->getPost ( 'id' );
				$this->getItemTable ()->deleteItem ( $id );
			}
			
			// Redirect to list of items
			return $this->redirect ()->toRoute ( 'item' );
		}
		return array (
				'id' => $id,
				'item' => $this->getItemTable ()->getItem ( $id ) 
		);
	}
	public function getItemTable() {
		if (! $this->itemTable) {
			$sm = $this->getServiceLocator ();
			$this->itemTable = $sm->get ( 'Item\Model\ItemTable' );
		}
		return $this->itemTable;
	}
}
