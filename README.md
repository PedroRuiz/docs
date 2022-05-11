# Docs
(_To read in english version [click here](README_en.md)_)

### ¿Qué es docs?
Docs es un módulo parte de la aplicación contenedora [Modular](https://github.com/PedroRuiz/modular). Este módulo es un simple editor de textos.

### ¿Qué lo hace de especial?
Al ser un módulo, ya está todo preconfigurado y su instlalación dentro de **Modular** es bastante simple.

## ¿Cómo se instala?
- Forzosamente tiene que ser instalado previamente **Modular**.
- Edita app/Config/autoload.php e incluye el espacio de nombres así:
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
- Desde un terminal, sitúate en el directorio ROOTPATH.'/Modular' de tu instalación de módular.
```bash
$ git clone https://github.com/PedroRuiz/docs
```
- Asegúrate que el nombre del directorio es "Docs".

- Ve a la raíz de tu instalación de Módular. Desde un terminal:
```bash
$ php spark migrate -n Docs
```

Es todo. Disfruta.
