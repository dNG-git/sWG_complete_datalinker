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
* dataport/swgap/datalinker/swg_view.php
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
if (!isset ($direct_settings['datalinker_iview_embedded_objects_per_page'])) { $direct_settings['datalinker_iview_embedded_objects_per_page'] = 10; }
if (!isset ($direct_settings['serviceicon_core_datasub_new'])) { $direct_settings['serviceicon_core_datasub_new'] = "mini_default_option.png"; }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }

if (($direct_settings['a'] == "index")||($direct_settings['a'] == "list_subs")||($direct_settings['a'] == "list_pobjects")||($direct_settings['a'] == "list_mobjects"))
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }

	$g_eid = (isset ($direct_settings['dsd']['deid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['deid'])) : "");
	$g_ecount = (isset ($direct_settings['dsd']['decount']) ? ($direct_classes['basic_functions']->inputfilter_number ($direct_settings['dsd']['decount'])) : $direct_settings['datalinker_iview_embedded_objects_per_page']);
	$g_smode = (isset ($direct_settings['dsd']['dsmode']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['dsmode'])) : "time-desc");
	$direct_cachedata['output_options'] = (isset ($direct_settings['dsd']['doptions']) ? ($direct_classes['basic_functions']->inputfilter_number ($direct_settings['dsd']['doptions'])) : 1);
	$direct_cachedata['output_view'] = (isset ($direct_settings['dsd']['dview']) ? ($direct_classes['basic_functions']->inputfilter_number ($direct_settings['dsd']['dview'])) : "default");
	$direct_cachedata['output_page'] = (isset ($direct_settings['dsd']['page']) ? ($direct_classes['basic_functions']->inputfilter_number ($direct_settings['dsd']['page'])) : 1);
	$g_source = (isset ($direct_settings['dsd']['source']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['source'])) : "");

	$g_source_url = ($g_source ? base64_decode ($g_source) : "m=datalinker&a=view&dsd=[oid]");

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

		$direct_cachedata['page_this'] = "m=dataport&s=swgap;datalinker;iview&a={$direct_settings['a']}&dsd=dtheme+{$direct_cachedata['output_dtheme_mode']}++deid+{$g_eid}++decount+{$g_ecount}++dsmode+{$g_smode}++doptions+{$direct_cachedata['output_options']}++source+".(urlencode ($g_source));
		$direct_cachedata['page_backlink'] = str_replace ("[oid]","deid+{$g_eid}++",$g_source_url);
		$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'] ;

		$g_continue_check = $direct_classes['kernel']->service_init_default ();
		$g_ecount = $direct_settings['datalinker_iview_objects_per_page'];
		$direct_cachedata['output_view'] = "full";
	}
	else
	{
		$direct_cachedata['output_dtheme_mode'] = 0;
		$g_dtheme = false;
		$g_dtheme_embedded = false;

		$g_continue_check = $direct_classes['kernel']->service_init_rboolean ();
		if (($direct_cachedata['output_view'] != "minimal")&&($direct_cachedata['output_view'] != "full")) { $direct_cachedata['output_view'] = "default"; }
	}

	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/dhandler/swg_datalinker.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/dhandler/swg_datalinker_uhome.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/datalinker/swg_iviewer.php"); }

	direct_local_integration ("datalinker");

	if ($g_continue_check)
	{
	//j// BOA
	if ($g_dtheme_embedded) { direct_output_related_manager ("dataport_swgap_datalinker_iview","pre_module_service_action_embedded"); }
	elseif ($g_dtheme) { direct_output_related_manager ("dataport_swgap_datalinker_iview","pre_module_service_action"); }
	else { direct_output_related_manager ("dataport_swgap_datalinker_iview","pre_module_service_action_ajax"); }

	if ($g_dtheme_embedded) { direct_output_theme_subtype ("embedded"); }

	direct_class_init ("output");
	if (($g_dtheme)&&($direct_cachedata['output_options'])&&($direct_cachedata['page_backlink'])) { $direct_classes['output']->options_insert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0"); }

	$g_datalinker_object = ((strpos ($g_eid,"u-") === 0) ? new direct_datalinker_uhome () : new direct_datalinker ());

	$g_datalinker_array = ($g_datalinker_object ? $g_datalinker_object->get ($g_eid) : NULL);

	if ($g_datalinker_array)
	{
		if (($direct_cachedata['output_options'])&&($direct_settings['user']['type'] != "gt")&&(($direct_settings['a'] == "index")||($direct_settings['a'] == "list_subs"))&&($g_datalinker_object->is_sub_allowed ())) { $direct_classes['output']->options_insert (1,"servicemenu","m=datalinker&s=subs&a=new&dsd=deid+{$g_eid}++source+".(urlencode ($g_source)),(direct_local_get ("core_datasub_new_entry")),$direct_settings['serviceicon_core_datasub_new'],"url0"); }

		$direct_cachedata['output_object'] = $g_datalinker_object->parse ();
		$direct_cachedata['output_objects'] = array ();
		$direct_cachedata['output_tid'] = $g_eid;

		if (($direct_settings['a'] == "index")||($direct_settings['a'] == "list_subs")) { $direct_cachedata['output_pages'] = ceil ($g_datalinker_array['ddbdatalinker_subs'] / $g_ecount); }
		elseif (($direct_settings['a'] == "list_pobjects")||($direct_settings['a'] == "list_mobjects")) { $direct_cachedata['output_pages'] = ceil ($g_datalinker_array['ddbdatalinker_objects'] / $g_ecount); }

		if ($direct_cachedata['output_pages'] < 1) { $direct_cachedata['output_pages'] = 1; }
		if ((!$direct_cachedata['output_page'])||($direct_cachedata['output_page'] < 1)) { $direct_cachedata['output_page'] = 1; }

		$g_offset = (($direct_cachedata['output_page'] - 1) * $g_ecount);

		if (($direct_settings['a'] == "index")||($direct_settings['a'] == "list_subs")) { $g_subs_array = $g_datalinker_object->get_subs ("direct_datalinker","",$g_datalinker_array['ddbdatalinker_id'],"","",$g_offset,$g_ecount,$g_smode); }
		elseif ($direct_settings['a'] == "list_pobjects") { $g_subs_array = $g_datalinker_object->get_subs ("direct_datalinker",NULL,$g_datalinker_array['ddbdatalinker_id'],"","",$g_offset,$g_ecount,$g_smode); } 
		elseif ($direct_settings['a'] == "list_mobjects") { $g_subs_array = $g_datalinker_object->get_subs ("direct_datalinker",$g_datalinker_array['ddbdatalinker_id'],NULL,"","",$g_offset,$g_ecount,$g_smode); }

		foreach ($g_subs_array as $g_sub_object)
		{
			$g_sub_array = $g_sub_object->get ();
			$g_service_type = $g_sub_array['ddbdatalinker_type'];
			$g_service_array = $g_datalinker_object->get_service ($g_sub_array['ddbdatalinker_sid']);

			if (isset ($g_service_array['services'][$g_service_type]))
			{
				$g_service_array = $g_service_array['services'][$g_service_type];
				$g_service_array['datalinker_iview_options'] = $direct_cachedata['output_options'];
				$g_service_array['datalinker_iview_source'] = $g_source_url;

				$g_iviewer_array = direct_datalinker_iviewer ($g_service_array,$g_sub_object);
				if ($g_iviewer_array) { $direct_cachedata['output_objects'][] = $g_iviewer_array; }
			}
		}
	
		if ($g_dtheme)
		{
			if ($g_dtheme_embedded)
			{
				direct_output_related_manager ("dataport_swgap_datalinker_iview","post_module_service_action_embedded");
				$direct_cachedata['output_page_url'] = "m=dataport&s=swgap;datalinker;iview&a={$direct_settings['a']}&dsd=dtheme+2++deid+{$g_eid}++decount+{$g_ecount}++dsmode+{$g_smode}++doptions+{$direct_cachedata['output_options']}++source+".(urlencode ($g_source))."++";
				$direct_classes['output']->oset ("datalinker_embedded","iview");
			}
			else
			{
				direct_output_related_manager ("dataport_swgap_datalinker_iview","post_module_service_action");
				$direct_cachedata['output_page_url'] = "m=dataport&s=swgap;datalinker;iview&a={$direct_settings['a']}&dsd=dtheme+1++deid+{$g_eid}++decount+{$g_ecount}++dsmode+{$g_smode}++doptions+{$direct_cachedata['output_options']}++source+".(urlencode ($g_source))."++";
				$direct_classes['output']->oset ("datalinker","iview");
			}

			$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);

			if ((isset ($direct_cachedata['output_object']['subs_title']))&&(strlen ($direct_cachedata['output_object']['subs_title']))) { $direct_classes['output']->page_show ($direct_cachedata['output_object']['subs_title']); }
			else { $direct_classes['output']->page_show ($direct_cachedata['output_object']['title']); }
		}
		else
		{
			$direct_cachedata['output_page_url'] = "javascript:djs_dataport_{$direct_cachedata['output_tid']}_call_url0('m=dataport&amp;s=swgap;datalinker;iview&amp;a={$direct_settings['a']}&amp;dsd=dtheme+0++deid+{$g_eid}++decount+{$g_ecount}++dsmode+{$g_smode}++doptions+{$direct_cachedata['output_options']}++page+[page]++source+".(urlencode ($g_source))."')";

			$direct_classes['output']->header (false);
			header ("Content-type: text/xml; charset=".$direct_local['lang_charset']);

echo ("<?xml version='1.0' encoding='$direct_local[lang_charset]' ?>
".(direct_output_smiley_decode ($direct_classes['output']->oset_content ("datalinker_embedded","ajax_iview"))));
		}
	}
	elseif ($g_dtheme) { $direct_classes['error_functions']->error_page ("standard","core_datasub_eid_invalid","sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
}

//j// EOF
?>