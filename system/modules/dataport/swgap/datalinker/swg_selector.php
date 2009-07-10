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
* dataport/swgap/datalinker/swg_selector.php
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

if (!isset ($direct_settings['datalinker_https_selector'])) { $direct_settings['datalinker_https_selector'] = false; }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
$direct_settings['additional_copyright'][] = array ("Module datalinker #echo(sWGdatalinkerVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "preselect"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// $direct_settings['a'] == "preselect"
case "preselect":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=preselect_ (#echo(__LINE__)#)"); }

	$g_eid = (isset ($direct_settings['dsd']['deid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['deid'])) : "");
	$g_confirm = (isset ($direct_settings['dsd']['dconfirm']) ? ($direct_classes['basic_functions']->inputfilter_number ($direct_settings['dsd']['dconfirm'])) : 1);
	$g_source = (isset ($direct_settings['dsd']['source']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['source'])) : "");
	$g_target = (isset ($direct_settings['dsd']['target']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['target'])) : "");

	if ($g_source) { $g_source_url = base64_decode ($g_source); }
	else { $g_source_url = "m=datalinker&a=view&dsd=[oid]"; }

	if ($g_target) { $g_target_url = base64_decode ($g_target); }
	else
	{
		$g_target = $g_source;
		$g_target_url = $g_source_url;
	}

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

		$direct_cachedata['page_this'] = "m=dataport&s=swgap;datalinker;selector&a=preselect&dsd=dtheme+{$direct_cachedata['output_dtheme_mode']}++deid+{$g_eid}++dconfirm+{$g_confirm}++source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_backlink'] = str_replace ("[oid]","deid+{$g_eid}++",$g_source_url);
		$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'] ;

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
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/dhandler/swg_datalinker_uhome.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/datalinker/swg_iviewer.php"); }

	if ($g_continue_check)
	{
	//j// BOA
	if ($g_dtheme_embedded) { direct_output_related_manager ("datalinker_selector_preselect","pre_module_service_action_embedded"); }
	elseif ($g_dtheme) { direct_output_related_manager ("datalinker_selector_preselect","pre_module_service_action"); }
	else { direct_output_related_manager ("datalinker_selector_preselect","pre_module_service_action_ajax"); }

	if ($g_dtheme) { $direct_classes['kernel']->service_https ($direct_settings['datalinker_https_selector'],$direct_cachedata['page_this']); }
	if ($g_dtheme_embedded) { direct_output_theme_subtype ("embedded"); }

	direct_class_init ("output");
	if (($g_dtheme)&&($direct_cachedata['page_backlink'])) { $direct_classes['output']->options_insert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0"); }

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
		if ($direct_settings['user']['type'] == "gt")
		{
			$g_uuid_string = $direct_classes['kernel']->v_uuid_get ("s");

			if (!$g_uuid_string)
			{
				$g_uuid_string = "<evars><userid /></evars>";
				$direct_classes['kernel']->v_uuid_write ($g_uuid_string);
				$direct_classes['kernel']->v_uuid_cookie_save ();
			}
		}

		$g_datalinker_cache = direct_tmp_storage_get ("evars",$direct_settings['uuid'],"4c6924b0583e6882d3db6aff277bfc3e","link_cache");
		// md5 ("datalinker")

		if ((isset ($g_datalinker_cache['datalinker_objects_selected']))&&(is_array ($g_datalinker_cache['datalinker_objects_selected']))) { $g_datalinker_cache['datalinker_objects_selected'][$g_eid] = $g_eid; }
		else { $g_datalinker_cache = array ("datalinker_objects_selected" => array ($g_eid => $g_eid)); }

		$g_continue_check = direct_tmp_storage_write ($g_datalinker_cache,$direct_settings['uuid'],"4c6924b0583e6882d3db6aff277bfc3e","link_cache","evars",$direct_cachedata['core_time'],($direct_cachedata['core_time'] + 3600));
	}

	if ($g_continue_check)
	{
		if (($g_dtheme)&&(($g_confirm)||(!$g_target_url)))
		{
			direct_local_integration ("datalinker");

			$direct_cachedata['output_job'] = direct_local_get ("datalinker_selector_preselect");
			$direct_cachedata['output_job_desc'] = direct_local_get ("datalinker_done_selector_preselect");

			if ($g_target_url)
			{
				$g_target_link = str_replace ("[oid]","deid_d+{$g_eid}++",$g_target_url);

				$direct_cachedata['output_jsjump'] = 2000;
				$direct_cachedata['output_pagetarget'] = str_replace ('"',"",(direct_linker ("url0",$g_target_link)));
				$direct_cachedata['output_scripttarget'] = str_replace ('"',"",(direct_linker ("url0",$g_target_link,false)));
			}

			if ($g_dtheme_embedded)
			{
				direct_output_related_manager ("datalinker_selector_preselect","post_module_service_action_embedded");
				$direct_classes['output']->oset ("default_embedded","done");
			}
			else
			{
				direct_output_related_manager ("datalinker_selector_preselect","post_module_service_action");
				$direct_classes['output']->oset ("default","done");
			}

			$direct_classes['output']->options_flush (true);
			$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
			$direct_classes['output']->page_show ($direct_cachedata['output_job']);
		}
		elseif ($g_target_url)
		{
			$g_target_link = str_replace ("[oid]","deid_d+{$g_eid}++",$g_target_url);
			$direct_classes['output']->redirect (direct_linker ("url1",$g_target_link,false));
		}
	}
	elseif ($g_dtheme) { $direct_classes['error_functions']->error_page ("login","core_access_denied","sWG/#echo(__FILEPATH__)# _a=preselect_ (#echo(__LINE__)#)"); }
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>