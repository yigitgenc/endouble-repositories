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

Load `VacancyRepository` class, then add data sources and set one 
which you would like to use. 

You can change your data source anytime using
 `$vacancyRepository->setSource($source);` method.

```
...
use App\Repositories\VacancyRepository;

$vacancyRepository = new VacancyRepository();
$vacancyRepository->addSource('test')
    ->addSource('albert')
    ...
    ->addSource('booking');
    
$vacancyRepository->setSource('booking');
```

Or remove a data source using `$vacancyRepository->removeSource($source);`

To get data sources, use `$vacancyRepository->getSources();`

### Querying

Let's define a dummy array first.
```
$data = [
    "title" => "Example Vacancy",
    "content" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
    "description" => "This is a description."
];
```

#### insert(array $data): bool

`$vacancyRepository->insert($data);`

#### save(array $data): object

```
...
use App\Models\Vacancy;

$vacancy = new Vacancy($data);
$vacancyRepository->save($vacancy);
```

#### all($columns = ['*']): mixed

`$vacancyRepository->all();`

#### find($id, $columns = ['*']): mixed

`$vacancyRepository->find($id);`

#### findBy($field, $value, $columns = ['*']): mixed

`$vacancyRepository->find($field, $value);`

#### paginate($perPage = 15, $columns = ['*']): mixed

`$vacancyRepository->paginate(20);`

#### update(array $data, $id, $reflect = false): bool

`$vacancyRepository->update($data, $id);`

> Use `$reflect = true` to apply this action to the other sources.

#### delete($id, $reflect = false): bool

`$vacancyRepository->delete($id);`

> Use `$reflect = true` to apply this action to the other sources.

## Testing

`composer exec phpunit test`

## About The Author

- <a href="https://github.com/yigitgenc" target="_blank">Github</a>
- <a href="https://linkedin.com/in/yigitgenc" target="_blank">LinkedIn</a>
- <a href="https://twitter.com/yigidix" target="_blank">Twitter</a>
- <a href="https://facebook.com/yigidix" target="_blank">Facebook</a>