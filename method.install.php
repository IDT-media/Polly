<?php
#-------------------------------------------------------------------------
# Module: Polly
# Version: 1.0
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

//$config = cmsms()->GetConfig();

#---------------------
# Database tables
#---------------------

$dict = NewDataDictionary($db);
$taboptarray = array('mysql' => 'TYPE=MyISAM');

# Item table
$flds = "
	id I KEY AUTO,
	name C(255),
	alias C(255),
	create_date DT,
	modified_date DT
";
$sqlarray = $dict->CreateTableSQL(POLLY_DB_TABLE_POLLY, $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

# Event table
$flds = "
	id I KEY AUTO,
	polly_id I,
	type C(255),
	data X,	
	position I,
	create_date DT,
	modified_date DT	
";
$sqlarray = $dict->CreateTableSQL(POLLY_DB_TABLE_QUESTIONS, $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

# Attributes table
$flds = "
	hash C(255) KEY,
	question_id I KEY,
	ip C(255),
	user_info C(255),
	timestamp DT	
";
$sqlarray = $dict->CreateTableSQL(POLLY_DB_TABLE_ANSWERS, $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

#---------------------
# Preferences
#---------------------

$this->SetPreference('adminsection', 'extensions');

#---------------------
# Permissions
#---------------------

$this->CreatePermission($this->GetName() . '_manage_polly', $this->GetName() . ': Manage polly');
$this->CreatePermission($this->GetName() . '_modify_options', $this->GetName() . ': Modify Options');

#---------------------
# Smarty
#---------------------

$this->RegisterModulePlugin(true);
