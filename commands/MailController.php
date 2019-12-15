<?php


namespace app\commands;


use app\models\Activity;
use yii\console\Controller;

class MailController extends Controller
{

    public $message;

    // php yii mail 'arg' -m='hello'
    public function actionIndex($arg){
        echo $arg.PHP_EOL;
        echo $this->message.PHP_EOL;
    }

    // php yii mail --message='hello'
    public function options($actionId){
        return ['message']; //
    }

    // php yii mail -m='hello'
    public function optionAliases(){
        return ['m' => 'message']; //
    }

    /**
     * @param $email
     * php yii mail/send-out hello@geekbrains.ru
     */
    public function actionSendOut($email = null){

        $activitiesQuery = Activity::find();
        if(!is_null($email)){
            $activitiesQuery->joinWith('users')->where(['user.email' => $email]);
        }

        foreach($activitiesQuery->each() as $activity){

            foreach($activity->users as $user){

                $mailSend = \Yii::$app->mailer
                    ->compose('activity/notification-html', ['activity' => $activity])
                    ->setFrom('noreply@localhost.yiibasic-course1')
                    ->setSubject('Первое письмо')
                    ->setTo($user->email)
                    ->setCharset('UTF-8')
                    ->send();

                if($mailSend === true){
                    echo "Сообщение на email $user->email отправлено {$activity->title}".PHP_EOL;
                }

            }


        }

    }

}