<?php

namespace app\controllers;

use app\models\print_invent;
use app\models\printers;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;

class InvController extends Controller
{


    public function behaviors()
    {
        return [
            'access' => [ //Определение уровня доступа к action
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [ // Список правил
                    [
                        'allow' => true, // Разрешено
                        'roles' => ['@'], //Для авторизованных
                    ],
                ],
            ],
        ];
    }

    //Страница добавления пользователя [url = users/add]
    public function actionAdd()
    {

        $model = new print_invent(); // Создаём модель пользователя
        $model->setScenario('register'); // Указываем сценарий обработки данных
        $data = Yii::$app->request->post();
        // Сохраняем данные переденные чере POST в переменную
        if ($model->load($data)) { // Загружаем в модель данные
            if ($model->save()) { // Сохранение модели в БД
                //return $this->redirect(['/inv/add']);
                return $this->redirect(['/printer/index']);// Переадресация пользователя на страницу index
            }
        }
        return $this->render('add', ['model' => $model]); // Отображение страницы добавления пользователя

    }

    //Удаление пользователя [url = users/delete]
    public function actionDelete($id)
    {
        $model = print_invent::findOne(['id' => $id]); // Поиск модели пользователя по полю id
        if (!$model) { // Проверка существования пользователя
            throw new HttpException('404', 'Объект не найден'); // Выбрасываем ошибку
        }
        $model->delete(); // Удаляем модель из БД
        //return $this->redirect(Yii::$app->request->getReferrer());
        return $this->render('update', ['model' => $model]); // Переадресовываем пользователя на страницу с который был запрос
    }

    //Редактирование пользователя [url = users/update]
    public function actionUpdate($id)
    {
        $model = print_invent::findOne(['id' => $id]); // Поиск модели пользователя в БД по полю id
        $model->Invent = ''; // Очищаем свойство которое хранит пароль что бы не отображать его в форме
        if (!$model) { // Проверка существования пользователя
            throw new HttpException('404', 'Объект не найден');
        }
        $data = Yii::$app->request->post(); // Сохраняем данные переденные чере POST в переменную
        if ($model->load($data)) { // Загружаем в модель данные
            if ($model->save()) { // Сохранение модели в БД
                return $this->redirect(['/printer/index']); // Переадресация пользователя на страницу index
            };
        }
        return $this->render('update', ['model' => $model]); // Отображение страницы редактирования пользователя
    }

    //Страница списка пользователей [url = users/index]
    public function actionIndex()
    {

        $model = new print_invent(); // Создаём модель пользователя
        $data = \Yii::$app->request->get(); // получаем из запроса GET данные
        $model->load($data);
        //return $this->render('/printer/index');
       return $this->render('/inv/index', ['model' => $model]);
        //return $this->redirect(Yii::$app->request->getReferrer());

    }


}