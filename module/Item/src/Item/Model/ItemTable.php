<?php
namespace Item\Model;

use Zend\Db\TableGateway\TableGateway;

class ItemTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getItem($item_id)
    {
        $item_id  = (int) $item_id;
        $rowset = $this->tableGateway->select(array('item_id' => $item_id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $item_id");
        }
        return $row;
    }

    public function saveItem(Item $item)
    {
        $data = array(
            'name' => $item->name,
            'description'  => $item->description,
        	'status'  => $item->status,
        );

        $item_id = (int)$item->item_id;
        if ($item_id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getItem($item_id)) {
                $this->tableGateway->update($data, array('item_id' => $item_id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteItem($item_id)
    {
        $this->tableGateway->delete(array('item_id' => $item_id));
    }
}