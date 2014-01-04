<?php
namespace Sora\DB;

class Base extends \Illuminate\Database\Capsule\Manager{
    static function registerIlluminate($settings){
        $capsule = new static();
        $capsule->addConnection($settings);
        $capsule->setEventDispatcher(
            new \Illuminate\Events\Dispatcher(
                new \Illuminate\Container\Container()
            )
        );
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    static function begin(){
        \Sora\DB\Base::connection()->getPdo()->beginTransaction();
    }
    static function commit(){
        \Sora\DB\Base::connection()->getPdo()->commit();
    }
    static function rollback(){
        \Sora\DB\Base::connection()->getPdo()->rollBack();
    }
}
