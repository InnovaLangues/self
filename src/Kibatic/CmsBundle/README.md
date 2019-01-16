# KibaticCmsBundle

## Installation

```
// composer.json
{
    ...
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/kibatic/KibaticCmsBundle"
        }
    ]
}
```

```
composer require kibatic/cms-bundle dev-master
```

```
// app/AppKernel.php

public function registerBundles()
{
    $bundles = [
        // ...
        new Kibatic\CmsBundle\KibaticCmsBundle(),
        // ...
    ];
}
```

```
// app/config/routing.yml

kibatic_cms:
    resource: "@KibaticCmsBundle/Resources/config/routing.yml"
    prefix:   /
```


Update your database schema with :

```
bin/console doctrine:schema:update --force
```

or :

```
bin/console doctrine:migration:diff
bin/console doctrine:migration:migrate
```

Your user must have the `ROLE_CMS_ADMIN` to be able to use the CMS.

## Override Layout

By default, the cms use this layout : `::layout.html.twig`

If you wish to use another one, simply create a template : `app/Resources/KibaticCmsBundle/layout.html.twig`

For example to use a layout in your AppBundle :

```
{% extends 'AppBundle::layout.html.twig' %}
```
