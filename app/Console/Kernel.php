<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
 
    Commands\MakeAdapter::class,
    Commands\GenerateInviteCode::class,
    Commands\Updatesql::class,
    Commands\MinutelyJob::class,
    Commands\DailyJob::class,
    Commands\WeeklyJob::class,
    Commands\MonthlyJob::class,
    Commands\HistoryJob::class,
    Commands\HourlyJob::class,
    Commands\MonthJob::class,
    Commands\UserLedger::class,
    Commands\UserCoinLedger::class,
    Commands\Add3rdSettlement::class,
    Commands\MakeConfigEvent::class,
    Commands\SystemRunningCoinAccounts::class,
    Commands\SystemRunningAccounts::class,
    Commands\FlatRunningAccounts::class,
    Commands\UserOrder::class,
    Commands\UserDayReport::class,
    Commands\UserHourReport::class,
    Commands\UsersUseCoupons::class,
    Commands\OrderRevoke::class,
    Commands\AddVoucher::class,
    Commands\Pay2User::class,
    Commands\MinuteJob::class,
    Commands\SellRevoke::class,
    Commands\CoinJournal::class,
    Commands\AddQueue::class,
    Commands\LimitSell::class,
    Commands\LimitBuy::class,
    Commands\BuyRevoke::class,
    Commands\DisVoucher::class,
    Commands\ThirdPaymentJournalRevoke::class,
    Commands\UpdateProductName::class,
    Commands\TransUserCash::class,
    Commands\RevokeOrderVoucher::class,
    Commands\TransUserCash::class,
    Commands\UpdateUserMobileIdnoInfo::class,
    Commands\UpdateBonusSuccess::class,
    Commands\createVoucherStorage::class,
    Commands\DayJob::class,
    Commands\SysCoinRecharge::class,
    Commands\NewerProjBonus::class,
    Commands\ExecBonsPlans::class,
    Commands\TradeDayJob::class,
    Commands\NewUserBonusPlan::class,
    Commands\AddNewerProject::class,
    Commands\NewApplication::class,
    \Cybereits\Application\Command\AppRelease::class,
    Commands\ClearCoinType::class,
    ];
    
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }
    
    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        include base_path('routes/console.php');
    }
}
