<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

class Game {
    public $d_textid = null;
    public $d_gameid = null;
    public $players = [];
    public $title = null;
    public $started = false;
    public $start_time = null;
    
    public function __construct($gameid, $textid, $title) {
        $this->d_textid = $textid;
        $this->d_gameid = $gameid;
        $this->title = $title;
    }

    public function addPlayer($c_uid) {
        $this->players[$c_uid] = "";
    }

    public function removePlayer($c_uid) {
        unset($this->players[$c_uid]);
    }
}

class User {
    public $name = null;
    public $email = null;
    public $appear = false;
    public $conn = null;
    public $d_gameid = null;
    public $status = "waiting";
    public $progress = 0;
    public $duration = 0;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function login($name, $email) {
        $this->appear = true;
        $this->name = $name;
        $this->email = $email;
    }

    public function hasLoggedIn() {
        return $this->appear;
    }

}

class Chat implements MessageComponentInterface {
    protected $clients = [];
    private $games = [];
    private $Users = null;
    private $Texts = null;
    private $Games = null;
    private $AllTexts = [];//dictionary key=id, value=text
    private $AllTextsIds = [];//
    private $timer = 10;

    public function __construct() {
        $dsn = 'mysql://root:a@localhost/ttar';
        ConnectionManager::config('default', ['url' => $dsn]);
        $this->Users = TableRegistry::get('Users');
        $this->Texts = TableRegistry::get('Texts');
        $this->Games = TableRegistry::get('Games');
        $this->loadAllTexts();
    }

    public function loadAllTexts() {
        $qu = $this->Texts->find('all');
        $this->AllTexts = [];
        foreach ($qu as $i) $this->AllTexts[$i->id] = $i->text;
        foreach ($this->AllTexts as $key => $value) {
            $this->AllTextsIds[] = $key;
        }
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients[$conn->resourceId] = new User($conn);
        echo "Connection {$conn->resourceId} has connected\n";
    }

    public function broadcast($c_uid, $msg) {
        $user = $this->clients[$c_uid];
        if ($user->d_gameid == null) {
            $this->clients[$c_uid]->conn->send(json_encode(['broadcast', 'server', 'You need to join a game first.']));
            return ;
        }
        $game = $this->games[$user->d_gameid];
        foreach ($this->games[$user->d_gameid]->players as $c_id => $dummy) {
            $this->clients[$c_id]->conn->send(json_encode(['broadcast', $user->name, $msg]));
        }
    }

    public function getUserList() {
        $r = [];
        foreach ($this->clients as $user) {
            if ($user->hasLoggedIn()) {
                $r[] = [$user->conn->resourceId, $user->name];
            }
        }
        return $r;
    }

    public function getUserProgress($d_gameid) {
        if ($d_gameid == null) echo 'what?';
        $r = [];
        $games = & $this->games[$d_gameid];
        foreach ($games->players as $c_id => $dummy) {
            $name = $this->clients[$c_id]->name;
            $progress = $this->clients[$c_id]->progress;
            $d = $this->clients[$c_id]->duration;
            $status = $this->clients[$c_id]->status;
            $r[] = [
                'name' => $name, 
                'progress' => $progress, 
                'duration' => $d, 
                'status' => $status
            ];
        }
        return $r;
    }

    public function getGameList() {
        $r = [];
        foreach ($this->games as $d_gameid => $game) {
            $delay = 1;
            if (!$game->started || time() < $game->start_time - $delay) {
                $r[] = [$d_gameid, $game->title];
            }
        }
        return $r;
    }

    public function getRandomTextId() {
        srand(time());
        $id = rand(0, count($this->AllTextsIds) - 1);
        $d_id = $this->AllTextsIds[$id];
        return $d_id;
    }

    //returns primary key of the new game created
    public function insertGameIntoDb($c_userid, $d_textid, $title) {
        $email = $this->clients[$c_userid]->email;
        $game = $this->Users->newEntity();
        $game->title = $title;
        $game->created = time();
        $game->text_id = $d_textid;
        $r = $this->Games->save($game);
        return $r->id;
    }

