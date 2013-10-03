<?php

namespace MyApp;

use application\entities\GameEvent;
use application\entities\tables\ChatPings;
use application\entities\tables\ChatRooms;
use application\entities\tables\Users;
use application\entities\User;
use application\entities\Game;
use b2db\Core;
use Ratchet\ConnectionInterface,
    Ratchet\Wamp\WampServerInterface;
use Ratchet\Wamp\Topic;

class Pusher implements WampServerInterface
{

    protected $_clients;
    protected $_users = array();
    protected $_subscribed_topics = array();

    protected $_mailer = null;

    protected function _getMailer()
    {
        if ($this->_mailer === null) {
            require_once CASPAR_LIB_PATH . 'swift/lib/swift_required.php';
            $transport = \Swift_SmtpTransport::newInstance('smtp.domeneshop.no', 587)
                ->setUsername('dragonevo1')
                ->setPassword('sDf47nQ5');
            $this->_mailer = \Swift_Mailer::newInstance($transport);
        }
        return $this->_mailer;
    }

    public function __construct()
    {
        $this->_clients = new \SplObjectStorage();
        echo "----------------------\n";
        echo "Dragon Evo game server\n";
        echo "Version 0.1\n";
        echo "----------------------\n\n";
        echo "[".date('H:m:s')."] Accepting connections\n";
    }

    /**
     * When a new connection is opened it will be passed to this method
     *
     * @param  ConnectionInterface $conn The socket/connection that just connected to your application
     *
     * @throws \Exception
     */
    function onOpen(ConnectionInterface $conn)
    {
        $this->_clients->attach($conn);

        echo "[".date('H:m:s')."] New connection! ({$conn->resourceId})\n";
    }

    /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     *
     * @param  ConnectionInterface $conn The socket/connection that is closing/closed
     *
     * @throws \Exception
     */
    function onClose(ConnectionInterface $conn)
    {
        $this->_clients->detach($conn);
        if (isset($this->_users[$conn->resourceId])) {
            $user_id = $this->_users[$conn->resourceId];
            foreach ($this->_clients as $client) {
                if ($conn !== $client) {
                    $client->event('gamedata', array('topic' => 'user_disconnect', 'data' => array('user_id' => $user_id)));
                }
            }
            ChatPings::getTable()->cleanUserPings($user_id);
        }

        echo "[".date('H:m:s')."] Connection {$conn->resourceId} has disconnected!\n";
    }

    /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     *
     * @param  ConnectionInterface $conn
     * @param  \Exception $e
     *
     * @throws \Exception
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "[".date('H:m:s')."] An error has occured: {$e->getMessage()}\n";
        echo($e->getTraceAsString());

