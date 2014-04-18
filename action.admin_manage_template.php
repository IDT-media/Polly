<?php  
#-------------------------------------------------------------------------
# Module: mBooking - Reservation module
# Version: 1.2
#
#-------------------------------------------------------------------------
#
# Some wackos started destroying stuff since 2014: 
#
# Tapio Löytty, <tapsa@orange-media.fi>
# Web: www.orange-media.fi
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2010 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
#
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
/*
if (!$this->CheckPermission('Modify Templates'))
	return;*/

#---------------------
# Check params
#---------------------

if (isset($params['type'])) {

	$tpl_type = $params['type'];
	$tpl_content = $this->GetTemplateFromFile('samples/' . $tpl_type . '_default');
	$tpl_name = '';

} elseif(isset($params['name'])) {

	list($tpl_type, $tpl_name) = explode('_', $params['name'], 2);
	$tpl_content = $this->GetTemplate($params['name']);
	$params['orig_name'] = $params['name'];

} else {

	throw new Exception('Cant happend');
}

if(isset($params['template_name'])) 
	$tpl_name = $params['template_name'];

if(isset($params['template_text'])) 
	$tpl_content = $params['template_text'];

#---------------------
# Operations
#---------------------

if(isset($params['operation'])) {

	switch($params['operation']) {

		case 'set_default':
			$this->SetPreference('template_default_'.$tpl_type, $tpl_name);	
			$this->SetMessage($this->Lang('default'));
			break;
	
		case 'delete':			
			$this->DeleteTemplate($params['name']);			
			$this->SetMessage($this->Lang('deleted'));
			break;
			
		case 'cancel':
			break;
	}
	
	$this->RedirectToAdminTab('templates', array(), 'defaultadmin');
}

#---------------------
# Submit
#---------------------

if (isset($params['submit']) || isset($params['apply'])) {

	$errors = array();
	
	if (empty($tpl_name)) 
		$errors[] = $this->Lang('error_empty');
	
	if (empty($tpl_content)) 
		$errors[] = $this->Lang('error_empty');

	if (empty($errors)) {
	
		if(isset($params['orig_name'])) {
		
			$this->DeleteTemplate($params['orig_name']);
			list($orig_tpl_type, $orig_tpl_name) = explode('_', $params['orig_name'], 2);
			
			$tpl_default = $this->GetPreference('template_default_'.$tpl_type);
			if($tpl_default == $orig_tpl_name) {
			
				$this->SetPreference('template_default_'.$tpl_type, $tpl_name);
			}			
		}
		
		$this->SetTemplate($tpl_type.'_'.$tpl_name, $tpl_content);
	
		if (!isset($params['apply'])) {
	
			$this->SetMessage($this->Lang('message_changessaved'));
			$this->RedirectToAdminTab('templates', array(), 'defaultadmin');
            
        } else {
            echo $this->ShowMessage($this->Lang('message_changessaved'));
		}
	}
}

#---------------------
# Message control
#---------------------

if (!empty($errors))
	echo $this->ShowErrors($errors);

#---------------------
# Smarty processing
#---------------------   

$smarty->assign('title', isset($params['name']) ? $this->Lang('edit') : $this->Lang('add', $this->Lang($tpl_type.'_template')));
$smarty->assign('startform', $this->CreateFormStart ($id, $name, $returnid, 'post', 'multipart/form-data', false, '', $params));
$smarty->assign('endform', $this->CreateFormEnd());
$smarty->assign('input_template', $this->CreateSyntaxArea($id, $tpl_content, 'template_text'));
$smarty->assign('input_name', $this->CreateInputText($id, 'template_name', $tpl_name, 40));

$templatelist = $this->GetFileTemplatesByType($tpl_type);
$smarty->assign('input_tpl_list', $this->CreateInputDropdown($id, 'template_fromfile', $templatelist));

/*$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('apply', $this->CreateInputSubmit($id, 'apply', lang('apply')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));*/

echo $this->ProcessTemplate('manage_template.tpl');

?>