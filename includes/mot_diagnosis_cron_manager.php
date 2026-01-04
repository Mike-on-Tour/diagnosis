<?php
/**
*
* @package MoT phpBB Diagnosis v0.0.1
* @copyright (c) 2025 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\diagnosis\includes;

class mot_diagnosis_cron_manager extends \phpbb\cron\manager
{
	/**
	* Array holding the names of all tasks that have been found.
	*
	* @var array
	*/
	protected $task_names = [];

	/**
	* Array holding the classes including path of all tasks that have been found.
	*
	* @var array
	*/
	protected $task_classes = [];

	public function __construct(protected $phpbb_container, protected $routing_helper, protected $phpbb_root_path, protected $php_ext, protected $template)
	{
		parent::__construct($this->phpbb_container, $this->routing_helper, $this->phpbb_root_path, $this->php_ext, $this->template);
	}

	public function load_task_names()
	{
		$tasks = $this->phpbb_container->get('cron.task_collection');
		foreach ($tasks as $task)
		{
			$this->task_names[] = $task->get_name();
		}
	}

	public function get_task_names() : array
	{
		$this->load_task_names();

		return $this->task_names;
	}

	public function load_task_classes()
	{
		$tasks = $this->phpbb_container->get('cron.task_collection');
		foreach ($tasks as $task)
		{
			$this->task_classes[] = get_class($task);
		}
	}

	public function get_task_classes() : array
	{
		$this->load_task_classes();

		return $this->task_classes;
	}

	public function check_should_run(string $name) : bool
	{
		$task = $this->find_task($name);

		return ! is_null($task) ? $task->should_run() : false;
	}

	public function check_runnable(string $name) : bool
	{
		$task = $this->find_task($name);

		return ! is_null($task) ? $task->is_runnable() : false;
	}
}
