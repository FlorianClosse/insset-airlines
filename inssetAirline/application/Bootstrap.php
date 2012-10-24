<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

  public function run()
	{
		parent::run();
	}
	
	protected function _initConfig()
	{
		Zend_Registry::set('configs', new Zend_Config($this->getOptions()));
	}
	
	protected function _initSession()
	{
		$session = new Zend_Session_Namespace('inssetAirline', true);
		return $session;
	}
	
	// 	protected function _initDb()
	// 	{
	// 		$db = Zend_Db::factory(Zend_Registry::get('config')->database);
	// 		Zend_Registry::set('db', $db);
	// 	}
}


