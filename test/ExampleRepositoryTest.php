<?php

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;
use Config\Database;
use App\Repositories\ExampleRepository;
use App\Models\Example;

/**
 * Class ExampleRepositoryTest
 */
class ExampleRepositoryTest extends TestCase
{
    /**
     * @var Capsule $capsule
     */
    private $capsule;

    /**
     * @var ExampleRepository $instance
     */
    private $instance;

    /**
     * Example data.
     *
     * @var array $data
     */
    private $data = [
        "title" => "Example",
        "content" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
        "description" => "This is a description."
    ];

    /**
     * Setup test database and data source for testing.
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->capsule = new Capsule;
        $this->capsule->bootEloquent();
        $this->capsule->addConnection(Database::getConfig('test'));

        $this->instance = new ExampleRepository();
        $this->instance->addSource('default')
            ->setSource('default');
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->capsule = null;
        $this->instance = null;
    }

    /**
     * Test save method.
     *
     */
    public function testSave()
    {
        $stub = $this->createMock(ExampleRepository::class);

        $example = new Example($this->data);

        $stub->expects($this->any())
            ->method('save')
            ->with($this->isType('object'))
            ->willReturn($this->instance->save($example));

        $this->assertEquals(
            $this->instance->save($example),
            $stub->save($example)
        );

        $example->title = 'Great Example';
        $example->description = 'Great Example description';
        $example->content = 'Foo bar baz';

        $this->assertEquals(
            $this->instance->save($example),
            $stub->save($example)
        );
    }

    /**
     * Test insert method.
     *
     */
    public function testInsert()
    {
        $stub = $this->createMock(ExampleRepository::class);
        $example = new Example();

        $stub->expects($this->once())
            ->method('insert')
            ->with($this->isType('array'))
            ->willReturn(true);

        $this->assertEquals(
            $example->insert($this->data),
            $stub->insert($this->data)
        );
    }

    /**
     * Test insert method with another data source.
     * For example: booking.com as `booking`
     *
     */
    public function testInsertWithAnotherDataSource()
    {
        $dataSource = 'booking';

        $this->capsule->addConnection(Database::getConfig($dataSource), $dataSource);

        $stub = $this->createMock(ExampleRepository::class);
        $example = new Example();

        $stub->expects($this->once())
            ->method('insert')
            ->with($this->isType('array'))
            ->willReturn(true);


        $example->setConnection($dataSource);
        $this->instance->addSource($dataSource);

        $this->assertContains($dataSource, $this->instance->getSources());

        $this->assertEquals(
            $example->insert($this->data),
            $stub->insert($this->data)
        );
    }

    /**
     * Test all method.
     *
     */
    public function testAll()
    {
        $stub = $this->createMock(ExampleRepository::class);
        $example = new Example();

        $stub->expects($this->any())
            ->method('all')
            ->with($this->isType('array'))
            ->willReturn($example->all());

        $this->assertEquals(
            $example->all(),
            $stub->all()
        );

        $this->assertObjectHasAttribute('items', $stub->all());
    }

    /**
     * Test find method.
     *
     */
    public function testFind()
    {
        $stub = $this->createMock(ExampleRepository::class);
        $example = new Example();

        $stub->expects($this->once())
            ->method('find')
            ->with($this->isType('integer'), $this->isType('array'))
            ->willReturn($example->find(1));

        $this->assertEquals(
            $example->find(1),
            $stub->find(1)
        );
    }

    /**
     * Test findBy method.
     *
     */
    public function testFindBy()
    {
        $stub = $this->createMock(ExampleRepository::class);
        $example = (new Example())->newQuery()
            ->where('title', $this->data['title'])
            ->get();

        $stub->expects($this->once())
            ->method('findBy')
            ->with(
                $this->isType('string'),
                $this->isType('string'),
                $this->isType('array')
            )->willReturn($example);

        $this->assertEquals(
            $example,
            $stub->findBy('title', $this->data['title'])
        );
    }

    /**
     * Test paginate method.
     */
    public function testPaginate()
    {
        $stub = $this->createMock(ExampleRepository::class);
        $example = new Example();

        $stub->expects($this->once())
            ->method('paginate')
            ->with($this->isType('integer'), $this->isType('array'))
            ->willReturn($example->newQuery()->paginate(20, ['title', 'description']));

        $this->assertEquals(
            $example->newQuery()->paginate(20, ['title', 'description']),
            $stub->paginate(20, ['title', 'description'])
        );
    }

    /**
     * Test update method.
     */
    public function testUpdate()
    {
        $stub = $this->createMock(ExampleRepository::class);
        $example = (new Example())->newQuery()
            ->find(1)
            ->update(['title' => 'Another Awesome Example']);

        $stub->expects($this->once())
            ->method('update')
            ->with($this->isType('array'), $this->isType('integer'))
            ->willReturn(true);

        $this->assertEquals(
            $example,
            $stub->update(['title' => 'Another Awesome Example'], 1)
        );
    }

    /**
     * Test searchInContent method.
     */
    public function testSearchInContent()
    {
        $string = "baz";

        $stub = $this->createMock(ExampleRepository::class);
        $example = (new Example())->newQuery()
            ->where('content', 'like', "%{$string}%")
            ->get();;

        $stub->expects($this->once())
            ->method('searchInContent')
            ->with($this->isType('string'))
            ->willReturn($example);

        $this->assertEquals(
            $example,
            $stub->searchInContent($string)
        );
    }
}