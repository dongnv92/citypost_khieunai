<?php
require_once '../includes/core.php';
switch ($act){
    case 'detail':
        $admin_title = 'Chi tiết khiếu nại';
        require_once 'header.php';
        $detail = getGlobalAll(_DB_TABLE_KHIEU_NAI, array('id' => $id), array('onecolum' => 'limit'));

        if($detail['content_service'] == 1){
            $service = 'Khiếu nại về dịch vụ';
        }else{
            $service = 'Khiếu nại về cước phí';
        }
        if($detail['content_status'] == 0){
            updateGlobal(_DB_TABLE_KHIEU_NAI, array('content_status' => 1), array('id' => $id));
            $detail = getGlobalAll(_DB_TABLE_KHIEU_NAI, array('id' => $id), array('onecolum' => 'limit'));
        }
        if($submit && $_POST['post_category']){
            updateGlobal(_DB_TABLE_KHIEU_NAI, array('content_status' => $_POST['post_category']), array('id' => $id));
            $detail = getGlobalAll(_DB_TABLE_KHIEU_NAI, array('id' => $id), array('onecolum' => 'limit'));
        }
        ?>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Nội dung</h4>
                    </div>
                    <div class="card-content">
                        <?php echo $detail['content_content'];?>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">File đính kèm</h4>
                    </div>
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <?php
                                foreach (getGlobalAll(_DB_TABLE_KHIEU_NAI_FILES, array('files_id' => $id)) AS $files){
                                    echo '<tr><td><a href="'. _URL_HOME .'/'. $files['files_url'] .'">'. $files['files_name'] .'</a> </td></tr>';
                                }
                                ?>
                                </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <form action="" method="post">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Cập nhập trạng thái</h4>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <div class="col">
                                    <select class="selectpicker" data-style="btn btn-success" name="post_category" data-size="7">
                                        <?php
                                        echo '<option value="'. $detail['content_status'] .'">'. getTextStatus($detail['content_status']) .'</option>';
                                        for($i = 0; $i<=3; $i++){
                                            echo '<option value="'. $i .'">'. getTextStatus($i) .'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="submit" name="submit" value="Update Trạng thái" class="btn btn-success btn-google">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        break;
    default:
        $admin_title = 'Quản Lý Khiếu Nại';
        require_once 'header.php';
        ?>
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Chi tiết khiếu nại</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kiểu khiếu nại</th>
                                    <th>Mã vận đơn</th>
                                    <th>Tên người khiếu nại</th>
                                    <th>Số điện thoại liên hệ</th>
                                    <th>Thời gian</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $khieu_nai = getGlobalAll(_DB_TABLE_KHIEU_NAI, array());
                                foreach ($khieu_nai AS $row){
                                    if($row['content_service'] == 1){
                                        $service = 'Khiếu nại về dịch vụ';
                                    }else{
                                        $service = 'Khiếu nại về cước phí';
                                    }
                                    echo '<tr>';
                                    echo '<td><a href="index.php?act=detail&id='. $row['id'] .'">'. $service .'</a></td>';
                                    echo '<td>'. $row['content_code'] .'</td>';
                                    echo '<td>'. $row['content_name'] .'</td>';
                                    echo '<td>'. $row['content_phone'] .'</td>';
                                    echo '<td>'. date('H:i:s d-m-Y', $row['content_time']) .'</td>';
                                    echo '<td>'. getTextStatus($row['content_status']) .'</td>';
                                    echo '</tr>';
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
        break;
}
require_once 'footer.php';

