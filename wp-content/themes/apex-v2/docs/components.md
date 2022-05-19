# Components #
`/blocks/components/`  
Components represent reusable components for flex-items within the theme. For instance, all flex items
contain a header and text field. These fields can be rendered by using the native WP `get_template_part()` function.
```php
get_template_part('components/header-and-text');
```
*Don't forget to omit the .php.* To pass any arguments to the component, simply create an array with the arguments and
pass it to the `get_template_part()` function, like so:
```php
$args['repeater-field'] = get_field('button-repeater'); 
get_template_part('/blocks/components/button-group', 'button-group', $args);
```
Below is a description of all available components and the arguments they accept/require.

`block-header.php` [/blocks/components/block-header.php](#block-image)  
`block-footer.php` [/blocks/components/block-footer.php](#block-footer)  
`button-group.php` [/blocks/components/button-group.php](#button-group)
`button.php` [/blocks/components/button.php](#button)
`content-image.php` [/blocks/components/content-image.php](#content-image)

## Block header ##
`/blocks/components/block-header.php`

The block header is called before each flex item block and contains the basic flex block opening tags.
It's called via the native WP `get_template_part()`, and therefore any arguments that need to be passed to the header, need to be 
passed through the `$args` array.

```php
(array)     $args;
(string)    $args['flex-bgc-select'];
(string)    $args['column'];
(array)     $args['classlist'];
```
|Option|Description|
|---|---|
|`'flex-bgc-select'`|The background color for this element
|`'column'`|The selected column width for this element.
|`'classlist'`|This contains an optional array of classes that will be added to the `<section>` tag.

## Block footer ##
`/blocks/components/block-footer.php`

Contains the closing tags for the tags opened in `/blocks/components/block-header.php`.

```php
// No arguments
```

## Button group ##
`/blocks/components/button-group.php`

Wraps the buttons in a group.

```php
(array)     $args;
(array)     $args['button-repeater-field'];
```
|Option|Required|Description|
|---|---|---|
|`'button-repeater-field'`|Yes|The repeater field containing the individual buttons

## Button ##
`/blocks/components/button.php`

The single button. Should receive the `button-group` field 

```php
(array)     $args;
(array)     $args['button-group'];
```
|Option|Required|Description|
|---|---|---|
|`'button-group'`|Yes|The group field containing the individual button data

## Content image ##
`/blocks/components/content-image.php`

```php
(array)     $args;
(array)     $args['image'];
(bool)      $args['caption'];
(string)    $args['context'];
(int)       $args['lightbox-id'];
(string)    $args['image-size'];
```
|Option|Required|Description|
|---|---|---|
|`'image'`|Yes|The WP Image opbject  
|`'caption'`|No|Whether or not the caption should be displayed.  
|`'context'`|No|The flex element where the image is placed in. Options:</br>`'card'` 
|`'lightbox-id'`|No|The lightbox ID  
|`'image-size'`|No|Optional image size. If none is specified, a sourceset with images will be created.

