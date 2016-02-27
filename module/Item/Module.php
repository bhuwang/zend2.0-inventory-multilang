<?php

namespace Item;

use Item\Model\Item;
use Item\Model\ItemTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module {
	public function getAutoloaderConfig() {
	}
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}
	public function getServiceConfig() {
		return array (
				'factories' => array (
						'Item\Model\ItemTable' => function ($sm) {
							$tableGateway = $sm->get ( 'ItemTableGateway' );
							$table = new ItemTable ( $tableGateway );
							return $table;
						},
						'ItemTableGateway' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							$resultSetPrototype = new ResultSet ();
							$resultSetPrototype->setArrayObjectPrototype ( new Item () );
							return new TableGateway ( 'item', $dbAdapter, null, $resultSetPrototype );
						} 
				) 
		);
	}
}
