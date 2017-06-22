<?php
/**
 * Anlprz
 *
 * @category   Anlprz
 * @package    Anlprz_Contactsus
 * @author     Anil Prajapati <anilprz3@gmail.com>
 * @copyright  Copyright (c) 2015.
 */

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('contactsusemail')};

CREATE TABLE IF NOT EXISTS {$this->getTable('contactsusemail')} (
  `contactemails_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(300) NOT NULL,
  `message` text NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(`contactemails_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

");

$installer->endSetup(); 