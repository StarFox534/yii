<?php

namespace app\controllers;

use app\models\print_invent;
use app\models\print_prod;
use app\models\printers;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;

class PrinterController extends Controller
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

        $model = new printers(); // Создаём модель пользователя
        $model->setScenario('register'); // Указываем сценарий обработки данных
        $data = Yii::$app->request->post();
        // Сохраняем данные переденные чере POST в переменную
        if ($model->load($data)) { // Загружаем в модель данные
            if ($model->save()) { // Сохранение модели в БД
                return $this->redirect(['/printer/add']); // Переадресация пользователя на страницу index
            }
        }
        return $this->render('add', ['model' => $model]); // Отображение страницы добавления пользователя

    }

    //Удаление пользователя [url = users/delete]
    public function actionDelete($id)
    {
        $model = printers::findOne(['id' => $id]); // Поиск модели пользователя по полю id
        if(!$model){ // Проверка существования пользователя
            throw new HttpException('404','Объект не найден'); // Выбрасываем ошибку
        }
        $model->delete(); // Удаляем модель из БД
        return $this->redirect(['/printer/index']);
    }
    public function actionDeleteInv($id)
    {
        $model1 = print_invent::findOne(['id' => $id]); // Поиск модели пользователя по полю id
        if(!$model1){ // Проверка существования пользователя
            throw new HttpException('404','Объект не найден'); // Выбрасываем ошибку
        }
        $model1->delete(); // Удаляем модель из БД
        return $this->redirect(\Yii::$app->request->getReferrer()); // Переадресовываем пользователя на страницу с который был запрос
    }


    //Редактирование пользователя [url = users/update]
    public function actionUpdate($id)
    {
        $model = printers::findOne(['id' => $id]); // Поиск модели пользователя в БД по полю id
        $model->ModelName = ''; // Очищаем свойство которое хранит пароль что бы не отображать его в форме
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


        $model = new printers(); // Создаём модель пользователя
        $data = Yii::$app->request->get(); // получаем из запроса GET данные
        $model->load($data); // Загружаем в модель данные из запроса

        $model1 = new print_invent(); // Создаём модель пользователя
        $data1 = \Yii::$app->request->get(); // получаем из запроса GET данные
        $model1->load($data1);

        $model2 = new print_prod(); // Создаём модель пользователя
        $data2 = \Yii::$app->request->get(); // получаем из запроса GET данные
        $model2->load($data2);
        //return $this->render('/printer/index');
       return $this->render('/printer/index', ['model' => $model,'model1' => $model1,'model2' => $model2,]);
        //return $this->redirect(Yii::$app->request->getReferrer());
    }
}