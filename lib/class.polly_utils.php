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

class polly_utils
{
	private function __construct() {}

	final static public function init_var($string, &$params, $default = '') 
	{
		$var = $default;
		if(isset($params[$string])) {

			$var = $params[$string];
		}
		
		return $var;
	}
	
	final static public function generate_hash($text = 'answer')
	{
		$text .= cms_utils::get_real_ip();
		$text .= @session_id();
		$text .= time();
		$text .= dirname(__FILE__);
		$text .= rand(1,404);
	
		$text = md5($text);
		$text = substr($text, 0, 16);
		
		return $text;
	}	
	
} // end of class
?>