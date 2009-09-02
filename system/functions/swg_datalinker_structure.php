<?php
//j// BOF

/*n// NOTE
----------------------------------------------------------------------------
secured WebGine
net-based application engine
----------------------------------------------------------------------------
(C) direct Netware Group - All rights reserved
http://www.direct-netware.de/redirect.php?swg

The following license agreement remains valid unless any additions or
changes are being made by direct Netware Group in a written form.

This program is free software; you can redistribute it and/or modify it
under the terms of the GNU General Public License as published by the
Free Software Foundation; either version 2 of the License, or (at your
option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT
ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
more details.

You should have received a copy of the GNU General Public License along with
this program; if not, write to the Free Software Foundation, Inc.,
59 Temple Place, Suite 330, Boston, MA 02111-1307, USA.
----------------------------------------------------------------------------
http://www.direct-netware.de/redirect.php?licenses;gpl
----------------------------------------------------------------------------
#echo(sWGdatalinkerVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* The DataLinker Structure Handling provides a unified way to analyize and
* manipulate structured data.
*
* @internal   We are using phpDocumentor to automate the documentation process
*             for creating the Developer's Manual. All sections including
*             these special comments will be removed from the release source
*             code.
*             Use the following line to ensure 76 character sizes:
* ----------------------------------------------------------------------------
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG
* @subpackage datalinker
* @uses       direct_product_iversion
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;gpl
*             GNU General Public License 2
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

//f// direct_datalinker_structure_add ($f_structure,$f_source_position,$f_id,$f_target_array)
/**
* Call the module specific iViewer handler.
*
* @param  string $f_structure Structure list
* @param  integer $f_source_position Entry position
* @param  string $f_direction Movement direction
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return array New structure list as an array; False if not moved
* @since  v0.1.00
*/
function direct_datalinker_structure_add ($f_structure,$f_source_position,$f_id,$f_target_array)
{
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_datalinker_structure_add (+f_structure,$f_source_position,$f_id,+f_target_array)- (#echo(__LINE__)#)"); }
	$f_return = ((is_array ($f_target_array)) ? true : false);

	if ($f_return)
	{
		if (is_string ($f_structure)) { $f_structure_list_array = explode ("\n",$f_structure); }
		else { $f_structure_list_array = array (); }

		$f_structure_list_count = count ($f_structure_list_array);

		if ($f_source_position < 1) { $f_source_id = $f_id; }
		elseif (isset ($f_structure_list_array[$f_source_position]))
		{
			$f_source_tree_array = explode (":",$f_structure_list_array[$f_source_position]);
			$f_source_id = array_pop ($f_source_tree_array);
			$f_source_tree_entries = count ($f_source_tree_array);

			if ($f_id != $f_source_id) { $f_return = false; }
		}
		else { $f_return = false; }
	}

	if ($f_return)
	{
		if (($f_source_position > 0)&&($f_source_tree_entries))
		{
			$f_target_array['ddbdatalinker_id_parent'] = $f_source_tree_array[($f_source_tree_entries - 1)];
			$f_target_array['ddbdatalinker_id_main'] = $f_source_tree_array[0];
		}
		else
		{
			$f_target_array['ddbdatalinker_id_parent'] = $f_source_id;
			$f_target_array['ddbdatalinker_id_main'] = $f_source_id;
		}

		$f_structure_list_lower_array = array_slice ($f_structure_list_array,0,(1 + $f_source_position));
		$f_structure_list_lower_array[] = $f_target_array;
		$f_structure_list_upper_array = array_slice ($f_structure_list_array,(1 + $f_source_position));
		$f_return = array_merge ($f_structure_list_lower_array,$f_structure_list_upper_array);
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_datalinker_structure_add ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_datalinker_structure_move ($f_structure,$f_source_position,$f_id,$f_direction)
/**
* Call the module specific iViewer handler.
*
* @param  string $f_structure Structure list
* @param  integer $f_source_position Entry position
* @param  string $f_direction Movement direction
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return array New structure list as an array; False if not moved
* @since  v0.1.00
*/
function direct_datalinker_structure_move ($f_structure,$f_source_position,$f_id,$f_direction)
{
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_datalinker_structure_move (+f_structure,$f_source_position,$f_id,$f_direction)- (#echo(__LINE__)#)"); }
	$f_return = ((is_string ($f_structure)) ? true : false);

	if ($f_return)
	{
		$f_structure_list_array = explode ("\n",$f_structure);
		$f_structure_list_filtered = $f_structure_list_array;
		$f_structure_list_count = count ($f_structure_list_array);

		if ((($f_direction == "up")&&($f_source_position > 1))||($f_direction == "down")) { $f_return = isset ($f_structure_list_array[$f_source_position]); }
		else { $f_return = false; }
	}

	if ($f_return)
	{
		$f_source_tree_array = explode (":",$f_structure_list_array[$f_source_position]);
		$f_source_id = array_pop ($f_source_tree_array);
		$f_source_tree_entries = count ($f_source_tree_array);

		if ($f_id != $f_source_id) { $f_return = false; }
	}

	if (($f_return)&&(($f_direction == "up")||($f_source_position < ($f_structure_list_count - 1))))
	{
		$f_target_found_check = false;
		$f_target_position = $f_source_position;

		do
		{
			if ($f_direction == "up") { $f_target_position--; }
			else { $f_target_position++; }

			if ($f_structure_list_count > $f_target_position)
			{
				$f_return = isset ($f_structure_list_array[$f_target_position]);

				if ($f_return)
				{
					$f_target_tree_array = explode (":",$f_structure_list_array[$f_target_position]);
					$f_target_id = array_pop ($f_target_tree_array);
					$f_target_tree_entries = count ($f_target_tree_array);
					if (!in_array ($f_source_id,$f_target_tree_array)) { $f_target_found_check = true; }
				}
			}
		}
		while ((!$f_target_found_check)&&($f_return)&&($f_structure_list_count > $f_target_position));

		if (!$f_target_found_check) { $f_target_position = -1; }
	}
	else { $f_target_position = -1; }

	if ($f_return)
	{
		if ($f_target_position < 0)
		{
			if ($f_source_tree_entries > 1) { $f_structure_list_array[$f_source_position] = array ($f_source_tree_array[($f_source_tree_entries - 2)],$f_source_id,false); }
		}
		elseif ($f_source_tree_entries > $f_target_tree_entries)
		{
			if ($f_direction == "up")
			{
				if (($f_source_tree_entries - $f_target_tree_entries) > 1)
				{
					$f_source_definition_array = array ($f_source_tree_array[($f_source_tree_entries - 1)],$f_source_id,false);
					$f_target_definition_array = array ($f_target_tree_array[($f_target_tree_entries - 1)],$f_target_id,false);
				}
				else
				{
					$f_source_definition_array = array ($f_target_tree_array[($f_target_tree_entries - 1)],$f_source_id,false);
					$f_target_definition_array = array ($f_target_tree_array[($f_target_tree_entries - 1)],$f_target_id,false);
				}
			}
			else
			{
				if (($f_source_tree_entries - $f_target_tree_entries) > 1)
				{
					$f_source_definition_array = array ($f_source_tree_array[($f_source_tree_entries - 2)],$f_source_id,false);
					$f_target_definition_array = array ($f_target_tree_array[($f_target_tree_entries - 1)],$f_target_id,false);
				}
				else
				{
					$f_source_definition_array = array ($f_target_tree_array[($f_target_tree_entries - 1)],$f_target_id,false);
					$f_target_definition_array = array ($f_target_tree_array[($f_target_tree_entries - 1)],$f_source_id,false);
				}
			}

			$f_structure_list_array[$f_target_position] = $f_source_definition_array;
			$f_structure_list_array[$f_source_position] = $f_target_definition_array;
		}
		else
		{
			if ($f_direction == "up")
			{
				if ($f_target_tree_entries > $f_source_tree_entries)
				{
					$f_source_definition_array = array ($f_target_tree_array[($f_target_tree_entries - 1)],$f_target_id,false);
					$f_target_definition_array = array ($f_target_tree_array[$f_source_tree_entries],$f_source_id,false);
				}
				else
				{
					$f_source_definition_array = array ($f_target_tree_array[($f_target_tree_entries - 1)],$f_target_id,true);
					$f_target_definition_array = array ($f_target_id,$f_source_id,false);
				}
			}
			else
			{
				$f_source_definition_array = array ($f_target_id,$f_source_id,false);
				$f_target_definition_array = array ($f_target_tree_array[($f_target_tree_entries - 1)],$f_target_id,true);
			}

			$f_structure_list_array[$f_target_position] = $f_source_definition_array;
			$f_structure_list_array[$f_source_position] = $f_target_definition_array;
		}

		$f_return = $f_structure_list_array;
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_datalinker_structure_move ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// EOF
?>