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

class PollyOperations
{
	#---------------------
	# Magic methods
	#---------------------		
	
	private function __construct() {}
	
	#---------------------
	# Database methods
	#---------------------	
	
	static final public function Save(&$obj)
	{
		$db = cmsms()->GetDb();
	
		// Item routines
		if ($obj->id > 0) {
		
			$query = "UPDATE ".POLLY_DB_TABLE_POLLY." SET 
				name = ?, 
				alias = ?,
				modified_date = NOW() 
				WHERE id = ?";
			
			$dbresult = $db->Execute($query, array(
				$obj->name, 
				$obj->alias, 
				$obj->id
			));
			
		} else {

			$query = "INSERT INTO ".POLLY_DB_TABLE_POLLY." (
				name, 
				alias,
				create_date, 
				modified_date
				) VALUES (?,?,NOW(),NOW())";
			
			$dbresult = $db->Execute($query, array(
				$obj->name, 
				$obj->alias,
			));
			
			$obj->id = $db->Insert_ID();
		}
		
		// Question routines
		$insert = "INSERT INTO ".POLLY_DB_TABLE_QUESTIONS." (type, data, create_date, modified_date, polly_id) VALUES (?,?,NOW(),NOW(),?)";
		$update = "UPDATE ".POLLY_DB_TABLE_QUESTIONS." SET type = ?, data = ?, modified_date = NOW(), polly_id = ? WHERE id = ?";
		foreach($obj->questions as $question) {
		
			if($question->id > 0)
				$dbresult = $db->Execute($update, array($question->type, $question->data, $obj->id, $question->id,));
			else
				$dbresult = $db->Execute($insert, array($question->type, $question->data, $obj->id));
			
			if (!$dbresult) 
				die('FATAL SQL ERROR: ' . $db->ErrorMsg() . '<br/>QUERY: ' . $db->sql);			
		}		

		return true;
	}

	static final public function Delete($id)
	{
		$db = cmsms()->GetDb();

		// Delete from items
		$query = "DELETE FROM ".POLLY_DB_TABLE_POLLY." WHERE id = ?";
		$db->Execute($query, array($id));

		$query = "SELECT id FROM ".POLLY_DB_TABLE_QUESTIONS." WHERE polly_id = ?";
		$question_id = $db->GetCol($query, array($id));			
		
		// Delete from events
		$query = "DELETE FROM ".POLLY_DB_TABLE_QUESTIONS." WHERE polly_id = ?";	
		$db->Execute($query, array($id));
		
		// Delete from attributes
		$query = "DELETE FROM ".POLLY_DB_TABLE_ANSWERS." WHERE question_id IN (". implode(',', $question_id) .")";	
		$db->Execute($query);
									
		return true;
	}
	
	static final public function Load(&$obj, $id, $full = true)
	{
		$db = cmsms()->GetDb();

		$query = "SELECT * FROM ".POLLY_DB_TABLE_POLLY." WHERE id = ?";
		$row = $db->GetRow($query, array($id));

		if ($row) {
		
			// Set static
			$obj->id 			= $row['id'];
			$obj->name 			= $row['name'];
			$obj->alias 		= $row['alias'];
			$obj->created 		= $row['create_date'];
			$obj->modified 		= $row['modified_date'];
		
			if($full) {
			
				// Question routines
				$query = 'SELECT * FROM '.POLLY_DB_TABLE_QUESTIONS.' WHERE polly_id = ?';
				$dbr = $db->Execute($query, array($obj->id));
				
				while($dbr && !$dbr->EOF) {
				
					$question = new PollyQuestion;
					
					$question->id 		= $dbr->fields['id'];
					$question->type 	= $dbr->fields['type'];
					$question->data 	= $dbr->fields['data'];
					
					$obj->questions[] = $question;
				
					$dbr->MoveNext();
				}		

				if($dbr) 
					$dbr->Close();				
						
			}
						
			return true;
		}

		return FALSE;
	}	

	
} // end of class

?>