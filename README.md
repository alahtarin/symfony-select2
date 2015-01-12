# Symfony Select2 Bundle
This bundle doesn't provides the original select2 component files, it just integrates it into Symfony2 form extension.

## Installation
1. Add dependecies to your `composer.json` file
```JSON
{
    ...
    "require": {
        ...
        "ivaynberg/select2": "3.5.2",
        "alahtarin/symfony-select2": "dev-master",
        ...
    }
    ...
    "repositories": [
      ...
      {
        "type" : "vcs",
        "url" : "https://github.com/alahtarin/symfony-select2.git"
      },
      ...
    ]
}
```

2. Enable bundle in `AppKernel.php`
```PHP
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            ...
            new Alahtarin\Select2Bundle\AlahtarinSelect2Bundle(),
            ...
        );
    }
}
``` 

3. Edit your config file to add new theme template:
```YML
twig:
    form_themes:
      ...
      - 'AlahtarinSelect2Bundle:Form:select2.html.twig'
```

## Usage
You can now use the `select2` form type in your FormBuilder:
```PHP
  $builder->add('city', 'select2', [
      'repository' => $this->cityRepository,
      'url' => $this->router->generate('your_bundle_city_search'),
      'field' => 'name'
  ])
```

### Required parameters:
 - **repository**: either a Doctrine Entity or Document repository, or your custom repository class. The only requirement is, it should provide the get() method
 - **url**: the search url which should return json response with the found entities

### Optional parameters:
 - **field**: the name of the field which represents the name of the entity (default: *label*)
