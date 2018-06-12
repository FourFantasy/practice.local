<?php
use yii\widgets\LinkPager;




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <style>
        .label-default{
            border: 1px solid #ddd;
            background: none;
            color: #333;
            min-width: 30px;
            display: inline-block;
        }
    </style>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<nav class="navbar navbar-fixed-top navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Orders</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <ul class="nav nav-tabs p-b">
        <li class="active"><a href="/">All orders</a></li>
        <li><a href="/?orders_status=0">Pending</a></li>
        <li><a href="/?orders_status=1">In progress</a></li>
        <li><a href="/?orders_status=2">Completed</a></li>
        <li><a href="/?orders_status=3">Canceled</a></li>
        <li><a href="/?orders_status=4">Error</a></li>

        <li class="pull-right custom-search">
            <form class="form-inline" action="" method="get">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" value="" placeholder="Search orders">
                    <span class="input-group-btn search-select-wrap">
            <input type="hidden" name="orders_status" value="<?=$_GET['orders_status']?>" //захват статуса>
            <select class="form-control search-select" name="search_type">
              <option value="0" selected="">Order ID</option>
              <option value="1">Link</option>
              <option value="2">Username</option>
            </select>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
                </div>
            </form>
        </li>

    </ul>


    <table class="table order-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Link</th>
            <th>Quantity</th>
            <th>
                <form method="GET" action="">
                      <select  name="orders_service_id" onchange="this.form.submit()">
                            <option value="">Service</option>
                            <option value="">All (<?=$allpages?>)</option>


                          <?php
                          for ($i = 0, $k = 1; $i <= count($orders_count_service), $k<= count($orders_count_service); $i++,$k++)
                          {
                              if($orders_count_service[$k] != 0)
                              {
                              ?>
                              <option value="<?=$services[$i]->id?>"><span class="label-id"><?=$orders_count_service[$k].' '?></span><?=$services[$i]->name?></option>
                          <?php } } ?>


                      </select>
                      <input type="hidden" name="orders_status" value="<?=$_GET['orders_status'] //захват статуса ?>">
                      <input type="hidden" name="orders_mode" value="<?=$_GET['orders_mode'] //захват mode ?>">
                 </form>
            </th>
            <th>Status</th>
            <th>
                <form method="GET" action="">
                     <select  name="orders_mode" onchange="this.form.submit()">
                            <option value="">Mode</option>
                            <option value="">All</option>
                            <option value="0">Manual</option>
                            <option value="1">Auto</option>
                      </select>
                      <input type="hidden" name="orders_status" value="<?=$_GET['orders_status']  //захват статуса ?>">
                      <input type="hidden" name="orders_service_id" value="<?=$_GET['orders_service_id'] //захват service ?>">
                </form>
            </th>
            <th>Created</th>
        </tr>
        </thead>
        <tbody>


        <?php foreach ($orders as $order) { ?>

            <tr>
            <td><?= $order->id; ?></td>
            <td><?= $order->user; ?></td>
            <td class="link"><?= $order->link; ?></td>
            <td><?= $order->quantity; ?></td>
            <td class="service"><span class="label-id"><?= $order->service_id; ?></span>
                <?php foreach ($services as $servic)
                    {
                        if($order->service_id == $servic->id)
                        {
                           echo $servic->name;
                        }
                    }
                ?>
            </td>
            <td>
                <?
                foreach ($status as $status_key => $status_one)
                    {
                        if($status_key == $order->status)
                        {
                           echo $status_one;
                        }
                    }
                ?>
            </td>
            <td>
                <?
                foreach ($mode as $mode_key => $mode_one)
                {
                    if($mode_key == $order->mode)
                    {
                        echo $mode_one;
                    }
                }
                ?>
            </td>
            <td><span class="nowrap"><?= $order->created_at; ?></span></td>
        </tr>
       <?php }  ?>
        </tbody>
    </table>

    <div class="row">
        <div class="col-sm-8">

            <nav>
                <?= LinkPager::widget(['pagination' => $pagination]); ?>
            </nav>


        </div>
        <div class="col-sm-4 pagination-counters">
            <?
           echo $page.' to ';
           if($pages < $allpages)
           {
               echo $pages;
           }
           else
           {
               echo $allpages;
           }
            echo  ' of '.$allpages;
           ?>
        </div>

    </div>
</div>

</body>
<html>