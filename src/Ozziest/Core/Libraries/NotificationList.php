<?php namespace Ozziest\Core\Libraries;

use Notification;
use Exception;

class NotificationList {
    
    private $senderId;
    private $objectId;
    private $objectType;
    private $recipientIds;
    private $data;
    
    public function __construct($senderId, $objectId = null, $objectType = null)
    {
        $this->senderId       = $senderId;
        $this->objectId       = $objectId;
        $this->objectType     = $objectType;
        $this->data           = array();
        $this->recipientIds   = array();
    }
    
    public function add($recipientId)
    {
        if (in_array($recipientId, $this->recipientIds) === false)// && $recipientId !== $this->senderId)
        {
            array_push($this->recipientIds, $recipientId);
            array_push($this->data, [
                'sender_id'    => $this->senderId,
                'recipient_id' => $recipientId,
                'object_id'    => $this->objectId,
                'object_type'  => $this->objectType,
            ]);
        }
    }
    
    public function push()
    {
        if (count($this->data) > 0)
        {
            Notification::createMultiple($this->data);
        }
    }
    
}