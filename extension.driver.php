<?php
Class extension_statusfield extends Extension
{
	// About this extension:
	public function about()
	{
		return array(
			'name' => 'Field: Status',
			'version' => '0.1',
			'release-date' => '2010-10-20',
			'author' => array(
				'name' => 'Giel Berkers',
				'website' => 'http://www.gielberkers.com',
				'email' => 'info@gielberkers.com'),
			'description' => 'Store the status and hold a history of previous statusses.'
		);
	}
	
	// Set the delegates:
	public function getSubscribedDelegates()
	{
		return array(
			array(
				'page' => '/backend/',
				'delegate' => 'InitaliseAdminPageHead',
				'callback' => 'initialiseHead'
			),
		);
	}
	
	public function initialiseHead($context)
	{
		Administration::instance()->Page->addScriptToHead(URL . '/extensions/statusfield/assets/statusfield.js', 101, false);
		Administration::instance()->Page->addStylesheetToHead(URL . '/extensions/statusfield/assets/statusfield.css', 'screen', 101, false);
	}
	
	public function uninstall()
	{
		Symphony::Database()->query("DROP TABLE `tbl_fields_status`");
		Symphony::Database()->query("DROP TABLE `tbl_fields_status_statusses`");
	}

	public function install()
	{
		Symphony::Database()->query("CREATE TABLE `tbl_fields_status` (
			`id` int(11) unsigned NOT NULL auto_increment,
			`field_id` int(11) unsigned NOT NULL,
			`options` TEXT default NULL,
			`valid_until` TINYTEXT default NULL,
			PRIMARY KEY  (`id`),
			UNIQUE KEY `field_id` (`field_id`)
		)");
		Symphony::Database()->query("CREATE TABLE `tbl_fields_status_statusses` (
			`id` int(11) unsigned NOT NULL auto_increment,
			`field_id` int(11) unsigned NOT NULL,
			`entry_id` int(11) unsigned NOT NULL,
			`date` DATE,
			`status` TEXT,
			`valid_until` DATE,
			PRIMARY KEY  (`id`)
		)");
	}
}
