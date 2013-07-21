# XhtmlTable

Standalone PHP class for generating `<table>` tag content. Class reads
configuration from yaml files. It possible to specify language
and use stored files with texts. **XhtmlTable** class assigns dataset
from array (standard query result).

## Usage

Include class to your code. Create object, then set `$aConfig` as table
configuration from yaml. Assign dataset with right method and use `transate()`
method to specify texts for a table.

Render table finally.

```php
$oTable = new AyaXhtmlTable();

$oTable->configure($aConfig);

$oTable->assign($aDataset);

$oTable->translate($aTexts, $aLocalTexts);

$oTable->render();
```

## TODO

* modifiers (to change cell content)
* policies (to display table depending by privileges)
* caches (to store parsed config)
* accessibility
