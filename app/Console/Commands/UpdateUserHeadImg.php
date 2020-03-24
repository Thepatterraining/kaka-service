<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\User\UserData;

class UpdateUserHeadImg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:updateUser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle()
    {
        $userData = new UserData();
        $users = $userData->getUsers();
        foreach ($users as $user) {
            if (empty($user->user_idno)) {
                $user->user_headimgurl = '/upload/touxiang/tianping.jpg';
            } else {
                $user->user_headimgurl = $userData->getUserConstellationHeadImg($user->user_idno);
            }
            $userData->save($user);
        }
        $this->alert('执行成功');
    }
}
