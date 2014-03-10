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
# Process list
#---------------------

$items = $this->GetItems(false);

foreach($items as $item) {

	$item->name = $this->CreateLink($id, 'admin_manage_poll', $returnid, $item->name, array('item'=>$item->id));
	$item->editlink = $this->CreateLink($id, 'admin_manage_poll', $returnid, cmsms()->get_variable('admintheme')->DisplayImage('icons/system/edit.gif', $this->Lang('edit'),'','','systemicon'), array('item'=>$item->id));
	$item->deletelink = $this->CreateLink($id, 'admin_delete_poll', $returnid, cmsms()->get_variable('admintheme')->DisplayImage('icons/system/delete.gif', $this->Lang('delete'),'','','systemicon'), array('item'=>$item->id), $this->Lang('are_you_sure'));	
}

#---------------------
# Smarty processing
#---------------------

$smarty->assign('items', $items);
$smarty->assign('add_item', $this->CreateLink($id, 'admin_manage_poll', $returnid, $this->Lang('sub_add', $this->Lang('poll')), array()));
													
echo $this->ProcessTemplate('main_tab.tpl');

?>