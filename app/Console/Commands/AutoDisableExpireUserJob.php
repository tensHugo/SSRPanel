<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Models\User;
use Log;

class autoDisableExpireUserJob extends Command
{
    protected $signature = 'command:autoDisableExpireUserJob';
    protected $description = '自动降级到期用户';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // 到期账号降级，暂时不封SSR状态
        User::query()->where('enable', 1)->where('pay_way','<>','0')->where('expire_time', '<=', date('Y-m-d'))->update(['level' => 1,'transfer_enable' => 2048 * 1048576,'u' => 0,'d' => 0,'traffic_reset_day' => 0,'pay_way' => 0]);
        Log::info('定时任务：' . $this->description);
    }

}