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
* OOP (Object Oriented Programming) requires an abstract data
* handling. The sWG is OO (where it makes sense).
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
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;gpl
*             GNU General Public License 2
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

/* -------------------------------------------------------------------------
Testing for required classes
------------------------------------------------------------------------- */

$g_continue_check = ((defined ("CLASS_direct_datalinker_uhome")) ? false : true);
if (!defined ("CLASS_direct_datalinker")) { $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/dhandler/swg_datalinker.php"); }
if (!defined ("CLASS_direct_datalinker")) { $g_continue_check = false; }

if ($g_continue_check)
{
//c// direct_datalinker_uhome
/**
* This is the uHome implementation for DataLinker specific functions.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG
* @subpackage datalinker
* @uses       CLASS_direct_datalinker
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;gpl
*             GNU General Public License 2
*/
class direct_datalinker_uhome extends direct_datalinker
{
/* -------------------------------------------------------------------------
Extend the class
------------------------------------------------------------------------- */

	//f// direct_datalinker_uhome->__construct ()
/**
	* Constructor (PHP5) __construct (direct_datalinker_uhome)
	*
	* @uses  USE_debug_reporting
	* @since v0.1.00
*/
	public function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->__construct (direct_datalinker_uhome)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
"get_aid ()" is unsupported for the virtual home directory.
------------------------------------------------------------------------- */

		$this->functions['get_aid'] = false;
	}

	//f// direct_datalinker_uhome->add_objects ($f_count,$f_update = true)
/**
	* Increases the objects counter.
	*
	* @param  number $f_count Number to be added to the view counter
	* @param  boolean $f_update True to update the database entry
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	public function add_objects ($f_count,$f_update = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->add_objects ($f_count,+f_update)- (#echo(__LINE__)#)"); }
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->add_objects ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker_uhome->add_subs ($f_count,$f_update = true)
/**
	* Increases the subs counter.
	*
	* @param  number $f_count Number to be added to the view counter
	* @param  boolean $f_update True to update the database entry
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	public function add_subs ($f_count,$f_update = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->add_subs ($f_count,+f_update)- (#echo(__LINE__)#)"); }
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->add_subs ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker_uhome->add_views ($f_count,$f_update = true)
/**
	* Increases the views counter.
	*
	* @param  number $f_count Number to be added to the view counter
	* @param  boolean $f_update True to update the database entry
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	public function add_views ($f_count,$f_update = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->add_views ($f_count,+f_update)- (#echo(__LINE__)#)"); }
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->add_views ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker_uhome->define_custom_sorting ($f_data)
/**
	* Defines a custom sorting algorithm for this DataLinker.
	*
	* @param  mixed $f_data String (one) or array (multiple) new attributes to
	*         provide.  
	* @param  boolean $f_onetime True to use the given attributes only for the
	*         next request.
	* @uses   direct_datalinker::define_custom_sorting()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @since  v0.1.00
*/
	public function define_custom_sorting ($f_data,$f_onetime = true)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->define_custom_sorting ($f_data,+f_onetime)- (#echo(__LINE__)#)"); }
		parent::define_custom_sorting ($f_data,$f_onetime);
	}

	//f// direct_datalinker_uhome->define_extra_attributes ($f_data,$f_onetime = false)
/**
	* Defines additional attributes for this DataLinker.
	*
	* @param  mixed $f_data String (one) or array (multiple) new attributes to
	*         provide.  
	* @param  boolean $f_onetime True to use the given attributes only for the
	*         next request.
	* @uses   direct_datalinker::define_extra_attributes()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @since  v0.1.00
*/
	public function define_extra_attributes ($f_data,$f_onetime = true)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->define_extra_attributes (+f_data,+f_onetime)- (#echo(__LINE__)#)"); }
		parent::define_extra_attributes ($f_data,$f_onetime);
	}

	//f// direct_datalinker_uhome->define_extra_conditions ($f_data,$f_onetime = false)
/**
	* Defines additional conditions for this DataLinker.
	*
	* @param  mixed $f_data String (one) or array (multiple) new attributes to
	*         provide.  
	* @param  boolean $f_onetime True to use the given attributes only for the
	*         next request.
	* @uses   direct_datalinker::define_extra_conditions()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @since  v0.1.00
*/
	public function define_extra_conditions ($f_data,$f_onetime = true)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->define_extra_conditions (+f_data,+f_onetime)- (#echo(__LINE__)#)"); }
		parent::define_extra_conditions ($f_data,$f_onetime);
	}

	//f// direct_datalinker_uhome->define_extra_joins ($f_data,$f_onetime = false)
/**
	* Defines additional "JOIN" statements for this DataLinker.
	*
	* @param  mixed $f_data String (one) or array (multiple) new attributes to
	*         provide.  
	* @param  boolean $f_onetime True to use the given attributes only for the
	*         next request.
	* @uses   direct_datalinker::define_extra_joins()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @since  v0.1.00
*/
	public function define_extra_joins ($f_data,$f_onetime = true)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->define_extra_joins (+f_data,+f_onetime)- (#echo(__LINE__)#)"); }
		parent::define_extra_joins ($f_data,$f_onetime);
	}

	//f// direct_datalinker_uhome->delete ($f_link_data = true,$f_data = true)
/**
	* Delete the object from the database.
	*
	* @param  boolean $f_link_data Update *_datalinker if true
	* @param  boolean $f_data Update *_datalinkerd if true
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	public function delete ($f_link_data = true,$f_data = true)
	{
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->delete (+f_link_data,+f_data)- (#echo(__LINE__)#)"); }
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->delete ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->define_subs_allowed ($f_state = NULL)
/**
	* (De)Activates the possibility to add subs to this object.
	*
	* @param  mixed $f_state Boolean indicating the state or NULL to switch
	*         automatically
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean Accepted state
	* @since  v0.1.00
*/
	public function define_subs_allowed ($f_state = NULL)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->define_subs_allowed (+f_state)- (#echo(__LINE__)#)"); }
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->define_subs_allowed ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->define_views_count ($f_state = NULL)
/**
	* (De)Activates the counter for views.
	*
	* @param  mixed $f_state Boolean indicating the state or NULL to switch
	*         automatically
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean Accepted state
	* @since  v0.1.00
*/
	public function define_views_count ($f_state = NULL)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->define_views_count (+f_state)- (#echo(__LINE__)#)"); }
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->define_views_count ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker_uhome->get ($f_uid = "",$f_load = true)
/**
	* Returns a virtual user's home dataset.
	*
	* @param  string $f_uid DataLinker (user) ID
	* @param  boolean $f_load Load DataLinker data from the database
	* @uses   direct_debug()
	* @uses   direct_kernel_system::v_user_get()
	* @uses   USE_debug_reporting
	* @return mixed Datalinker array; false on error
	* @since  v0.1.00
*/
	public function get ($f_uid = "",$f_load = true)
	{
		global $direct_classes;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->get ($f_uid)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if ($f_load)
		{
			if ($this->data) { $f_return = $this->data; }
			elseif (strlen ($f_uid))
			{
				if (strpos ($f_uid,"-") !== false) { $f_uid = substr ($f_uid,2); }
				$f_user_array = $direct_classes['kernel']->v_user_get ($f_uid,"",true);

				if ($f_user_array)
				{
$this->data = array (
"ddbdatalinker_id" => "u-".$f_user_array['ddbusers_id'],
"ddbdatalinker_id_object" => "u-".$f_user_array['ddbusers_id'],
"ddbdatalinker_id_parent" => "",
"ddbdatalinker_id_main" => "u-".$f_user_array['ddbusers_id'],
"ddbdatalinker_sid" => "00000000000000000000000000000000",
"ddbdatalinker_type" => 0,
"ddbdatalinker_position" => 0,
"ddbdatalinker_title_alt" => $f_user_array['ddbusers_name'],
"ddbdatalinker_subs" => NULL,
"ddbdatalinker_objects" => NULL,
"ddbdatalinker_sorting_date" => $f_user_array['ddbusers_lastvisit_time'],
"ddbdatalinker_symbol" => "",
"ddbdatalinker_title" => $f_user_array['ddbusers_name'],
"ddbdatalinker_datasubs_type" => NULL,
"ddbdatalinker_datasubs_hide" => NULL,
"ddbdatalinker_datasubs_new" => NULL,
"ddbdatalinker_views_count" => 0,
"ddbdatalinker_views" => 0
);

					$f_return = $this->data;
				}
			}
		}
		elseif (strlen ($f_uid))
		{
			$this->data = array ("ddbdatalinker_id" => $f_uid);
			$f_return = $this->data;
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->get ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker_uhome->get_aid ($f_attributes = NULL,$f_values = "")
/**
	* Request and load the Datalinker object based on a custom attribute ID.
	* This method is unsupported for the virtual home directory.
	*
	* @param  mixed $f_attributes Attribute name(s) (array or string)
	* @param  mixed $f_values Attribute value(s) (array or string)
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return mixed Datalinker array; false on error
	* @since  v0.1.00
*/
	public function get_aid ($f_attributes = NULL,$f_values = "")
	{
		if (USE_debug_reporting) { direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->get_aid (+f_attributes,+f_values)- (#echo(__LINE__)#)"); }
		return /*#ifdef(DEBUG):direct_debug (9,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->get_aid ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker_uhome->remove_objects ($f_count,$f_update = true)
/**
	* Decreases the objects counter.
	*
	* @param  number $f_count Number to be removed from the view counter
	* @param  boolean $f_update True to update the database entry
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	public function remove_objects ($f_count,$f_update = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->remove_objects ($f_count,+f_update)- (#echo(__LINE__)#)"); }
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->remove_objects ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker_uhome->remove_subs ($f_count,$f_update = true)
/**
	* Decreases the subs counter.
	*
	* @param  number $f_count Number to be removed from the view counter
	* @param  boolean $f_update True to update the database entry
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	public function remove_subs ($f_count,$f_update = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->remove_subs ($f_count,+f_update)- (#echo(__LINE__)#)"); }
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->remove_subs ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker_uhome->remove_views ($f_count,$f_update = true)
/**
	* Decreases the views counter.
	*
	* @param  number $f_count Number to be removed from the view counter
	* @param  boolean $f_update True to update the database entry
	* @uses   direct_datalinker::update()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	public function remove_views ($f_count,$f_update = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->remove_views ($f_count,+f_update)- (#echo(__LINE__)#)"); }
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->remove_views ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker_uhome->set_sorting_date ($f_datetime,$f_update = true)
/**
	* Sets a new value for "ddbdatalinker_sorting_date" and updates it.
	*
	* @param  number $f_datetime New UNIX timestamp to be used
	* @param  boolean $f_update True to update the database entry
	* @uses   direct_datalinker::update()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	public function set_sorting_date ($f_datetime,$f_update = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->set_sorting_date ($f_datetime,+f_update)- (#echo(__LINE__)#)"); }
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->set_sorting_date ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker_uhome->update ($f_link_data = true,$f_data = true,$f_insert_mode_deactivate = true)
/**
	* Writes the object data to the database.
	*
	* @param  boolean $f_link_data Update *_datalinker if true
	* @param  boolean $f_data Update *_datalinkerd if true
	* @param  boolean $f_insert_mode_deactivate Deactive insert mode after calling
	*         update ()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	public function update ($f_link_data = true,$f_data = true,$f_insert_mode_deactivate = true)
	{
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->update (+f_link_data,+f_data,+f_insert_mode_deactivate)- (#echo(__LINE__)#)"); }

		if (($f_insert_mode_deactivate)&&($this->data_insert_mode)) { $this->data_insert_mode = false; }
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_uhome->update ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_direct_datalinker_uhome",true);
}

//j// EOF
?>