<?php
/**
 * Created by PhpStorm.
 * User: m.fellinger
 * Date: 21.01.2017
 * Time: 16:47
 */

namespace TeamWorkPm;

class CalendarEvent extends Model
{
	public function get($id, $get_time = false)
	{
		$id = (int)$id;
		if ($id <= 0) {
			throw new Exception('Invalid param id');
		}
		$params = [];
		if ($get_time) {
			$params['getTime'] = (int)$get_time;
		}
		return $this->rest->get("$this->action/$id", $params);
	}

	/**
	 * Retrieve all calendar events between two dates
	 *
	 * GET /calendarevents.json?startDate={startdate}&endDate={endDate}
	 *
	 * @param \DateTimeInterface $startDate
	 * @param \DateTimeInterface $endDate
	 *
	 * @return \TeamWorkPm\Response\Model
	 * @throws Exception
	 */
	public function getCalendarEvents(\DateTimeInterface $startdate, \DateTimeInterface $enddate)
	{
		if (null == $startdate) {
			throw new Exception('Invalid param startdate');
		}
		if (null == $enddate) {
			throw new Exception('Invalid param enddate');
		}
		$params = [
			'startdate' => $startdate->format('Ymd'),
			'enddate' => $enddate->format('Ymd')
		];
		return $this->rest->get("$this->action", $params);
	}

	/**
	 * Create Item on a List
	 *
	 * POST /calendarevents.json
	 *
	 * For the submitted list, creates a todo item. It will be added to the end of the list,
	 * and marked as uncomplete by default. If you give a persons id as the responsible-party-id value,
	 * they will be responsible for same, you can also use the “notify” key to indicate whether an email
	 * should be sent to that person to tell them about the assignment.
	 * Multiple people can be assigned by passing a comma delimited list for responsible-party-id.
	 *
	 * @param array $data
	 * @return int
	 */
	public function insert(array $data)
	{
		return $this->rest->post("$this->action", $data);
	}

	protected function init()
	{
		$this->fields = [
			'where' => false,
			'project-users-can-edit' => true,
			'description' => false,
			'attending-user-ids' => false,
			'notify-user-names' => false,
			'attending-user-names' => false,
			'status' => false,
			'owner' => false,
			'reminders' => false,
			'notify-user-ids' => false,
			'start' => [
				'required' => true,
				'attributes' => [
					'type' => 'string'
				]
			],
			'repeat' => false,
			'all-day' => false,
			'id' => false,
			'end' => [
				'required' => false,
				'attributes' => [
					'type' => 'string'
				]
			],
			'show-as-busy' => false,
			'last-changed-on' => false,
			'privacy' => false,
			'attendees-can-edit' => false,
			'type' => false,
			'title' => false
		];
		$this->parent = 'event';
	}

}