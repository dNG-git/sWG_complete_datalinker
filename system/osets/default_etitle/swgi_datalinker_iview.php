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
$Id: swgi_datalinker_iview.php,v 1.3 2009/03/02 17:54:03 s4u Exp $
#echo(sWGdatalinkerVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* osets/default_etitle/swgi_datalinker_iview.php
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

//f// direct_datalinker_oset_iview ($f_target,$f_data,$f_embedded_count,$f_source = "",$f_view = "default",$f_view_options = true,$f_hide_override = NULL,$f_prefix = "")
/**
* direct_datalinker_oset_iview ()
*
* @param  string $f_target Target AJAX mode
* @param  array $f_data DataLinker based output data
* @param  integer $f_embedded_count iViewer elements to show
* @param  string $f_source Base64 encoded source URL to use as reference
* @param  string $f_view View mode to be used
* @param  boolean $f_view_options Show iViewer options
* @param  mixed $f_hide_override True to hide the iView area, NULL to use
*         the predefined setting
* @param  string $f_prefix Key prefix 
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_datalinker_oset_iview ($f_target,$f_data,$f_embedded_count,$f_source = "",$f_view = "default",$f_view_options = true,$f_hide_override = NULL,$f_prefix = "")
{
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_datalinker_oset_iview ($f_target,+f_data,$f_embedded_count,$f_source,$f_view,+f_view_options,+f_hide_override,$f_prefix)- (#echo(__LINE__)#)"); }

	if ((isset ($f_data[$f_prefix."subs_id"]))&&(($f_data[$f_prefix."subs_allowed"])||($f_data[$f_prefix."subs_available"])))
	{
		if (!$f_data[$f_prefix."subs"]) { $f_data[$f_prefix."subs"] = 0; }

		if ($f_view_options) { $f_view_options_code = "++doptions+1"; }
		else { $f_view_options_code = "++doptions+0"; }

		$f_ajax_call = addslashes (direct_linker ("url0","m=dataport&s=ajax;datalinker;iview&a=content&dsd=deid+[f_id]++tid+".$f_data[$f_prefix."oid"]."++source+".(urlencode ($f_source)),false));
		$f_ajax_call_url0 = addslashes (direct_linker ("url0","[f_url]",false));

$f_return = ("<script language='JavaScript1.5' type='text/javascript'><![CDATA[
if ((djs_swgAJAX)&&(djs_swgDOM))
{
	if (typeof (djs_var['datalinker_iview_content_requested_id']) == 'undefined') { djs_var['datalinker_iview_content_requested_id'] = ''; }

	function djs_datalinker_iview_".$f_data[$f_prefix."subs_id"]."_call (f_id)
	{
		if (djs_var['datalinker_iview_content_requested_id'] == '')
		{
			djs_var['datalinker_iview_content_requested_id'] = f_id;
			djs_swgAJAX_call (\"datalinker_iview_".$f_data[$f_prefix."subs_id"]."_\" + f_id + \"_point\",djs_datalinker_iview_".$f_data[$f_prefix."subs_id"]."_response,'GET',('$f_ajax_call'.replace (/\[f_id\]/g,f_id)),5000);
		}
	}

	function djs_datalinker_iview_".$f_data[$f_prefix."subs_id"]."_response ()
	{
		if (djs_var['datalinker_iview_content_requested_id'] == '') { djs_swgAJAX_response_ripoint (\"datalinker_iview_".$f_data[$f_prefix."subs_id"]."_point\",\"swgAJAX_datalinker_iview_".$f_data[$f_prefix."subs_id"]."_point\",''); }
		else
		{
			if (djs_swgAJAX_response_ripoint (\"datalinker_iview_".$f_data[$f_prefix."subs_id"]."_\" + djs_var['datalinker_iview_content_requested_id'] + \"_point\",\"swgAJAX_datalinker_iview_".$f_data[$f_prefix."subs_id"]."_\" + djs_var['datalinker_iview_content_requested_id'] + \"_point\",'') != 0) { djs_var['datalinker_iview_content_requested_id'] = ''; }
		}
	}

	function djs_dataport_".$f_data[$f_prefix."subs_id"]."_call_url0 (f_url)
	{
		if (djs_var['datalinker_iview_content_requested_id'] == '') { djs_swgAJAX_call (\"datalinker_iview_".$f_data[$f_prefix."subs_id"]."_point\",djs_datalinker_iview_".$f_data[$f_prefix."subs_id"]."_response,'GET',('$f_ajax_call_url0'.replace (/\[f_url\]/g,f_url)),5000); }
	}
}
]]></script>");

		if ((($f_hide_override === NULL)&&($f_data[$f_prefix."subs_hide"]))||(($f_hide_override !== NULL)&&($f_hide_override)))
		{
$f_return .= ("<p id='swgAJAX_datalinker_iview_".$f_data[$f_prefix."subs_id"]."_point' class='pagecontent'><a href='".(direct_linker ("url0","m=dataport&s=swgap;datalinker;iview&a=list_{$f_target}&dsd=dtheme+1++deid+".$f_data[$f_prefix."oid"]."++dview+{$f_view}{$f_view_options_code}++source+".$f_source))."' target='_self'>".$f_data[$f_prefix."subs_link_title"]."</a> (".$f_data[$f_prefix."subs"].")</p><script language='JavaScript1.5' type='text/javascript'><![CDATA[
if ((djs_swgAJAX)&&(djs_swgDOM)) { djs_swgDOM_replace (\"<p id='swgAJAX_datalinker_iview_".$f_data[$f_prefix."subs_id"]."_point' class='pagecontent'><a href=\"javascript:djs_dataport_".$f_data[$f_prefix."subs_id"]."_call_url0('m=dataport&s=swgap;datalinker;iview&a=list_{$f_target}&dsd=dtheme+0++deid+".$f_data[$f_prefix."oid"]."++decount+$f_embedded_count++dview+{$f_view}{$f_view_options_code}++source+{$f_source}');\" target='_self'>".$f_data[$f_prefix."subs_link_title"]."</a> (".$f_data[$f_prefix."subs"].")</p>\",'swgAJAX_datalinker_iview_".$f_data[$f_prefix."subs_id"]."_point'); }
]]></script>");
		}
		else
		{
$f_return .= ("<p id='swgAJAX_datalinker_iview_".$f_data[$f_prefix."subs_id"]."_point' class='pagecontent'>".(direct_local_get ("core_datasub_error_1"))."<a href='".(direct_linker ("url0","m=dataport&s=swgap;datalinker;iview&a=list_{$f_target}&dsd=dtheme+1++deid+".$f_data[$f_prefix."oid"]."++dview+{$f_view}{$f_view_options_code}++source+".$f_source))."' target='_self'>".(direct_local_get ("core_datasub_error_2"))."</a>".(direct_local_get ("core_datasub_error_3"))."</p><script language='JavaScript1.5' type='text/javascript'><![CDATA[
if ((djs_swgAJAX)&&(djs_swgDOM))
{
	if ((djs_swgDOM_content_editable)&&(djs_swgDOM_elements_editable))
	{
		djs_swgDOM_replace (\"<p id='swgAJAX_datalinker_iview_".$f_data[$f_prefix."subs_id"]."_point' class='pagecontent'>".(direct_local_get ("core_datasub_loading","text"))."</p>\",'swgAJAX_datalinker_iview_".$f_data[$f_prefix."subs_id"]."_point');
		djs_var['core_run_onload'].push ('djs_dataport_".$f_data[$f_prefix."subs_id"]."_call_url0 (\"m=dataport&s=swgap;datalinker;iview&a=list_{$f_target}&dsd=dtheme+0++deid+".$f_data[$f_prefix."oid"]."++decount+$f_embedded_count++dview+{$f_view}{$f_view_options_code}++source+{$f_source}\")');
	}
}
]]></script>");
		}
	}

	return $f_return;
}

//f// direct_datalinker_oset_iview_list ($f_objects_array,$f_view = "default")
/**
* direct_datalinker_oset_iview_list ()
*
* @param  array $f_objects_array DataLinker objects to output
* @param  string $f_view View mode to use
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_datalinker_oset_iview_list ($f_objects_array,$f_view = "default")
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_datalinker_oset_iview_list (+f_objects,$f_view)- (#echo(__LINE__)#)"); }

	$f_return = "";

	foreach ($f_objects_array as $f_object_array)
	{
		if ((isset ($f_object_array['marked']))&&($f_object_array['marked'])) { $f_return .= "<div class='pageborder2' style='margin:1px 0px'><div id='swgAJAX_datalinker_iview_{$direct_cachedata['output_tid']}_{$f_object_array['object_id']}_point' class='pagehighlightborder2'><p class='pagecontenttitle'>"; }
		else { $f_return .= "<div class='pageborder2' style='margin:1px 0px'><div id='swgAJAX_datalinker_iview_{$direct_cachedata['output_tid']}_{$f_object_array['object_id']}_point'><p class='pagecontenttitle'>"; }

		if ($f_object_array['object_title_type']) { $f_return .= "<span style='font-size:10px'>{$f_object_array['object_title_type']}:</span> "; }
		if ($f_object_array['object_new']) { $f_return .= "<img src='".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_themes]/$direct_settings[theme]/status_object_new.png",true,false))."' border='0' alt='".(direct_local_get ("datalinker_entry_new"))."' title='".(direct_local_get ("datalinker_entry_new"))."' style='float:right' />"; }
		if ($f_object_array['object_symbol']) { $f_return .= "<img src='{$f_object_array['object_symbol']}' border='0' alt='' title='' style='float:left;margin-right:5px' />"; }

		if ((isset ($f_object_array['object_title_alt']))&&(strlen ($f_object_array['object_title_alt'])))
		{
			if ($f_object_array['object_url']) { $f_return .= "<a href='{$f_object_array['object_url']}' target='_blank'>{$f_object_array['object_title_alt']}</a>"; }
			else { $f_return .= $f_object_array['object_title_alt']; }
		}
		else
		{
			if ($f_object_array['object_url']) { $f_return .= "<a href='{$f_object_array['object_url']}' target='_blank'>{$f_object_array['object_title']}</a>"; }
			else { $f_return .= $f_object_array['object_title']; }
		}

		if (strlen ($f_object_array['object_entries'])) { $f_return .= " <span style='font-size:10px'>({$f_object_array['object_entries']})</span>"; }
		$f_return .= "</p>";

		if ($f_object_array['object_last_time'])
		{
			if (strlen ($f_object_array['object_last_username']))
			{
				$f_return .= "<p class='pageextracontent' style='font-size:10px;font-weight:bold'>";
				if ($f_object_array['object_last_useravatar']) { $f_return .= "<img src='{$f_object_array['object_last_useravatar']}' border='0' alt='' title='' style='float:right;margin-left:5px' />"; }
				$f_return .= (direct_local_get ("core_datasub_last_entry_1_1")).$f_object_array['object_last_time'].(direct_local_get ("core_datasub_last_entry_1_2"));

				if ($f_object_array['object_last_userpageurl']) { $f_return .= "<a href=\"{$f_object_array['object_last_userpageurl']}\" target='_blank'>{$f_object_array['object_last_username']}</a>"; }
				else { $f_return .= $f_object_array['object_last_username']; }

				$f_return .= (direct_local_get ("core_datasub_last_entry_1_3"))."</p>";
			}
			else { $f_return .= "<p class='pageextracontent' style='font-size:10px;font-weight:bold'>".(direct_local_get ("core_datasub_last_entry_0_1")).$f_object_array['object_last_time'].(direct_local_get ("core_datasub_last_entry_0_2"))."</p>"; }
		}

		switch ($f_view)
		{
		case "full":
		{
			if (strlen ($f_object_array['object_content'])) { $f_return .= "<div class='pageextracontent'>{$f_object_array['object_content']}</div>"; }
			elseif (strlen ($f_object_array['object_preview'])) { $f_return .= "<div class='pageextracontent'>{$f_object_array['object_preview']}</div>"; }
			elseif (strlen ($f_object_array['object_desc'])) { $f_return .= "<p class='pageextracontent'>{$f_object_array['object_desc']}</p>"; }

			break 1;
		}
		case "minimal":
		{
			if (strlen ($f_object_array['object_desc'])) { $f_return .= "<p class='pageextracontent'>{$f_object_array['object_desc']}</p>"; }
			break 1;
		}
		default:
		{
			$f_p_check = true;

			if (strlen ($f_object_array['object_preview'])) { $f_return .= "<div class='pageextracontent'>".$f_object_array['object_preview']; }
			elseif (strlen ($f_object_array['object_desc'])) { $f_return .= "<p class='pageextracontent'>".$f_object_array['object_desc']; }
			else { $f_p_check = false; }

			if ($f_object_array['object_extended_available'])
			{
				if ($f_p_check) { $f_return .= " "; }
				else
				{
					$f_return .= "<p class='pageextracontent'>";
					$f_p_check = true;
				}

				$f_return .= "<span style='font-weight:bold;font-size:8px'><a href=\"javascript:djs_datalinker_iview_content_{$direct_cachedata['output_tid']}_call('{$f_object_array['object_id']}')\">".(direct_local_get ("core_datasub_request_content"))."</a></span>";
			}

			if ($f_p_check)
			{
				if (strlen ($f_object_array['object_preview'])) { $f_return .= "</div>"; }
				else { $f_return .= "</p>"; }
			}
		}
		}

		if (($f_view != "minimal")&&(isset ($f_object_array['category_id'])))
		{
			$f_return .= "<p class='pageextracontent' style='font-size:8px'>";
			if ($f_object_array['category_title_type']) { $f_return .= $f_object_array['category_title_type'].": "; }

			if ($f_object_array['category_url']) { $f_return .= "<a href='{$f_object_array['category_url']}' target='_blank'>{$f_object_array['category_title']}</a>"; }
			else { $f_return .= $f_object_array['category_title']; }

			if (strlen ($f_object_array['category_entries'])) { $f_return .= " ({$f_object_array['category_entries']})"; }
			$f_return .= "</p>";
		}

		$f_return .= "</div>";
		if (isset ($f_object_array['pageurl_marker'],$f_object_array['marker_title'])) { $f_return .= "\n<p class='pageborder2' style='text-align:center'><span class='pageextracontent' style='font-weight:bold'><a href=\"$f_object_array[pageurl_marker]\" target='_self'>$f_object_array[marker_title]</a></span></p>"; }
		$f_return .= "</div>";
	}

	return $f_return;
}

//f// direct_datalinker_oset_iview_mobjects ($f_data,$f_embedded_count,$f_source = "",$f_view = "default",$f_view_options = true,$f_hide_override = NULL,$f_prefix = "")
/**
* direct_datalinker_oset_iview_mobjects ()
*
* @param  array $f_data DataLinker based output data
* @param  integer $f_embedded_count iViewer elements to show
* @param  string $f_source Base64 encoded source URL to use as reference
* @param  string $f_view View mode to be used
* @param  boolean $f_view_options Show iViewer options
* @param  mixed $f_hide_override True to hide the iView area, NULL to use
*         the predefined setting
* @param  string $f_prefix Key prefix 
* @uses   direct_datalinker_oset_iview()
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_datalinker_oset_iview_mobjects ($f_data,$f_embedded_count,$f_source = "",$f_view = "default",$f_view_options = true,$f_hide_override = NULL,$f_prefix = "")
{
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_datalinker_oset_iview_mobjects (+f_data,$f_embedded_count,$f_source,$f_view,+f_view_options,+f_hide_override,$f_prefix)- (#echo(__LINE__)#)"); }
	return direct_datalinker_oset_iview ("mobjects",$f_data,$f_embedded_count,$f_source,$f_view,$f_view_options,$f_hide_override,$f_prefix);
}

//f// direct_datalinker_oset_iview_pobjects ($f_data,$f_embedded_count,$f_source = "",$f_view = "default",$f_view_options = true,$f_hide_override = NULL,$f_prefix = "")
/**
* direct_datalinker_oset_iview_pobjects ()
*
* @param  array $f_data DataLinker based output data
* @param  integer $f_embedded_count iViewer elements to show
* @param  string $f_source Base64 encoded source URL to use as reference
* @param  string $f_view View mode to be used
* @param  boolean $f_view_options Show iViewer options
* @param  mixed $f_hide_override True to hide the iView area, NULL to use
*         the predefined setting
* @param  string $f_prefix Key prefix 
* @uses   direct_datalinker_oset_iview()
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_datalinker_oset_iview_pobjects ($f_data,$f_embedded_count,$f_source = "",$f_view = "default",$f_view_options = true,$f_hide_override = NULL,$f_prefix = "")
{
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_datalinker_oset_iview_pobjects (+f_data,$f_embedded_count,$f_source,$f_view,+f_view_options,+f_hide_override,$f_prefix)- (#echo(__LINE__)#)"); }
	return direct_datalinker_oset_iview ("pobjects",$f_data,$f_embedded_count,$f_source,$f_view,$f_view_options,$f_hide_override,$f_prefix);
}

//f// direct_datalinker_oset_iview_subs ($f_data,$f_embedded_count,$f_source = "",$f_view = "default",$f_view_options = true,$f_hide_override = NULL,$f_prefix = "")
/**
* direct_datalinker_oset_iview_subs ()
*
* @param  array $f_data DataLinker based output data
* @param  integer $f_embedded_count iViewer elements to show
* @param  string $f_source Base64 encoded source URL to use as reference
* @param  string $f_view View mode to be used
* @param  boolean $f_view_options Show iViewer options
* @param  mixed $f_hide_override True to hide the iView area, NULL to use
*         the predefined setting
* @param  string $f_prefix Key prefix 
* @uses   direct_datalinker_oset_iview()
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_datalinker_oset_iview_subs ($f_data,$f_embedded_count,$f_source = "",$f_view = "default",$f_view_options = true,$f_hide_override = NULL,$f_prefix = "")
{
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_datalinker_oset_iview_subs (+f_data,$f_embedded_count,$f_source,$f_view,+f_view_options,+f_hide_override,$f_prefix)- (#echo(__LINE__)#)"); }
	return direct_datalinker_oset_iview ("subs",$f_data,$f_embedded_count,$f_source,$f_view,$f_view_options,$f_hide_override,$f_prefix);
}

//f// direct_datalinker_oset_iview_url ($f_url,$f_eid,$f_hide = false)
/**
* direct_datalinker_oset_iview_url ()
*
* @param  string $f_url AJAX URL to call
* @param  string $f_eid DataLinker element ID
* @param  boolean $f_hide True to hide the iView area
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_datalinker_oset_iview_url ($f_url,$f_eid,$f_hide = false)
{
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_datalinker_oset_iview_url ($f_url,$f_eid,+f_hide)- (#echo(__LINE__)#)"); }

	$f_ajax_call = addslashes (direct_linker ("url0","m=dataport&s=ajax;datalinker;iview&a=content&dsd=deid+[f_id]++tid+".$f_eid,false));
	$f_ajax_call_url0 = addslashes (direct_linker ("url0","[f_url]",false));

$f_return = ("<script language='JavaScript1.5' type='text/javascript'><![CDATA[
if ((djs_swgAJAX)&&(djs_swgDOM))
{
	if (typeof (djs_var['datalinker_iview_content_requested_id']) == 'undefined') { djs_var['datalinker_iview_content_requested_id'] = ''; }

	function djs_datalinker_iview_{$f_eid}_call (f_id)
	{
		if (djs_var['datalinker_iview_content_requested_id'] == '')
		{
			djs_var['datalinker_iview_content_requested_id'] = f_id;
			djs_swgAJAX_call (\"datalinker_iview_{$f_eid}_\" + f_id + \"_point\",djs_datalinker_iview_{$f_eid}_response,'GET',('$f_ajax_call'.replace (/\[f_id\]/g,f_id)),5000);
		}
	}

	function djs_datalinker_iview_{$f_eid}_response ()
	{
		if (djs_var['datalinker_iview_content_requested_id'] == '') { djs_swgAJAX_response_ripoint (\"datalinker_iview_{$f_eid}_point\",\"swgAJAX_datalinker_iview_{$f_eid}_point\",''); }
		else
		{
			if (djs_swgAJAX_response_ripoint (\"datalinker_iview_{$f_eid}_\" + djs_var['datalinker_iview_content_requested_id'] + \"_point\",\"swgAJAX_datalinker_iview_{$f_eid}_\" + djs_var['datalinker_iview_content_requested_id'] + \"_point\",'') != 0) { djs_var['datalinker_iview_content_requested_id'] = ''; }
		}
	}

	function djs_dataport_{$f_eid}_call_url0 (f_url)
	{
		if (djs_var['datalinker_iview_content_requested_id'] == '') { djs_swgAJAX_call (\"datalinker_iview_{$f_eid}_point\",djs_datalinker_iview_{$f_eid}_response,'GET',('$f_ajax_call_url0'.replace (/\[f_url\]/g,f_url)),5000); }
	}
}
]]></script>");

	if ($f_hide)
	{
$f_return .= ("<p id='swgAJAX_datalinker_iview_{$f_eid}_point' class='pagecontent'><a href='".(direct_linker ("url0",$f_url."++dtheme+1"))."' target='_self'>".(direct_local_get ("core_datasub_title_link_default"))."</a></p><script language='JavaScript1.5' type='text/javascript'><![CDATA[
if ((djs_swgAJAX)&&(djs_swgDOM))
{
	if ((djs_swgDOM_content_editable)&&(djs_swgDOM_elements_editable)) { djs_swgDOM_replace (\"<p id='swgAJAX_datalinker_iview_{$f_eid}_point' class='pagecontent'><a href=\"javascript:djs_dataport_{$f_eid}_call_url0('$f_url');\">".(direct_local_get ("core_datasub_title_link_default"))."</a></p>\",'swgAJAX_datalinker_iview_{$f_eid}_point'); }
}
]]></script>");
	}
	else
	{
$f_return .= ("<p id='swgAJAX_datalinker_iview_{$f_eid}_point' class='pagecontent'>".(direct_local_get ("core_datasub_error_1"))."<a href='".(direct_linker ("url0",$f_url."++dtheme+1"))."' target='_self'>".(direct_local_get ("core_datasub_error_2"))."</a>".(direct_local_get ("core_datasub_error_3"))."</p><script language='JavaScript1.5' type='text/javascript'><![CDATA[
if ((djs_swgAJAX)&&(djs_swgDOM))
{
	djs_swgDOM_replace (\"<p id='swgAJAX_datalinker_iview_{$f_eid}_point' class='pagecontent'>".(direct_local_get ("core_datasub_loading","text"))."</p>\",'swgAJAX_datalinker_iview_{$f_eid}_point');
	djs_var['core_run_onload'].push (\"djs_dataport_{$f_eid}_call_url0 ('$f_url')\");
}
]]></script>");
	}

	return $f_return;
}

//j// EOF
?>