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
$Id: swg_index.php,v 1.5 2009/01/11 10:54:10 s4u Exp $
#echo(sWGdatalinkerVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* datalinker/swg_index.php
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

if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
$direct_settings['additional_copyright'][] = array ("Module datalinker #echo(sWGdatalinkerVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "view"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// $direct_settings['a'] == "count"
case "count":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=view_ (#echo(__LINE__)#)"); }

	$g_eid = (isset ($direct_settings['dsd']['deid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['deid'])) : "");
	$g_adsd = (isset ($direct_settings['dsd']['dadsd']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['dadsd'])) : "");
	$g_source = (isset ($direct_settings['dsd']['source']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['source'])) : "");
	$g_target = (isset ($direct_settings['dsd']['target']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['target'])) : "");

	if ($g_source) { $g_source_url = base64_decode ($g_source); }
	else { $g_source_url = "m=datalinker&a=view&dsd=[oid]"; }

	if ($g_target) { $g_target_url = base64_decode ($g_target); }
	else { $g_target_url = $g_source_url; }

	$direct_cachedata['page_this'] = "m=datalinker&a=count&dsd=deid+{$g_eid}++dadsd+".(urlencode ($g_adsd))."++source+".(urlencode ($g_source))."++target+".(urlencode ($g_target));
	$direct_cachedata['page_backlink'] = str_replace ("[oid]","deid+{$g_eid}++",$g_source_url);
	$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'];

	if ($direct_classes['kernel']->service_init_default ())
	{
	//j// BOA
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/dhandler/swg_datalinker.php");

	if (strpos ($g_eid,"-") === false) { $g_datalinker_object = new direct_datalinker (); }
	else { $g_datalinker_object = new direct_datalinker_uhome (); }

	if ($g_datalinker_object) { $g_entry_array = $g_datalinker_object->get ($g_eid); }
	else { $g_entry_array = NULL; }

	if ((!is_array ($g_entry_array))||(!strlen ($g_target_url))) { $direct_classes['error_functions']->error_page ("standard","core_datasub_eid_invalid","sWG/#echo(__FILEPATH__)# _a=view_ (#echo(__LINE__)#)"); }
	else
	{
		if ($g_datalinker_object->is_views_counting ()) { $g_datalinker_object->add_views (1); }

		direct_class_init ("output");
		$g_target_link = str_replace ("[oid]","deid_d+{$g_eid}++",$g_target_url);

		if (strlen ($g_adsd))
		{
			$g_adsd_array = explode (";",$g_adsd);
			$g_target_adsd = "";

			foreach ($g_adsd_array as $g_adsd_id)
			{
				$g_adsd_id = urlencode ($g_adsd_id);
				if (isset ($direct_settings['dsd'][$g_adsd_id])) { $g_target_adsd .= $g_adsd_id."+".(urlencode ($direct_settings['dsd'][$g_adsd_id]))."++"; }
			}

			$g_target_link = str_replace ("&dsd=","&dsd=".$g_target_adsd,$g_target_link);
		}

		$direct_classes['output']->redirect (direct_linker ("url1",$g_target_link,false));
	}
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// $direct_settings['a'] == "view"
case "view":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=view_ (#echo(__LINE__)#)"); }

	$g_eid_d = (isset ($direct_settings['dsd']['deid_d']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['deid_d'])) : "");
	$g_eid = (isset ($direct_settings['dsd']['deid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['deid'])) : $g_eid_d);
	$g_source = (isset ($direct_settings['dsd']['source']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['source'])) : "");

	if ($g_source) { $g_source_url = base64_decode ($g_source); }
	else { $g_source_url = ""; }

	$direct_cachedata['page_this'] = "m=datalinker&dsd=deid+{$g_eid}++source+".(urlencode ($g_source_url));
	$direct_cachedata['page_backlink'] = str_replace ("[oid]","deid+{$g_eid}++",$g_source_url);
	$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'];

	if ($direct_classes['kernel']->service_init_default ())
	{
	//j// BOA
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/dhandler/swg_datalinker.php");
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/dhandler/swg_datalinker_uhome.php");

	if (strpos ($g_eid,"-") === false) { $g_datalinker_object = new direct_datalinker (); }
	else { $g_datalinker_object = new direct_datalinker_uhome (); }

	if ($g_datalinker_object) { $g_entry_array = $g_datalinker_object->get ($g_eid); }
	else { $g_entry_array = NULL; }

	if (!is_array ($g_entry_array)) { $direct_classes['error_functions']->error_page ("standard","core_datasub_eid_invalid","sWG/#echo(__FILEPATH__)# _a=view_ (#echo(__LINE__)#)"); }
	else
	{
		direct_output_related_manager ("datalinker_index_view_".$g_entry_array['ddbdatalinker_id'],"pre_module_service_action");
		$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/datalinker/swg_iviewer.php");
		$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php");

		direct_class_init ("output");
		$direct_classes['output']->options_insert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

		$g_continue_check = true;
		$g_entry_type = $g_entry_array['ddbdatalinker_type'];
		$g_entry_service = $g_datalinker_object->get_service ($g_entry_array['ddbdatalinker_sid']);

		if (isset ($g_entry_service['services'][$g_entry_type]))
		{
			$g_entry_service = $g_entry_service['services'][$g_entry_type];
			$direct_cachedata['output_object'] = direct_datalinker_iviewer ($g_entry_service,$g_datalinker_object);
			if ($direct_cachedata['output_object']) { $g_continue_check = $direct_cachedata['output_object']['object_available']; }
		}
		else { $g_continue_check = false; }

		if ($g_continue_check)
		{
			direct_local_integration ("datalinker");

			direct_output_related_manager ("datalinker_index_view_".$g_entry_array['ddbdatalinker_id'],"post_module_service_action");
			$direct_classes['output']->oset ("datalinker","view");
			$direct_classes['output']->options_flush (true);
			$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
			$direct_classes['output']->page_show (direct_local_get ("datalinker_view"));
		}
		else { $direct_classes['error_functions']->error_page ("login","core_access_denied","sWG/#echo(__FILEPATH__)# _a=view_ (#echo(__LINE__)#)"); }
	}
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>