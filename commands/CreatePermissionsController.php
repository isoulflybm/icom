<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

use app\models\Permission;

class CreatePermissionsController extends Controller
{
    private $permissions = [
        'admin_menu' => 'Администрирование',
    ];
    
    public function actionIndex()
    {
        Permission::deleteAll();
        foreach($this->permissions as $key => $value) {
            $permission = new Permission();
            $permission->key = $key;
            $permission->value = $value;
            $permission->save(false);
        }
        
        return ExitCode::OK;
    }

}
