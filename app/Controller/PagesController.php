<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       Cake.Controller
 * @link http://book.cakephp.org/view/958/The-Pages-Controller
 */
class PagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Pages';

/**
 * Default helper
 *
 * @var array
 */
	public $helpers = array('Html', 'Session', 'Geocode', 'Markdown', 'FacebookGraph');

    function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('*');
	}
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 */
	public function display() {
		$path = func_get_args();
		
		$count = count($path);
		if (!$count) {
            if(!empty($_GET['id'])) {
                // for jeditable request
                $path[0] = $this->parseEntityId($_GET['id']);
                $this->set('onlyMarkdown', true);
                if(!empty($_GET['name'])) {
                    $this->set('field', 'name');
                } else $this->set('field', 'content');
            } else {
                $this->redirect('/');
            }
		}
		
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
            if($page === 'edit') {
                return $this->edit();
            }
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		if($page === 'resources') {
			$this->set('pages', $this->Page->findAllBySection('resources', array('id', 'name')));
		}
		
		$dynamicPage = $this->Page->findById($page);
		
		if(!$dynamicPage) {
			$this->set(compact('page', 'subpage', 'title_for_layout'));
			$this->render(implode('/', $path));
		} else {
			$this->set('page', $dynamicPage);
			$this->set('title_for_layout', $dynamicPage['Page']['name']);
		}
	}

	public function edit() {
        $this->isAuthorized(Configure::read('Privilege.Page.edit'));
        $this->Page->id = $this->parseEntityId($this->request->data['id']);
        if(!empty($this->request->data['value'])) {
            $this->Page->saveField('content', $this->request->data['value']);
            $this->set('content', $this->request->data['value']);
        } else if(!empty($this->request->data['name'])) {
            $this->Page->saveField('name', $this->request->data['name']);
            $this->set('content', $this->request->data['name']);
        }

        $this->render('edit');
	}
	
	private function parseEntityId($id) {
	   $id = str_replace('page-resource-', '', $id);
       $id = str_replace('title-', '', $id);
       return $id;
	}
}
