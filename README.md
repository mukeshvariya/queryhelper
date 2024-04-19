# QueryHelper
Laravel query helper
<br />
This package will short your code and decrease the number of queries as Laravel Developer

## How to install in Laravel project?
`composer require snowfingers/query-helper`

## How to use?
This is very simple use in your existing project to improve development level.

First import the class using Laravel sytem<br />
`use QueryHelper\QueryHelper;`

Now in your controller function<br />
`QueryHelper::leftJoin(ModelQueryVariable, ChildClass::class);`
