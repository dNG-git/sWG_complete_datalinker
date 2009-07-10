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
* dataport/ajax/datalinker/swg_view.php
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

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "content"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// $direct_settings['a'] == "content"
case "content":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=content_ (#echo(__LINE__)#)"); }

	$g_eid = (isset ($direct_settings['dsd']['deid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['deid'])) : "");
	$direct_cachedata['output_tid'] = (isset ($direct_settings['dsd']['tid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['tid'])) : "");

	$g_continue_check = $direct_classes['kernel']->service_init_rboolean ();
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/dhandler/swg_datalinker.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/dhandler/swg_datalinker_uhome.php"); }
	if ($g_continue_check) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/datalinker/swg_iviewer.php"); }

	if ($g_continue_check)
	{
	//j// BOA
	direct_output_related_manager ("datalinker_iview_content","pre_module_service_action_ajax");

	if (strpos ($g_eid,"u-") === 0) { $g_datalinker_object = new direct_datalinker_uhome (); }
	else { $g_datalinker_object = new direct_datalinker (); }

	if ($g_datalinker_object) { $g_datalinker_array = $g_datalinker_object->get ($g_eid); }

	if ((is_array ($g_datalinker_array))&&(direct_class_init ("output")))
	{
		$direct_cachedata['output_object'] = array ();

		$g_service_type = $g_datalinker_array['ddbdatalinker_type'];
		$g_service_array = $g_datalinker_object->get_service ($g_datalinker_array['ddbdatalinker_sid']);

		if (isset ($g_service_array['services'][$g_service_type]))
		{
			$g_service_array = $g_service_array['services'][$g_service_type];
			$g_iviewer_array = direct_datalinker_iviewer ($g_service_array,$g_datalinker_object);
			if ($g_iviewer_array) { $direct_cachedata['output_object'] = $g_iviewer_array; }
		}

		direct_output_related_manager ("datalinker_iview_content","post_module_service_action_ajax");
		$direct_classes['output']->header (false);
		header ("Content-type: text/xml; charset=".$direct_local['lang_charset']);

echo direct_output_smiley_decode ("<?xml version='1.0' encoding='$direct_local[lang_charset]' ?>
".(direct_output_smiley_decode ($direct_classes['output']->oset_content ("datalinker_embedded","ajax_iview_content"))));
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