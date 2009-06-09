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
$Id: swg_datalinker.php,v 1.4 2009/01/03 10:35:44 s4u Exp $
#echo(sWGdatalinkerVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* osets/default/swg_datalinker.php
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

//f// direct_output_oset_datalinker_iview ()
/**
* direct_output_oset_datalinker_iview ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_datalinker_iview ()
{
	global $direct_cachedata,$direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_datalinker_iview ()- (#echo(__LINE__)#)"); }

	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_datalinker_iview.php");

	if ((isset ($direct_cachedata['output_object']['subs_title']))&&(strlen ($direct_cachedata['output_object']['subs_title']))) { $f_return = "<p class='pagecontenttitle'>{$direct_cachedata['output_object']['subs_title']}</p>"; }
	else { $f_return = "<p class='pagecontenttitle'>{$direct_cachedata['output_object']['title']}</p>"; }

	if (empty ($direct_cachedata['output_objects'])) { $f_return .= "<p class='pagecontent' style='font-weight:bold'>".(direct_local_get ("datalinker_subs_list_empty"))."</p>"; }
	else
	{
		if ($direct_cachedata['output_pages'] > 1) { $f_return .= "\n<p class='pageborder2' style='text-align:center'><span class='pageextracontent' style='font-size:10px'>".(direct_output_pages_generator ($direct_cachedata['output_page_url'],$direct_cachedata['output_pages'],$direct_cachedata['output_page'],false))."</span></p>"; }
		$f_return .= direct_datalinker_oset_iview_list ($direct_cachedata['output_objects'],"full");
		if ($direct_cachedata['output_pages'] > 1) { $f_return .= "\n<p class='pageborder2' style='text-align:center'><span class='pageextracontent' style='font-size:10px'>".(direct_output_pages_generator ($direct_cachedata['output_page_url'],$direct_cachedata['output_pages'],$direct_cachedata['output_page'],false))."</span></p>"; }
	}

	return $f_return;
}

//f// direct_output_oset_datalinker_list_iviews ()
/**
* direct_output_oset_datalinker_list_iviews ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_datalinker_list_iviews ()
{
	global $direct_cachedata,$direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_datalinker_list_iviews ()- (#echo(__LINE__)#)"); }

	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_datalinker_iview.php");
	$f_ajax_call = addslashes (direct_linker ("url0","m=dataport&s=ajax;datalinker;iview&a=content&dsd=deid+[f_id]++tid+{$direct_cachedata['output_tid']}++source+".(urlencode ($direct_cachedata['output_source'])),false));

$f_return = ("<p class='pagecontenttitle'>{$direct_cachedata['output_title']}</p><script language='JavaScript1.5' type='text/javascript'><![CDATA[
if ((djs_swgAJAX)&&(djs_swgDOM))
{
	if (typeof (djs_var['datalinker_iview_content_requested_id']) == 'undefined') { djs_var['datalinker_iview_content_requested_id'] = ''; }

	function djs_datalinker_iview_{$direct_cachedata['output_tid']}_call (f_id)
	{
		if (djs_var['datalinker_iview_content_requested_id'] == '')
		{
			djs_var['datalinker_iview_content_requested_id'] = f_id;
			djs_swgAJAX_call (\"datalinker_iview_{$direct_cachedata['output_tid']}_\" + f_id + \"_point\",djs_datalinker_iview_{$direct_cachedata['output_tid']}_response,'GET',('$f_ajax_call'.replace (/\[f_id\]/g,f_id)),5000);
		}
	}

	function djs_datalinker_iview_{$direct_cachedata['output_tid']}_response ()
	{
		if (djs_var['datalinker_iview_content_requested_id'] != '')
		{
			if (djs_swgAJAX_response_ripoint (\"datalinker_iview_{$direct_cachedata['output_tid']}_\" + djs_var['datalinker_iview_content_requested_id'] + \"_point\",\"swgAJAX_datalinker_iview_{$direct_cachedata['output_tid']}_\" + djs_var['datalinker_iview_content_requested_id'] + \"_point\",'') != 0) { djs_var['datalinker_iview_content_requested_id'] = ''; }
		}
	}
}
]]></script>");

	if (empty ($direct_cachedata['output_objects'])) { $f_return .= "\n<p class='pagecontent' style='font-weight:bold'>".(direct_local_get ("datalinker_subs_list_empty"))."</p>"; }
	else
	{
		if ($direct_cachedata['output_pages'] > 1) { $f_return .= "\n<p class='pageborder2' style='text-align:center'><span class='pageextracontent' style='font-size:10px'>".(direct_output_pages_generator ($direct_cachedata['output_page_url'],$direct_cachedata['output_pages'],$direct_cachedata['output_page']))."</span></p>"; }
		$f_return .= direct_datalinker_oset_iview_list ($direct_cachedata['output_objects']);
		if ($direct_cachedata['output_pages'] > 1) { $f_return .= "\n<p class='pageborder2' style='text-align:center'><span class='pageextracontent' style='font-size:10px'>".(direct_output_pages_generator ($direct_cachedata['output_page_url'],$direct_cachedata['output_pages'],$direct_cachedata['output_page']))."</span></p>"; }
	}

	return $f_return;
}

//f// direct_output_oset_datalinker_view ()
/**
* direct_output_oset_datalinker_view ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.00
*/
function direct_output_oset_datalinker_view ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_datalinker_view ()- (#echo(__LINE__)#)"); }

	$f_return = "<p class='pagecontenttitle'>";
	if ($direct_cachedata['output_object']['object_new']) { $f_return .= "<img src='".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_themes]/$direct_settings[theme]/status_object_new.png",true,false))."' border='0' alt='".(direct_local_get ("datalinker_entry_new"))."' title='".(direct_local_get ("datalinker_entry_new"))."' style='float:right' />"; }
	if ($direct_cachedata['output_object']['object_title_type']) { $f_return .= "<span style='font-size:10px'>{$direct_cachedata['output_object']['object_title_type']}:</span> "; }
	if ($direct_cachedata['output_object']['object_symbol']) { $f_return .= "<img src='{$direct_cachedata['output_object']['object_symbol']}' border='0' alt='' title='' style='float:left;margin-right:5px' />"; }

	if ((isset ($direct_cachedata['output_object']['object_title_alt']))&&(strlen ($direct_cachedata['output_object']['object_title_alt'])))
	{
		if ($direct_cachedata['output_object']['object_url']) { $f_return .= "<a href='{$direct_cachedata['output_object']['object_url']}' target='_blank'>{$direct_cachedata['output_object']['object_title_alt']}</a>"; }
		else { $f_return .= $direct_cachedata['output_object']['object_title_alt']; }
	}
	else
	{
		if ($direct_cachedata['output_object']['object_url']) { $f_return .= "<a href='{$direct_cachedata['output_object']['object_url']}' target='_blank'>{$direct_cachedata['output_object']['object_title']}</a>"; }
		else { $f_return .= $direct_cachedata['output_object']['object_title']; }
	}

	if (strlen ($direct_cachedata['output_object']['object_entries'])) { $f_return .= " <span style='font-size:10px'>({$direct_cachedata['output_object']['object_entries']})</span>"; }
	$f_return .= "</p>";

	if ($direct_cachedata['output_object']['object_last_time'])
	{
		if (strlen ($direct_cachedata['output_object']['object_last_username']))
		{
			$f_return .= "\n<p class='pagecontent' style='font-size:10px;font-weight:bold'>";
			if ($direct_cachedata['output_object']['object_last_useravatar']) { $f_return .= "<img src='{$direct_cachedata['output_object']['object_last_useravatar']}' border='0' alt='' title='' style='float:right;margin-left:5px' />"; }
			$f_return .= (direct_local_get ("core_datasub_last_entry_1_1")).$direct_cachedata['output_object']['object_last_time'].(direct_local_get ("core_datasub_last_entry_1_2"));

			if ($direct_cachedata['output_object']['object_last_userpageurl']) { $f_return .= "<a href=\"{$direct_cachedata['output_object']['object_last_userpageurl']}\" target='_self'>{$direct_cachedata['output_object']['object_last_username']}</a>"; }
			else { $f_return .= $direct_cachedata['output_object']['object_last_username']; }

			$f_return .= (direct_local_get ("core_datasub_last_entry_1_3"))."</p>";
		}
		else { $f_return .= "\n<p class='pagecontent' style='font-size:10px;font-weight:bold'>".(direct_local_get ("core_datasub_last_entry_0_1")).$direct_cachedata['output_object']['object_last_time'].(direct_local_get ("core_datasub_last_entry_0_2"))."</p>"; }
	}

	if (strlen ($direct_cachedata['output_object']['object_content'])) { $f_return .= "\n<div class='pagecontent'>{$direct_cachedata['output_object']['object_content']}</div>"; }
	elseif (strlen ($direct_cachedata['output_object']['object_preview'])) { $f_return .= "\n<div class='pagecontent'>{$direct_cachedata['output_object']['object_preview']}</div>"; }
	elseif (strlen ($direct_cachedata['output_object']['object_desc'])) { $f_return .= "\n<p class='pagecontent'>{$direct_cachedata['output_object']['object_desc']}</p>"; }

	if (isset ($direct_cachedata['output_object']['category_id']))
	{
		$f_return .= "\n<p class='pagecontent' style='font-size:8px'>";
		if ($direct_cachedata['output_object']['category_title_type']) { $f_return .= $direct_cachedata['output_object']['category_title_type'].": "; }

		if ($direct_cachedata['output_object']['category_url']) { $f_return .= "<a href='{$direct_cachedata['output_object']['category_url']}' target='_self'>{$direct_cachedata['output_object']['category_title']}</a>"; }
		else { $f_return .= $direct_cachedata['output_object']['category_title']; }

		if (strlen ($direct_cachedata['output_object']['category_entries'])) { $f_return .= " ({$direct_cachedata['output_object']['category_entries']})"; }
		$f_return .= "</p>";
	}

	return $f_return;
}

//j// EOF
?>