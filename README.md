# OVERVIEW PROJECT

The custom module Overview dynamically displays Crop and Cultivars.

See a glimpse about the module. Open this [image one](/ScreenShot.png) and [image two](/ScreenShot2.png)

## Getting Started

A. Cloning an Existing Repository  
```bash

git clone https://github.com/Viktoru/Overview.git

```
B. Drag and drop the Custom module Overview files to your "Custom" folder or "modules" folder.

After you install the module you need to add a field and name it "link_the_site". This field allows you to connect to the module Overview. Go to your Drupal 8 site, and select Content Types named "Main Lab Fruit and Nut". Click on the Manage Fields option, and "Add" a field name "field_link_the_site". Make sure it is exactly the same name.
Otherwise, it will return an error after you install the module Overview.

Note: In the future you can create a Custom Content Type file by creating a YAML file that contains all the required configurations. For more details go to the mlfruitandnut->config->install folders. 
Also, visit [development docs](https://github.com/Viktoru/mlfruitandnut/blob/master/mlfruitandnut/docs/development.md). for more information about this module.
### Prerequisites

- Drupal 8.6.x
- PHP 7.1.x
- Custom module mlfruitandnut (D8)
- MySQL or  PostgreSQL
- CSV Import Module [CSV Import](https://www.drupal.org/project/csv_importer) - Downloads 8.x.1.4

### Installing

To install the Overview module you just need to copy the module into your Drupal 8 Module folder or custom folder.
After that go to my Drupal 8 Extend Menu to install the module.

## Built With

* [CodyHouse](https://codyhouse.co/) - The web framework used
* [Collapsible](https://github.com/Viktoru/Overview/tree/master/mainlab_list/assets/css) - Local by Victor
* [Bootstrap](https://getbootstrap.com/docs/3.4/) - Used to generate theme
* [PHP 7.1.x](http://php.net/) - PHP version


## Development

Please read [Development](https://github.com/Viktoru/Overview/blob/master/mainlab_list/docs/development.md) for details.


## Contributing

Please read [CONTRIBUTING.md](https://github.com/Viktoru/) for details.

## Authors

* **Victor P Unda** - [Victor](https://github.com/Viktoru/)

## License

This project is licensed under the WSU Main Lab - see the [Main Website](http://www.bioinfo.wsu.edu) for details.