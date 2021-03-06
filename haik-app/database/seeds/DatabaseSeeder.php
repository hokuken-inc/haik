<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('HaikUsersTableSeeder');
		$this->call('HaikPagesTableSeeder');
		$this->call('HaikPageMetaFragmentsTableSeeder');
		$this->call('HaikConfigFragmentsTableSeeder');
	}

}
