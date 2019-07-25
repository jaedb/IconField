<?php

namespace Jaedb\IconField;
use DirectoryIterator;
use SilverStripe\View\Requirements;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Forms\FormField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Core\Config\Config;

class IconField extends OptionsetField {
	
	static $sourceFolder;
	
	/**
	 * Construct the field
	 *
	 * @param string $name
	 * @param null|string $title
	 * @param string $sourceFolder
	 **/
	public function __construct($name, $title = null, $sourceFolder = null){	
		parent::__construct($name, $title, array());

		if (!$sourceFolder){
			$sourceFolder = Config::inst()->get('IconField','icons_directory');
		}
		
		$icons = array();
		$sourcePath = BASE_PATH.$sourceFolder;
		$extensions = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg');

		// Scan each directory for files
		if (file_exists($sourcePath)){
			$directory = new DirectoryIterator($sourcePath);
			foreach ($directory as $fileinfo){
				if ($fileinfo->isFile()){

					$extension = strtolower(pathinfo($fileinfo->getFilename(), PATHINFO_EXTENSION));

					// Only add to our available icons if it's an extension we're after
					if (in_array($extension, $extensions)){					
						$icons[$sourceFolder.$fileinfo->getFilename()] = $fileinfo->getFilename();
					}
				}
			}
		}
		
		$this->source = $icons;		
		Requirements::css('/resources/vendor/jaedb/iconfield/css/IconField.css');
	}
	

	/**
	 * Build the field
	 *
	 * @return HTML
	 **/
	public function Field($properties = array()) {
		$source = $this->getSource();
		$odd = 0;
		$options = array();

		// Add a clear option
		$options[] = ArrayData::create(array(
			'ID' => 'none',
			'Name' => $this->name,
			'Value' => '',
			'Title' => '',
			'isChecked' => (!$this->value || $this->value == '')
		));

		if ($source){
			foreach($source as $value => $title) {
				$itemID = $this->ID() . '_' . preg_replace('/[^a-zA-Z0-9]/', '', $value);
				$options[] = ArrayData::create(array(
					'ID' => $itemID,
					'Name' => $this->name,
					'Value' => $value,
					'Title' => $title,
					'isChecked' => $value == $this->value
				));
			}
		}

		$properties = array_merge($properties, array(
			'Options' => ArrayList::create($options)
		));

		return $this->customise($properties)->renderWith('IconField');
        //return FormField::Field($properties);
	}

	/**
	 * Handle extra classes
	 **/
    public function extraClass(){
        $classes = array('field', 'IconField', parent::extraClass());

		if (($key = array_search("icon", $classes)) !== false) {
		    unset($classes[$key]);
		}

        return implode(' ', $classes);
    }
}




