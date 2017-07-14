<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
require_once(__DIR__.'/db/pdo.php');
require_once(__DIR__.'/inc/functions.php');

class chatclass implements  MessageComponentInterface
{
    private $clients;

	private $db;

	public function __construct()
	{
        $this->clients    = array();
        $this->db         = new as_database();
        $this->func       = new assetfunc();

	}

	public function onOpen(ConnectionInterface $conn){
        // Store the new connection to send messages to later
        $cur_time   = time();
        $resourceId = $conn->resourceId;
        $user_id    = $conn->WebSocket->request->getCookies()['user_id'];

        /*$this->db->as_insert('message', array(
                'msg_text' => $resourceId,
                'user_id' => $user_id,
                'cur_time' => $cur_time
            ));*/

        $this->clients[$conn->resourceId] = array(
                'user_id'       => $user_id, 
                'resourceId'    => $resourceId, 
                'conn'          => $conn
            );
	}

    public function onMessage(ConnectionInterface $from, $msg) {

        $cur_time   = time();
        $resourceId = $from->resourceId;
        $user_id    = $from->WebSocket->request->getCookies()['user_id'];
        $total_msg  = json_decode($msg);
        $user_to_id = (int)$total_msg->user_to_id;
        $full_msg   = $total_msg->msg;
        $type       = $total_msg->type;
        $usemeta_image    = $this->func->get_user_meta($user_id, 'user_profile_poc', true);
        $sender_info      = $this->func->get_user($user_id);
        $usemeta_name      = $sender_info['display_name'];
        $user_image = $this->func->get_image_by_size((int)$usemeta_image, 'override_gravater');
       // print_r(json_decode($msg));
        if ($type == 'chat') {
            foreach ($this->clients as $client) {
                if ($client['resourceId'] != $from->resourceId) {
                    if ($client['user_id'] == $user_to_id || $client['user_id'] == $user_id) {
                        $total_msg  = array(
                            'type'          => 'chat', 
                            'message'       => $full_msg, 
                            'msg_form'      => $user_id,
                            'msg_to'        => $user_to_id,
                            'user_image'    => $user_image,
                            'usemeta_name'    => $usemeta_name,
                             );
                        //print_r($total_msg);
                        $total_msg = json_encode($total_msg);
                        $client['conn']->send($total_msg);
                    }
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
    	unset($this->clients[$conn->resourceId]);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
    	echo 'some error' . $e->getMessage();
    	$conn->close();
    }




}