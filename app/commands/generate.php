<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Chores\Generator;

class generate extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'chores:generate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Activates all generators for all households.';

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
		$this->info('Generating...');

		
		$generators = Generator::where('active', true)->get();
		foreach($generators as $gen)
		{
			$this->info('Generating '.$gen->household->name);
			$gen->generate();
		}

		$this->info('Generating Done');
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
