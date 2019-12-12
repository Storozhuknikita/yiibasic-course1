<?php


namespace app\commands;


use app\models\User;
use yii\console\Controller;

class RbacController extends Controller
{

    /**
     * php yii rbac/init
     * @throws \Exception
     * Role: Admin,
     */
    public function actionInit(){

        $role = \Yii::$app->authManager->createRole('admin');
        $role->description = 'Администратор';
        \Yii::$app->authManager->add($role);

        $role = \Yii::$app->authManager->createRole('simple');
        $role->description = 'Простой, очень простой пользователь';
        \Yii::$app->authManager->add($role);

        $permisson = \Yii::$app->authManager->createPermission('getMyActivity');
        \Yii::$app->authManager->add($permisson);

    }

    /**
     * Добавление админа
     */
    public function actionAddAdmin() {
        $user = User::find()->where(['username' => 'admin'])->one();

        if (empty($user)) {
            $user = new User();
            $user->username = 'admin';
            $user->email = 'admin@admin.ru';
            $user->setPassword('admin');
            $user->generateAuthKey();

            if ($user->save()) {
                echo 'good';
            }
        }

        $adminRole = \Yii::$app->authManager->getRole('admin');
        \Yii::$app->authManager->assign($adminRole, $user->id);
    }


    /**
     * @param $username
     * @throws \Exception
     * Изменение роли
     */
    public function actionSetAdminRoleToUser($username){
        $user = User::findByUsername($username);
        if(!Yii::$app->user->can('admin')){
            $adminRole = \Yii::$app->authManager->getRole('admin');
            \Yii::$app->authManager->assign($adminRole, $user->id);
        }

    }

}