<?php

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;
use Config\Database;
use App\Repositories\VacancyRepository;
use App\Models\Vacancy;

/**
 * Class VacancyRepositoryTest
 */
class VacancyRepositoryTest extends TestCase
{
    /**
     * @var Capsule $capsule
     */
    private $capsule;

    /**
     * @var VacancyRepository $instance
     */
    private $instance;

    /**
     * Example data.
     *
     * @var array $data
     */
    private $data = [
        "title" => "Example Vacancy",
        "content" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
        "description" => "This is a description."
    ];

    /**
     * Setup test database for testing.
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->capsule = new Capsule;
        $this->capsule->bootEloquent();
        $this->capsule->addConnection(Database::getConfig('test'));
    }

    /**
     * Test save method.
     *
     */
    public function testSave()
    {
        $stub = $this->createMock(VacancyRepository::class);

        $stub->expects($this->any())
            ->method('save')
            ->with($this->isType('object'))
            ->willReturn(true);

        $vacancy = new Vacancy($this->data);
        $vacancyRepository = new VacancyRepository();

        $this->assertEquals(
            $vacancyRepository->save($vacancy),
            $stub->save($vacancy)
        );

        $vacancy->title = 'Great Vacancy';
        $vacancy->description = 'Great vacancy description';
        $vacancy->content = 'Foo bar baz';

        $this->assertEquals(
            $vacancyRepository->save($vacancy),
            $stub->save($vacancy)
        );
    }

    /**
     * Test insert method.
     *
     */
    public function testInsert()
    {
        $stub = $this->createMock(VacancyRepository::class);
        $vacancy = new Vacancy();

        $stub->expects($this->once())
            ->method('insert')
            ->with($this->isType('array'))
            ->willReturn(true);

        $this->assertEquals(
            $vacancy->insert($this->data),
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

        $stub = $this->createMock(VacancyRepository::class);
        $vacancy = new Vacancy();
        $vacancyRepository = new VacancyRepository();

        $stub->expects($this->once())
            ->method('insert')
            ->with($this->isType('array'))
            ->willReturn(true);


        $vacancy->setConnection($dataSource);
        $vacancyRepository->addSource($dataSource);

        $this->assertContains($dataSource, $vacancyRepository->getSources());

        $this->assertEquals(
            $vacancy->insert($this->data),
            $stub->insert($this->data)
        );
    }

    /**
     * Test all method.
     *
     */
    public function testAll()
    {
        $stub = $this->createMock(VacancyRepository::class);
        $vacancy = new Vacancy();

        $stub->expects($this->any())
            ->method('all')
            ->with($this->isType('array'))
            ->willReturn($vacancy->all());

        $this->assertEquals(
            $vacancy->all(),
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
        $stub = $this->createMock(VacancyRepository::class);
        $vacancy = new Vacancy();

        $stub->expects($this->once())
            ->method('find')
            ->with($this->isType('integer'), $this->isType('array'))
            ->willReturn($vacancy->find(1));

        $this->assertEquals(
            $vacancy->find(1),
            $stub->find(1)
        );
    }

    /**
     * Test findBy method.
     *
     */
    public function testFindBy()
    {
        $stub = $this->createMock(VacancyRepository::class);
        $vacancy = new Vacancy();

        $stub->expects($this->once())
            ->method('findBy')
            ->with(
                $this->isType('string'),
                $this->isType('string'),
                $this->isType('array')
            )->willReturn(
                $vacancy->newQuery()
                    ->where('title', $this->data['title'])
                    ->get()
            );

        $this->assertEquals(
            $vacancy->newQuery()->where('title', $this->data['title'])->get(),
            $stub->findBy('title', $this->data['title'])
        );
    }

    /**
     * Test paginate method.
     */
    public function testPaginate()
    {
        $stub = $this->createMock(VacancyRepository::class);
        $vacancy = new Vacancy();

        $stub->expects($this->once())
            ->method('paginate')
            ->with($this->isType('integer'), $this->isType('array'))
            ->willReturn($vacancy->newQuery()->paginate(20, ['title', 'description']));

        $this->assertEquals(
            $vacancy->newQuery()->paginate(20, ['title', 'description']),
            $stub->paginate(20, ['title', 'description'])
        );
    }

    /**
     * Test update method.
     */
    public function testUpdate()
    {
        $stub = $this->createMock(VacancyRepository::class);
        $vacancy = new Vacancy();

        $stub->expects($this->once())
            ->method('update')
            ->with($this->isType('array'), $this->isType('integer'))
            ->willReturn(true);

        $this->assertEquals(
            $vacancy->newQuery()->find(1)->update(['title' => 'Another Awesome Vacancy']),
            $stub->update(['title' => 'Another Awesome Vacancy'], 1)
        );
    }

    /**
     * Test searchInContent method.
     */
    public function testSearchInContent()
    {
        $string = "baz";

        $stub = $this->createMock(VacancyRepository::class);
        $vacancy = new Vacancy();
        $result = $vacancy->newQuery()
            ->where('content', 'like', "%{$string}%")
            ->get();

        $stub->expects($this->once())
            ->method('searchInContent')
            ->with($this->isType('string'))
            ->willReturn($result);

        $this->assertEquals(
            $result,
            $stub->searchInContent($string)
        );
    }
}