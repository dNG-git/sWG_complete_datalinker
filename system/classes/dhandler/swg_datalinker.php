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
$Id: swg_datalinker.php,v 1.4 2009/04/30 09:44:35 s4u Exp $
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

$f_continue_check = true;
if (defined ("CLASS_direct_datalinker")) { $f_continue_check = false; }
if (!defined ("CLASS_direct_data_handler")) { $f_continue_check = false; }

if ($f_continue_check)
{
//c// direct_datalinker
/**
* This abstraction layer provides DataLinker specific functions.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG
* @subpackage datalinker
* @uses       CLASS_direct_data_handler
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;gpl
*             GNU General Public License 2
*/
class direct_datalinker extends direct_data_handler
{
/**
	* @var array $data_changed Cache for changed data keys
*/
	protected $data_changed;
/**
	* @var array $data_custom_sorting Customized sorting specification
*/
	protected $data_custom_sorting;
/**
	* @var array $data_extra_attributes Additional attributes for SQL
	*      queries
*/
	protected $data_extra_attributes;
/**
	* @var array $data_extra_conditions Additional conditions for SQL
	*      queries
*/
	protected $data_extra_conditions;
/**
	* @var array $data_extra_joins Additional "JOIN" statements for SQL
	*      queries
*/
	protected $data_extra_joins;
/**
	* @var array $data_sid_type_table Cache for SID and type identifiers
*/
	protected $data_sid_type_table;
/**
	* @var array $data_subcounts Elements (subs and objects) number
*/
	protected $data_subcounts;
/**
	* @var boolean $data_subs_allowed True if new subs may be added
*/
	protected $data_subs_allowed;
/**
	* @var boolean $data_subs_allowed True if the next "update ()"
	*      call is an insert - the code is the same.
*/
	protected $data_insert_mode;

/* -------------------------------------------------------------------------
Extend the class
------------------------------------------------------------------------- */

	//f// direct_datalinker->__construct ()
/**
	* Constructor (PHP5) __construct (direct_datalinker)
	*
	* @uses   direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.00
*/
	public function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->__construct (direct_datalinker)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions 
------------------------------------------------------------------------- */

		$this->functions['add_objects'] = true;
		$this->functions['add_subs'] = true;
		$this->functions['add_views'] = true;
		$this->functions['define_custom_sorting'] = true;
		$this->functions['define_extra_attributes'] = true;
		$this->functions['define_extra_conditions'] = true;
		$this->functions['define_extra_joins'] = true;
		$this->functions['define_subs_allowed'] = true;
		$this->functions['define_views_count'] = true;
		$this->functions['delete'] = true;
		$this->functions['get_aid'] = true;
		$this->functions['get_service'] = true;
		$this->functions['get_sid'] = true;
		$this->functions['get_sid_type_table'] = true;
		$this->functions['get_structure'] = true;
		$this->functions['get_structure_walker'] = true;
		$this->functions['get_subs'] = true;
		$this->functions['get_subcounts'] = true;
		$this->functions['insert'] = true;
		$this->functions['insert_link'] = true;
		$this->functions['is_changed'] = true;
		$this->functions['is_empty'] = true;
		$this->functions['is_of_type'] = true;
		$this->functions['is_sub_allowed'] = true;
		$this->functions['is_views_counting'] = true;
		$this->functions['remove_objects'] = true;
		$this->functions['remove_subs'] = true;
		$this->functions['remove_views'] = true;
		$this->functions['set_extras'] = true;
		$this->functions['set_insert'] = true;
		$this->functions['set_sorting_date'] = true;
		$this->functions['set_update'] = true;
		$this->functions['update'] = true;

/* -------------------------------------------------------------------------
Set up an additional variables :)
------------------------------------------------------------------------- */

		$this->data = array ();
		$this->data_changed = array ();
		$this->data_custom_sorting = array ();
		$this->data_extra_attributes = array ();
		$this->data_extra_conditions = array ();
		$this->data_extra_joins = array ();
		$this->data_insert_mode = false;
		$this->data_sid_type_table = array ();
		$this->data_subcounts = array ();
		$this->data_subs_allowed = false;
	}

	//f// direct_datalinker->add_objects ($f_count,$f_update = true)
/**
	* Increases the objects counter.
	*
	* @param  number $f_count Number to be added to the objects counter
	* @param  boolean $f_update True to update the database entry
	* @uses   direct_datalinker::update()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	public function add_objects ($f_count,$f_update = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->add_objects ($f_count,+f_update)- (#echo(__LINE__)#)"); }
		$f_return = false;

		if (isset ($this->data['ddbdatalinker_objects']))
		{
			$this->data['ddbdatalinker_objects'] += $f_count;
			$this->data_changed['ddbdatalinker_objects'] = true;

			if ($f_update) { $f_return = $this->update (false,true); }
			else { $f_return = true; }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->add_objects ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->add_subs ($f_count,$f_update = true)
/**
	* Increases the subs counter.
	*
	* @param  number $f_count Number to be added to the subs counter
	* @param  boolean $f_update True to update the database entry
	* @uses   direct_datalinker::update()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	public function add_subs ($f_count,$f_update = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->add_subs ($f_count,+f_update)- (#echo(__LINE__)#)"); }
		$f_return = false;

		if (isset ($this->data['ddbdatalinker_subs']))
		{
			$this->data['ddbdatalinker_subs'] += $f_count;
			$this->data_changed['ddbdatalinker_subs'] = true;

			if ($f_update) { $f_return = $this->update (false,true); }
			else { $f_return = true; }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->add_subs ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->add_views ($f_count,$f_update = true)
/**
	* Increases the views counter.
	*
	* @param  number $f_count Number to be added to the view counter
	* @param  boolean $f_update True to update the database entry
	* @uses   direct_datalinker::update()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	public function add_views ($f_count,$f_update = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->add_views ($f_count,+f_update)- (#echo(__LINE__)#)"); }
		$f_return = false;

		if ((isset ($this->data['ddbdatalinker_views']))&&(isset ($this->data['ddbdatalinker_views_count']))&&($this->data['ddbdatalinker_views_count']))
		{
			$this->data['ddbdatalinker_views'] += $f_count;
			$this->data_changed['ddbdatalinker_views'] = true;

			if ($f_update) { $f_return = $this->update (false,true); }
			else { $f_return = true; }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->add_views ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->changed (&$f_data)
/**
	* Builds a cache with changed data keys (called by "set ()").
	*
	* @param  array $f_data New content for $this->data
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @since  v0.1.00
*/
	private function changed (&$f_data)
	{
		if (USE_debug_reporting) { direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->changed (+f_data)- (#echo(__LINE__)#)"); }

		if (is_array ($f_data))
		{
			$f_data_keys = array_keys ($f_data);
			$this->data_changed = array ();

			foreach ($f_data_keys as $f_data_key)
			{
				if ((!array_key_exists ($f_data_key,$this->data))||($f_data[$f_data_key] != $this->data[$f_data_key])) { $this->data_changed[$f_data_key] = true; }
			}
		}
	}

	//f// direct_datalinker->define_custom_sorting ($f_data)
/**
	* Defines a custom sorting algorithm for this DataLinker.
	*
	* @param  mixed $f_data String (one) or array (multiple) new attributes to
	*         provide.  
	* @param  boolean $f_onetime True to use the given attributes only for the
	*         next request.
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @since  v0.1.00
*/
	protected function define_custom_sorting ($f_data,$f_onetime = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->define_custom_sorting ($f_data,+f_onetime)- (#echo(__LINE__)#)"); }
		if (is_string ($f_data)) { $this->data_custom_sorting = array ("definition" => $f_data,"onetime" => $f_onetime); }
	}

	//f// direct_datalinker->define_extra_attributes ($f_data,$f_onetime = false)
/**
	* Defines additional attributes for this DataLinker.
	*
	* @param  mixed $f_data String (one) or array (multiple) new attributes to
	*         provide.  
	* @param  boolean $f_onetime True to use the given attributes only for the
	*         next request.
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @since  v0.1.00
*/
	protected function define_extra_attributes ($f_data,$f_onetime = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->define_extra_attributes (+f_data,+f_onetime)- (#echo(__LINE__)#)"); }

		if ((is_array ($f_data))&&(!empty ($f_data))) { $f_attributes_array = $f_data; }
		else { $f_attributes_array = array ($f_data); }

		if (empty ($f_attributes_array)) { $this->data_extra_attributes = array (); }
		elseif (!empty ($f_attributes_array))
		{
			if ($f_onetime) { $f_onetime = true; }
			else { $f_onetime = false; }

			foreach ($f_attributes_array as $f_attribute)
			{
				if ((strlen ($f_attribute))&&((!$f_onetime)||(($f_onetime)&&(!isset ($this->data_extra_attributes[$f_attribute]))))) { $this->data_extra_attributes[$f_attribute] = array ("attribute" => $f_attribute,"onetime" => $f_onetime); }
			}
		}
	}

	//f// direct_datalinker->define_extra_conditions ($f_data,$f_onetime = false)
/**
	* Defines additional conditions for this DataLinker.
	*
	* @param  mixed $f_data String (one) or array (multiple) new attributes to
	*         provide.  
	* @param  boolean $f_onetime True to use the given attributes only for the
	*         next request.
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @since  v0.1.00
*/
	protected function define_extra_conditions ($f_data,$f_onetime = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->define_extra_conditions (+f_data,+f_onetime)- (#echo(__LINE__)#)"); }

		if ((is_array ($f_data))&&(!empty ($f_data))) { $f_conditions_array = $f_data; }
		else { $f_conditions_array = array ($f_data); }

		if (empty ($f_conditions_array)) { $this->data_extra_conditions = array (); }
		elseif (!empty ($f_conditions_array))
		{
			if ($f_onetime) { $f_onetime = true; }
			else { $f_onetime = false; }

			foreach ($f_conditions_array as $f_condition)
			{
				$f_condition_key = md5 ($f_condition);
				if ((strlen ($f_condition))&&((!$f_onetime)||(($f_onetime)&&(!isset ($this->data_extra_conditions[$f_condition_key]))))) { $this->data_extra_conditions[$f_condition_key] = array ("condition" => $f_condition,"onetime" => $f_onetime); }
			}
		}
	}

	//f// direct_datalinker->define_extra_joins ($f_data,$f_onetime = false)
/**
	* Defines additional "JOIN" statements for this DataLinker.
	*
	* @param  mixed $f_data String (one) or array (multiple) new attributes to
	*         provide.  
	* @param  boolean $f_onetime True to use the given attributes only for the
	*         next request.
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @since  v0.1.00
*/
	protected function define_extra_joins ($f_data,$f_onetime = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->define_extra_joins (+f_data,+f_onetime)- (#echo(__LINE__)#)"); }

		if (empty ($f_data)) { $this->data_extra_joins = array (); }
		elseif (!empty ($f_data))
		{
			if ($f_onetime) { $f_onetime = true; }
			else { $f_onetime = false; }

			foreach ($f_data as $f_join_array)
			{
				$f_join_key = md5 ($f_join_array['type'].$f_join_array['table'].$f_join_array['condition']);
				if ((!$f_onetime)||(($f_onetime)&&(!isset ($this->data_extra_joins[$f_join_key])))) { $this->data_extra_joins[$f_join_key] = array ("type" => $f_join_array['type'],"table" => $f_join_array['table'],"condition" => $f_join_array['condition'],"onetime" => $f_onetime); }
			}
		}
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
		$f_return = false;

		if (isset ($this->data['ddbdatalinker_datasubs_new']))
		{
			if (((is_bool ($f_state))||(is_string ($f_state)))&&($f_state)) { $f_return = true; }
			elseif (($f_state === NULL)&&(!$this->data['ddbdatalinker_datasubs_new'])) { $f_return = true; }
		}

		if ($f_return) { $this->data['ddbdatalinker_datasubs_new'] = 1; }
		else { $this->data['ddbdatalinker_datasubs_new'] = 0; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->define_subs_allowed ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
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
		$f_return = false;

		if (isset ($this->data['ddbdatalinker_views_count']))
		{
			if (((is_bool ($f_state))||(is_string ($f_state)))&&($f_state)) { $f_return = true; }
			elseif (($f_state === NULL)&&(!$this->data['ddbdatalinker_views_count'])) { $f_return = true; }
		}

		if ($f_return) { $this->data['ddbdatalinker_views_count'] = 1; }
		else { $this->data['ddbdatalinker_views_count'] = 0; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->define_views_count ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->delete ($f_link_data = true,$f_data = true)
/**
	* Delete the object from the database.
	*
	* @param  boolean $f_link_data Delete *_datalinker if true
	* @param  boolean $f_data Delete *_datalinkerd if true
	* @uses   direct_db::define_row_conditions()
	* @uses   direct_db::define_row_conditions_encode()
	* @uses   direct_db::init_delete()
	* @uses   direct_db::query_exec()
	* @uses   direct_db::v_optimize()
	* @uses   direct_db::v_transaction_begin()
	* @uses   direct_db::v_transaction_commit()
	* @uses   direct_db::v_transaction_rollback()
	* @uses   direct_dbsync_event()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	public function delete ($f_link_data = true,$f_data = true)
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -datalinker_handler->delete (+f_link_data,+f_data)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (isset ($this->data['ddbdatalinker_id']))
		{
			$direct_classes['db']->v_transaction_begin ();

			if ($f_link_data)
			{
				$direct_classes['db']->init_delete ($direct_settings['datalinker_table']);

				$f_delete_criteria = "<sqlconditions>".($direct_classes['db']->define_row_conditions_encode ($direct_settings['datalinker_table'].".ddbdatalinker_id",$this->data['ddbdatalinker_id'],"string"))."</sqlconditions>";
				$direct_classes['db']->define_row_conditions ($f_delete_criteria);

				$f_return = $direct_classes['db']->query_exec ("ar");

				if ($f_return)
				{
					if (function_exists ("direct_dbsync_event")) { direct_dbsync_event ($direct_settings['datalinker_table'],"delete",$f_delete_criteria); }
					if (!$direct_settings['swg_auto_maintenance']) { $direct_classes['db']->v_optimize ($direct_settings['datalinker_table']); }
				}
			}
			else { $f_return = true; }

			if (($f_return)&&($f_data))
			{
				$direct_classes['db']->init_delete ($direct_settings['datalinkerd_table']);

				$f_delete_criteria = "<sqlconditions>".($direct_classes['db']->define_row_conditions_encode ($direct_settings['datalinkerd_table'].".ddbdatalinkerd_id",$this->data['ddbdatalinker_id'],"string"))."</sqlconditions>";
				$direct_classes['db']->define_row_conditions ($f_delete_criteria);

				$f_return = $direct_classes['db']->query_exec ("ar");

				if ($f_return)
				{
					if (function_exists ("direct_dbsync_event")) { direct_dbsync_event ($direct_settings['datalinkerd_table'],"delete",$f_delete_criteria); }
					if (!$direct_settings['swg_auto_maintenance']) { $direct_classes['db']->v_optimize ($direct_settings['datalinkerd_table']); }
				}
			}

			if ($f_return) { $direct_classes['db']->v_transaction_commit (); }
			else { $direct_classes['db']->v_transaction_rollback (); }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->delete ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->get ($f_eid = "",$f_load = true)
/**
	* Reads in the DataLinker entry with the specified ID.
	*
	* @param  string $f_eid DataLinker ID
	* @param  boolean $f_load Load DataLinker data from the database
	* @uses   direct_debug()
	* @uses   direct_datalinker::get_aid()
	* @uses   USE_debug_reporting
	* @return mixed Datalinker array; false on error
	* @since  v0.1.00
*/
	public function get ($f_eid = "",$f_load = true)
	{
		if (USE_debug_reporting) { direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->get ($f_eid,+f_load)- (#echo(__LINE__)#)"); }
		$f_return = false;

		if ($f_load) { $f_return = $this->get_aid (NULL,$f_eid); }
		elseif (strlen ($f_eid))
		{
			$this->data = array ("ddbdatalinker_id" => $f_eid);
			$f_return = $this->data;
		}

		return /*#ifdef(DEBUG):direct_debug (9,"sWG/#echo(__FILEPATH__)# -datalinker_handler->get ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->get_aid ($f_attributes = NULL,$f_values = "")
/**
	* Reads in the DataLinker entry with custom attribute. Please note that only
	* attributes of type "string" are supported.
	*
	* @param  mixed $f_attributes Attribute name(s) (array or string)
	* @param  mixed $f_values Attribute value(s) (array or string)
	* @uses   direct_db::define_attributes()
	* @uses   direct_db::define_join()
	* @uses   direct_db::define_limit()
	* @uses   direct_db::define_row_conditions()
	* @uses   direct_db::define_row_conditions_encode()
	* @uses   direct_db::init_select()
	* @uses   direct_db::query_exec()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return mixed Datalinker array; false on error
	* @since  v0.1.00
*/
	public function get_aid ($f_attributes = NULL,$f_values = "")
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -datalinker_handler->get_aid (+f_attributes,+f_values)- (#echo(__LINE__)#)"); }

		if (!isset ($f_attributes)) { $f_attributes = $direct_settings['datalinker_table'].".ddbdatalinker_id"; }
		$f_return = false;

		if ((is_string ($f_attributes))&&(is_string ($f_values)))
		{
			$f_attributes = array ($f_attributes);
			$f_values = array ($f_values);
		}
		elseif ((!is_array ($f_attributes))||(!is_array ($f_values))||(count ($f_attributes) != (count ($f_values)))) { $f_attributes = NULL; }

		if (isset ($f_attributes))
		{
			if ($this->data) { $f_return = $this->data; }
			elseif ((($f_values == NULL)&&(!empty ($this->data_extra_conditions)))||(isset ($f_attributes)))
			{
				$direct_classes['db']->init_select ($direct_settings['datalinker_table']);

				$f_select_attributes = array ($direct_settings['datalinker_table'].".*",$direct_settings['datalinkerd_table'].".*");

				if (!empty ($this->data_extra_attributes))
				{
					foreach ($this->data_extra_attributes as $f_attribute => $f_attribute_array)
					{
						$f_select_attributes[] = $f_attribute_array['attribute'];
						if ($f_attribute_array['onetime']) { unset ($this->data_extra_attributes[$f_attribute]); }
					}
				}

				$direct_classes['db']->define_attributes ($f_select_attributes);
				$direct_classes['db']->define_join ("left-outer-join",$direct_settings['datalinkerd_table'],"<sqlconditions><element1 attribute='$direct_settings[datalinkerd_table].ddbdatalinkerd_id' value='$direct_settings[datalinker_table].ddbdatalinker_id_object' type='attribute' /></sqlconditions>");

				if (!empty ($this->data_extra_joins))
				{
					foreach ($this->data_extra_joins as $f_join_key => $f_join_array)
					{
						$direct_classes['db']->define_join ($f_join_array['type'],$f_join_array['table'],$f_join_array['condition']);
						if ($f_join_array['onetime']) { unset ($this->data_extra_joins[$f_join_key]); }
					}
				}

				$f_select_criteria = "<sqlconditions>";

				if (isset ($f_attributes,$f_values))
				{
					foreach ($f_values as $f_value)
					{
						$f_attribute = array_shift ($f_attributes);
						$f_select_criteria .= $direct_classes['db']->define_row_conditions_encode ($f_attribute,$f_value,"string");
					}
				}

				if (!empty ($this->data_extra_conditions))
				{
					foreach ($this->data_extra_conditions as $f_condition_key => $f_condition_array)
					{
						$f_select_criteria .= $f_condition_array['condition'];
						if ($f_condition_array['onetime']) { unset ($this->data_extra_conditions[$f_condition_key]); }
					}
				}

				$f_select_criteria .= "</sqlconditions>";
				$direct_classes['db']->define_row_conditions ($f_select_criteria);

				$direct_classes['db']->define_limit (1);
				$this->data = $direct_classes['db']->query_exec ("sa");

				if ($this->data)
				{
					if (($this->data['ddbdatalinker_datasubs_type'] !== NULL)&&(($this->data['ddbdatalinker_datasubs_new'])||($direct_classes['kernel']->v_usertype_get_int ($direct_settings['user']['type']) > 3))) { $this->data_subs_allowed = true; }
					else { $this->data_subs_allowed = false; }

					$f_return = $this->data;
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->get_aid ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->get_service ($f_sid)
/**
	* Returns service data for a specified SID.
	*
	* @param  string $f_sid Service ID
	* @uses   direct_debug()
	* @uses   direct_datalinker::get_sid_type_table()
	* @uses   USE_debug_reporting
	* @return array Found result; False on error
	* @since  v0.1.00
*/
	public function get_service ($f_sid)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->get_service ($f_sid)- (#echo(__LINE__)#)"); }
		$f_sid_type_array = $this->get_sid_type_table ();

		if (($f_sid_type_array)&&(isset ($f_sid_type_array[$f_sid]))) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->get_service ()- (#echo(__LINE__)#)",:#*/$f_sid_type_array[$f_sid]/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->get_service ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_datalinker->get_sid_type_table ()
/**
	* Reads and returns the SID and type table.
	*
	* @uses   direct_debug()
	* @uses   direct_basic_functions::memcache_get_file_merged_xml()
	* @uses   USE_debug_reporting
	* @return array Found result or empty array
	* @since  v0.1.00
*/
	public function get_sid_type_table ()
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->get_sid_type_table ()- (#echo(__LINE__)#)"); }

		$f_return = array ();

		if ($this->data_sid_type_table) { $f_return = $this->data_sid_type_table; }
		else
		{
			$f_xml_array = $direct_classes['basic_functions']->memcache_get_file_merged_xml ($direct_settings['path_data']."/settings/swg_datalinker_subs.php");

			if (($f_xml_array)&&(isset ($f_xml_array['swg_datalinker_subs_list_v1_datalinker_types_default']))&&(isset ($f_xml_array['swg_datalinker_subs_list_v1_datalinker_services'])))
			{
				$f_default_types = array ();

				if (isset ($f_xml_array['swg_datalinker_subs_list_v1_datalinker_types_default']['tag'])) { $f_default_types[$f_xml_array['swg_datalinker_subs_list_v1_datalinker_types_default']['attributes']['type']] = array ("name" => $f_xml_array['swg_datalinker_subs_list_v1_datalinker_types_default']['attributes']['name'],"action" => $f_xml_array['swg_datalinker_subs_list_v1_datalinker_types_default']['attributes']['action'],"symbol" => $f_xml_array['swg_datalinker_subs_list_v1_datalinker_types_default']['attributes']['symbol']); }
				else
				{
					foreach ($f_xml_array['swg_datalinker_subs_list_v1_datalinker_types_default'] as $f_default_type_array) { $f_default_types[$f_default_type_array['attributes']['type']] = array ("name" => $f_default_type_array['attributes']['name'],"action" => $f_default_type_array['attributes']['action'],"symbol" => $f_default_type_array['attributes']['symbol']); }
				}

				if (isset ($f_xml_array['swg_datalinker_subs_list_v1_datalinker_services']['tag'])) { $f_xml_array['swg_datalinker_subs_list_v1_datalinker_services'] = array ($f_xml_array['swg_datalinker_subs_list_v1_datalinker_services']); }

				$f_default_types_keys = array_keys ($f_default_types);

				foreach ($f_xml_array['swg_datalinker_subs_list_v1_datalinker_services'] as $f_xml_node_array)
				{
					$this->data_sid_type_table[$f_xml_node_array['attributes']['sid']] = array ("name" => $f_xml_node_array['attributes']['name'],"services" => array ());

					if (isset ($f_xml_node_array['attributes']['handler'])) { $this->data_sid_type_table[$f_xml_node_array['attributes']['sid']]['handler'] = $f_xml_node_array['attributes']['handler']; }
					else { $this->data_sid_type_table[$f_xml_node_array['attributes']['sid']]['handler'] = $f_xml_node_array['attributes']['name']; }

					foreach ($f_default_types_keys as $f_default_types_key)
					{
						$this->data_sid_type_table[$f_xml_node_array['attributes']['sid']]['services'][$f_default_types_key] = $f_default_types[$f_default_types_key];
						$this->data_sid_type_table[$f_xml_node_array['attributes']['sid']]['services'][$f_default_types_key]['handler'] = $this->data_sid_type_table[$f_xml_node_array['attributes']['sid']]['handler'];
					}

					$f_sid_types_key = "swg_datalinker_subs_list_v1_datalinker_types_".$f_xml_node_array['attributes']['sid'];

					if (isset ($f_xml_array[$f_sid_types_key]))
					{
						if (isset ($f_xml_array[$f_sid_types_key]['tag']))
						{
							$this->data_sid_type_table[$f_xml_node_array['attributes']['sid']]['services'][$f_xml_array[$f_sid_types_key]['attributes']['type']] = array ("name" => $f_xml_array[$f_sid_types_key]['attributes']['name'],"action" => $f_xml_array[$f_sid_types_key]['attributes']['action'],"symbol" => $f_xml_array[$f_sid_types_key]['attributes']['symbol']);

							if (isset ($f_xml_array[$f_sid_types_key]['attributes']['handler'])) { $this->data_sid_type_table[$f_xml_node_array['attributes']['sid']]['services'][$f_xml_array[$f_sid_types_key]['attributes']['type']]['handler'] = $f_xml_array[$f_sid_types_key]['attributes']['handler']; }
							else { $this->data_sid_type_table[$f_xml_node_array['attributes']['sid']]['services'][$f_xml_array[$f_sid_types_key]['attributes']['type']]['handler'] = $this->data_sid_type_table[$f_xml_node_array['attributes']['sid']]['handler']; }
						}
						else
						{
							foreach ($f_xml_array[$f_sid_types_key] as $f_xml_sub_node_array)
							{
								$this->data_sid_type_table[$f_xml_node_array['attributes']['sid']]['services'][$f_xml_sub_node_array['attributes']['type']] = array ("name" => $f_xml_sub_node_array['attributes']['name'],"action" => $f_xml_sub_node_array['attributes']['action'],"symbol" => $f_xml_sub_node_array['attributes']['symbol']);

								if (isset ($f_xml_sub_node_array['attributes']['handler'])) { $this->data_sid_type_table[$f_xml_node_array['attributes']['sid']]['services'][$f_xml_sub_node_array['attributes']['type']]['handler'] = $f_xml_sub_node_array['attributes']['handler']; }
								else { $this->data_sid_type_table[$f_xml_node_array['attributes']['sid']]['services'][$f_xml_sub_node_array['attributes']['type']]['handler'] = $this->data_sid_type_table[$f_xml_node_array['attributes']['sid']]['handler']; }
							}
						}
					}
				}

				$f_return = $this->data_sid_type_table;
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->get_sid_type_table ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->get_sid ($f_service)
/**
	* Returns SID for a specified SID.
	*
	* @param  string $f_service Service name
	* @uses   direct_debug()
	* @uses   direct_datalinker::get_sid_type_table()
	* @uses   USE_debug_reporting
	* @return string Found result or empty string
	* @since  v0.1.00
*/
	public function get_sid ($f_service)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->get_sid ($f_service)- (#echo(__LINE__)#)"); }
		$f_return = "";

		$f_sid_type_array = $this->get_sid_type_table ();

		foreach ($f_sid_type_array as $f_sid => $f_sid_array)
		{
			if ($f_sid_array['name'] == $f_service) { $f_return = $f_sid; }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->get_sid ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->get_structure ($f_sid = "",$f_type = "",$f_highest_first = true,$f_sorting_date_preferred = false)
/**
	* Returns an array containing the object list for the main ID and a structured
	* string.
	*
	* @param  string $f_sid Service ID (or empty for all)
	* @param  string $f_type Object type (or empty for all)
	* @param  boolean $f_highest_first True to sort descending
	* @param  boolean $f_sorting_date_preferred True to sort the results by
	*         sorting date rather than by the defined position
	* @uses   direct_datalinker::get_structure_walker()
	* @uses   direct_db::define_attributes()
	* @uses   direct_db::define_ordering()
	* @uses   direct_db::define_row_conditions()
	* @uses   direct_db::define_row_conditions_encode()
	* @uses   direct_db::init_select()
	* @uses   direct_db::query_exec()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return array Objects of this structure (array "objects") and the multi
	*         level object structure (string "structure" - ":" is delimiter)
	* @since  v0.1.00
*/
	public function get_structure ($f_sid = "",$f_type = "",$f_highest_first = true,$f_sorting_date_preferred = false)
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->get_structure ($f_sid,$f_type,+f_highest_first,+f_sorting_date_preferred)- (#echo(__LINE__)#)"); }

		$f_return = array ();
		$f_select_attributes = array ($direct_settings['datalinker_table'].".*",$direct_settings['datalinkerd_table'].".*");

		$direct_classes['db']->init_select ($direct_settings['datalinker_table']);

		if (!empty ($this->data_extra_attributes))
		{
			foreach ($this->data_extra_attributes as $f_attribute => $f_attribute_array)
			{
				$f_select_attributes[] = $f_attribute_array['attribute'];
				if ($f_attribute_array['onetime']) { unset ($this->data_extra_attributes[$f_attribute]); }
			}
		}

		$direct_classes['db']->define_attributes ($f_select_attributes);
		$direct_classes['db']->define_join ("left-outer-join",$direct_settings['datalinkerd_table'],"<sqlconditions><element1 attribute='$direct_settings[datalinkerd_table].ddbdatalinkerd_id' value='$direct_settings[datalinker_table].ddbdatalinker_id_object' type='attribute' /></sqlconditions>");

		if (!empty ($this->data_extra_joins))
		{
			foreach ($this->data_extra_joins as $f_join_key => $f_join_array)
			{
				$direct_classes['db']->define_join ($f_join_array['type'],$f_join_array['table'],$f_join_array['condition']);
				if ($f_join_array['onetime']) { unset ($this->data_extra_joins[$f_join_key]); }
			}
		}

		$f_select_criteria = "<sqlconditions>".($direct_classes['db']->define_row_conditions_encode ($direct_settings['datalinker_table'].".ddbdatalinker_id_main",$this->data['ddbdatalinker_id_main'],"string"));
		if (strlen ($f_sid)) { $f_select_criteria .= $direct_classes['db']->define_row_conditions_encode ($direct_settings['datalinker_table'].".ddbdatalinker_sid",$f_sid,"string"); }
		if (strlen ($f_type)) { $f_select_criteria .= $direct_classes['db']->define_row_conditions_encode ($direct_settings['datalinker_table'].".ddbdatalinker_type",(md5 ($f_type)),"string"); }

		if (!empty ($this->data_extra_conditions))
		{
			foreach ($this->data_extra_conditions as $f_condition_key => $f_condition_array)
			{
				$f_select_criteria .= $f_condition_array['condition'];
				if ($f_condition_array['onetime']) { unset ($this->data_extra_conditions[$f_condition_key]); }
			}
		}

		$f_select_criteria .= "</sqlconditions>";
		$direct_classes['db']->define_row_conditions ($f_select_criteria);

		if ($f_highest_first) { $f_select_criteria = "desc"; }
		else { $f_select_criteria = "asc"; }

		if (!empty ($this->data_custom_sorting))
		{
			$f_select_criteria = $this->data_custom_sorting['definition'];
			if ($this->data_custom_sorting['onetime']) { $this->data_custom_sorting = array (); }
		}
		elseif ($f_sorting_date_preferred)
		{
$f_select_criteria = ("<sqlordering>
<element1 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_sorting_date' type='$f_select_criteria' />
<element2 attribute='$direct_settings[datalinker_table].ddbdatalinker_position' type='$f_select_criteria' />
<element3 attribute='$direct_settings[datalinker_table].ddbdatalinker_title_alt' type='asc' />
<element4 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_title' type='asc' />
</sqlordering>");
		}
		else
		{
$f_select_criteria = ("<sqlordering>
<element1 attribute='$direct_settings[datalinker_table].ddbdatalinker_position' type='$f_select_criteria' />
<element2 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_sorting_date' type='$f_select_criteria' />
<element3 attribute='$direct_settings[datalinker_table].ddbdatalinker_title_alt' type='asc' />
<element4 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_title' type='asc' />
</sqlordering>");
		}

		$direct_classes['db']->define_ordering ($f_select_criteria);
		$f_results_array = $direct_classes['db']->query_exec ("ma");

		$f_toplevel_id = "";

		if ($f_results_array)
		{
			$f_return['objects'] = array ();
			$f_cache_array = array ();

			foreach ($f_results_array as $f_result_array)
			{
				if ($f_result_array['ddbdatalinker_id'] == $this->data['ddbdatalinker_id_main']) { $f_toplevel_id = $f_result_array['ddbdatalinker_id']; }

				if ($f_result_array['ddbdatalinker_id_parent'])
				{
					$f_return['objects'][$f_result_array['ddbdatalinker_id']] = $f_result_array;
					if (!isset ($f_cache_array[$f_result_array['ddbdatalinker_id_parent']])) { $f_cache_array[$f_result_array['ddbdatalinker_id_parent']] = array (); }
					$f_cache_array[$f_result_array['ddbdatalinker_id_parent']][$f_result_array['ddbdatalinker_id']] = $f_return['objects'][$f_result_array['ddbdatalinker_id']];
				}
			}
		}

		if ($f_toplevel_id)
		{
			if (isset ($f_cache_array[$f_toplevel_id]))
			{
				$f_structure = $f_toplevel_id;
				$this->get_structure_walker ($f_toplevel_id,$f_toplevel_id,$f_cache_array[$f_toplevel_id],$f_cache_array,$f_structure);
				unset ($f_cache_array[$f_toplevel_id]);
			}

			while (!empty ($f_cache_array))
			{
				$f_element_array = array_shift ($f_cache_array);
				$this->get_structure_walker ("","",$f_element_array,$f_cache_array,$f_structure);
			}

			$f_return['structured'] = $f_structure;
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->get_structure ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->get_structure_walker ($f_parent,$f_parent_prefix,&$f_parent_objects,&$f_parents,&$f_objects_structured)
/**
	* Recursively creates the structured string using "ddbdatalinker_id_parent" as
	* identifier.
	*
	* @param  string $f_parent Parent ID
	* @param  string $f_parent_prefix Parent ID prefix string (":" is delimiter)
	* @param  array &$f_parent_objects Objects in this object level
	* @param  array &$f_parents All unused object levels (parent IDs)
	* @param  string &$f_objects_structured Structure string (one entry per line)
	* @uses   direct_datalinker::get_structure_walker()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @since  v0.1.00
*/
	protected function get_structure_walker ($f_parent,$f_parent_prefix,&$f_parent_objects,&$f_parents,&$f_objects_structured)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->get_structure_walker ($f_parent,$f_parent_prefix,+f_parent_objects,+f_parents,+f_objects_structured)- (#echo(__LINE__)#)"); }

		foreach ($f_parent_objects as $f_element_array)
		{
			if (strlen ($f_parent_prefix)) { $f_structure_key = $f_parent_prefix.":".$f_element_array['ddbdatalinker_id']; }
			else { $f_structure_key = $f_element_array['ddbdatalinker_id']; }

			if ($f_objects_structured) { $f_objects_structured .= "\n"; }
			$f_objects_structured .= $f_structure_key;

			if (isset ($f_parents[$f_element_array['ddbdatalinker_id']]))
			{
				$this->get_structure_walker ($f_element_array['ddbdatalinker_id'],$f_structure_key,$f_parents[$f_element_array['ddbdatalinker_id']],$f_parents,$f_objects_structured);
				unset ($f_parents[$f_element_array['ddbdatalinker_id']]);
			}
		}
	}

	//f// direct_datalinker->get_subcounts ()
/**
	* Returns the number of elements for each SID and type.
	*
	* @uses   direct_db::define_attributes()
	* @uses   direct_db::define_grouping()
	* @uses   direct_db::define_row_conditions()
	* @uses   direct_db::define_row_conditions_encode()
	* @uses   direct_db::init_select()
	* @uses   direct_db::query_exec()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string Filtered string
	* @since  v0.1.00
*/
	public function get_subcounts ()
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->get_subcounts ()- (#echo(__LINE__)#)"); }

		if ($this->data_subcounts) { return $this->data_subcounts; }
		else
		{
			$direct_classes['db']->init_select ($direct_settings['datalinker_table']);

			$f_select_attributes = array ($direct_settings['datalinker_table'].".ddbdatalinker_sid",$direct_settings['datalinker_table'].".ddbdatalinker_type","count-rows($direct_settings[datalinker_table].ddbdatalinker_type)");
			$direct_classes['db']->define_attributes ($f_select_attributes);

			$f_select_criteria = "<sqlconditions>".($direct_classes['db']->define_row_conditions_encode ($direct_settings['datalinker_table'].".ddbdatalinker_id_parent",$this->data['ddbdatalinker_id'],"string"))."</sqlconditions>";
			$direct_classes['db']->define_row_conditions ($f_select_criteria);

			$direct_classes['db']->define_grouping (array ($direct_settings['datalinker_table'].".ddbdatalinker_sid",$direct_settings['datalinker_table'].".ddbdatalinker_type"));
			$f_results_array = $direct_classes['db']->query_exec ("ma");

			if ($f_results_array)
			{
				$this->data_subcounts = $f_results_array;
				$f_return = $this->data_subcounts;
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->get_subcounts ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->get_subs ($f_datalinker_object,$f_mid = "",$f_pid = "",$f_sid = "",$f_type = "",$f_offset = 0,$f_perpage = "",$f_sorting_mode = "id-asc",$f_options = "")
/**
	* Returns all subobjects for the DataLinker with the given service ID and
	* type.
	*
	* @param  string $f_datalinker_object Responsible DataLinker class name
	* @param  string $f_mid Main object ID (or empty if not applicable)
	* @param  string $f_pid Parent object ID (or empty if not applicable
	* @param  string $f_sid Service ID (or empty for all)
	* @param  string $f_type Object type (or empty for all)
	* @param  integer $f_offset Offset for the result list
	* @param  integer $f_perpage Object count limit for the result list
	* @param  string $f_sorting_mode Sorting algorithm
	* @param  array $f_options Optional options given to the constructor
	* @uses   direct_datalinker::set()
	* @uses   direct_db::define_attributes()
	* @uses   direct_db::define_limit()
	* @uses   direct_db::define_offset()
	* @uses   direct_db::define_ordering()
	* @uses   direct_db::define_row_conditions()
	* @uses   direct_db::define_row_conditions_encode()
	* @uses   direct_db::init_select()
	* @uses   direct_db::query_exec()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return mixed Datalinker entry array or an result string
	* @since  v0.1.00
*/
	public function get_subs ($f_datalinker_object,$f_mid = NULL,$f_pid = NULL,$f_sid = "",$f_type = "",$f_offset = 0,$f_perpage = "",$f_sorting_mode = "id-asc",$f_options = "")
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->get_subs ($f_datalinker_object,$f_mid,$f_pid,$f_sid,$f_type,$f_offset,$f_perpage,$f_sorting_mode,+f_options)- (#echo(__LINE__)#)"); }

		if ($f_datalinker_object)
		{
			$f_continue_check = defined ("CLASS_".$f_datalinker_object);
			$f_return = array ();
		}
		else
		{
			$f_continue_check = true;
			$f_return = "";
		}

		if ($f_continue_check)
		{
			$direct_classes['db']->init_select ($direct_settings['datalinker_table']);

			if ($f_datalinker_object) { $f_select_attributes = array ($direct_settings['datalinker_table'].".*",$direct_settings['datalinkerd_table'].".*"); }
			else { $f_select_attributes = array (); }

			if (!empty ($this->data_extra_attributes))
			{
				foreach ($this->data_extra_attributes as $f_attribute => $f_attribute_array)
				{
					$f_select_attributes[] = $f_attribute_array['attribute'];
					if ($f_attribute_array['onetime']) { unset ($this->data_extra_attributes[$f_attribute]); }
				}
			}

			$direct_classes['db']->define_attributes ($f_select_attributes);
			$direct_classes['db']->define_join ("left-outer-join",$direct_settings['datalinkerd_table'],"<sqlconditions><element1 attribute='$direct_settings[datalinkerd_table].ddbdatalinkerd_id' value='$direct_settings[datalinker_table].ddbdatalinker_id_object' type='attribute' /></sqlconditions>");

			if (!empty ($this->data_extra_joins))
			{
				foreach ($this->data_extra_joins as $f_join_key => $f_join_array)
				{
					$direct_classes['db']->define_join ($f_join_array['type'],$f_join_array['table'],$f_join_array['condition']);
					if ($f_join_array['onetime']) { unset ($this->data_extra_joins[$f_join_key]); }
				}
			}

			$f_select_criteria = "<sqlconditions>";
			if ($f_pid !== NULL) { $f_select_criteria .= $direct_classes['db']->define_row_conditions_encode ($direct_settings['datalinker_table'].".ddbdatalinker_id_parent",$f_pid,"string"); }
			if ($f_mid !== NULL) { $f_select_criteria .= $direct_classes['db']->define_row_conditions_encode ($direct_settings['datalinker_table'].".ddbdatalinker_id_main",$f_mid,"string"); }
			if (strlen ($f_sid)) { $f_select_criteria .= $direct_classes['db']->define_row_conditions_encode ($direct_settings['datalinker_table'].".ddbdatalinker_sid",$f_sid,"string"); }
			if (strlen ($f_type)) { $f_select_criteria .= $direct_classes['db']->define_row_conditions_encode ($direct_settings['datalinker_table'].".ddbdatalinker_type",$f_type,"number"); }

			if (!empty ($this->data_extra_conditions))
			{
				foreach ($this->data_extra_conditions as $f_condition_key => $f_condition_array)
				{
					$f_select_criteria .= $f_condition_array['condition'];
					if ($f_condition_array['onetime']) { unset ($this->data_extra_conditions[$f_condition_key]); }
				}
			}

			$f_select_criteria .= "</sqlconditions>";
			$direct_classes['db']->define_row_conditions ($f_select_criteria);

			if (!empty ($this->data_custom_sorting))
			{
				$f_select_criteria = $this->data_custom_sorting['definition'];
				if ($this->data_custom_sorting['onetime']) { $this->data_custom_sorting = array (); }
			}
			else
			{
				switch ($f_sorting_mode)
				{
				case "id-desc":
				{
					$f_select_criteria = "<sqlordering><element1 attribute='$direct_settings[datalinker_table].ddbdatalinker_id' type='desc' /></sqlordering>";
					break 1;
				}
				case "position-asc":
				{
$f_select_criteria = ("<sqlordering>
<element1 attribute='$direct_settings[datalinker_table].ddbdatalinker_position' type='asc' />
<element2 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_sorting_date' type='asc' />
<element3 attribute='$direct_settings[datalinker_table].ddbdatalinker_title_alt' type='asc' />
<element4 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_title' type='asc' />
</sqlordering>");

					break 1;
				}
				case "position-desc":
				{
$f_select_criteria = ("<sqlordering>
<element1 attribute='$direct_settings[datalinker_table].ddbdatalinker_position' type='desc' />
<element2 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_sorting_date' type='desc' />
<element3 attribute='$direct_settings[datalinker_table].ddbdatalinker_title_alt' type='asc' />
<element4 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_title' type='asc' />
</sqlordering>");

					break 1;
				}
				case "time-asc":
				{
$f_select_criteria = ("<sqlordering>
<element1 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_sorting_date' type='asc' />
<element2 attribute='$direct_settings[datalinker_table].ddbdatalinker_position' type='asc' />
<element3 attribute='$direct_settings[datalinker_table].ddbdatalinker_title_alt' type='asc' />
<element4 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_title' type='asc' />
</sqlordering>");

					break 1;
				}
				case "time-desc":
				{
$f_select_criteria = ("<sqlordering>
<element1 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_sorting_date' type='desc' />
<element2 attribute='$direct_settings[datalinker_table].ddbdatalinker_position' type='asc' />
<element3 attribute='$direct_settings[datalinker_table].ddbdatalinker_title_alt' type='asc' />
<element4 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_title' type='asc' />
</sqlordering>");

					break 1;
				}
				case "time-sticky-asc":
				{
$f_select_criteria = ("<sqlordering>
<element1 attribute='$direct_settings[datalinker_table].ddbdatalinker_position' type='desc' />
<element2 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_sorting_date' type='asc' />
<element3 attribute='$direct_settings[datalinker_table].ddbdatalinker_title_alt' type='asc' />
<element4 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_title' type='asc' />
</sqlordering>");

					break 1;
				}
				case "time-sticky-desc":
				{
$f_select_criteria = ("<sqlordering>
<element1 attribute='$direct_settings[datalinker_table].ddbdatalinker_position' type='desc' />
<element2 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_sorting_date' type='desc' />
<element3 attribute='$direct_settings[datalinker_table].ddbdatalinker_title_alt' type='asc' />
<element4 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_title' type='asc' />
</sqlordering>");

					break 1;
				}
				case "title-asc":
				{
$f_select_criteria = ("<sqlordering>
<element1 attribute='$direct_settings[datalinker_table].ddbdatalinker_title_alt' type='asc' />
<element2 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_title' type='asc' />
<element3 attribute='$direct_settings[datalinker_table].ddbdatalinker_position' type='asc' />
<element4 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_sorting_date' type='asc' />
</sqlordering>");

					break 1;
				}
				case "title-desc":
				{
$f_select_criteria = ("<sqlordering>
<element1 attribute='$direct_settings[datalinker_table].ddbdatalinker_title_alt' type='desc' />
<element2 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_title' type='desc' />
<element3 attribute='$direct_settings[datalinker_table].ddbdatalinker_position' type='asc' />
<element4 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_sorting_date' type='asc' />
</sqlordering>");

					break 1;
				}
				case "title-sticky-asc":
				{
$f_select_criteria = ("<sqlordering>
<element1 attribute='$direct_settings[datalinker_table].ddbdatalinker_position' type='desc' />
<element2 attribute='$direct_settings[datalinker_table].ddbdatalinker_title_alt' type='asc' />
<element3 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_title' type='asc' />
<element4 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_sorting_date' type='asc' />
</sqlordering>");

					break 1;
				}
				case "title-sticky-desc":
				{
$f_select_criteria = ("<sqlordering>
<element1 attribute='$direct_settings[datalinker_table].ddbdatalinker_position' type='desc' />
<element2 attribute='$direct_settings[datalinker_table].ddbdatalinker_title_alt' type='desc' />
<element3 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_title' type='desc' />
<element4 attribute='$direct_settings[datalinkerd_table].ddbdatalinker_sorting_date' type='asc' />
</sqlordering>");

					break 1;
				}
				default: { $f_select_criteria = "<sqlordering><element1 attribute='$direct_settings[datalinkerd_table].ddbdatalinkerd_id' type='asc' /></sqlordering>"; }
				}
			}

			if ($f_datalinker_object)
			{
				$direct_classes['db']->define_ordering ($f_select_criteria);

				if (is_numeric ($f_perpage))
				{
					$direct_classes['db']->define_limit ($f_perpage);
					$direct_classes['db']->define_offset ($f_offset);
				}
			}

			if ($f_datalinker_object)
			{
				$f_results_array = $direct_classes['db']->query_exec ("ma");

				if ((is_array ($f_options))&&($f_options)) { $f_continue_check = true; }
				else { $f_continue_check = false; }

				if ($f_results_array)
				{
					foreach ($f_results_array as $f_result_array)
					{
						if ($f_continue_check) { $f_return[$f_result_array['ddbdatalinker_id']] = new $f_datalinker_object ($f_options); }
						else { $f_return[$f_result_array['ddbdatalinker_id']] = new $f_datalinker_object (); }

						if (!$f_return[$f_result_array['ddbdatalinker_id']]->set ($f_result_array)) { unset ($f_return[$f_result_array['ddbdatalinker_id']]); }
					}
				}
			}
			else { $f_return = $direct_classes['db']->query_exec ("ss"); }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->get_subs ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->insert ($f_insert_mode_deactivate = true)
/**
	* Writes new object data to the database.
	*
	* @param  boolean $f_insert_mode_deactivate Deactive insert mode after calling
	*         update ()
	* @uses   direct_datalinker::update()
	* @uses   direct_dbsync_event()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	public function insert ($f_insert_mode_deactivate = true)
	{
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -datalinker_handler->insert (+f_insert_mode_deactivate)- (#echo(__LINE__)#)"); }
		$this->data_insert_mode = true;
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->insert ()- (#echo(__LINE__)#)",(:#*/$this->update (true,true,$f_insert_mode_deactivate)/*#ifdef(DEBUG):),true):#*/;
	}

	//f// direct_datalinker->insert_link ($f_insert_mode_deactivate = true)
/**
	* Writes new object data to the database.
	*
	* @param  boolean $f_insert_mode_deactivate Deactive insert mode after calling
	*         update ()
	* @uses   direct_datalinker::update()
	* @uses   direct_dbsync_event()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	public function insert_link ($f_insert_mode_deactivate = true)
	{
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -datalinker_handler->insert_link (+f_insert_mode_deactivate)- (#echo(__LINE__)#)"); }
		$this->data_insert_mode = true;
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->insert_link ()- (#echo(__LINE__)#)",(:#*/$this->update (true,false,$f_insert_mode_deactivate)/*#ifdef(DEBUG):),true):#*/;
	}

	//f// direct_datalinker->is_changed ($f_keys_array)
/**
	* Checks if at least one entry has changed.
	*
	* @param  array $f_keys_array Keys to check
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True if something has changed
	* @since  v0.1.00
*/
	public function is_changed ($f_keys_array)
	{
		if (USE_debug_reporting) { direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->is_changed (+f_keys_array)- (#echo(__LINE__)#)"); }
		$f_return = false;

		if (is_array ($f_keys_array))
		{
			foreach ($f_keys_array as $f_key)
			{
				if ((!$f_return)&&(isset ($this->data_changed[$f_key]))) { $f_return = true; }
			}
		}

		return /*#ifdef(DEBUG):direct_debug (9,"sWG/#echo(__FILEPATH__)# -datalinker_handler->is_changed ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->is_empty ()
/**
	* Returns true if this object is empty.
	*
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True or false
	* @since  v0.1.00
*/
	public function is_empty ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->is_empty ()- (#echo(__LINE__)#)"); }

		if (count ($this->data) > 1) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->is_empty ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->is_empty ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_datalinker->is_of_type ($f_sid,$f_type = NULL)
/**
	* Returns true if this object is of the given type (SID + type).
	*
	* @param  string $f_sid Service ID
	* @param  integer $f_type Type ID
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True or false
	* @since  v0.1.00
*/
	public function is_of_type ($f_sid,$f_type = NULL)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->is_of_type ($f_sid,+f_type)- (#echo(__LINE__)#)"); }
		$f_return = false;

		if ((isset ($this->data['ddbdatalinker_sid']))&&($this->data['ddbdatalinker_sid'] == $f_sid))
		{
			$f_return = true;
			if (($f_type !== NULL)&&($f_type != $this->data['ddbdatalinker_type'])) { $f_return = false; }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->is_of_type ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->is_sub_allowed ()
/**
	* Returns true if views should be counted.
	*
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean State
	* @since  v0.1.00
*/
	public function is_sub_allowed ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->is_sub_allowed ()- (#echo(__LINE__)#)"); }
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->is_sub_allowed ()- (#echo(__LINE__)#)",:#*/$this->data_subs_allowed/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->is_views_counting ()
/**
	* Returns true if views should be counted.
	*
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean State
	* @since  v0.1.00
*/
	public function is_views_counting ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->is_views_counting ()- (#echo(__LINE__)#)"); }

		if ((isset ($this->data['ddbdatalinker_views_count']))&&($this->data['ddbdatalinker_views_count'])) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->is_views_counting ()- (#echo(__LINE__)#)",:#*/true/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->is_views_counting ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_datalinker->parse ($f_prefix = "")
/**
	* Parses this DataLinker object and returns valid (X)HTML.
	*
	* @param  string $f_prefix Key prefix
	* @uses   direct_debug()
	* @uses   direct_html_encode_special()
	* @uses   direct_linker()
	* @uses   direct_local_get()
	* @uses   USE_debug_reporting
	* @return array Output data
	* @since  v0.1.00
*/
	public function parse ($f_prefix = "")
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->parse ($f_prefix)- (#echo(__LINE__)#)"); }
		$f_return = array ();

		if ($this->data)
		{
			$f_id_safe = strtolower (preg_replace ("#\W#","_",$this->data['ddbdatalinker_id']));
			$f_return[$f_prefix."id"] = "swgdhandlerdatalinker".$f_id_safe;
			$f_return[$f_prefix."oid"] = $this->data['ddbdatalinker_id'];
			$f_return[$f_prefix."title"] = direct_html_encode_special ($this->data['ddbdatalinker_title']);
			$f_return[$f_prefix."title_alt"] = direct_html_encode_special ($this->data['ddbdatalinker_title_alt']);
			$f_return[$f_prefix."objects"] = $this->data['ddbdatalinker_objects'];
			$f_return[$f_prefix."subs"] = $this->data['ddbdatalinker_subs'];
		
			if ($this->data['ddbdatalinker_subs'] > 0) { $f_return[$f_prefix."subs_available"] = true; }
			else { $f_return[$f_prefix."subs_available"] = false; }

			$f_return[$f_prefix."subs_id"] = $f_id_safe;
			$f_return[$f_prefix."subs_title"] = "";
			$f_return[$f_prefix."subs_link_title"] = "";
			$f_return[$f_prefix."subs_hide"] = false;
			$f_return[$f_prefix."subs_allowed"] = $this->data_subs_allowed;

			if (($f_return[$f_prefix."subs_allowed"])||($f_return[$f_prefix."subs_available"]))
			{
				if ($this->data['ddbdatalinker_datasubs_hide']) { $f_return[$f_prefix."subs_hide"] = true; }

				switch ($this->data['ddbdatalinker_datasubs_type'])
				{
				// Attachments
				case 1:
				{
					$f_return[$f_prefix."subs_title"] = direct_local_get ("core_datasub_title_attachments");
					$f_return[$f_prefix."subs_link_title"] = direct_local_get ("core_datasub_title_link_attachments");
					break 1;
				}
				// Downloads
				case 2:
				{
					$f_return[$f_prefix."subs_title"] = direct_local_get ("core_datasub_title_downloads");
					$f_return[$f_prefix."subs_link_title"] = direct_local_get ("core_datasub_title_link_downloads");
					break 1;
				}
				// Links
				case 3:
				{
					$f_return[$f_prefix."subs_title"] = direct_local_get ("core_datasub_title_links");
					$f_return[$f_prefix."subs_link_title"] = direct_local_get ("core_datasub_title_link_links");
					break 1;
				}
				// Additional content
				default:
				{
					$f_return[$f_prefix."subs_title"] = direct_local_get ("core_datasub_title_default");
					$f_return[$f_prefix."subs_link_title"] = direct_local_get ("core_datasub_title_link_default");
				}
				}
			}

			if ($this->data['ddbdatalinker_views_count'])
			{
				$f_return[$f_prefix."views"] = $this->data['ddbdatalinker_views'];
				$f_return[$f_prefix."views_counted"] = true;
			}
			else
			{
				$f_return[$f_prefix."views"] = 0;
				$f_return[$f_prefix."views_counted"] = false;
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->parse ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->remove_objects ($f_count,$f_update = true)
/**
	* Decreases the objects counter.
	*
	* @param  number $f_count Number to be removed from the objects counter
	* @param  boolean $f_update True to update the database entry
	* @uses   direct_datalinker::update()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	public function remove_objects ($f_count,$f_update = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->remove_objects ($f_count,+f_update)- (#echo(__LINE__)#)"); }
		$f_return = false;

		if (isset ($this->data['ddbdatalinker_objects']))
		{
			$this->data['ddbdatalinker_objects'] -= $f_count;
			$this->data_changed['ddbdatalinker_objects'] = true;

			if ($f_update) { $f_return = $this->update (false,true); }
			else { $f_return = true; }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->remove_objects ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->remove_subs ($f_count,$f_update = true)
/**
	* Decreases the subs counter.
	*
	* @param  number $f_count Number to be removed from the subs counter
	* @param  boolean $f_update True to update the database entry
	* @uses   direct_datalinker::update()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	public function remove_subs ($f_count,$f_update = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->remove_subs ($f_count,+f_update)- (#echo(__LINE__)#)"); }
		$f_return = false;

		if (isset ($this->data['ddbdatalinker_subs']))
		{
			$this->data['ddbdatalinker_subs'] -= $f_count;
			$this->data_changed['ddbdatalinker_subs'] = true;

			if ($f_update) { $f_return = $this->update (false,true); }
			else { $f_return = true; }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->remove_subs ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->remove_views ($f_count,$f_update = true)
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
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->remove_views ($f_count,+f_update)- (#echo(__LINE__)#)"); }
		$f_return = false;

		if ((isset ($this->data['ddbdatalinker_views']))&&(isset ($this->data['ddbdatalinker_views_count']))&&($this->data['ddbdatalinker_views_count']))
		{
			$this->data['ddbdatalinker_views'] -= $f_count;
			$this->data_changed['ddbdatalinker_views'] = true;

			if ($f_update) { $f_return = $this->update (false,true); }
			else { $f_return = true; }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->remove_views ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->set ($f_data)
/**
	* Sets (and overwrites existing) the DataLinker entry.
	*
	* @param  array $f_data DataLinker entry
	* @uses   direct_datalinker::changed()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	public function set ($f_data)
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->set (+f_data)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (isset ($f_data['ddbdatalinker_id'],$f_data['ddbdatalinker_id_parent'],$f_data['ddbdatalinker_sid'],$f_data['ddbdatalinker_type'],$f_data['ddbdatalinker_subs'],$f_data['ddbdatalinker_objects'],$f_data['ddbdatalinker_position'],$f_data['ddbdatalinker_sorting_date'],$f_data['ddbdatalinker_symbol'],$f_data['ddbdatalinker_title']))
		{
			$this->changed ($f_data);

			if (!isset ($f_data['ddbdatalinker_id_object']))
			{
				$f_data['ddbdatalinker_id_object'] = $f_data['ddbdatalinker_id'];
				$this->data_changed['ddbdatalinker_id_object'] = true;
			}

			if (!isset ($f_data['ddbdatalinker_id_main']))
			{
				$f_data['ddbdatalinker_id_main'] = "";
				$this->data_changed['ddbdatalinker_id_main'] = true;
			}

			if (!isset ($f_data['ddbdatalinker_title_alt']))
			{
				$f_data['ddbdatalinker_title_alt'] = "";
				$this->data_changed['ddbdatalinker_title_alt'] = true;
			}

			if (isset ($f_data['ddbdatalinker_datasubs_type']))
			{
				if (!isset ($f_data['ddbdatalinker_datasubs_hide']))
				{
					$f_data['ddbdatalinker_datasubs_hide'] = 1;
					$this->data_changed['ddbdatalinker_datasubs_hide'] = true;
				}

				if (!isset ($f_data['ddbdatalinker_datasubs_new']))
				{
					$f_data['ddbdatalinker_datasubs_new'] = 1;
					$this->data_changed['ddbdatalinker_datasubs_new'] = true;
				}
			}
			else
			{
				$f_data['ddbdatalinker_datasubs_type'] = NULL;
				$f_data['ddbdatalinker_datasubs_hide'] = NULL;
				$f_data['ddbdatalinker_datasubs_new'] = NULL;
			}

			if (!isset ($f_data['ddbdatalinker_views_count']))
			{
				$f_data['ddbdatalinker_views_count'] = 0;
				$this->data_changed['ddbdatalinker_views_count'] = true;
			}

			if (!isset ($f_data['ddbdatalinker_views']))
			{
				$f_data['ddbdatalinker_views'] = 0;
				$this->data_changed['ddbdatalinker_views'] = true;
			}

$this->data = array (
"ddbdatalinker_id" => $f_data['ddbdatalinker_id'],
"ddbdatalinker_id_object" => $f_data['ddbdatalinker_id_object'],
"ddbdatalinker_id_parent" => $f_data['ddbdatalinker_id_parent'],
"ddbdatalinker_id_main" => $f_data['ddbdatalinker_id_main'],
"ddbdatalinker_sid" => $f_data['ddbdatalinker_sid'],
"ddbdatalinker_type" => $f_data['ddbdatalinker_type'],
"ddbdatalinker_position" => $f_data['ddbdatalinker_position'],
"ddbdatalinker_title_alt" => $f_data['ddbdatalinker_title_alt'],
"ddbdatalinker_subs" => $f_data['ddbdatalinker_subs'],
"ddbdatalinker_objects" => $f_data['ddbdatalinker_objects'],
"ddbdatalinker_sorting_date" => $f_data['ddbdatalinker_sorting_date'],
"ddbdatalinker_symbol" => $f_data['ddbdatalinker_symbol'],
"ddbdatalinker_title" => $f_data['ddbdatalinker_title'],
"ddbdatalinker_datasubs_type" => $f_data['ddbdatalinker_datasubs_type'],
"ddbdatalinker_datasubs_hide" => $f_data['ddbdatalinker_datasubs_hide'],
"ddbdatalinker_datasubs_new" => $f_data['ddbdatalinker_datasubs_new'],
"ddbdatalinker_views_count" => $f_data['ddbdatalinker_views_count'],
"ddbdatalinker_views" => $f_data['ddbdatalinker_views']
);

			if (($this->data['ddbdatalinker_datasubs_type'] !== NULL)&&(($f_data['ddbdatalinker_datasubs_new'])||($direct_classes['kernel']->v_usertype_get_int ($direct_settings['user']['type']) > 3))) { $this->data_subs_allowed = true; }
			else { $this->data_subs_allowed = false; }

			$f_return = true;
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->set ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->set_extras ($f_data,$f_keys = "")
/**
	* Fills in additional keys in "$this->data". If $f_keys are specified
	* this method will overwrite existing values. Without $f_keys all keys in
	* $f_data will be added but no values will be overwritten.
	*
	* @param  array $f_data DataLinker data
	* @param  array $f_keys DataLinker keys to add / edit
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @since  v0.1.00
*/
	public function set_extras ($f_data,$f_keys = "")
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->set_extras (+f_data,+f_keys)- (#echo(__LINE__)#)"); }

		if ((is_array ($f_keys))&&(!empty ($f_keys)))
		{
			foreach ($f_keys as $f_key)
			{
				if (isset ($f_data[$f_key]))
				{
					if ((!isset ($this->data[$f_key]))||($this->data[$f_key] != $f_data[$f_key])) { $this->data_changed[$f_key] = true; }
					$this->data[$f_key] = $f_data[$f_key];
				}
			}
		}
		elseif ((is_array ($f_data))&&(!empty ($f_data)))
		{
			foreach ($f_data as $f_key => $f_value)
			{
				if (!isset ($this->data[$f_key]))
				{
					$this->data[$f_key] = $f_value;
					$this->data_changed[$f_key] = true;
				}
			}
		}
	}

	//f// direct_datalinker->set_insert ($f_data)
/**
	* Sets (and overwrites existing) the DataLinker entry and saves it to the
	* database. Note: If "set()" fails because of permission problems 
	* "update()" has to be called manually to write data to the database.
	* Please make sure that this is the intended behavior. You can use
	* "is_empty()" to check for the current data state of this object.
	*
	* @param  array $f_data DataLinker entry
	* @param  boolean $f_insert_mode_deactivate Deactive insert mode after calling
	*         update ()
	* @uses   direct_datalinker::set()
	* @uses   direct_datalinker::update()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	public function set_insert ($f_data,$f_insert_mode_deactivate = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->set_insert (+f_data,+f_insert_mode_deactivate)- (#echo(__LINE__)#)"); }

		if ($this->set ($f_data))
		{
			$this->data_insert_mode = true;
			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->set_insert ()- (#echo(__LINE__)#)",(:#*/$this->update (true,true,$f_insert_mode_deactivate)/*#ifdef(DEBUG):),true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->set_insert ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_datalinker->set_sorting_date ($f_datetime,$f_update = true)
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
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->set_sorting_date ($f_datetime,+f_update)- (#echo(__LINE__)#)"); }
		$f_return = false;

		if ((isset ($this->data['ddbdatalinker_sorting_date']))&&(is_numeric ($f_datetime)))
		{
			$this->data['ddbdatalinker_sorting_date'] = $f_datetime;
			$this->data_changed['ddbdatalinker_sorting_date'] = true;

			if ($f_update) { $f_return = $this->update (false,true); }
			else { $f_return = true; }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->set_sorting_date ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_datalinker->set_update ($f_data,$f_update_link_data = true,$f_update_data = true)
/**
	* Updates (and overwrites) the existing DataLinker entry and saves it to the
	* database. Note: If "set()" fails because of permission problems 
	* "update()" has to be called manually to write data to the database.
	* Please make sure that this is the intended behavior. You can use
	* "is_empty()" to check for the current data state of this object.
	*
	* @param  array $f_data DataLinker entry
	* @param  boolean $f_update_link_data Update *_datalinker if true
	* @param  boolean $f_update_data Update *_datalinkerd if true
	* @uses   direct_datalinker::set()
	* @uses   direct_datalinker::update()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	public function set_update ($f_data,$f_update_link_data = true,$f_update_data = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -datalinker_handler->set_update (+f_data,+f_update_link_data,+f_update_data)- (#echo(__LINE__)#)"); }

		if ($this->set ($f_data))
		{
			$this->data_insert_mode = false;
			return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->set_update ()- (#echo(__LINE__)#)",(:#*/$this->update ($f_update_link_data,$f_update_data)/*#ifdef(DEBUG):),true):#*/;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->set_update ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_datalinker->update ()
/**
	* Writes the object data to the database.
	*
	* @param  boolean $f_link_data Update *_datalinker if true
	* @param  boolean $f_data Update *_datalinkerd if true
	* @param  boolean $f_insert_mode_deactivate Deactive insert mode after calling
	*         update ()
	* @uses   direct_datalinker::is_changed()
	* @uses   direct_db::define_values()
	* @uses   direct_db::define_values_keys()
	* @uses   direct_db::define_values_encode()
	* @uses   direct_db::init_replace()
	* @uses   direct_db::optimize_random()
	* @uses   direct_db::query_exec()
	* @uses   direct_dbsync_event()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.00
*/
	public function update ($f_link_data = true,$f_data = true,$f_insert_mode_deactivate = true)
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -datalinker_handler->update (+f_link_data,+f_data,+f_insert_mode_deactivate)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (empty ($this->data_changed)) { $f_return = true; }
		else
		{
			$direct_classes['db']->v_transaction_begin ();

			if (count ($this->data) > 1)
			{
				if (($f_link_data)&&($this->is_changed (array ("ddbdatalinker_id","ddbdatalinker_id_object","ddbdatalinker_id_parent","ddbdatalinker_id_main","ddbdatalinker_sid","ddbdatalinker_type","ddbdatalinker_position","ddbdatalinker_title_alt"))))
				{
					if ($this->data_insert_mode) { $direct_classes['db']->init_insert ($direct_settings['datalinker_table']); }
					else { $direct_classes['db']->init_update ($direct_settings['datalinker_table']); }

					$f_update_values = "<sqlvalues>";
					if (($this->data_insert_mode)||(isset ($this->data_changed['ddbdatalinker_id']))) { $f_update_values .= $direct_classes['db']->define_set_attributes_encode ($direct_settings['datalinker_table'].".ddbdatalinker_id",$this->data['ddbdatalinker_id'],"string"); }
					if (($this->data_insert_mode)||(isset ($this->data_changed['ddbdatalinker_id_object']))) { $f_update_values .= $direct_classes['db']->define_set_attributes_encode ($direct_settings['datalinker_table'].".ddbdatalinker_id_object",$this->data['ddbdatalinker_id_object'],"string"); }
					if (($this->data_insert_mode)||(isset ($this->data_changed['ddbdatalinker_id_parent']))) { $f_update_values .= $direct_classes['db']->define_set_attributes_encode ($direct_settings['datalinker_table'].".ddbdatalinker_id_parent",$this->data['ddbdatalinker_id_parent'],"string"); }
					if (($this->data_insert_mode)||(isset ($this->data_changed['ddbdatalinker_id_main']))) { $f_update_values .= $direct_classes['db']->define_set_attributes_encode ($direct_settings['datalinker_table'].".ddbdatalinker_id_main",$this->data['ddbdatalinker_id_main'],"string"); }
					if (($this->data_insert_mode)||(isset ($this->data_changed['ddbdatalinker_sid']))) { $f_update_values .= $direct_classes['db']->define_set_attributes_encode ($direct_settings['datalinker_table'].".ddbdatalinker_sid",$this->data['ddbdatalinker_sid'],"string"); }
					if (($this->data_insert_mode)||(isset ($this->data_changed['ddbdatalinker_type']))) { $f_update_values .= $direct_classes['db']->define_set_attributes_encode ($direct_settings['datalinker_table'].".ddbdatalinker_type",$this->data['ddbdatalinker_type'],"string"); }
					if (($this->data_insert_mode)||(isset ($this->data_changed['ddbdatalinker_position']))) { $f_update_values .= $direct_classes['db']->define_set_attributes_encode ($direct_settings['datalinker_table'].".ddbdatalinker_position",$this->data['ddbdatalinker_position'],"number"); }
					if (($this->data_insert_mode)||(isset ($this->data_changed['ddbdatalinker_title_alt']))) { $f_update_values .= $direct_classes['db']->define_set_attributes_encode ($direct_settings['datalinker_table'].".ddbdatalinker_title_alt",$this->data['ddbdatalinker_title_alt'],"string"); }
					$f_update_values .= "</sqlvalues>";

					$direct_classes['db']->define_set_attributes ($f_update_values);
					if (!$this->data_insert_mode) { $direct_classes['db']->define_row_conditions ("<sqlconditions>".($direct_classes['db']->define_row_conditions_encode ($direct_settings['datalinker_table'].".ddbdatalinker_id",$this->data['ddbdatalinker_id'],"string"))."</sqlconditions>"); }
					$f_return = $direct_classes['db']->query_exec ("co");

					if ($f_return)
					{
						if (function_exists ("direct_dbsync_event"))
						{
							if ($this->data_insert_mode) { direct_dbsync_event ($direct_settings['datalinker_table'],"insert",("<sqlconditions>".($direct_classes['db']->define_row_conditions_encode ($direct_settings['datalinker_table'].".ddbdatalinker_id",$this->data['ddbdatalinker_id'],"string"))."</sqlconditions>")); }
							else { direct_dbsync_event ($direct_settings['datalinker_table'],"update",("<sqlconditions>".($direct_classes['db']->define_row_conditions_encode ($direct_settings['datalinker_table'].".ddbdatalinker_id",$this->data['ddbdatalinker_id'],"string"))."</sqlconditions>")); }
						}

						if (!$direct_settings['swg_auto_maintenance']) { $direct_classes['db']->optimize_random ($direct_settings['datalinker_table']); }
					}
				}
				else { $f_return = true; }

				if (($f_return)&&($f_data)&&($this->is_changed (array ("ddbdatalinkerd_id","ddbdatalinker_subs","ddbdatalinker_objects","ddbdatalinker_sorting_date","ddbdatalinker_symbol","ddbdatalinker_title","ddbdatalinker_views_count","ddbdatalinker_views","ddbdatalinker_datasubs_type","ddbdatalinker_datasubs_hide","ddbdatalinker_datasubs_new"))))
				{
					if ($this->data_insert_mode) { $direct_classes['db']->init_insert ($direct_settings['datalinkerd_table']); }
					else { $direct_classes['db']->init_update ($direct_settings['datalinkerd_table']); }

					$f_update_values = "<sqlvalues>";
					if (($this->data_insert_mode)||(isset ($this->data_changed['ddbdatalinkerd_id']))) { $f_update_values .= $direct_classes['db']->define_set_attributes_encode ($direct_settings['datalinkerd_table'].".ddbdatalinkerd_id",$this->data['ddbdatalinker_id_object'],"string"); }
					if (($this->data_insert_mode)||(isset ($this->data_changed['ddbdatalinker_subs']))) { $f_update_values .= $direct_classes['db']->define_set_attributes_encode ($direct_settings['datalinkerd_table'].".ddbdatalinker_subs",$this->data['ddbdatalinker_subs'],"number"); }
					if (($this->data_insert_mode)||(isset ($this->data_changed['ddbdatalinker_objects']))) { $f_update_values .= $direct_classes['db']->define_set_attributes_encode ($direct_settings['datalinkerd_table'].".ddbdatalinker_objects",$this->data['ddbdatalinker_objects'],"number"); }
					if (($this->data_insert_mode)||(isset ($this->data_changed['ddbdatalinker_sorting_date']))) { $f_update_values .= $direct_classes['db']->define_set_attributes_encode ($direct_settings['datalinkerd_table'].".ddbdatalinker_sorting_date",$this->data['ddbdatalinker_sorting_date'],"number"); }
					if (($this->data_insert_mode)||(isset ($this->data_changed['ddbdatalinker_symbol']))) { $f_update_values .= $direct_classes['db']->define_set_attributes_encode ($direct_settings['datalinkerd_table'].".ddbdatalinker_symbol",$this->data['ddbdatalinker_symbol'],"string"); }
					if (($this->data_insert_mode)||(isset ($this->data_changed['ddbdatalinker_title']))) { $f_update_values .= $direct_classes['db']->define_set_attributes_encode ($direct_settings['datalinkerd_table'].".ddbdatalinker_title",$this->data['ddbdatalinker_title'],"string"); }
					if (($this->data_insert_mode)||(isset ($this->data_changed['ddbdatalinker_views_count']))) { $f_update_values .= $direct_classes['db']->define_set_attributes_encode ($direct_settings['datalinkerd_table'].".ddbdatalinker_views_count",$this->data['ddbdatalinker_views_count'],"string"); }
					if (($this->data_insert_mode)||(isset ($this->data_changed['ddbdatalinker_views']))) { $f_update_values .= $direct_classes['db']->define_set_attributes_encode ($direct_settings['datalinkerd_table'].".ddbdatalinker_views",$this->data['ddbdatalinker_views'],"number"); }
					if (array_key_exists ("ddbdatalinker_datasubs_type",$this->data_changed)) { $f_update_values .= $direct_classes['db']->define_set_attributes_encode ($direct_settings['datalinkerd_table'].".ddbdatalinker_datasubs_type",$this->data['ddbdatalinker_datasubs_type'],"string"); }
					if (array_key_exists ("ddbdatalinker_datasubs_hide",$this->data_changed)) { $f_update_values .= $direct_classes['db']->define_set_attributes_encode ($direct_settings['datalinkerd_table'].".ddbdatalinker_datasubs_hide",$this->data['ddbdatalinker_datasubs_hide'],"string"); }
					if (array_key_exists ("ddbdatalinker_datasubs_new",$this->data_changed)) { $f_update_values .= $direct_classes['db']->define_set_attributes_encode ($direct_settings['datalinkerd_table'].".ddbdatalinker_datasubs_new",$this->data['ddbdatalinker_datasubs_new'],"string"); }

					$f_update_values .= "</sqlvalues>";

					$direct_classes['db']->define_set_attributes ($f_update_values);
					if (!$this->data_insert_mode) { $direct_classes['db']->define_row_conditions ("<sqlconditions>".($direct_classes['db']->define_row_conditions_encode ($direct_settings['datalinkerd_table'].".ddbdatalinkerd_id",$this->data['ddbdatalinker_id_object'],"string"))."</sqlconditions>"); }
					$f_return = $direct_classes['db']->query_exec ("co");

					if ($f_return)
					{
						if (function_exists ("direct_dbsync_event"))
						{
							if ($this->data_insert_mode) { direct_dbsync_event ($direct_settings['datalinkerd_table'],"insert",("<sqlconditions>".($direct_classes['db']->define_row_conditions_encode ($direct_settings['datalinkerd_table'].".ddbdatalinkerd_id",$this->data['ddbdatalinker_id_object'],"string"))."</sqlconditions>")); }
							else { direct_dbsync_event ($direct_settings['datalinkerd_table'],"update",("<sqlconditions>".($direct_classes['db']->define_row_conditions_encode ($direct_settings['datalinkerd_table'].".ddbdatalinkerd_id",$this->data['ddbdatalinker_id_object'],"string"))."</sqlconditions>")); }
						}

						if (!$direct_settings['swg_auto_maintenance']) { $direct_classes['db']->optimize_random ($direct_settings['datalinkerd_table']); }
					}
				}
			}

			if (($f_insert_mode_deactivate)&&($this->data_insert_mode)) { $this->data_insert_mode = false; }

			if ($f_return) { $direct_classes['db']->v_transaction_commit (); }
			else { $direct_classes['db']->v_transaction_rollback (); }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -datalinker_handler->update ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_direct_datalinker",true);

//j// Script specific commands

if (!isset ($direct_settings['datalinker_objects_per_page'])) { $direct_settings['datalinker_objects_per_page'] = 15; }
if (!isset ($direct_settings['swg_auto_maintenance'])) { $direct_settings['swg_auto_maintenance'] = false; }
}

//j// EOF
?>