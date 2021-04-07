# Install

`composer require plasticstudio/iconfield`

# Description

Simplifies the use of icons in a way content authors can set icons without interfering with the asset library. Instead, the web developer provides the icon set which the end-user can use but not manipulate.

![IconField](https://raw.githubusercontent.com/jaedb/IconField/master/screenshot.jpg)

# Requirements

- SilverStripe 4

# Usage

- Import the required classes:

```
use PlasticStudio\IconField\Icon;
use PlasticStudio\IconField\IconField;
```

- Set your `$db` field to type `Icon` (eg `'PageIcon' => Icon::class`)
- `IconField::create($name, $title, $iconFolder)`
- `$name` is the database field as defined in your class
- `$title` is the label for this field
- `$iconFolder` (optional) defines the directory where your icons can be found. If your project has a `public` directory, you'll need to make sure the path to this folder is exposed. Defaults to `_resources/app/client/assets/icons` (you can override this default in your project's own configg file).
- To change your default icon directory, see `_config/config.yml`.
- Use your icon in templates as you would any other property (eg `$PageIcon`). If your icon is an SVG, the SVG image data will be injected into the template. To prevent this, you can call `$PageIcon.IMG` instead to enforce use of `<img>` tags.
