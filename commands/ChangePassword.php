<?php

namespace App\Modules\Admin\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use App\Modules\User\Models\User;

use Hash;

class ChangePassword extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'admin:changepassword';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change password of user';

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
        $email = $this->ask('What the user email?');
        $user = User::where('email', '=', $email)->firstOrFail();
        $password = $this->ask('What the new password?');
        $user->password = Hash::make($password);
        $user->save();
        $this->info('Ok, password changed');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            //array('example', InputArgument::REQUIRED, 'An example argument.'),
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
            //array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
        );
    }

}
