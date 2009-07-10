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
* dataport/swgap/datalinker/swg_selector_link.php
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

//j// Basic configuration

/* -------------------------------------------------------------------------
Direct calls will be honored with an "exit ()"
------------------------------------------------------------------------- */

if (!defined ("direct_product_iversion")) { exit (); }

//j// Script specific commands

if (!isset ($direct_settings['datalinker_iview_objects_per_page'])) { $direct_settings['datalinker_iview_objects_per_page'] = 20; }
if (!isset ($direct_settings['datalinker_https_selector_link'])) { $direct_settings['datalinker_https_selector_link'] = false; }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
$direct_settings['additional_copyright'][] = array ("Module datalinker #echo(sWGdatalinkerVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "list"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// $direct_settings['a'] == "list"
case "list":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=list_ (#echo(__LINE__)#)"); }

	$direct_cachedata['output_tid'] = (isset ($direct_settings['dsd']['tid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['tid'])) : "");
	$direct_cachedata['output_page'] = (isset ($direct_settings['dsd']['page']) ? ($direct_classes['basic_functions']->inputfilter_number ($direct_settings['dsd']['page'])) : 1);

	if ((isset ($direct_settings['dsd']['dtheme']))&&($direct_settings['dsd']['dtheme']))
	{
		$g_dtheme = true;

		if ($direct_settings['dsd']['dtheme'] == 2)
		{
			$direct_cachedata['output_dtheme_mode'] = 2;
			$g_dtheme_embedded = true;
		}
		else
		{
			$direct_cachedata['output_dtheme_mode'] = 1;
			$g_dtheme_embedded = false;
		}

		$direct_cachedata['page_this'] = "m=dataport&s=swgap;datalinker;selector_link&a=list&dsd=dtheme+{$direct_cachedata['output_dtheme_mode']}++tid+{$direct_cachedata['output_tid']}++page+".$direct_cachedata['output_page'];
		$direct_cachedata['page_backlink'] = "";
		$direct_cachedata['page_homelink'] = "";

		$g_continue_check = $direct_classes['kernel']->service_init_default ();
	}
	else
	{
		$direct_cachedata['output_dtheme_mode'] = 0;
		$g_dtheme = false;
		$g_dtheme_embedded = false;

		$g_continue_check = $direct_classes['kernel']->service_init_rboolean ();
	}

	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->settings_get ($direct_settings['path_data']."/settings/swg_datalinker.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/dhandler/swg_datalinker.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/datalinker/swg_iviewer.php"); }

	if ($g_continue_check)
	{
	//j// BOA
	if ($direct_cachedata['output_tid'] == "") { $direct_cachedata['output_tid'] = $direct_settings['uuid']; }
	$g_task_array = direct_tmp_storage_get ("evars",$direct_cachedata['output_tid'],"","task_cache");

	if (($g_task_array)&&(isset ($g_task_array['core_sid'],$g_task_array['uuid']))&&(!$g_task_array['datalinker_link_selection_done'])&&($g_task_array['uuid'] == $direct_settings['uuid']))
	{
		if ($g_dtheme_embedded) { direct_output_related_manager ("datalinker_selector_link_list","pre_module_service_action_embedded"); }
		elseif ($g_dtheme) { direct_output_related_manager ("datalinker_selector_link_list","pre_module_service_action"); }
		else { direct_output_related_manager ("datalinker_selector_link_list","pre_module_service_action_ajax"); }

		$direct_cachedata['page_backlink'] = str_replace ("[oid]","",$g_task_array['core_back_return']);
		$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'];

		if ((!isset ($g_task_array['datalinker_link_objects_marked']))||(!is_array ($g_task_array['datalinker_link_objects_marked']))) { $g_task_array['datalinker_link_objects_marked'] = array (); }
	}
	else { $g_continue_check = false; }

	if ($g_dtheme) { $direct_classes['kernel']->service_https ($direct_settings['datalinker_https_selector_link'],$direct_cachedata['page_this']); }
	if ($g_dtheme_embedded) { direct_output_theme_subtype ("embedded"); }
	direct_local_integration ("datalinker");

	direct_class_init ("output");
	if (($g_dtheme)&&($direct_cachedata['page_backlink'])) { $direct_classes['output']->options_insert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0"); }

	if ($g_continue_check)
	{
		$direct_cachedata['output_source'] = base64_encode ("m=dataport&s=swgap;datalinker;selector_link&a=list&dsd=dtheme+{$direct_cachedata['output_dtheme_mode']}++tid+{$direct_cachedata['output_tid']}++page+".$direct_cachedata['output_page']);

		$g_datalinker_cache = direct_tmp_storage_get ("evars",$direct_settings['uuid'],"4c6924b0583e6882d3db6aff277bfc3e","link_cache");
		// md5 ("datalinker")

		if (($g_datalinker_cache)&&(isset ($g_datalinker_cache['datalinker_objects_selected']))&&(is_array ($g_datalinker_cache['datalinker_objects_selected']))) { $g_objects_selected_array = array_values ($g_datalinker_cache['datalinker_objects_selected']); }
		else { $g_objects_selected_array = array (); }

		$g_objects_count = count ($g_objects_selected_array);

		if ((isset ($g_task_array['datalinker_link_selection_automark_one']))&&($g_task_array['datalinker_link_selection_automark_one'])&&($g_objects_count == 1)&&(!in_array ($g_objects_selected_array[0],$g_task_array['datalinker_link_objects_marked']))) { $direct_classes['output']->redirect (direct_linker ("url1","m=dataport&s=swgap;datalinker;selector_link&a=mark_switch&dsd=dtheme+{$direct_cachedata['output_dtheme_mode']}++deid+{$g_objects_selected_array[0]}++tid+{$direct_cachedata['output_tid']}++page+".$direct_cachedata['output_page'],false)); }
		else
		{
			$direct_cachedata['output_pages'] = ceil ($g_objects_count / $direct_settings['datalinker_iview_objects_per_page']);
			if ($direct_cachedata['output_pages'] < 1) { $direct_cachedata['output_pages'] = 1; }
			if ((!is_numeric ($direct_cachedata['output_page']))||($direct_cachedata['output_page'] < 1)) { $direct_cachedata['output_page'] = 1; }

			$g_objects_limit = ($direct_cachedata['output_page'] * $direct_settings['datalinker_iview_objects_per_page']);
			$g_objects_offset = (($direct_cachedata['output_page'] - 1) * $direct_settings['datalinker_iview_objects_per_page']);
			$g_objects_selected = array ();

			for ($g_i = $g_objects_offset;$g_i < $g_objects_limit;$g_i++)
			{
				if (isset ($g_objects_selected_array[$g_i])) { $g_objects_selected[] = $g_objects_selected_array[$g_i]; }
				elseif ($g_objects_limit < $g_objects_count) { $g_objects_limit++; }
			}

			$direct_cachedata['output_objects'] = array ();

			if (!empty ($g_objects_selected))
			{
				$direct_classes['db']->init_select ($direct_settings['datalinker_table']);
				$direct_classes['db']->define_attributes (array ($direct_settings['datalinker_table'].".*",$direct_settings['datalinkerd_table'].".*"));
				$direct_classes['db']->define_join ("left-outer-join",$direct_settings['datalinkerd_table'],"<sqlconditions><element1 attribute='{$direct_settings['datalinkerd_table']}.ddbdatalinkerd_id' value='{$direct_settings['datalinker_table']}.ddbdatalinker_id_object' type='attribute' /></sqlconditions>");

				$g_select_criteria = "<sqlconditions>";
				foreach ($g_objects_selected as $g_id) { $g_select_criteria .= $direct_classes['db']->define_row_conditions_encode ($direct_settings['datalinker_table'].".ddbdatalinker_id",$g_id,"string","==","or"); }
				$g_select_criteria .= "</sqlconditions>";

				$direct_classes['db']->define_row_conditions ($g_select_criteria);

				$g_datalinker_object = new direct_datalinker ();
				$g_objects_selected = $direct_classes['db']->query_exec ("ma");

				foreach ($g_objects_selected as $g_object_array)
				{
					if ($g_datalinker_object->set ($g_object_array))
					{
						$f_service_array = $g_datalinker_object->get_service ($g_object_array['ddbdatalinker_sid']);

						if (isset ($f_service_array['services'][$g_object_array['ddbdatalinker_type']]))
						{
							$f_service_array = $f_service_array['services'][$g_object_array['ddbdatalinker_type']];
							$g_result_selected = direct_datalinker_iviewer ($f_service_array,$g_datalinker_object);

							$g_result_selected['marked'] = in_array ($g_object_array['ddbdatalinker_id'],$g_task_array['datalinker_link_objects_marked']);

							if ((isset ($g_task_array['datalinker_link_selection_quantity']))&&($g_task_array['datalinker_link_selection_quantity']))
							{
								$g_result_selected['pageurl_marker'] = direct_linker ("url0","m=dataport&s=swgap;datalinker;selector_link&a=mark_switch&dsd=dtheme+{$direct_cachedata['output_dtheme_mode']}++deid+{$g_object_array['ddbdatalinker_id']}++tid+{$direct_cachedata['output_tid']}++page+".$direct_cachedata['output_page']);

								if ($g_result_selected['marked'])
								{
									if (isset ($g_task_array['datalinker_link_marker_title_1'])) { $g_result_selected['marker_title'] = $g_task_array['datalinker_link_marker_title_1']; }
									else { $g_result_selected['marker_title'] = direct_local_get ("datalinker_object_unmark"); }
								}
								else
								{
									if (isset ($g_task_array['datalinker_link_marker_title_0'])) { $g_result_selected['marker_title'] = $g_task_array['datalinker_link_marker_title_0']; }
									else { $g_result_selected['marker_title'] = direct_local_get ("datalinker_object_mark"); }
								}
							}

							$direct_cachedata['output_objects'][] = $g_result_selected;
						}
					}
				}
			}
		}

		if ((isset ($g_task_array['datalinker_link_selection_title']))&&($g_task_array['datalinker_link_selection_title'])) { $direct_cachedata['output_title'] = $g_task_array['datalinker_link_selection_title']; }
		else { $direct_cachedata['output_title'] = direct_local_get ("datalinker_entries_selector"); }

		if ($g_dtheme)
		{
			if ($g_dtheme_embedded)
			{
				direct_output_related_manager ("datalinker_selector_link_list","post_module_service_action_embedded");
				$direct_cachedata['output_page_url'] = "m=dataport&s=swgap;datalinker;selector_link&a=list&dsd=dtheme+2++tid+{$direct_cachedata['output_tid']}++";
				$direct_classes['output']->oset ("datalinker_embedded","list_iviews");
			}
			else
			{
				direct_output_related_manager ("datalinker_selector_link_list","post_module_service_action");
				$direct_cachedata['output_page_url'] = "m=dataport&s=swgap;datalinker;selector_link&a=list&dsd=dtheme+1++tid+{$direct_cachedata['output_tid']}++";
				$direct_classes['output']->oset ("datalinker","list_iviews");
			}

			$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
			$direct_classes['output']->page_show ($direct_cachedata['output_title']);
		}
		else
		{
			$direct_cachedata['output_page_url'] = "javascript:djs_dataport_{$direct_cachedata['output_tid']}_call_url0('m=dataport&amp;s=swgap;datalinker;selector_link&amp;a=list&amp;dsd=dtheme+0++tid+{$direct_cachedata['output_tid']}++page+[page]')";

			$direct_classes['output']->header (false);
			header ("Content-type: text/xml; charset=".$direct_local['lang_charset']);

echo ("<?xml version='1.0' encoding='$direct_local[lang_charset]' ?>
".(direct_output_smiley_decode ($direct_classes['output']->oset_content ("datalinker_embedded","ajax_list_iviews"))));
		}
	}
	else { $direct_classes['error_functions']->error_page ("standard","core_tid_invalid","sWG/#echo(__FILEPATH__)# _a=list_ (#echo(__LINE__)#)"); }
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// $direct_settings['a'] == "mark_switch"
case "mark_switch":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=mark_switch_ (#echo(__LINE__)#)"); }

	$g_eid = (isset ($direct_settings['dsd']['deid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['deid'])) : "");
	$g_tid = (isset ($direct_settings['dsd']['tid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['tid'])) : "");
	$g_page = (isset ($direct_settings['dsd']['page']) ? ($direct_classes['basic_functions']->inputfilter_number ($direct_settings['dsd']['page'])) : 1);

	if ((isset ($direct_settings['dsd']['dtheme']))&&($direct_settings['dsd']['dtheme']))
	{
		$g_dtheme = true;

		if ($direct_settings['dsd']['dtheme'] == 2)
		{
			$g_dtheme_embedded = true;
			$g_dtheme_mode = 2;
		}
		else
		{
			$g_dtheme_embedded = false;
			$g_dtheme_mode = 1;
		}

		$direct_cachedata['page_this'] = "";
		$direct_cachedata['page_backlink'] = "";
		$direct_cachedata['page_homelink'] = "";

		$g_continue_check = $direct_classes['kernel']->service_init_default ();
	}
	else
	{
		$g_dtheme = false;
		$g_dtheme_embedded = false;
		$g_dtheme_mode = 0;

		$g_continue_check = $direct_classes['kernel']->service_init_rboolean ();
	}

	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->settings_get ($direct_settings['path_data']."/settings/swg_datalinker.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/dhandler/swg_datalinker.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/dhandler/swg_datalinker_uhome.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/datalinker/swg_iviewer.php"); }

	if ($g_continue_check)
	{
	//j// BOA
	$g_task_array = direct_tmp_storage_get ("evars",$g_tid,"","task_cache");

	if (($g_task_array)&&(isset ($g_task_array['core_sid'],$g_task_array['uuid']))&&(!$g_task_array['datalinker_link_selection_done'])&&($g_task_array['uuid'] == $direct_settings['uuid']))
	{
		if ($g_dtheme_embedded) { direct_output_related_manager ("datalinker_selector_link_mark_switch","pre_module_service_action_embedded"); }
		elseif ($g_dtheme) { direct_output_related_manager ("datalinker_selector_link_mark_switch","pre_module_service_action"); }
		else { direct_output_related_manager ("datalinker_selector_link_mark_switch","pre_module_service_action_ajax"); }

		$direct_cachedata['page_backlink'] = "m=dataport&s=swgap;datalinker;selector_link&a=list&dsd=dtheme+{$g_dtheme_mode}++tid+{$g_tid}++page+".$g_page;
		$direct_cachedata['page_homelink'] = str_replace ("[oid]","",$g_task_array['core_back_return']);

		if ((!isset ($g_task_array['datalinker_link_objects_marked']))||(!is_array ($g_task_array['datalinker_link_objects_marked']))) { $g_task_array['datalinker_link_objects_marked'] = array (); }
	}
	else { $g_continue_check = false; }

	if ($g_dtheme_embedded) { direct_output_theme_subtype ("embedded"); }

	direct_class_init ("output");
	if (($g_dtheme)&&($direct_cachedata['page_backlink'])) { $direct_classes['output']->options_insert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0"); }

	if ($g_continue_check)
	{
		if (strpos ($g_eid,"u-") === 0) { $g_datalinker_object = new direct_datalinker_uhome (); }
		else { $g_datalinker_object = new direct_datalinker (); }

		if ($g_datalinker_object) { $g_datalinker_array = $g_datalinker_object->get ($g_eid); }
		else { $g_datalinker_array = NULL; }

		$g_continue_check = false;

		if ($g_datalinker_array)
		{
			$g_service_array = $g_datalinker_object->get_service ($g_datalinker_array['ddbdatalinker_sid']);

			if (isset ($g_service_array['services'][$g_datalinker_array['ddbdatalinker_type']]))
			{
				$g_service_array = $g_service_array['services'][$g_datalinker_array['ddbdatalinker_type']];
				$g_datalinker_array = direct_datalinker_iviewer ($g_service_array,$g_datalinker_object);

				if ($g_datalinker_array) { $g_continue_check = $g_datalinker_array['object_available']; }
			}
		}

		if ($g_continue_check)
		{
			if (in_array ($g_eid,$g_task_array['datalinker_link_objects_marked'])) { unset ($g_task_array['datalinker_link_objects_marked'][$g_eid]); }
			else
			{
				if ($g_task_array['datalinker_link_selection_quantity'] > count ($g_task_array['datalinker_link_objects_marked'])) { $g_task_array['datalinker_link_objects_marked'][$g_eid] = $g_eid; }
				else
				{
					array_shift ($g_task_array['datalinker_link_objects_marked']);
					$g_task_array['datalinker_link_objects_marked'][$g_eid] = $g_eid;
				}
			}

			if ($g_task_array['datalinker_link_marker_return']) { $g_task_array['datalinker_link_selection_done'] = 1; }
			direct_tmp_storage_write ($g_task_array,$g_tid,$g_task_array['core_sid'],"task_cache","evars",$direct_cachedata['core_time'],($direct_cachedata['core_time'] + 3600));

			if ((isset ($g_task_array['datalinker_link_marker_return']))&&($g_task_array['datalinker_link_marker_return']))
			{
				$g_back_link = str_replace ("[oid]","deid_d+$g_eid++",$g_task_array['datalinker_link_marker_return']);
				$direct_classes['output']->redirect (direct_linker ("url1",$g_back_link,false));
			}
			else { $direct_classes['output']->redirect (direct_linker ("url1","m=dataport&s=swgap;datalinker;selector_link&a=list&dsd=dtheme+{$g_dtheme_mode}++tid+{$g_tid}++page+{$g_page}#swgdhandlerdatalinker".$g_eid,false)); }
		}
		elseif ($g_dtheme) { $direct_classes['error_functions']->error_page ("login","core_access_denied","sWG/#echo(__FILEPATH__)# _a=mark_switch_ (#echo(__LINE__)#)"); }
	}
	elseif ($g_dtheme) { $direct_classes['error_functions']->error_page ("standard","core_tid_invalid","sWG/#echo(__FILEPATH__)# _a=mark_switch_ (#echo(__LINE__)#)"); }
	//j// BOA
	}

	$direct_cachedata['core_service_activated'] = 1;
	break 1;
}
//j// EOS
}

//j// EOF
?>