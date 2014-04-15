<?php
#-------------------------------------------------------------------------
# Module: Mail Plate
# Version: 1.0
#-------------------------------------------------------------------------
#
# Copyright:
#
# Tapio Löytty
# Web: www.orange-media.fi
# Email: tapsa@orange-media.fi
#
#-------------------------------------------------------------------------
#
# License:
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

namespace Polly;
 
 /**
 * IDT Class
 *
 * @package IDT Media modules
 * @author Tapio Löytty
 * @version 1.0
 */
class ModuleExtensions
{
	#---------------------
	# Magic methods
	#---------------------		
	
	private function __construct() {}
	
	#---------------------
	# IDT
	#---------------------		
	
	static public function IDTHelp(&$mod)
	{
		return IDT::getModuleHelp();
	}
	
	#---------------------
	# Module methods
	#---------------------		
	
	static public function addCSS(&$mod)
	{
		$config = cmsms()->GetConfig();
		$smarty = cmsms()->GetSmarty();
		
		$themeObject = \cms_utils::get_theme_object();
		$theme_url = $config['root_url'].'/'.$config['admin_dir']."/themes/".$themeObject->themeName;
		$smarty->assignByRef('themeObject', $themeObject);
		$smarty->assign('theme_url', $theme_url);
		$smarty->assign('module_url', $mod->GetModuleURLPath());
		
		$left_delim = $smarty->left_delimiter;
		$right_delim = $smarty->right_delimiter;
		
		$smarty->left_delimiter = "[[";
		$smarty->right_delimiter = "]]";	
	
		$output = '';
		$css_path  = cms_join_path($mod->GetModulePath(),'lib','css', strtolower($mod->GetName()) . '-*.css');		
		foreach(glob($css_path) as $file) {
		
			$css = @file_get_contents($file);
			$output .= $smarty->fetch('string:'.$css);
		}
			
		$smarty->left_delimiter = $left_delim;
		$smarty->right_delimiter = $right_delim;					
			
		return $output;
	}
	
} // end of class
?>