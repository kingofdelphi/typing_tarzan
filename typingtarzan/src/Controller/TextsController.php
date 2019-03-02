<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Bookmarks Controller
 *
 * @property \App\Model\Table\BookmarksTable $Bookmarks
 */
class TextsController extends AppController
{
    public function initialize() {
        parent::initialize();
    }

    public function isLoggedIn() {
        $session = $this->request->session();
        if (!$session->check('user')) 
            return $this->redirect(['action' => 'index', 'controller' => 'Users']);
    }

    public function index() {
        $this->isLoggedIn();
        $texts = $this->Texts->find('all');
        $this->set(compact('texts'));
        $load = false;
        if ($this->request->is('post')) { 
            $load = true;
            $sel = $this->request->data['choice'];
            $txt = $this->Texts->get($sel);
            $this->set(compact('sel'));
            $this->set(compact('txt'));
        }
        $this->set(compact('load'));
        $this->render('typer');
    }

    public function delete($id) {
        $this->Flash->success('Your article has been updated.');
        return $this->redirect(['action' => 'index']);
    }

}
