<?php
#-------------------------------------------------------------------------
# Module: Polly
# Version: 1.0
#-------------------------------------------------------------------------
#
# Copyright:
#
# IDT Media - Goran Ilic & Tapio L�ytty
# Web: www.idt-media.com
# Email: hi@idt-media.com
#
#
# Authors:
#
# Goran Ilic, <ja@ich-mach-das.at>
# Web: www.ich-mach-das.at
# 
# Tapio L�ytty, <tapsa@orange-media.fi>
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
# Database
#---------------------

$dict = NewDataDictionary($db);

$sqlarray = $dict->DropTableSQL(POLLY_DB_TABLE_POLLY);
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->DropTableSQL(POLLY_DB_TABLE_OPTIONS);
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->DropTableSQL(POLLY_DB_TABLE_ANSWERS);
$dict->ExecuteSQLArray($sqlarray);

#---------------------
# Templates
#---------------------	

$this->DeleteTemplate();

#---------------------
# Preferences
#---------------------

$this->RemovePreference();

#---------------------
# Permissions
#---------------------

$this->RemovePermission($this->GetName() . '_manage_polly');
$this->RemovePermission($this->GetName() . '_modify_options');

#---------------------
# Smarty
#---------------------

$this->RemoveSmartyPlugin();