<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\User\UserData;
use App\Data\API\AliAPI\API;

class UpdateUserMobileIdnoInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:updateuserinfo';

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
        $data = new UserData;
        $model = $data->newitem();

        $model->chunk(
            100, function ($users) {
                $data = new UserData;
                foreach ($users as $user) {
                    if (!empty($user->user_mobile)) {
                        $mobileInfo = API::QueryMobileInfo($user->user_mobile);
                        if (!empty($mobileInfo) && is_object($mobileInfo)) {
                            $user->mobile_province = $mobileInfo->province;
                            $user->mobile_city = $mobileInfo->city;;
                            $user->mobile_company = $mobileInfo->company;;
                            $user->mobile_cardtype = $mobileInfo->cardtype;;
                        }
                    }

                    if (!empty($user->user_idno)) {
                        $idnoInfo = API::QueryIDInfo($user->user_idno);
                        if (!empty($idnoInfo) && is_object($idnoInfo)) {
                            $user->id_province = $idnoInfo->province;
                            $user->id_city = $idnoInfo->city;
                            $user->id_town = $idnoInfo->town;
                            $user->id_area = $idnoInfo->area;
                            $user->user_sex = $idnoInfo->sex;
                            $user->id_birth = $data->strToDate($idnoInfo->birth);
                        }
                    }

                    $user->save();
                
                    $this->info($user->id);
                }
            }
        );
        $this->info('ok');
    }
}
