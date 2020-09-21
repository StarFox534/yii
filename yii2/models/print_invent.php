<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\web\IdentityInterface;

/**
 * This is the prods class for table "room".
 *
 * @property integer $id
 * @property string $Invent
 */
//Модель пользователя, а так же модель для авторизации
class print_invent extends ActiveRecord //implements IdentityInterface
{

    public $old_Invent;// добавили поле для сохранения старого пароля пользователя

    /**
     * {@inheritdoc}
     */
    //метод возвращает имя таблицы к которой обращается модель
    public static function tableName()
    {
        return 'print_invent';

    }

    /**
     * {@inheritdoc}
     */
    //Правила валидации данных модели
    public function rules()
    {
        return [
            //[['id'], 'integer'=> ['register']],
            [['Invent'],'required', 'on' => ['register']], //Обязательные поля
            //[['Kolvo', ], 'integer', 'max' => 11], //Указанные поля должны быть строкой не более 255 символов длинной

        ];

    }
    /**
     * {@inheritdoc}
     */
    //описание атрибутов модели
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Invent' => 'Инвентарный номер',
            //'ModelName' => 'Модель Принтера',
            //'Kolvo' =>'Количество'
        ];
    }
    //Метод выполняется перед сохранением модели в бд
    public function beforeSave($insert)
    {
        if($this->Invent != ''){ // проверяем пустой ли пароль введён пользователем
            //если не пустой то делаем ХЭШ пароля и сохраняем его в поле

        }else{
            //Если пустой то сохраняем старое значение пароля
            $this->Invent = $this->old_Invent;
        }
        return parent::beforeSave($insert);
    }

    //Метод выполняется после того как будет выполнен find модели
    //Т.е. как пример User::find или User::findOne
    public function afterFind()
    {
        //Сохраняем полученный пароль из бд как старый
        $this->old_Invent = $this->Invent;
        parent::afterFind();
    }

    //Метод который выполняется каждый раз при заходе авторизованного пользователя
    public static function findIdentity($id) {
        //ищем пользователя по полю id и возвращаем его модель
        return print_invent::find()->where(['id' => $id])->one();
    }

    //Метод нужен для получения id авторизованного пользователя
    public function getId(){
        return $this->id;
    }

    //Метод проверки пароля



    //Поиск и фильтрация пользователей
    public function search()
    {
        /**
         * @var $query Query;
         */
        //Создаём запрос на поиск всех пользователей, по логину или по имени
        $query = print_invent::find()
            ->andFilterWhere(["like", 'Invent', $this->Invent]);
        // WHERE login like '%$login%'


        //Создаём поставщика данных, в котором указывам запрос
        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);
        //Возвращаем поставщика данных
        return $provider;




    }

    public static function findIdentityByAccessToken($token, $type = null){

    }

    public function getAuthKey(){

    }

    public function validateAuthKey($authKey){

    }

}