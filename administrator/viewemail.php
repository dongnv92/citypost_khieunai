<?php
/**
 * Created by PhpStorm.
 * User: DONG
 * Date: 12/06/2018
 * Time: 14:26
 */
require_once '../includes/core.php';
$detail = getGlobalAll(_DB_TABLE_KHIEU_NAI, array('id' => $id), array('onecolum' => 'limit'));
if($detail['content_service'] == 1){
    $service = 'Khiếu nại về dịch vụ';
}else{
    $service = 'Khiếu nại về cước phí';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>KHIẾU NẠI CITYPOST.COM.VN</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Bootstrap core CSS     -->
    <link href="<?php echo _URL_HOME?>/administrator/assets/css/bootstrap.min.css" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="<?php echo _URL_HOME?>/administrator/assets/css/material-dashboard.css?v=1.2.1" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="http://blueimp.github.io/jQuery-File-Upload/css/jquery.fileupload.css">
</head>
<body>
<div class="wrapper">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header"><h4 class="card-title">Nội dung khiếu nại</h4></div>
                        <div class="card-content">
                            <?php echo $detail['content_content'];?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Thông tin chi tiết</h4>
                        </div>
                        <div class="card-content">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td class="text-left">Kiểu khiếu nại</td>
                                        <td class="text-left"><?php echo $service;?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Mã Vận Đơn</td>
                                        <td class="text-left"><?php echo $detail['content_code'];?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Tên người khiếu nại</td>
                                        <td class="text-left"><?php echo $detail['content_name'];?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Số điện thoại liên hệ</td>
                                        <td class="text-left"><?php echo $detail['content_phone'];?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Trạng thái</td>
                                        <td class="text-left"><?php echo getTextStatus($detail['content_status']);?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Thời gian tạo</td>
                                        <td class="text-left"><?php echo date('H:i:s d-m-Y', $detail['content_time']);?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left"></td>
                                        <td class="text-left"><a href="<?php echo _URL_ADMIN.'/?act=detail&id='.$id;?>">Xem chi tiết khiếu nại</a> </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>