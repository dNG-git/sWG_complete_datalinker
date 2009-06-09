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
$Id: swg_subs.php,v 1.2 2009/01/01 13:14:37 s4u Exp $
#echo(sWGdatalinkerVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* datalinker/swg_subs.php
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

if (!isset ($direct_settings['datalinker_https_subs_new'])) { $direct_settings['datalinker_https_subs_new'] = false; }
if (!isset ($direct_settings['datalinker_subs_supported'])) { $direct_settings['datalinker_subs_supported'] = array (); }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
$direct_settings['additional_copyright'][] = array ("Module datalinker #echo(sWGdatalinkerVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "new"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// ($direct_settings['a'] == "new")||($direct_settings['a'] == "new-save")
case "new":
case "new-save":
{
	if ($direct_settings['a'] == "new-save") { $g_mode_save = true; }
	else { $g_mode_save = false; }

	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }

	$g_eid = (isset ($direct_settings['dsd']['deid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['deid'])) : "");
	$g_tid = (isset ($direct_settings['dsd']['tid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['tid'])) : "");
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

	if ($g_mode_save)
	{
		$direct_cachedata['page_this'] = "";
		$direct_cachedata['page_backlink'] = "m=datalinker&s=subs&a=new&dsd=deid+{$g_eid}++tid+{$g_tid}++source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_homelink'] = str_replace ("[oid]","deid+{$g_eid}++",$g_source_url);
	}
	else
	{
		$direct_cachedata['page_this'] = "m=datalinker&s=subs&a=new&dsd=deid+{$g_eid}++tid+{$g_tid}++source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
		$direct_cachedata['page_backlink'] = str_replace ("[oid]","deid+{$g_eid}++",$g_source_url);
		$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'] ;
	}

	if ($direct_classes['kernel']->service_init_default ())
	{
	if ($direct_settings['datalinker_subs_supported'])
	{
	//j// BOA
	if ($g_mode_save) { direct_output_related_manager ("datalinker_subs_new_{$g_task_array['datalinker_eid']}_form_save","pre_module_service_action"); }
	else { direct_output_related_manager ("datalinker_subs_new_{$g_task_array['datalinker_eid']}_form","pre_module_service_action"); }

	if (!$g_mode_save) { $direct_classes['kernel']->service_https ($direct_settings['datalinker_https_subs_new'],$direct_cachedata['page_this']); }
	direct_local_integration ("datalinker");

	$g_continue_check = $direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php");

	if ($g_tid)
	{
		$g_task_array = direct_tmp_storage_get ("evars",$g_tid,"","task_cache");

		if ($g_task_array)
		{
			if ((isset ($g_task_array['core_sid'],$g_task_array['datalinker_eid'],$g_task_array['uuid']))&&(!$g_task_array['datalinker_subs_new_done'])&&($g_task_array['uuid'] == $direct_settings['uuid']))
			{
				$direct_cachedata['page_backlink'] = str_replace ("[oid]","deid+{$g_task_array['datalinker_eid']}++",$g_task_array['core_back_return']);
				$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'];
			}
			else { $g_continue_check = false; }
		}
	}
	else { $g_task_array = array ("datalinker_eid" => $g_eid,"datalinker_name" => "","datalinker_handler" => "","datalinker_sub_sid" => "","datalinker_sub_mode" => "select","datalinker_sub_id" => "","core_back_return" => $g_source_url,"datalinker_subs_new_return" => $g_target_url,"uuid" => $direct_settings['uuid']); }

	if ($g_continue_check)
	{
		$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/dhandler/swg_datalinker.php");
		$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/dhandler/swg_datalinker_uhome.php");

		if (strpos ($g_task_array['datalinker_eid'],"u-") === 0) { $g_datalinker_object = new direct_datalinker_uhome (); }
		else { $g_datalinker_object = new direct_datalinker (); }

		if (($g_tid)&&($g_datalinker_object)) { $g_datalinker_array = $g_datalinker_object->get ($g_task_array['datalinker_eid']); }
		else { $g_datalinker_array = NULL; }

		if ($g_datalinker_array)
		{
			$g_service_array = $g_datalinker_object->get_service ($g_datalinker_array['ddbdatalinker_sid']);

			if (isset ($g_service_array['services'][$g_datalinker_array['ddbdatalinker_type']]))
			{
				$g_service_array = $g_service_array['services'][$g_datalinker_array['ddbdatalinker_type']];

				if ((isset ($g_service_array['handler']))&&($direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/datalinker/swg_{$g_service_array['handler']}.php")))
				{
					$f_handler_function = "direct_datalinker_".$g_service_array['handler'];
					$g_datalinker_object = $f_handler_function ($g_datalinker_object);
				}
			}

			if ($g_datalinker_object)
			{
				if (direct_class_function_check ($g_datalinker_object,"is_readable")) { $g_continue_check = $g_datalinker_object->is_readable (); }
				else { $g_continue_check = true; }
			}

			if ($g_continue_check) { $g_continue_check = $g_datalinker_object->is_sub_allowed (); }
		}
	}

	if ($g_continue_check)
	{
		$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_formbuilder.php");

		direct_class_init ("formbuilder");
		direct_class_init ("output");
		$direct_classes['output']->options_insert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

		if ($g_mode_save)
		{
/* -------------------------------------------------------------------------
We should have input in save mode
------------------------------------------------------------------------- */

			$direct_cachedata['i_dmode'] = (isset ($GLOBALS['i_dmode']) ? (str_replace ("'","",$GLOBALS['i_dmode'])) : "");
			$g_sub_sid = (isset ($GLOBALS['i_dsub']) ? (str_replace ("'","",$GLOBALS['i_dsub'])) : $g_task_array['datalinker_sub_sid']);
		}
		else
		{
			$direct_cachedata['i_dmode'] = str_replace ("'","",$g_task_array['datalinker_sub_mode']);
			$g_sub_sid = $g_task_array['datalinker_sub_sid'];
		}

		if (is_string ($direct_settings['datalinker_subs_supported'])) { $direct_settings['datalinker_subs_supported'] = array ($direct_settings['datalinker_subs_supported']); }
		$direct_cachedata['i_dsub'] = "<evars>";

		foreach ($direct_settings['datalinker_subs_supported'] as $g_service)
		{
			$g_sid = md5 ($g_service);
			$g_service_name = direct_string_id_translation ("datalinker",$g_sid);

			$direct_cachedata['i_dsub'] .= "<s$g_sid><value value='$g_sid' />";
			if ($g_sub_sid == $g_sid) { $direct_cachedata['i_dsub'] .= "<selected value='1' />"; }

			if ($g_service_name) { $direct_cachedata['i_dsub'] .= "<text><![CDATA[$g_service_name]]></text>"; }
			else { $direct_cachedata['i_dsub'] .= "<text><![CDATA[".(direct_local_get ("core_unknown"))." ($g_service)]]></text>"; }

			$direct_cachedata['i_dsub'] .= "</s$g_sid>";
		}

		$direct_cachedata['i_dsub'] .= "</evars>";
		$direct_cachedata['i_dmode'] = str_replace ("<value value='$direct_cachedata[i_dmode]' />","<value value='$direct_cachedata[i_dmode]' /><selected value='1' />","<evars><existing><value value='select' /><text><![CDATA[".(direct_local_get ("datalinker_subs_mode_entry_existing"))."]]></text></existing><new><value value='new' /><text><![CDATA[".(direct_local_get ("datalinker_subs_mode_entry_new"))."]]></text></new></evars>");

/* -------------------------------------------------------------------------
Build the form
------------------------------------------------------------------------- */

		$direct_classes['formbuilder']->entry_add_radio ("dsub",(direct_local_get ("datalinker_subs_supported")),true);
		$direct_classes['formbuilder']->entry_add_select ("dmode",(direct_local_get ("datalinker_subs_mode")),true,"s");

		$direct_cachedata['output_formelements'] = $direct_classes['formbuilder']->form_get ($g_mode_save);

		if (($g_mode_save)&&($direct_classes['formbuilder']->dvar_check_result))
		{
/* -------------------------------------------------------------------------
Save data edited
------------------------------------------------------------------------- */

			$g_service_selected_array = $g_datalinker_object->get_service ($direct_cachedata['i_dsub']);

			if ((isset ($g_service_selected_array['handler']))&&(file_exists ($direct_settings['path_system']."/modules/datalinker/swg_subs_{$g_service_selected_array['handler']}.php")))
			{
				if (!$g_tid)
				{
					$g_task_array['core_sid'] = "4c6924b0583e6882d3db6aff277bfc3e";
					// md5 ("datalinker")
					$g_task_array['datalinker_handler'] = $g_service_array['handler'];
					$g_task_array['datalinker_name'] = $g_service_array['name'];
					$g_task_array['datalinker_subs_new_done'] = 0;
					$g_task_array['uuid'] = $direct_settings['uuid'];
					$g_tid = md5 (uniqid (""));
				}

				$g_task_array['datalinker_sub_sid'] = $direct_cachedata['i_dsub'];
				$g_task_array['datalinker_sub_mode'] = $direct_cachedata['i_dmode'];
				if (!isset ($g_task_array['datalinker_subs_new_linked_done'])) { $g_task_array['datalinker_subs_new_linked_done'] = 0; }
				if (!isset ($g_task_array['datalinker_subs_new_selected_done'])) { $g_task_array['datalinker_subs_new_selected_done'] = 0; }

				direct_tmp_storage_write ($g_task_array,$g_tid,$g_task_array['core_sid'],"task_cache","evars",$direct_cachedata['core_time'],($direct_cachedata['core_time'] + 3600));
				$direct_classes['output']->redirect (direct_linker ("url1","m=datalinker&s=subs_{$g_service_selected_array['handler']}&a={$direct_cachedata['i_dmode']}&dsd=tid+".$g_tid,false));
			}
			else { $direct_classes['error_functions']->error_page ("standard","core_unknown_error","sWG/#echo(__FILEPATH__)# _a=new-save_ (#echo(__LINE__)#)"); }
		}
		else
		{
/* -------------------------------------------------------------------------
View form
------------------------------------------------------------------------- */

			$direct_cachedata['output_formbutton'] = direct_local_get ("core_continue");
			$direct_cachedata['output_formtarget'] = "m=datalinker&s=subs&a=new-save&dsd=deid+{$g_eid}++tid+{$g_tid}++source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
			$direct_cachedata['output_formtitle'] = direct_local_get ("core_datasub_new_entry");

			direct_output_related_manager ("datalinker_subs_new_{$g_task_array['datalinker_eid']}_form","post_module_service_action");
			$direct_classes['output']->oset ("default","form");
			$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
			$direct_classes['output']->page_show ($direct_cachedata['output_formtitle']);
		}
	}
	else { $direct_classes['error_functions']->error_page ("standard","core_tid_invalid","sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }
	//j// EOA
	}
	else { $direct_classes['error_functions']->error_page ("standard","core_service_inactive","sWG/#echo(__FILEPATH__)# _a=new_ (#echo(__LINE__)#)"); }
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// $direct_settings['a'] == "new-link"
case "new-link":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=new-link_ (#echo(__LINE__)#)"); }

	$g_tid = (isset ($direct_settings['dsd']['tid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['tid'])) : "");

	$direct_cachedata['page_this'] = "";
	$direct_cachedata['page_backlink'] = "m=datalinker&s=subs&a=new&dsd=tid+".$g_tid;
	$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'];

	if ($direct_classes['kernel']->service_init_default ())
	{
	if ($direct_settings['datalinker_subs_supported'])
	{
	//j// BOA
	if ($g_tid == "") { $g_tid = $direct_settings['uuid']; }

	$g_continue_check = $direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php");
	$g_task_array = direct_tmp_storage_get ("evars",$g_tid,"","task_cache");

	if (($g_task_array)&&(isset ($g_task_array['core_sid'],$g_task_array['datalinker_eid'],$g_task_array['uuid']))&&(!$g_task_array['datalinker_subs_new_done'])&&(!$g_task_array['datalinker_subs_new_linked_done'])&&($g_task_array['datalinker_subs_new_selected_done'])&&($g_task_array['uuid'] == $direct_settings['uuid']))
	{
		$g_back_link = "m=datalinker&s=subs&a=new&dsd=tid+{$g_tid}++source+".(urlencode (base64_encode ($g_task_array['core_back_return'])));
		if (isset ($g_task_array['datalinker_subs_new_return'])) { $g_back_link .= "++target+".(urlencode (base64_encode ($g_task_array['datalinker_subs_new_return']))); }

		$direct_cachedata['page_backlink'] = $g_back_link;
		$direct_cachedata['page_homelink'] = str_replace ("[oid]","deid+{$g_eid}++",$g_task_array['core_back_return']);
	}
	else { $g_continue_check = false; }

	direct_local_integration ("datalinker");

	if ($g_continue_check)
	{
		direct_output_related_manager ("datalinker_subs_new_selected_link","pre_module_service_action");
		$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/dhandler/swg_datalinker.php");
		$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/dhandler/swg_datalinker_uhome.php");

		direct_class_init ("output");
		$direct_classes['output']->options_insert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

		if (strpos ($g_task_array['datalinker_sub_id'],"u-") === 0)
		{
			$g_datalinker_object = new direct_datalinker_uhome ();
			if ($g_datalinker_object) { $g_datalinker_array = $g_datalinker_object->get ($g_task_array['datalinker_sub_id']); }
			$g_datalinker_object = new direct_datalinker ();
		}
		else
		{
			$g_datalinker_object = new direct_datalinker ();
			if ($g_datalinker_object) { $g_datalinker_array = $g_datalinker_object->get ($g_task_array['datalinker_sub_id']); }
		}
	}

	if (($g_continue_check)&&($g_datalinker_array))
	{
		$g_task_array['datalinker_sub_id'] = uniqid ("");

$g_datalinker_array = array (
"ddbdatalinker_id" => $g_task_array['datalinker_sub_id'],
"ddbdatalinker_id_object" => $g_datalinker_array['ddbdatalinker_id_object'],
"ddbdatalinker_id_parent" => $g_task_array['datalinker_eid'],
"ddbdatalinker_id_main" => "",
"ddbdatalinker_sid" => $g_datalinker_array['ddbdatalinker_sid'],
"ddbdatalinker_type" => $g_datalinker_array['ddbdatalinker_type'],
"ddbdatalinker_position" => 0,
"ddbdatalinker_subs" => $g_datalinker_array['ddbdatalinker_subs'],
"ddbdatalinker_objects" => $g_datalinker_array['ddbdatalinker_objects'],
"ddbdatalinker_sorting_date" => $g_datalinker_array['ddbdatalinker_sorting_date'],
"ddbdatalinker_symbol" => $g_datalinker_array['ddbdatalinker_symbol'],
"ddbdatalinker_title" => $g_datalinker_array['ddbdatalinker_title']
);

		$g_continue_check = $g_datalinker_object->set ($g_datalinker_array);
		if ($g_continue_check) { $g_continue_check = $g_datalinker_object->insert_link (); }

		if ($g_continue_check)
		{
			$g_task_array['datalinker_subs_new_linked_done'] = 1;
			direct_tmp_storage_write ($g_task_array,$g_tid,$g_task_array['core_sid'],"task_cache","evars",$direct_cachedata['core_time'],($direct_cachedata['core_time'] + 3600));

			$direct_cachedata['output_job'] = direct_local_get ("datalinker_entry_select");
			$direct_cachedata['output_job_desc'] = direct_local_get ("datalinker_done_entry_select");
			$direct_cachedata['output_jsjump'] = 2000;

			$direct_cachedata['output_pagetarget'] = direct_linker ("url0","m=datalinker&s=subs&a=new-selected&dsd=tid+".$g_tid);
			$direct_cachedata['output_scripttarget'] = direct_linker ("url0","m=datalinker&s=subs&a=new-selected&dsd=tid+".$g_tid,false);

			direct_output_related_manager ("datalinker_subs_new_selected_link","post_module_service_action");
			$direct_classes['output']->oset ("default","done");
			$direct_classes['output']->options_flush (true);
			$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
			$direct_classes['output']->page_show ($direct_cachedata['output_job']);
		}
		else { $direct_classes['error_functions']->error_page ("fatal","core_database_error","sWG/#echo(__FILEPATH__)# _a=new-link (#echo(__LINE__)#)"); }
	}
	else { $direct_classes['error_functions']->error_page ("standard","core_tid_invalid","sWG/#echo(__FILEPATH__)# _a=new-link_ (#echo(__LINE__)#)"); }
	//j// EOA
	}
	else { $direct_classes['error_functions']->error_page ("standard","core_service_inactive","sWG/#echo(__FILEPATH__)# _a=new-link_ (#echo(__LINE__)#)"); }
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// $direct_settings['a'] == "new-selected"
case "new-selected":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=new-selected_ (#echo(__LINE__)#)"); }

	$g_tid = (isset ($direct_settings['dsd']['tid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['tid'])) : "");

	$direct_cachedata['page_this'] = "";
	$direct_cachedata['page_backlink'] = "m=datalinker&s=subs&a=new&dsd=tid+".$g_tid;
	$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'];

	if ($direct_classes['kernel']->service_init_default ())
	{
	if ($direct_settings['datalinker_subs_supported'])
	{
	//j// BOA
	$g_continue_check = $direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php");
	if ($g_tid == "") { $g_tid = $direct_settings['uuid']; }

	$g_task_array = direct_tmp_storage_get ("evars",$g_tid,"","task_cache");

	if (($g_task_array)&&(isset ($g_task_array['core_sid'],$g_task_array['datalinker_eid'],$g_task_array['uuid']))&&(!$g_task_array['datalinker_subs_new_done'])&&($g_task_array['datalinker_subs_new_linked_done'])&&($g_task_array['datalinker_subs_new_selected_done'])&&($g_task_array['uuid'] == $direct_settings['uuid']))
	{
		$g_back_link = "m=datalinker&s=subs&a=new&dsd=tid+{$g_tid}++source+".(urlencode (base64_encode ($g_task_array['core_back_return'])));
		if (isset ($g_task_array['datalinker_subs_new_return'])) { $g_back_link .= "++target+".(urlencode (base64_encode ($g_task_array['datalinker_subs_new_return']))); }

		$direct_cachedata['page_backlink'] = $g_back_link;
		$direct_cachedata['page_homelink'] = str_replace ("[oid]","deid+{$g_eid}++",$g_task_array['core_back_return']);
	}
	else { $g_continue_check = false; }

	direct_local_integration ("datalinker");

	if ($g_continue_check)
	{
		$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/dhandler/swg_datalinker.php");
		$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/dhandler/swg_datalinker_uhome.php");

		direct_class_init ("output");
		$direct_classes['output']->options_insert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

		if (strpos ($g_task_array['datalinker_eid'],"u-") === 0) { $g_datalinker_parent_object = new direct_datalinker_uhome (); }
		else { $g_datalinker_parent_object = new direct_datalinker (); }

		if ($g_datalinker_parent_object) { $g_datalinker_parent_array = $g_datalinker_parent_object->get ($g_task_array['datalinker_eid']); }

		if (strpos ($g_task_array['datalinker_sub_id'],"u-") === 0) { $g_datalinker_child_object = new direct_datalinker_uhome (); }
		else { $g_datalinker_child_object = new direct_datalinker (); }

		if ($g_datalinker_child_object) { $g_datalinker_child_array = $g_datalinker_child_object->get ($g_task_array['datalinker_sub_id']); }

		if (($g_datalinker_parent_array)&&($g_datalinker_child_array)) { $g_continue_check = true; }
		else { $g_continue_check = false; }

		if (($g_continue_check)&&($g_datalinker_parent_array['ddbdatalinker_id'] == $g_datalinker_child_array['ddbdatalinker_id_parent'])) { $g_continue_check = $g_datalinker_parent_object->add_subs (1); }

		if ($g_continue_check)
		{
			$g_task_array['datalinker_subs_new_done'] = 1;
			direct_tmp_storage_write ($g_task_array,$g_tid,$g_task_array['core_sid'],"task_cache","evars",$direct_cachedata['core_time'],($direct_cachedata['core_time'] + 3600));
		}

		if (($g_continue_check)&&(isset ($g_task_array['datalinker_subs_new_return']))&&($g_task_array['datalinker_subs_new_return']))
		{
			$g_target_link = str_replace ("[oid]","deid_d+{$g_datalinker_parent_array['ddbdatalinker_id']}++doid_d+{$g_datalinker_child_array['ddbdatalinker_id']}++",$g_task_array['datalinker_subs_new_return']);
			$direct_classes['output']->redirect (direct_linker ("url1",$g_target_link,false));
		}
		else { $direct_classes['error_functions']->error_page ("standard","core_tid_invalid","sWG/#echo(__FILEPATH__)# _a=new-selected_ (#echo(__LINE__)#)"); }
	}
	else { $direct_classes['error_functions']->error_page ("standard","core_tid_invalid","sWG/#echo(__FILEPATH__)# _a=new-selected_ (#echo(__LINE__)#)"); }
	//j// EOA
	}
	else { $direct_classes['error_functions']->error_page ("standard","core_service_inactive","sWG/#echo(__FILEPATH__)# _a=new-selected_ (#echo(__LINE__)#)"); }
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>