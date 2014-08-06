<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class import extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'chores:import';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Imports the old chores database';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$chores = public_path().'/csv/chores.csv';
		//dd($chores);
		$result = \Helpers\Importer::Import('\Models\Chore', $chores, array('assignedDate', 'lastdone'));
		if(\Helpers\Importer::$error)
		{
			$this->error(\Helpers\Importer::$error);
			foreach($result->failure as $num => $error)
			{
				$this->error($error);
			}
		}

		$rooms = public_path().'/csv/rooms.csv';
		$result = \Helpers\Importer::Import('\Models\Room', $rooms);
		if(\Helpers\Importer::$error)
		{
			$this->error(\Helpers\Importer::$error);
			foreach($result->failure as $num => $error)
			{
				$this->error($error);
			}
		}
		
		$scores = public_path().'/csv/scores.csv';
		$result = \Helpers\Importer::Import('\Models\Score', $scores);
		if(\Helpers\Importer::$error)
		{
			$this->error(\Helpers\Importer::$error);
			foreach($result->failure as $num => $error)
			{
				$this->error($error);
			}
		}
		
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
		);
	}

}
