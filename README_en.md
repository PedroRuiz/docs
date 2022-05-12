# docs
(_Para leer en español [pulsa aquí](README_en.md)_)

### What is docs?
Docs is a module part of the container application [Modular](https://github.com/PedroRuiz/modular). This module is a simple text editor.

### What makes it special?
Being a module, everything is already preconfigured and its installation within **Modular** is quite simple.

## How to install?
- It necessarily has to be previously installed **Modular**.
- Edit .env and declare this module as shown in the example, other modules will be declared the same
```php
#--------------------------------------------------------------------
# INSTALLED MODULES
#--------------------------------------------------------------------
modules = 'main|Docs'
```
- Edit app/Config/autoload.php and incluye the namespaces like is shown here:
```php
/**
     * -------------------------------------------------------------------
     * Namespaces
     * -------------------------------------------------------------------
     * This maps the locations of any namespaces in your application to
     * their location on the file system. These are used by the autoloader
     * to locate files the first time they have been instantiated.
     *
     * The '/app' and '/system' directories are already mapped for you.
     * you may change the name of the 'App' namespace if you wish,
     * but this should be done prior to creating any namespaced classes,
     * else you will need to modify all of those classes for this to work.
     *
     * Prototype:
     *```
     *   $psr4 = [
     *       'CodeIgniter' => SYSTEMPATH,
     *       'App'	       => APPPATH
     *   ];
     *```
     *
     * @var array<string, string>
     */
    public $psr4 = [
        APP_NAMESPACE => APPPATH, // For custom app namespace
        'Config'            => APPPATH . 'Config',
        'IonAuth'           => ROOTPATH . 'CodeIgniter-Ion-Auth',         
        'Docs'              => ROOTPATH . 'Modules/Docs',

    ];
```
- From a terminal, go to the ROOTPATH.'/Modular' directory of your module installation.
```bash
$ git clone https://github.com/PedroRuiz/docs
```
- Make sure the directory name is "Docs".

- Go to the root of your Modular installation. From a terminal:
```bash
$ php spark migrate -n Docs
```

That's all. Enjoy.