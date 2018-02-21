# Description

Simplifies the use of icons in a way content authors can set icons without interfering with the asset library. Instead, the web developer provides the icon set which the end-user can use but not manipulate.

![IconSelectField](https://raw.githubusercontent.com/jaedb/IconField/master/screenshot.jpg)


# Dependencies

* SilverStripe 4
* Betterbuttons


# Usage

* Set your `$db` field to type `Icon` (eg `'PageIcon' => 'Icon'`)
* `IconSelectField::create($name, $title, $iconFolder)`
* `$name` is the database field as defined in your class
* `$title` is the label for this field
* `$iconFolder` (optional) defines the directory where your icons can be found. Defaults to `/site/icons`.
* To change your default icon directory, see `_config/config.yml`.
* Use your icon in templates as you would any other property (eg `$PageIcon`). If your icon is an SVG, the SVG image data will be injected into the template. To prevent this, you can call `$PageIcon.IMG` instead to enforce use of `<img>` tags.