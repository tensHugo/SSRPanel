<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('username', 128)->comment('用户名');
            $table->string('password', 64)->comment('密码');
            $table->integer('port')->default('0')->comment('SS端口');
            $table->string('passwd', 16)->comment('SS密码');
            $table->bigInteger('transfer_enable')->default('1073741824000')->comment('可用流量，单位字节，默认1TiB');
            $table->bigInteger('u')->default('0')->comment('已上传流量，单位字节');
            $table->bigInteger('d')->default('0')->comment('已下载流量，单位字节');
            $table->integer('t')->default('0')->comment('最后使用时间');
            $table->tinyInteger('enable')->default('1')->comment('SS状态');
            $table->string('method', 30)->default('aes-192-ctr')->comment('加密方式')->nullable();
            $table->string('custom_method', 30)->default('aes-192-ctr')->comment('自定义加密方式');
            $table->string('protocol', 30)->default('auth_chain_a')->comment('协议');
            $table->string('protocol_param', 255)->comment('协议参数')->nullable();
            $table->string('obfs', 30)->default('tls1.2_ticket_auth')->comment('混淆');
            $table->string('obfs_param', 255)->comment('混淆参数')->nullable();
            $table->integer('speed_limit_per_con')->default('204800')->comment('单连接限速，默认200M，单位KB');
            $table->integer('speed_limit_per_user')->default('204800')->comment('单用户限速，默认200M，单位KB');
            $table->tinyInteger('gender')->default('1')->comment('性别：0-女、1-男');
            $table->string('wechat', 30)->comment('微信')->nullable();
            $table->string('qq', 20)->comment('QQ')->nullable();
            $table->tinyInteger('usage')->default('1')->comment('用途：1-手机、2-电脑、3-路由器、4-其他');
            $table->tinyInteger('pay_way')->default('3')->comment('付费方式：0-免费、1-月付、2-半年付、3-年付');
            $table->decimal('balance', 10, 2)->default('0.00')->comment('余额');
            $table->integer('score')->default('0')->comment('积分');
            $table->dateTime('enable_time')->comment('开通日期')->nullable();
            $table->dateTime('expire_time')->default('2099-01-01')->comment('过期时间')->nullable();
            $table->integer('ban_time')->default('0')->comment('封禁到期时间');
            $table->text('remark')->comment('备注');
            $table->tinyInteger('level')->default('1')->comment('等级');
            $table->tinyInteger('is_admin')->default('0')->comment('是否管理员：0-否、1-是');
            $table->string('reg_ip', 20)->default('127.0.0.1')->comment('注册IP');
            $table->integer('last_login')->default('0')->comment('最后一次登录时间');
            $table->integer('referral_uid')->default('0')->comment('邀请人');
            $table->tinyInteger('traffic_reset_day')->default('0')->comment('流量自动重置日，0表示不重置');
            $table->tinyInteger('status')->default('0')->comment('状态：-1-禁用、0-未激活、1-正常');
            $table->string('remember_token', 255)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->unique('port');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
