<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //使用 Gate::guessPolicyNamesUsing 方法来自定义策略文件的寻找逻辑
        Gate::guessPolicyNamesUsing(function ($clss)
        {
           // class_name 是Laravel提供的辅助函数，可以获取类的简短名称
            // 例如 传入 \app\models\user 会返回user
            return '\\App\\Policies\\'.class_basename($class).'Policy';
        });
    }
}
