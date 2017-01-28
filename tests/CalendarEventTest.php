<?php

class CalendarEventTest extends TestCase
{
	private $model;
	private $id;
	private $userId;
	private $projectId;
	/**
	 * @var \DateTime
	 */
	private $start;
	/**
	 * @var \DateTime
	 */
	private $end;

	public function setUp()
	{
		parent::setUp();
		$this->model = TeamWorkPm\Factory::build('CalendarEvent');
		$this->projectId = get_first_project_id();
		$this->userId = get_first_person_id($this->projectId);
	}

	/**
	 * @dataProvider provider
	 * @test
	 */
	public function insert($data)
	{
		try {
			/**
			 * @var \TeamWorkPm\CalendarEvent $event
			 */
			$event = \TeamWorkPm\Factory::build('CalendarEvent');
			$this->id = $event->insert($data);
		} catch (Exception $e) {
			$this->fail($e->getTraceAsString());
		}
	}

	/**
	 * @dataProvider provider
	 * @test
	 */
	public function update($data)
	{
	}

	/**
	 *
	 * @test
	 */
	public function get()
	{
	}

	/**
	 *
	 * @test
	 */
	public function getCalendarEvents()
	{
		/**
		 * @var \TeamWorkPm\CalendarEvent $event
		 */
		$event = \TeamWorkPm\Factory::build('CalendarEvent');
		/**
		 * @var \TeamWorkPm\Response\JSON $events
		 */
		$events = $event->getCalendarEvents(new DateTime('1900-01-01T00:00:00'), $this->getEnd());
		$this->assertGreaterThan(0, $events->count());
	}

	public function provider()
	{
		return [
			[
				[
					'start' => $this->getStart()->format('Y-m-d\TH:i:s'),
					'end' => $this->getEnd()->format('Y-m-d\TH:i:s'),
					'all-day' => 'false',
					'description' => 'Description',
					'where' => 'Where',
					'privacy' => array('type' => 'personal', 'project-id' => $this->projectId),
					'show-as-busy' => 'true',
					'attending-user-ids' => $this->userId,
					'notify-user-ids' => $this->userId,
					'notify' => 'false',
					'attendees-can-edit' => 'true',
					'project-users-can-edit' => 'true',
					'reminders' => [],
					'title' => 'Title'
				]
			]
		];
	}

	/**
	 * @return DateTime
	 */
	private function getStart()
	{
		if (null == $this->start) {
			$this->start = new DateTime();
			$this->start->add(new DateInterval('P1D'));
		}
		return $this->start;
	}

	/**
	 * @return DateTime
	 */
	private function getEnd()
	{
		if (null == $this->end) {
			$this->end = new DateTime();
			$this->end->add(new DateInterval('P1D'));
			$this->end->add(new DateInterval('PT2H'));
		}
		return $this->end;
	}
}