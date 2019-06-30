<?php

namespace App\Console\Commands;

use App\Services\FetchCurrency;
use Illuminate\Console\Command;

class FetchExchange extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'exchange:fetch {--date=}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Загрузка и хранение курсов валют.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle(FetchCurrency $exchange) {
		$exchange->fetch($this->option('date'));
		$this->info('Exchage rates fetched and stored to db successfully!');
	}
}