    public function joinGame($c_uid, $d_gameid) {
        if (isset($this->games[$d_gameid]->players[$c_uid])) {
            echo 'already joined';
            return ; //player already joined
        }
        $this->leaveGame($c_uid); //leave any old game
        $user = &$this->clients[$c_uid];
        $user->status = "waiting";
        $user->d_gameid = $d_gameid;
        $d_textid = $this->games[$d_gameid]->d_textid;

        $game = &$this->games[$d_gameid];
        $game->addPlayer($c_uid);

        $user->conn->send(json_encode(['joinGame', $d_gameid, $this->AllTexts[$d_textid]]));

        if (count($game->players) > 1) {
            if (!$game->started) {
                $game->started = true;
                $game->start_time = time() + $this->timer;
                foreach ($game->players as $c_id => $dummy) {
                    if (isset($this->clients[$c_id])) {
                        $this->clients[$c_id]->conn->send(json_encode(['timerStart', $this->timer, $game->start_time]));
                    }
                }
            } else {
                $dur = $game->start_time - time();
                $user->conn->send(json_encode(['timerStart', max(0, $dur), $game->start_time]));
            }
        }
        $this->broadcast($c_uid, ':: joins game');
    }

    public function createNewGame($c_userid, $title) {
        //if inside an old game remove
        $this->leaveGame($c_userid);
        $user = &$this->clients[$c_userid];
        $user->status = "waiting";
        $d_textid = $this->getRandomTextId();
        $d_gameid = $this->insertGameIntoDb($c_userid, $d_textid, $title);
        $this->games[$d_gameid] = new Game($d_gameid, $d_textid, $title);
        $this->joinGame($c_userid, $d_gameid);
        //var_dump($this->games);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $m = json_decode($msg, true);
        $m = (object)$m;
        $user = $this->clients[$from->resourceId];
        switch ($m->type) {
        case 'login':
            $user->login($m->name, $m->email);
            break;
        case 'getUserList':
            $from->send(json_encode(['getUserList', $this->getUserList()]));
            break;
        case 'getUserProgress':
            $from->send(json_encode(['getUserProgress', $this->getUserProgress($this->clients[$from->resourceId]->d_gameid)]));
            break;
        case 'getGameList':
            $from->send(json_encode(['getGameList', $this->getGameList()]));
            break;
        case 'getstatus':
            $from->send(json_encode(['getstatus', $user->status]));
            break;
        case 'finish_game':
            $user->status = "finished";
            $user->duration = time() - $this->games[$user->d_gameid]->start_time;
            $this->broadcast($from->resourceId, ':: finishes game');
            echo 'finished received';
            break;
        case 'progress':
            $user->progress = $m->progress;
            break;
        case 'createNewGame':
            if ($m->title != "") {
                $this->createNewGame($from->resourceId, $m->title);
            }
            break;
        case 'joinGame':
            $this->joinGame($from->resourceId, $m->gameid);
            $user = &$this->clients[$from->resourceId];
            break;
        case 'broadcast':
            $user = &$this->clients[$from->resourceId];
            $this->broadcast($from->resourceId, $m->message);
            break;
        default:
            break;
        }
    }
    
    //make user leave game
    public function leaveGame($c_uid) {
        $usr = & $this->clients[$c_uid];
        $gid = $usr->d_gameid;
        if ($gid != null) {
            $this->games[$gid]->removePlayer($c_uid);
            $this->broadcast($c_uid, ':: leaves game');
            if (count($this->games[$gid]->players) == 0) {
                unset($this->games[$gid]);
            }
            $usr->d_gameid = null;
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $usr = & $this->clients[$conn->resourceId];
        $this->leaveGame($conn->resourceId);
        unset($this->clients[$conn->resourceId]);
        //echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
