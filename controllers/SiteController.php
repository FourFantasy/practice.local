<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\models\Orders;
use app\models\Services;
use yii\data\Pagination;

class SiteController extends Controller
{
    /*
    Тестовая задача
     */
    public function actionIndex()
    {

        $page = Yii::$app->request->get("page", 1);//Get запрос номер страницы
        $orders_status = Yii::$app->request->get("orders_status");//Get запрос статус
        $orders_mode = Yii::$app->request->get("orders_mode");//Get запрос mode
        $orders_service_id = Yii::$app->request->get("orders_service_id");//Get запрос service_id

        $search = Yii::$app->request->get("search");//Get запрос поиск
        $search_type = Yii::$app->request->get("search_type");//Get запрос тип поиска
        $search_status = ['id', 'link', 'user'];//массив для поиска
        foreach ($search_status as $search_key => $search_one)//Работа с поиском по категориям
        {
            if($search_key == $search_type)
            {
                $search_filter = $search_one;
            }
        }


        $services = services::find()->all(); // таблица services

        $orders = orders::find()
            ->where(['LIKE', 'status', "$orders_status"])//Выборка статуса запрос статус
            ->andWhere(['LIKE', 'mode', "$orders_mode"])//Выборка статуса запрос mode
            ->andWhere(['LIKE', "$search_filter", "$search"])//Выборка статуса запрос поиск
            ->orderBy(['id' => SORT_DESC]);//сортировка по убыванию

        if($orders_service_id) {//Выборка статуса запрос service
            $orders = orders::find()
            ->where(['LIKE', 'status', "$orders_status"])//Выборка статуса запрос статус
            ->andWhere(['LIKE BINARY', 'service_id', "$orders_service_id"])//Выборка статуса запрос service
            ->andWhere(['LIKE', 'mode', "$orders_mode"])//Выборка статуса запрос mode
            ->andWhere(['LIKE', "$search_filter", "$search"])//Выборка статуса запрос поиск
            ->orderBy(['id' => SORT_DESC]);//сортировка по убыванию
        }

        foreach ($services as $servic) {//Количество записей по категориям раздел service
            $orders_count_service[$servic->id] = orders::find()->where(['LIKE', 'status', "$orders_status"])->andWhere(['LIKE BINARY', 'service_id', "$servic->id"])->count();
         }

        $pages = 100;//Количество страниц
        $pagination = new Pagination( //Пагинация записей
            [
                'defaultPageSize'=> "$pages",
                'totalCount' => $allpages=$orders->count()
            ]
        );
        $orders = $orders //Для пагинации
        ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();


        $status = ['Pending', 'In progress', 'Completed', 'Canceled', 'Fail'];//массив со статусами
        $mode= ['Manual', 'Auto'];//массив с модами




        return $this->render
        (
            'index',
            [
                'orders_count_service' => $orders_count_service,//Количество записей по категориям раздел service
                'pages' => $pages,//количество выводимых страниц
                'allpages' => $allpages, //всего страниц
                'page' => $page, //Номер страницы
                'status' => $status,//массив со статусами
                'mode' => $mode,//массив с модами
                'orders' => $orders,//таблица orders
                'services' => $services,//таблица services
                'pagination' => $pagination,//пагинация
            ]
        );
    }

}
