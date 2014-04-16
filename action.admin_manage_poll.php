<?php
#-------------------------------------------------------------------------
# Module: Notifications
# Version: 1.1
#-------------------------------------------------------------------------
#
# Copyright:
#
# IDT Media - Goran Ilic & Tapio Löytty
# Web: www.idt-media.com
# Email: hi@idt-media.com
#
#
# Authors:
#
# Goran Ilic, <ja@ich-mach-das.at>
# Web: www.ich-mach-das.at
# 
# Tapio Löytty, <tapsa@orange-media.fi>
# Web: www.orange-media.fi
#
# License:
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------

if (!is_object(cmsms())) exit;

#---------------------
# Init params
#---------------------

if(isset($params['cancel'])) {

	$this->RedirectToAdminTab('main', array(), 'defaultadmin');
}

$item 					= (int)polly_utils::init_var('item', $params, null);
$title 					= (string)polly_utils::init_var('title', $params, '');
$options 				= (string)polly_utils::init_var('options', $params, '');

#---------------------
# Init object
#---------------------

$obj = new PollyItem;
PollyOperations::Load($obj, $item);

//print_r($obj->options);

#---------------------
# Submit or Apply
#---------------------

if(isset($params['submit']) || isset($params['apply'])) {

	$errors = array();
	
	if(empty($title)) 
		$errors[] = $this->Lang('error_fieldempty', $this->Lang('name'));
	
	if(empty($errors)) {
	
		// Fill static
		$obj->name 			= $title;
		$obj->options		= array(); // <- Reset, might be dangerous, check this.
		
		//print_r(json_decode(urldecode($options)));die;
		$options_array = json_decode(urldecode($options));
		foreach($options_array as $option_raw) {
		
			$option = new PollyOption;
			
			$option->id 		= (int)$option_raw->id;
			$option->data 		= (string)$option_raw->data;
			$option->position 	= (int)$option_raw->position;
			
			$obj->options[] = $option;
		}
		
		// Save object
		PollyOperations::Save($obj);
		
		if(isset($params['submit'])) {
		
			$this->SetMessage($this->Lang('message_changessaved'));
			$this->RedirectToAdminTab('main', array(), 'defaultadmin');			
			
		} else {
		
			echo $this->ShowMessage($this->Lang('message_changessaved'));
		}
	} 
		
} 
elseif($obj->id > 0) {

	$title 				= $obj->name;
}

#---------------------
# Message control
#---------------------

if (!empty($errors))
	echo $this->ShowErrors($errors);

#---------------------
# Smarty processing
#---------------------

if(isset($obj))
	$smarty->assign('item', $obj);

$smarty->assign('startform', $this->CreateFormStart ($id, $name, $returnid, 'post', 'multipart/form-data', false, '', $params));
$smarty->assign('endform', $this->CreateFormEnd ());

$smarty->assign('input_name',$this->CreateInputText($id, 'title', $title, 50));

echo $this->ProcessTemplate('manage_poll.tpl');

?>