        $conn->close();
    }

    /**
     * An RPC call has been received
     *
     * @param \Ratchet\ConnectionInterface $conn
     * @param string $id     The unique ID of the RPC, required to respond to
     * @param string|Topic $topic  The topic to execute the call against
     * @param array $params Call parameters received from the client
     */
    function onCall(ConnectionInterface $conn, $id, $topic, array $params)
    {
        $conn->callError($id, $topic, 'You are not allowed to make calls')->close();
    }

    /**
     * A request to subscribe to a topic has been made
     *
     * @param \Ratchet\ConnectionInterface $conn
     * @param string|Topic $topic The topic to subscribe to
     */
    function onSubscribe(ConnectionInterface $conn, $topic)
    {
        if (!array_key_exists($topic->getId(), $this->_subscribed_topics)) {
            $this->_subscribed_topics[$topic->getId()] = $topic;
        }
        $topic->add($conn);
    }

    public function onGameData($data)
    {
        $data = json_decode($data, true);

        $category = $data['category'];
        if (isset($data['event'])) {
            switch (true) {
                case (isset($data['event']['topic']) && $data['event']['topic'] == 'new_game_invite'):
                    $eventdata = $data['event']['data'];
                    if (!$this->_isUserOnline($eventdata['invite_user_id'])) {
                        $user = Users::getTable()->selectById($eventdata['invite_user_id']);
                        $this->_sendGameInvite($eventdata['game_id'], $eventdata['player_name'], $user);
                    }
                    break;
                case (isset($data['event']['type']) && $data['event']['type'] == GameEvent::TYPE_REPLENISH):
                    $eventdata = $data['event'];
                    if (!$this->_isUserOnline($eventdata['opponent_id'])) {
                        $user = Users::getTable()->selectById($eventdata['opponent_id']);
                        $this->_sendGameTurnEmail($eventdata['game_id'], $eventdata['player_name'], $user);
                    }
                    break;
            }
        }
        if (!array_key_exists($category, $this->_subscribed_topics)) return;

        $topic = $this->_subscribed_topics[$category];
        $topic->broadcast($data['event']);
    }

    /**
     * A request to unsubscribe from a topic has been made
     *
     * @param \Ratchet\ConnectionInterface $conn
     * @param string|Topic $topic The topic to unsubscribe from
     */
    function onUnSubscribe(ConnectionInterface $conn, $topic)
    {
        // TODO: Implement onUnSubscribe() method.
    }

    function isValidSecret($user_id, $secret)
    {
        $user = Users::getTable()->selectById($user_id);
        return (substr($user->getPassword(), -20) == $secret) ? $user : null;
    }

    protected function _isUserOnline($user_id)
    {
        return in_array($user_id, $this->_users);
    }

    protected function _sendUserData(ConnectionInterface $conn, User $user)
    {
        $userfriends = $user->getUserFriends();
        $friends = array();
        foreach ($userfriends as $userfriend) {
            $friend = ($userfriend->getFriendUser()->getId() == $user->getId()) ? $userfriend->getUser() : $userfriend->getFriendUser();
            $is_online = $this->_isUserOnline($friend->getId());
            $friends[$friend->getId()] = array('user_id' => $friend->getId(), 'username' => $friend->getUsername(), 'charactername' => $friend->getCharactername(), 'accepted' => $userfriend->isAccepted(), 'online' => $is_online);
        }
        $conn->event('userdata-'.$user->getId(), array('topic' => 'initial_data', 'data' => array('friends' => $friends)));
    }

    /**
     * A client is attempting to publish content to a subscribed connections on a URI
     *
     * @param \Ratchet\ConnectionInterface $conn
     * @param string|Topic $topic    The topic the user has attempted to publish to
     * @param string $event    Payload of the publish
     * @param array $exclude  A list of session IDs the message should be excluded from (blacklist)
     * @param array $eligible A list of session Ids the message should be send to (whitelist)
     */
    function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible)
    {
        switch ($topic) {
            case 'identify':
                $user_id = (int) $event['user_id'];
                $user = $this->isValidSecret($user_id, $event['secret']);
                if (!$user instanceof User) {
                    echo "[".date('H:m:s')."] Client failed to identify as user ".$user_id."\n";
                    $conn->close();
                } else {
                    echo "[".date('H:m:s')."] Client successfully identified as user ".$user_id."\n";
                    $this->_users[$conn->resourceId] = $user_id;
                }
                break;
            case 'initialize':
                $user_id = (int) $event['user_id'];
                $user = $this->isValidSecret($user_id, $event['secret']);
                if (!$user instanceof User) {
                    echo "[".date('H:m:s')."] Client not allowed to initialize as user ".$user_id."\n";
                    $conn->close();
                } else {
                    echo "[".date('H:m:s')."] Sending initial data for user ".$user_id."\n";
                    $this->_sendUserData($conn, $user);
                }
                break;
            case 'ping':
                $user_id = (int) $event['user_id'];
                $user = $this->isValidSecret($user_id, $event['secret']);
                if (!$user instanceof User) {
                    echo "[".date('H:m:s')."] Failing to ping as user ".$user_id."\n";
                    $conn->close();
                } else {
                    echo "[".date('H:m:s')."] User ".$user_id." is still here, rooms: ".join(', ', $event['rooms'])."\n";
                    foreach ($event['rooms'] as $room_id) {
                        $room = ChatRooms::getTable()->selectById($room_id);
                        $room->ping($user);
                    }
                }
                break;
            default:
                echo "[".date('H:m:s')."] Someone is publishing to an unknown topic";
                var_dump($topic);
                var_dump($event);
                $conn->close();
        }
    }

    protected function _sendGameInvite($game_id, $player_name, User $user)
    {
        $mailer = $this->_getMailer();
        $message = \Swift_Message::newInstance('New game invitation from '.$player->getCharactername().' ('.$player->getUsername().')');
        $message->setFrom('support@playdragonevo.com', 'The Dragon Evo team');
        $message->setTo($user->getEmail());
        $plain_content = str_replace(array('%username%', '%playername%', '%game_id%'), array($user->getCharactername(), $player_name, $game_id), file_get_contents(CASPAR_MODULES_PATH . 'main' . DS . 'templates' . DS . 'game_invite.txt'));
        $message->setBody($plain_content, 'text/plain');
        $retval = $mailer->send($message);
    }

    protected function _sendGameTurnEmail($game_id, $player_name, User $user)
    {
        $mailer = $this->_getMailer();
        $message = \Swift_Message::newInstance($player->getCharactername().' ('.$player->getUsername().') just finished their turn!');
        $message->setFrom('support@playdragonevo.com', 'The Dragon Evo team');
        $message->setTo($user->getEmail());
        $plain_content = str_replace(array('%username%', '%playername%', '%game_id%'), array($user->getCharactername(), $player_name, $game_id), file_get_contents(CASPAR_MODULES_PATH . 'main' . DS . 'templates' . DS . 'game_turn.txt'));
        $message->setBody($plain_content, 'text/plain');
        $retval = $mailer->send($message);
    }

}
