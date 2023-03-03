<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Bouncer;

class CreateRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $admin = Bouncer::role()->firstOrCreate([
            'name' => 'admin',
            'title' => 'ادمن',
        ]);
        $benificary = Bouncer::role()->firstOrCreate([
            'name' => 'benificary',
            'title' => 'راعي',
        ]);
        $doctor = Bouncer::role()->firstOrCreate([
            'name' => 'doctor',
            'title' => 'دكتور',
        ]);
        $guide = Bouncer::role()->firstOrCreate([
            'name' => 'guide',
            'title' => 'مرشد',
        ]);
        $manager = Bouncer::role()->firstOrCreate([
            'name' => 'manager',
            'title' => 'مدير',
        ]);
        return Command::SUCCESS;
    }
}
