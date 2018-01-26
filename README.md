# SonataPageMenuBundle
Symfony 3 Bundle for Menu creation within Sonata Admin

## Installation

This bundle is a fork of [SonataPageBundle](https://github.com/skillberto/SonataPageMenuBundle) made by @skillberto.

It gives a lot of enhancements, like 
* User restrict a menu,
* Set an icon on a menu item,
* Choose between **standard** an **boostrap** template
* Define more than one menu with menu types
* and maybe many more coming

This fork has waiting PRs to be merged, but I don't know if, and when the author will merge it into master branch.

So, to use it for my project, I created a `enhanced` branch where the modifications resides.

If you want to use it, you should install this bundle by adding a [VCS repositories](https://getcomposer.org/doc/05-repositories.md#loading-a-package-from-a-vcs-repository).

So to install this bundle :

  Put this code in your repositories part of your composer.json.
```
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/psyray/SonataPageMenuBundle"
        }
    ],

```
  Make a `composer require skillberto/sonata-page-menu-bundle dev-enhanced`
  
  And you're good to go ;)

## Usage

To use this bundle simply add this include to the template where you want the menu to appear, based on menu type id 
```
{% include 'SkillbertoSonataPageMenuBundle:Menu:menu.html.twig' with {'type': 1} %}
```

You could choose between two templates, **standard** and **bootstrap**

Default value is **standard**.

If you want the Bootstrap template simply add to your config.yml (and of course you should have the bootstrap CSS/JS loaded)
```
skillberto_sonata_page_menu:
    template: bootstrap
```

Template could also be overrided in the include, like this

```
{% include 'SkillbertoSonataPageMenuBundle:Menu:menu.html.twig' with {'type': 1, 'template': 'bootstrap', 'fixed': false, 'inverse': false, 'toggle': 'collapse'} %}
```

Type is the database id of the menu type (main, footer...) 

Full options is (with default values), you could tweak the bootstrap navbar here
```
skillberto_sonata_page_menu:
    template: standard
    bootstrap_options:
        fixed: false
        inverse: false
        toggle: collapse
        navbar_brand:
            displayed: true
            title: "My company"
            mobile_text: "Browse"
            link_path: #
```