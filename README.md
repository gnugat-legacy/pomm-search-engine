# Pomm Search Engine

A [Pomm Foundation](http://www.pomm-project.org/) implementation for [SearchEngine](http://gnugat.github.io/search-engine/).

## Installation

Download SearchEngine using [Composer](https://getcomposer.org/download):

    composer require gnugat/pomm-search-engine:^0.1

To get an instance of `Fetcher`, you can do the following:

```php
use Gnugat\PommSearchEngine\Build;

$fetcher = Build::fetcher($queryManager);
```

The `$queryManager` variable should be an instance of an implementation of `PommProject\Foundation\QueryManager\QueryManagerInterface`.

## Further documentation

Please visit [the official SearchEngine website](http://gnugat.github.io/search-engine/) for more information.
