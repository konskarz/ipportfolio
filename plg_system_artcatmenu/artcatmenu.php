<?php
defined('_JEXEC') or die('Restricted access');

class plgSystemArtCatMenu extends JPlugin {

	private $data= null;
	private $menutype = null;
	
	function onAfterRoute() {
		if (!isset($_POST['task'])) {
			return;
		}
		if (strpos($_POST['task'], 'plugin.save') !== FALSE 
			|| strpos($_POST['task'], 'plugin.apply') !== FALSE) {
			if (isset($_POST['jform']['element']) 
				&& $_POST['jform']['element'] == $this->_name
				&& isset($_POST['jform']['folder']) 
				&& $_POST['jform']['folder'] == $this->_type) {
				$_SESSION[$this->_name]['apply'] = true;
			}
			return;
		}
		$types = array(
			'categories',
			'category',
			'articles',
			'article'
		);
		$actions = array(
			'save',
			'apply',
			'publish',
			'unpublish',
			'archive',
			'featured',
			'trash',
			'batch',
			'rebuild'
		);
		foreach ($types as $t) {
			foreach ($actions as $a) {
				if (strpos($_POST['task'], $t . '.' . $a) !== FALSE) {
					$data['type'] = (strpos($t, 'categor') !== FALSE) ? 0 : 1;
					$data['id'] = (isset($_POST['jform']['id'])) ? (int) $_POST['jform']['id'] : 0;
					$data['cid'] = (isset($_POST['cid'])) ? $_POST['cid'] : array();
					$_SESSION[$this->_name] = $data;
					break;
				}
			}
		}
	}
	
	function onAfterRender() {
		if (!isset($_SESSION[$this->_name])) {
			return;
		}
		$this->data = (object) $_SESSION[$this->_name];
		unset($_SESSION[$this->_name]);
		
		if (isset($this->data->apply) 
			&& count($this->params->get('catid')) > 0) {
			foreach ($this->params->get('catid') as $catid) {
				$this->menutype = $this->getMenuType($catid);
				if ($this->isNew($this->getMenuTitle($catid))) {
					$this->createMenuItems($catid);
				}
			}
		}
		else if (isset($this->data->cid) 
			&& count($this->data->cid) > 0) {
			foreach ($this->data->cid as $a) {
				$this->data->id = $a;
				$this->updateMenu();
			}
		}
		else if (isset($this->data->id)) {
			$this->updateMenu();
		}
		$table = JTable::getInstance('Menu');
		$table->rebuild();
	}
	
	private function getMenuType($catid) {
		return $catid > 0 ? $this->_name . '-' . $catid : $this->_name;
	}
	
	private function getMenuTitle($catid) {
		return $catid > 0 ? JText::_('JCATEGORY') . ' ' . $catid : JText::_('JCATEGORY');
	}
	
	private function getMenuItemLink($id) {
		return 'index.php?option=com_content&view=article&id=' . $id;
	}
	
	private function getContentFields() {
		return array(
				'id',
				'title',
				'alias',
				'access',
				'state',
				'catid',
				'language'
			);
	}
	
	private function isNew($title) {
		$table = JTable::getInstance('MenuType');
		$data = array(
			'menutype' => $this->menutype,
			'title' => $title
		);
		if ($table->load($data)) {
			return false;
		}
		$table->save($data);
		return true;
	}
	
	private function createMenuItems($catid) {
		$db = JFactory::getDBO();
		$query = $db->getQuery(true)
			->select($this->getContentFields())
			->from($db->quoteName('#__content'))
			->where($db->quoteName('catid') . ' = ' . $db->quote($catid));
		$db->setQuery($query);
		$articles = $db->loadAssocList('id');
		foreach ($articles as $a) {
			$menu_id = $this->createMenuItem($a['id']);
			$this->updateMenuItem($menu_id, $a);
		}
	}
	
	private function createMenuItem($id) {		
		$table = JTable::getInstance('Menu');
		$data = array(
			'menutype' => $this->menutype,
			'alias' => microtime(),
			'link' => $this->getMenuItemLink($id),
			'type' => 'component',
			'level' => 1,
			'component_id' => 22
		);
		$table->save($data);
		return $table->id;
	}
	
	private function updateMenuItem($menu_id, $a) {
		$table = JTable::getInstance('Menu');
		$data = array(
			'id' => $menu_id,
			'title' => $a['title'],
			'alias' => $this->getMenuItemAlias($a['alias'], $menu_id),
			'published' => $a['state'],
			'parent_id' => $table->getRootId(),
			'access' => $a['access'],
			'language' => $a['language']
		);
		$table->bind($data);
		$table->store();
	}
	
	private function getMenuItemAlias($alias, $id) {
		$db = JFactory::getDBO();
		$origalias = $alias;
		for ($i = 1; ; $i++) {
			$query = $db->getQuery(true)
				->select($db->quoteName('id'))
				->from($db->quoteName('#__menu'))
				->where($db->quoteName('alias') . ' = ' . $db->quote($alias) . 
					' AND ' . $db->quoteName('id') . ' != ' . $db->quote($id));
			$db->setQuery($query);
			$column = $db->loadColumn();
			if (!isset($column[0])) {
				return $alias;
			}
			$alias = $origalias . '-' . $i;
		}
	}
	
	private function updateMenu() {
		if ($this->data->type !== 1 || $this->data->id < 1) {
			return;
		}
		$db = JFactory::getDBO();
		$query = $db->getQuery(true)
			->select($this->getContentFields())
			->from($db->quoteName('#__content'))
			->where($db->quoteName('id') . ' = ' . $db->quote($this->data->id));
		$db->setQuery($query);
		$a = $db->loadAssoc();
		$this->menutype = $this->getMenuType($a['catid']);
		$menu_id = $this->getMenuItemId($a['id']);
		if ($menu_id == 0) {
			$menu_id = $this->createMenuItem($a['id']);
		}
		$this->updateMenuItem($menu_id, $a);
	}
	
	private function getMenuItemId($id) {
		$table = JTable::getInstance('Menu');
		$data = array(
			'menutype' => $this->menutype,
			'link' => $this->getMenuItemLink($id)
		);
		return $table->load($data) ? $table->id : 0;
	}
	
}