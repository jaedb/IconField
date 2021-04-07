<?php

namespace PlasticStudio\IconField;

use DirectoryIterator;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\Forms\FormField;
use SilverStripe\View\Requirements;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Core\Manifest\ModuleResourceLoader;

class IconField extends OptionsetField
{
    public static $sourceFolder;
    
    /**
     * Construct the field
     *
     * @param string $name
     * @param null|string $title
     * @param string $sourceFolder
     *
     * @return array icons to provide as source array for the field
     **/
    public function __construct($name, $title = null, $sourceFolder = null)
    {
        parent::__construct($name, $title, []);

        if (!$sourceFolder) {
            $sourceFolder = Config::inst()->get('IconField', 'icons_directory');
        }
        // not entirely sure we need to run this through resolvePath
        // TODO: further testing to see if it's necessary
        $sourcePath = ModuleResourceLoader::singleton()->resolvePath($sourceFolder);

        
        $icons = [];
        $extensions = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg');

        // Scan each directory for files
        if (file_exists($sourcePath)) {
            $directory = new DirectoryIterator($sourcePath);
            foreach ($directory as $fileinfo) {
                if ($fileinfo->isFile()) {
                    $extension = strtolower(pathinfo($fileinfo->getFilename(), PATHINFO_EXTENSION));

                    // Only add to our available icons if it's an extension we're after
                    if (in_array($extension, $extensions)) {
                        $value = Controller::join_links($sourceFolder, $fileinfo->getFilename());
                        $title = $fileinfo->getFilename();
                        $icons[$value] = $title;
                    }
                }
            }
        }
        
        $this->source = $icons;
        Requirements::css('plasticstudio/iconfield:css/IconField.css');
    }
    

    /**
     * Build the field
     *
     * @return HTML
     **/
    public function Field($properties = array())
    {
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

        if ($source) {
            foreach ($source as $value => $title) {
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
    public function extraClass()
    {
        $classes = array('field', 'IconField', parent::extraClass());

        if (($key = array_search("icon", $classes)) !== false) {
            unset($classes[$key]);
        }

        return implode(' ', $classes);
    }
}
