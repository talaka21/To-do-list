<?php
namespace Tests\Unit;

use Tests\TestCase; 
use App\Services\TaskService;
use Carbon\Carbon;
use ReflectionClass;

class TaskParserTest extends TestCase
{

    protected function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }

    public function test_it_sets_high_priority_for_urgent_keywords()
    {
        $service = new TaskService();

        $result = $this->invokeMethod($service, 'parseTaskTitle', ['اشتري خبز بسرعة']);

        $this->assertEquals('high', $result['priority']);
        $this->assertEquals('اشتري خبز', $result['clean_title']);
    }

    public function test_it_parses_due_date_correctly()
    {
        $service = new TaskService();
        $result = $this->invokeMethod($service, 'parseTaskTitle', ['Meeting tomorrow']);

        $this->assertNotNull($result['due_date']);

        $this->assertEquals(Carbon::parse('tomorrow')->startOfHour()->toDateTimeString(), $result['due_date']->toDateTimeString());
    }
}
