<?php

/*
	Copyright (c) 2009-2012 F3::Factory/Bong Cosca, All rights reserved.

	This file is part of the Fat-Free Framework (http://fatfree.sf.net).

	THE SOFTWARE AND DOCUMENTATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF
	ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
	IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR
	PURPOSE.

	Please see the license.txt file for more information.
*/

//! PHP magic wrapper
abstract class Magic {

	/**
		Return TRUE if key is not empty
		@return bool
		@param $key string
	**/
	abstract function exists($key);

	/**
		Bind value to key
		@return mixed
		@param $key string
		@param $val mixed
	**/
	abstract function set($key,$val);

	/**
		Retrieve contents of key
		@return mixed
		@param $key string
	**/
	abstract function get($key);

	/**
		Unset key
		@return NULL
		@param $key string
	**/
	abstract function clear($key);

	/**
		Return TRUE if property has public visibility
		@return bool
		@param $Key string
	**/
	private function visible($key) {
		if (property_exists($this,$key)) {
			$ref=new \ReflectionProperty(get_class($this),$key);
			$out=$ref->ispublic();
			unset($ref);
			return $out;
		}
		return FALSE;
	}

	/**
		Convenience method for checking property value
		@return mixed
		@param $key string
	**/
	function __isset($key) {
		return $this->visible($key)?isset($this->$key):$this->exists($key);
	}

	/**
		Convenience method for assigning property value
		@return mixed
		@param $key string
		@param $val scalar
	**/
	function __set($key,$val) {
		return $this->visible($key)?($this->key=$val):$this->set($key,$val);
	}

	/**
		Convenience method for retrieving property value
		@return mixed
		@param $key string
	**/
	function __get($key) {
		return $this->visible($key)?$this->$key:$this->get($key);
	}

	/**
		Convenience method for checking property value
		@return mixed
		@param $key string
	**/
	function __unset($key) {
		if ($this->visible($key))
			unset($this->$key);
		else
			$this->clear($key);
	}

}
