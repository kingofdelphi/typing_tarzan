<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Bookmarks Controller
 *
 * @property \App\Model\Table\BookmarksTable $Bookmarks
 */
class UsersController extends AppController
{
    public function initialize() {
        parent::initialize();
    }

    public function loadInfo() {
        $s = $this->request->session();
        $email = $s->read('user')[0];
        $name = $s->read('user')[1];
        $this->set('userinfo', [$email, $name]);
        $this->render('loadInfo');
    }

    public function checkemail($email) {
        $ems = $this->Users->find('all')->where(['email =' => $email]);
        $found = $ems->count();
        $this->set('stat', $found);
        $this->render('emailcheck');
    }

    public function signup() {
        $this->isLoggedIn();
        $this->render('signup');
    }

    public function validateAccount($email) {
        $this->isLoggedIn();
        $valid = false;
        if ($this->request->is('post')) {
            $code = $this->request->data['vcode'];
            $ems = $this->Users->find('all')->where(['email =' => $email]);
            $usr = null;
            foreach ($ems as $user) { 
                $usr = $user;
                $vcode = $user->validation_code;
                $valid = $user->validation_code == $code;
                $this->set(compact('code'));
                $this->set(compact('vcode'));
                break;
            }
            if ($valid) {
                $usr->validated = 1;
                $this->Users->save($usr);
                $this->makeUserLogin($email);
            } else $this->set('invalid', true);
        }
        $this->set(compact('email'));
        $this->render('validate');
    }

    public function makeUserLogin($email) {
        $session = $this->request->session();
        $ems = $this->Users->find('all')->where(['email =' => $email]);
        $name = "";
        foreach ($ems as $user) { 
            $name = $user->username;
            break;
        }
        $session->write('user', [$email, $name]);
        return $this->redirect(['action' => 'index', 'controller' => 'Texts']);
    }

    public function loginVerify() {
        $this->isLoggedIn();
        if (!$this->request->is('post')) return $this->redirect(['action' => 'login']);
        $password = $this->blurPassword($this->request->data['pwd1']);
        $email = $this->request->data['email'];
        $ems = $this->Users->find('all')->where(['email =' => $email]);
        $found = $ems->count();
        $valid = true;
        $validated = false;
        if ($found == 0) {
            $valid = false;
        } else {
            foreach ($ems as $user) { 
                if ($user->hash != $password) $valid = false;
                $validated = $user->validated;
                break;//$ems will contain only one user
            }
        }
        if ($valid) {
            if (!$validated) return $this->redirect(['action' => 'validateAccount', $email]);
            return $this->makeUserLogin($email);
        } else {
            $this->set('invalid', true);
            $this->render('login');
        }
    }
    
    public function logout() {
        $session = $this->request->session();
        $session->delete('user');
        $this->render('login');
        $this->redirect(['action' => 'index', 'controller' => 'Users']);
    }

    public function login() {
        $this->isLoggedIn();
        $this->render('login');
    }


    public function isLoggedIn() {
        $session = $this->request->session();
        if ($session->check('user')) $this->redirect(['action' => 'index', 'controller' => 'Texts']);
    }

    public function index() {
        $this->isLoggedIn();
        $this->render('homepage');
    }

    public function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function smtpmailer($to, $from, $from_name, $subject, $body) { 
        //echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n";
        define('GUSER', 'kingofdelphi1992@gmail.com'); // GMail username
        define('GPWD', 'CodeCracker1234'); // GMail password
        require_once "../vendor/autoload.php";
        $error = "";
        $mail = new \PHPMailer();  // create a new object
        $mail->SMTPDebug = 8;
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true;  // authentication enabled
        $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587; 
        $mail->Username = GUSER;  
        $mail->Password = GPWD;           
        $mail->SetFrom($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($to);
        $mail->IsHTML(true);
        if(!$mail->Send()) {
            $error = 'Mail error: '.$mail->ErrorInfo; 
            return false;
        } else {
            $error = 'Message sent!';
            return true;
        }
    }
    
    public function sendVerification($user, $to, $password, $validation_code) {
        $msg = <<<htm
        <div style='font-size:20px'>
        Your verification code is <span style='background-color:black;color:white'>$validation_code</span>
        <br>
        Login with your email address and password and enter the activation code
        </div>
htm;
        return $this->smtpmailer($to, 'kingofdelphi1992@mail.com', 'Vector Softs', 'Typing Tarzan Verification', $msg);
    }

    public function blurPassword($s) {
        return hash("sha256", $s);
    }

    public function success() {
        $this->isLoggedIn();
        $this->Render('success');
    }

    public function newaccount() {
        $this->isLoggedIn();
        if ($this->request->is('post')) {
            $email = $this->request->data['email'];
            $password = $this->request->data['pwd1'];
            $display = $this->request->data['username'];
            $rnd = $this->generateRandomString(); 
            $mstat = $this->sendVerification($display, $email, $password, $rnd);
            if ($mstat) {
                $user = $this->Users->newEntity();
                $user->email = $email;
                $user->hash = $this->blurPassword($password);
                $user->username = $display;
                $user->validated = false;
                $user->validation_code = $rnd;
                $this->Users->save($user);
                return $this->redirect(['action' => 'success']);
            } else {
                die('error occurred');
            }
        } else return $this->redirect(['action' => 'signup']);
    }
}
