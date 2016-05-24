<?php namespace Ozziest\Core\Facades;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use App\Models\Notification as Model;
use App\Models\User;
use Exception;

class Notification {

    public function createMultiple($data)
    {
        Model::insert($data);
        foreach ($data as $key => $notification)
        {
            $this->push($notification);
        }
    }
    
    public function setAsRead($id, $recipientId)
    {
        $notification = Model::where('id', $id)
                             ->where('recipient_id', $recipientId)
                             ->firstOrFail();
        $notification->read_at = date('Y-m-d H:i:s');
        $notification->save();
    }
    
    /**
     * This method sends a message to the message layer in order to 
     * create a communication between php and nodejs socket server.
     *
     * @return null
     */
    private function push($notification)
    {
        try 
        {
            $notification['user'] = User::find($notification['sender_id']);
            $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
            $channel = $connection->channel();
            $channel->queue_declare('hello', false, false, false, false);
            $msg = new AMQPMessage(json_encode($notification));
            $channel->basic_publish($msg, '', 'hello');
            $channel->close();
            $connection->close();
        }
        catch (Exception $exception)
        {
            
        }
    }
    
}