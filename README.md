# Repository Pattern Implementation for Laravel 5.2

## Install
Install dependencies using <a href="https://getcomposer.org" target="_blank">composer</a>.

`composer install`

## Usage

### Adding Connections

At first, add connections using `Illuminate\Database\Capsule\Manager`

```
use Illuminate\Database\Capsule\Manager as Capsule;
use Config\Database;

$capsule = new Capsule;
$capsule->addConnection(Database::getConfig('albert'), 'albert');
$capsule->addConnection(Database::getConfig('booking'), 'booking');
...
$capsule->bootEloquent();
```

### Setup Data Sources

Load `ExampleRepository` class, then add data sources and set one 
which you would like to use. 

You can change your data source anytime using
 `$exampleRepository->setSource($source);` method.

```
...
use App\Repositories\ExampleRepository;

$exampleRepository = new ExampleRepository();
$exampleRepository->addSource('test')
    ->addSource('albert')
    ...
    ->addSource('booking');
    
$exampleRepository->setSource('booking');
```

Or remove a data source using `$exampleRepository->removeSource($source);`

To get data sources, use `$exampleRepository->getSources();`

### Querying

Let's define a dummy array first.
```
$data = [
    "title" => "Example",
    "content" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
    "description" => "This is a description."
];
```

#### insert(array $data): bool

`$exampleRepository->insert($data);`

#### save(array $data): object

```
...
use App\Models\Example;

$example = new Example($data);
$exampleRepository->save($example);
```

#### all($columns = ['*']): mixed

`$exampleRepository->all();`

#### find($id, $columns = ['*']): mixed

`$exampleRepository->find($id);`

#### findBy($field, $value, $columns = ['*']): mixed

`$exampleRepository->find($field, $value);`

#### paginate($perPage = 15, $columns = ['*']): mixed

`$exampleRepository->paginate(20);`

#### update(array $data, $id, $reflect = false): bool

`$exampleRepository->update($data, $id);`

> Use `$reflect = true` to apply this action to the other sources.

#### delete($id, $reflect = false): bool

`$exampleRepository->delete($id);`

> Use `$reflect = true` to apply this action to the other sources.

## Testing

`composer exec phpunit test`

## About The Author

- <a href="https://github.com/yigitgenc" target="_blank">Github</a>
- <a href="https://linkedin.com/in/yigitgenc" target="_blank">LinkedIn</a>
- <a href="https://twitter.com/yigidix" target="_blank">Twitter</a>
- <a href="https://facebook.com/yigidix" target="_blank">Facebook</a>