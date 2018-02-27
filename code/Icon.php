<?php

namespace Jaedb\IconField;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\DB;

class Icon extends DBField {

    function requireField() {
        DB::require_field($this->tableName, $this->name, 'Varchar(1024)');
    }

    private static $casting = array(
        'URL' => 'HTMLFragment',
        'IMG' => 'HTMLFragment',
        'SVG' => 'HTMLFragment'
    );	
	

	/**
	 * Default casting for this field
	 *
	 * @return string
	 */
	public function forTemplate() {
		return $this->getTag();
	}
	

	/**
	 * Default casting for this field
	 *
	 * @return string
	 */
	public function getTag() {
		$url = $this->URL();
		
		// We are an SVG, so return the SVG data
		if (substr($url, strlen($url) - 4) === '.svg'){
			return $this->SVG();
		} else {
			return $this->IMG();
		}
	}
	
	
	/** 
	 * Get just the URL for this icon
	 *
	 * @return string
	 **/
	public function URL(){
		return $this->getValue();
	}
	
	
	/** 
	 * Construct IMG tag
	 *
	 * @return string
	 **/
	public function IMG(){
		$url = $this->URL();	
		return '<img class="icon" src="'.$url.'" />';
	}
	
	
	/** 
	 * Construct SVG data
	 *
	 * @return string
	 **/
	public function SVG(){
		$url = $this->URL();

		if (substr($url, strlen($url) - 4) !== '.svg'){
			user_error('Deprecation notice: Direct access to $Icon.SVG in templates is deprecated, please use $Icon', E_USER_WARNING);
		}
		
		// figure out the full system location for the file
		$filePath = BASE_PATH.$url;
		if (!file_exists($filePath)){
			return false;
		}

		$svg = file_get_contents($filePath);
		return '<span class="icon svg">'.$svg.'</span>';
	}

	/**
	 * (non-PHPdoc)
	 * @see DBField::scaffoldFormField()
	 */
	public function scaffoldFormField($title = null, $params = null) {
		return IconField::create($this->name, $title);
	}
}