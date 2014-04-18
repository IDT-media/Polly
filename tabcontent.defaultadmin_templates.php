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
# Init items
#---------------------

$templates = $this->ListTemplates();
$items = array();
$addlinks = array();

foreach ($templates as $template) {

	list($tpl_type, $tpl_name) = explode('_', $template, 2);

    $onerow = new stdClass();

    $onerow->link   = $this->CreateLink($id, 'admin_manage_template', $returnid, $tpl_name, array('name' => $template));
    $onerow->name   = $tpl_name;
    $onerow->delete = $this->CreateLink($id, 'admin_manage_template', $returnid, $admintheme->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('operation' => 'delete', 'name' => $template));
    $onerow->edit   = $this->CreateLink($id, 'admin_manage_template', $returnid, $admintheme->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array('name' => $template));

	$tpl_default = $this->GetPreference('template_default_'.$tpl_type);
	
	if($tpl_default == $tpl_name) {

		$onerow->default = $admintheme->DisplayImage('icons/system/true.gif', $this->Lang('is_default'),'','','systemicon');		
		unset($onerow->delete); // <- Disable delete button
		
	} else {
	
		$onerow->default = $this->CreateLink($id,'admin_manage_template',$returnid,
						$admintheme->DisplayImage('icons/system/false.gif',$this->Lang('status_default'),'','','systemicon'),array('operation' => 'set_default', 'name' => $template));
	}	
	
    $items[$tpl_type][] = $onerow;
	
	if(!isset($addlinks[$tpl_type]))
		$addlinks[$tpl_type] = $this->CreateLink($id, 'admin_manage_template', $returnid, $this->Lang('add') .' '. $this->Lang($tpl_type) .' '. $this->Lang('template'), array('type' => $tpl_type));
}

ksort($items);

#---------------------
# Smarty processing
#---------------------

$smarty->assign('items', $items);
$smarty->assign('addlinks', $addlinks);

echo $this->ProcessTemplate('template_tab.tpl');
?>