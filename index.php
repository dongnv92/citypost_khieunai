<?php
require_once 'includes/core.php';

if($submit){
    $dong_service   = isset($_POST['dong_service']) ? trim($_POST['dong_service'])  : 1;
    $dong_code      = isset($_POST['dong_code'])    ? trim($_POST['dong_code'])     : '';
    $dong_name      = isset($_POST['dong_name'])    ? trim($_POST['dong_name'])     : '';
    $dong_phone     = isset($_POST['dong_phone'])   ? trim($_POST['dong_phone'])    : '';
    $dong_content   = isset($_POST['dong_content']) ? trim($_POST['dong_content'])  : '';
    $dong_content   = str_replace("\n" , '<br />', $dong_content);
    if($dong_service && $dong_code && $dong_name && $dong_phone){
        $colum  = array('[content_service]','[content_code]','[content_name]','[content_phone]','[content_content]','[content_status]','[content_time]');
        $data   = array($dong_service, "N'$dong_code'", "N'$dong_name'", "N'$dong_phone'", "N'$dong_content'", 0, "'". _CONFIG_TIME ."'");
        $query  = insertSqlserver(_DB_TABLE_KHIEU_NAI, $colum, $data);
        if($query){
            $result = $query;
            // Upload File
            if(checkFilesUploaded('files')){
                $max_file_size = 5*1024*1024; //5MB
                $path = "files/"; // Upload directory
                //$count = 0; // nr.successfully uploaded files
                $valid_formats = array("jpg","gif","jpeg","png");
                $valid_formats_server = array(
                    "image/jpg",
                    "image/gif",
                    "image/jpeg",
                    "image/png"
                );

                //prevent uploading from wrong file types(server secure)
                foreach ($_FILES['files']['type'] as $t => $tName) {
                    if(!in_array($_FILES['files']['type'][$t], $valid_formats_server)){
                        echo "wrong FILE TYPE";
                        return;
                    }
                }
                // Loop $_FILES to exeicute all files
                foreach ($_FILES['files']['name'] as $f => $name) {
                    if ($_FILES['files']['error'][$f] == 4) {
                        continue; // Skip file if any error found
                    }
                    if ($_FILES['files']['error'][$f] == 0) {
                        if ($_FILES['files']['size'][$f] > $max_file_size) {
                            echo $message[] = "$name is too large!";
                            continue; // Skip large files
                        }
                        elseif(!in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats)){
                            echo $message[] = "$name is not a valid format";
                            continue; // Skip invalid file formats
                        }
                        else{ // No error found! Move uploaded files
                            $ext = pathinfo($name, PATHINFO_EXTENSION);
                            $name_new_1 = md5($name.time()).'.'.$ext;
                            $name_new = $path.$name_new_1;
                            move_uploaded_file($_FILES["files"]["tmp_name"][$f], $name_new);
                            $files[] = $path.$name;
                            $colum  = array('[files_name]','[files_url]','[files_id]','[files_time]');
                            $data   = array("N'$name_new_1'", "N'$name_new'", $result, _CONFIG_TIME);
                            insertSqlserver(_DB_TABLE_KHIEU_NAI_FILES, $colum, $data);
                        }
                    }
                }
            }
            // Upload File
            dongSendEmail(array(
                'user'      => 'dongnguyen@citypost.com.vn',
                'pass'      => '123456789',
                'send_name' => 'Đông Nguyễn',
                'attach'    => $files,
                'title'     => '[KHIẾU NẠI CITYPOST.COM.VN] - Do Not Reply',
                'content'   => file_get_contents(_URL_HOME.'/administrator/viewemail.php?id='.$result),
                'receive'   => array(
                    array('dongnguyen@citypost.com.vn'  => 'Nguyễn văn Đông'),
                    array('thangnguyen@citypost.com.vn' => 'Nguyễn Chiến Thắng'),
                    array('thembui@citypost.com.vn'     => 'Bui thị thêm'),
                    array('tuanh@citypost.com.vn'       => 'Tú Anh'),
                    array('phuongcham@citypost.com.vn'  => 'Nguyễn Phương Châm')
                )));
        }else{
            $result = false;
        }
    }else{
        $result = false;
    }
}

?>
<!DOCTYPE html>
<!-- saved from url=(0036)https://citypost.com.vn/lien-he.html -->
<html lang="" class="page-home"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="description" content="Dịch vụ chuyển phát nhanh hỏa tốc, uy tín, rẻ , an toàn">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keyword" content="Chuyển phát nhanh , giao hàng tiết kiệm, giao hàng nhanh, dịch vụ chuyển phát nhanh , dịch vụ giao hàng , bảng giá chuyển phát nhanh , bảng giá chuyển phát bưu diện, bảng giá giao hàng nhanh, bảng giá cước bưu điện">
    <title>Chuyển phát nhanh hỏa tốc</title>
    <link rel="icon" href="https://citypost.com.vn/Images/Images/star.png">
    <link href="./index_files/css" rel="stylesheet" type="text/css">
    <link href="./index_files/css(1)" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="./index_files/owl.carousel.css">
    <link rel="stylesheet" href="./index_files/jquery.mmenu.all.css">
    <link rel="stylesheet" href="./index_files/lightslider.min.css">
    <link rel="stylesheet" href="./index_files/lightgallery.css">
    <link rel="stylesheet" href="./index_files/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="./index_files/style.css">
    <script async="" type="text/javascript" src="./index_files/saved_resource"></script><script type="text/javascript" async="" src="./index_files/loader.js.tải xuống"></script><script type="text/javascript" async="" src="./index_files/analytics.js.tải xuống"></script><script src="./index_files/jquery-1.10.2.min.js.tải xuống"></script>
    <script src="./index_files/jquery-1.10.2.js.tải xuống"></script>
    <script type="text/javascript" src="./index_files/script.js.tải xuống"></script>
    <!-- Slider -->

    <link rel="stylesheet" href="./index_files/settings.css">
    <link rel="stylesheet" href="./index_files/slider.css">
    <link rel="stylesheet" href="./index_files/main.css">
<script type="text/javascript" charset="UTF-8" src="./index_files/common.js.tải xuống"></script><script type="text/javascript" charset="UTF-8" src="./index_files/util.js.tải xuống"></script><script type="text/javascript" charset="UTF-8" src="./index_files/stats.js.tải xuống"></script></head>

<body style=""><nav id="mobile-menu" class="hidden-xl-up  mm-menu mm-effect-slide-menu mm-pageshadow mm-offcanvas mm-hasnavbar-top-2 mm-hasnavbar-bottom-1"><div class="mm-navbar mm-navbar-bottom mm-navbar-bottom-1 mm-navbar-size-1"><a href="http://mmenu.frebsite.nl/wordpress-plugin.html" target="_blank">WordPress plugin</a></div><div class="mm-navbar mm-navbar-top mm-navbar-top-2 mm-navbar-size-1 mm-hasbtns"><a class="mm-prev mm-btn mm-hidden"></a><a class="mm-title">Advanced menu</a><a class="mm-close mm-btn" href="https://citypost.com.vn/lien-he.html#mm-0"></a></div><div class="mm-navbar mm-navbar-top mm-navbar-top-1 mm-navbar-size-1"><div class="mm-search"><input placeholder="Search" type="text" autocomplete="off"></div></div><div class="mm-panels"><div class="mm-panel mm-opened mm-current" id="mm-1"><div class="mm-navbar"><a class="mm-title">Advanced menu</a></div><ul class="mm-listview">
        <li><a href="https://citypost.com.vn/trang-chu.html">Trang chủ</a></li>
        <li><a href="https://citypost.com.vn/gioi-thieu.html">Giới thiệu</a></li>
        <li><em class="mm-counter">11</em>
            <a class="mm-next" href="https://citypost.com.vn/lien-he.html#mm-2" data-target="#mm-2"></a><a href="https://citypost.com.vn/dich-vu.html">Dịch vụ</a>
        </li>
        <li><a href="https://citypost.com.vn/tin-tuc.html">Tin tức</a></li>
        <li><a href="https://citypost.com.vn/tuyen-dung.html">Tuyển dụng</a></li>
        <li><a href="https://citypost.com.vn/lien-he.html">Liên hệ</a></li>
        <li><a href="https://citypost.com.vn/fqa.html">FAQ</a></li>
        <li><a href="https://citypost.com.vn/khieu-nai-dich-vu.html">Khiếu Nại dịch Vụ</a></li>
    </ul><div class="mm-noresultsmsg">No results found.</div></div><div class="mm-panel mm-hidden" id="mm-2"><div class="mm-navbar"><a class="mm-btn mm-prev" href="https://citypost.com.vn/lien-he.html#mm-1" data-target="#mm-1"></a><a class="mm-title" href="https://citypost.com.vn/lien-he.html#mm-1">Dịch vụ</a></div><ul class="mm-listview">
                <li><a href="https://citypost.com.vn/dich-vu/chuyen-phat-nhanh-noi-thanh-fast-10.html"> CPN Nội Thành Fast-10</a></li>   
                <li><a href="https://citypost.com.vn/dich-vu/phat-sieu-toc.html">Siêu tốc</a></li>
                <li><a href="https://citypost.com.vn/dich-vu/chuyen-phat-nhanh-truoc-9h.html">Phát trước 9H</a></li>
                <li><a href="https://citypost.com.vn/dich-vu/chuyen-phat-nhanh-truoc-12h.html">Phát trước 12H</a></li>
                <li><a href="https://citypost.com.vn/dich-vu/chuyen-phat-trong-ngay.html">Phát trong ngày</a></li>
                <li><a href="https://citypost.com.vn/dich-vu/chuyen-phat-nhanh.html">Chuyển phát nhanh</a></li>
                <li><a href="https://citypost.com.vn/dich-vu/chuyen-phat-thu-ho.html">Thu Hộ Cod</a></li>
                <li><a href="https://citypost.com.vn/dich-vu/sieu-toc-tiet-kiem.html">Phát tiết kiệm</a></li>
                <li><a href="https://citypost.com.vn/dich-vu/chuyen-phat-quoc-te-express.html">CPN Express </a></li>
                <li><a href="https://citypost.com.vn/dich-vu/sieu-toc-thuong.html">Siêu Tốc Thường</a></li>
                <li><a href="https://citypost.com.vn/dich-vu/sieu-toc-tiet-kiem.html">Siêu Tốc Tiết Kiệm</a></li>             
            </ul></div></div></nav>
    <div id="mm-0" class="mm-page mm-slideout"><div id="page" class="hfeed site">
<link href="./index_files/flag-icon.min.css" rel="stylesheet">
<header class="site-header style-1">
    <div class="container">
        <div class="row">
            <div class="col-xs-8 col-lg-2 site-branding">
                <a href="https://citypost.com.vn/trang-chu.html" rel="home">
                    <img class="margin-top-10" src="./index_files/logocitypost.png" alt="Citypost Logo">
                </a>
            </div>
            <div class="col-lg-10 hidden-md-down">
                <div class="site-info">
                    <div class="top-menu-bar">
                        <div class="row">
                            <div class="col-md-4 col-xl-3 col-md-offset-8 col-xl-offset-9">
                                <div class="social-menu">
                                    <ul id="social-menu-top" class="menu">
                                        <li class="menu-item">
                                            <a href="http://facebook.com/BuuChinhThanhPho"><i class="fa fa-facebook"></i></a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="https://citypost.com.vn/lien-he.html#"><i class="fa fa-google-plus"></i></a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="https://citypost.com.vn/lien-he.html#"><i class="fa fa-twitter"></i></a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="https://citypost.com.vn/lien-he.html#"><i class="fa fa-youtube-play"></i></a>
                                        </li>
                                        <li id="menu-item680" class="menu-item">
                                            <a href="https://citypost.com.vn/lien-he.html#"><i class="fa fa-vimeo-square"></i></a>
                                        </li>
                                        <li id="menu-item681" class="menu-item">
                                            <a href="https://citypost.com.vn/feed"><i class="fa fa-dribbble"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="contact-bar">
                        <div class="row">
                            <div class="col-lg-9 col-xl-10">
                                <div class="contact-detail">
                                    <div class="row">
                                        <div class="col-md-4 col-xl-3 col-xl-offset-1">
                                            <i class="fa fa-phone"></i>
                                            <h3>1900 2630</h3>
                                            <span>info@citypost.com.vn</span>
                                        </div>
                                        <div class="col-md-4 ">
                                            <i class="fa fa-clock-o"></i>
                                            <h3>T2 - T7:8AM-6PM</h3>
                                            <span>Giờ Làm Việc </span>
                                        </div>
                                        <div class="col-md-4 ">
                                            <a href="https://citypost.com.vn/khieu-nai-dich-vu.html">
                                                <i class="fa fa-bullhorn"></i>
                                                <h3>Khiếu Nại dịch Vụ </h3>
                                                <span>dvkh@citypost.com.vn</span>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 hidden-xs hidden-sm hidden-md search-box ">
                                <a href="https://citypost.com.vn/tra-cuu-van-don.html?code=%27%20+%20codelading">
                                    <span class="fa fa-search font-size-25 faSearch search SeachLadding " style="color: #555;"></span>
                                </a>
                                <input type="search" name="" id="code" class="codeladding boder-input" value="" required="required" title="" placeholder="">
                            </div>
                            <div class="col-xs-2 hidden-lg-up hidden-xl-up">
                                <a class="trigger-menu" href="https://citypost.com.vn/lien-he.html#mobile-menu"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="col-xs-2 col-md-2 hidden-lg-up margin-top-7">
                <a class="trigger-menu" href="https://citypost.com.vn/lien-he.html#mobile-menu"></a>
            </div>
        </div>
    </div>
</header>
<nav class="navbar mega navbar-dark bg-dark hidden-xs-down ">
    <div class="container">
        <ul class="nav navbar-nav" style="text-transform: uppercase;">

            <li class="nav-item dropdown active">
                <a class="nav-link" href="https://citypost.com.vn/trang-chu.html" role="button" aria-haspopup="true" aria-expanded="false">Trang chủ <span class="sr-only">(current)</span></a>              
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="https://citypost.com.vn/gioi-thieu.html">Giới thiệu</a>
            </li>
            <li class="nav-item dropdown mega-fw">
                <a class="nav-link" role="button" aria-haspopup="true" aria-expanded="false" href="https://citypost.com.vn/dich-vu.html">Dịch vụ</a>
                <div class="dropdown-menu">
                    <div class="mega-content">
                        <div class="row">
                            <img class="mega-menu-img" src="./index_files/menu-service.png" alt="Transport Menu Image">

                            <ul class="col-sm-3 col-sm-offset-3  list-unstyled">
                                <li class="feature-list-item"><h6 class="feature-list-title"><a href="https://citypost.com.vn/dich-vu/chuyen-phat-nhanh-noi-thanh-fast-10.html"><i class="feature-list-icon fa fa-hand-o-up"></i> CPN Nội Thành Fast-10</a></h6></li>           
                                <li class="feature-list-item"><h6 class="feature-list-title"><a href="https://citypost.com.vn/dich-vu/phat-sieu-toc.html"><i class="feature-list-icon fa fa-cubes"></i> Siêu tốc</a></h6></li>
                                <li class="feature-list-item"><h6 class="feature-list-title"><a href="https://citypost.com.vn/dich-vu/chuyen-phat-nhanh-truoc-9h.html"><i class="feature-list-icon fa fa-picture-o"></i> Phát trước 9H</a></h6></li>
                                <li class="feature-list-item"><h6 class="feature-list-title"><a href="https://citypost.com.vn/dich-vu/chuyen-phat-nhanh-truoc-12h.html"><i class="feature-list-icon fa fa-th-large"></i> Phát trước 12H</a></h6></li>
                            </ul>
                            <ul class="col-sm-3 list-unstyled">
                                <li class="feature-list-item"><h6 class="feature-list-title"><a href="https://citypost.com.vn/dich-vu/chuyen-phat-nhanh.html"><i class="feature-list-icon fa fa-sitemap"></i>Chuyển phát nhanh</a></h6></li>
                                <li class="feature-list-item"><h6 class="feature-list-title"><a href="https://citypost.com.vn/dich-vu/chuyen-phat-thu-ho.html"><i class="feature-list-icon fa fa-laptop"></i>Thu Hộ Cod</a></h6></li>
                                <li class="feature-list-item"><h6 class="feature-list-title"><a href="https://citypost.com.vn/dich-vu/chuyen-phat-tiet-kiem.html"><i class="feature-list-icon fa fa-minus"></i>Phát tiết kiệm</a></h6></li>
                                <li class="feature-list-item"><h6 class="feature-list-title"><a href="https://citypost.com.vn/dich-vu/chuyen-phat-quoc-te-express.html"><i class="feature-list-icon fa fa-css3"></i>CPN Express </a></h6></li>
                            </ul>
                            <ul class="col-sm-3 list-unstyled">
                                <li class="feature-list-item"><h6 class="feature-list-title"><a href="https://citypost.com.vn/dich-vu/sieu-toc-thuong.html"><i class="feature-list-icon fa fa-space-shuttle"></i>Siêu Tốc Thường</a></h6></li>
                                <li class="feature-list-item"><h6 class="feature-list-title"><a href="https://citypost.com.vn/dich-vu/sieu-toc-tiet-kiem.html"><i class="feature-list-icon fa fa-hand-o-up"></i>Siêu Tốc Tiết Kiệm</a></h6></li>
                                <li class="feature-list-item"><h6 class="feature-list-title"><a href="https://citypost.com.vn/dich-vu/chuyen-phat-trong-ngay.html"><i class="feature-list-icon fa fa-puzzle-piece"></i> Phát trong ngày</a></h6></li>         
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="https://citypost.com.vn/tin-tuc.html">Tin tức</a>

            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="https://citypost.com.vn/tuyen-dung.html">Tuyển dụng</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://citypost.com.vn/lien-he.html">Liên hệ</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="https://citypost.com.vn/fqa.html">FAQ</a>
            </li>
        </ul>
            </div>         
        </div>

    </div>
</nav>
<br />
<div class="page-title ">
    <div class="container">
        <ol class="breadcrumb ">
            <li><a href="https://citypost.com.vn/lien-he.html#">Trang chủ</a></li>
            <li class="active"> Khiếu nại đơn hàng</li>
        </ol>
    </div>
</div>
<section class="info-contact">
    <div class="container">
        <div class="row">
            <div class="contact-content col-lg-12">
                <div class="custom-heading part-heading three-slashes">
                    <h2> Khiếu nại đơn hàng</h2>
                </div>
                <p>Liên hệ với chúng tôi nếu bạn có bất kỳ câu hỏi nào và chúng tôi sẽ liên hệ lại với bạn càng sớm càng tốt.Vui lòng điền vào đầy đủ thông tin bên dưới</p>
                <?php
                    if($submit && $result){
                        echo '<p style="color: green"><i>Khiếu nại của bạn đã được gửi đến BQT. Chúng tôi sẽ xem xét và phản hồi lại bạn sớm nhất.</i></p>';
                    }
                ?>
                <div class="contact-form">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-3">
                                <select name="dong_service" class="form-control">
									<option value="1">Khiếu nại về dịch vụ</option>
									<option value="2">Khiếu nại về Cước Phí</option>
								</select>
                            </div>
                            <div class="col-lg-3">
                                <input class="form-control address" type="text" name="dong_code" value="<?php echo $dong_code;?>" size="40" aria-invalid="false" placeholder="Nhập Mã Vận Đơn">
                            </div>
                            <div class="col-lg-3">
                                <input class="form-control phone" required type="text" name="dong_name" value="<?php echo $dong_name;?>" size="40" aria-invalid="false" placeholder="Tên người khiếu nại">
                            </div>
                            <div class="col-lg-3">
                                <input class="form-control company" required type="text" name="dong_phone" value="<?php echo $dong_phone;?>" size="40" aria-required="true" aria-invalid="false" placeholder="Số điện thoại lên hệ khi cần">
                            </div>
                            <div class="col-xs-12">
                                <textarea class="form-control content" name="dong_content" cols="40" rows="4" aria-invalid="false" placeholder="Nội dung"><?php echo $dong_content;?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 text-lg-left"><input type="file" class="custom-file-input" multiple="multiple" name="files[]"></div>
                                <div class="col-xs-6 text-lg-right"><input class="btn btn-primary btn-contact" type="submit" name="submit" value="Gửi khiếu nại"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ADVISORY
================================================== -->
<!-- OUR CLIENTS
   ================================================== -->
<section class="our-clients hidden-xs-down ">
    <div class="container">
        <div class="custom-heading section-heading">
            <h1>ĐỐI TÁC CỦA CHÚNG TÔI</h1>
        </div>
<div class="row">
    <div class="col-lg-2 col-sm-4 col-xs-6">
        <a href="https://fptshop.com.vn/">
            <img src="./index_files/doi-tac-7.png" alt="FPT" title="FPT" class="thumbnail img-fluid">
        </a>
    </div>
    <div class="col-lg-2 col-sm-4 col-xs-6">
        <a href="https://www.vietnamworks.com/">
            <img src="./index_files/doi-tac-5.png" alt="vietnamworks" title="vietnamworks" class="thumbnail img-fluid">
        </a>
    </div>
    <div class="col-lg-2 col-sm-4 col-xs-6">
        <a href="https://www.bmw.vn/">
            <img src="./index_files/doi-tac-10.png" alt="BMW" title="BMW" class="thumbnail img-fluid">
        </a>
    </div>
    <div class="col-lg-2 col-sm-4 col-xs-6">
        <a href="https://www.mt.com/vn/">
            <img src="./index_files/doi-tac-11.png" alt="METTLER TOLEDO" title="METTLER TOLEDO" class="thumbnail img-fluid">
        </a>
    </div>
    <div class="col-lg-2 col-sm-4 col-xs-6">
        <a href="http://www.uob.com.vn/">
            <img src="./index_files/doi-tac-4.png" alt="UOB" title="UOB" class="thumbnail img-fluid">
        </a>
    </div>
    <div class="col-lg-2 col-sm-4 col-xs-6">
        <a href="https://topica.edu.vn/">
            <img src="./index_files/doi-tac-12.png" alt="TOPICA" title="TOPICA" class="thumbnail img-fluid">
        </a>
    </div>
    <div class="col-lg-2 col-sm-4 col-xs-6">
        <a href="https://square.vn/gioi-thieu/gioi-thieu-ve-square">
            <img src="./index_files/doi-tac-13.png" alt="SQUARE" title="SQUARE" class="thumbnail img-fluid">
        </a>
    </div>
    <div class="col-lg-2 col-sm-4 col-xs-6">
        <a href="http://www.diana.com.vn/index.html">
            <img src="./index_files/doi-tac-14.png" alt="DIANA" title="DIANA" class="thumbnail img-fluid">
        </a>
    </div>
    <div class="col-lg-2 col-sm-4 col-xs-6">
        <a href="https://dienmaycholon.vn/">
            <img src="./index_files/doi-tac-15.png" alt="SIÊU THỊ CHỢ LỚN" title="SIÊU THỊ CHỢ LỚN" class="thumbnail img-fluid">
        </a>
    </div>
    <div class="col-lg-2 col-sm-4 col-xs-6">
        <a href="https://www.eximbank.com.vn/">
            <img src="./index_files/doi-tac-16.png" alt=" NGÂN HÀNG EXIMBANK" title=" NGÂN HÀNG EXIMBANK" class="thumbnail img-fluid">
        </a>
    </div>
    <div class="col-lg-2 col-sm-4 col-xs-6">
        <a href="http://www.agribank.com.vn/">
            <img src="./index_files/doi-tac-17.png" alt="NGÂN HÀNG AGRIBANK" title="NGÂN HÀNG AGRIBANK" class="thumbnail img-fluid">
        </a>
    </div>
    <div class="col-lg-2 col-sm-4 col-xs-6">
        <a href="http://www.htv.com.vn/">
            <img src="./index_files/doi-tac-1.png" alt="HTV" title="HTV" class="thumbnail img-fluid">
        </a>
    </div>
    <div class="col-lg-2 col-sm-4 col-xs-6">
        <a href="https://www.internationalsos.com/">
            <img src="./index_files/doi-tac-3.png" alt="INTERNATION SOS" title="INTERNATION SOS" class="thumbnail img-fluid">
        </a>
    </div>
    <div class="col-lg-2 col-sm-4 col-xs-6">
        <a href="http://hungthinhcorp.com.vn/">
            <img src="./index_files/doi-tac-2.png" alt="HƯNG THỊNH" title="HƯNG THỊNH" class="thumbnail img-fluid">
        </a>
    </div>
    <div class="col-lg-2 col-sm-4 col-xs-6">
        <a href="https://www.asus.com/">
            <img src="./index_files/doi-tac-6.png" alt="ASUS" title="ASUS" class="thumbnail img-fluid">
        </a>
    </div>
    <div class="col-lg-2 col-sm-4 col-xs-6">
        <a href="https://www.uber.com/">
            <img src="./index_files/doi-tac-8.png" alt="UBER" title="UBER" class="thumbnail img-fluid">
        </a>
    </div>
    <div class="col-lg-2 col-sm-4 col-xs-6">
        <a href="https://lottecinemavn.com/">
            <img src="./index_files/doi-tac-9.png" alt="LOTTE CENIMA" title="LOTTE CENIMA" class="thumbnail img-fluid">
        </a>
    </div>
    <div class="col-lg-2 col-sm-4 col-xs-6">
        <a href="https://www.mitsubishi-electric.vn/">
            <img src="./index_files/doi-tac-18.png" alt="MITSUBISHI ELECTRIC" title="MITSUBISHI ELECTRIC" class="thumbnail img-fluid">
        </a>
    </div>
</div>
    </div>
</section>

        <footer class="site-footer">
            <div class="container">
                <div class="row">
<div class="col-xs-12 col-sm-6 col-md-4">
    <aside class="widget widget_text">
        <h3 class="widget-title"><span>THÔNG TIN &amp; TRỢ GIÚP</span></h3>
        <div class="textwidget">
            <div class="office">
             
                        <p>
                            <a style="color: #aaa;" href="https://citypost.com.vn/fqa.html"><i class="fa fa-caret-right"></i>Hướng Dẫn Sử Dụng Site Customer ?</a>
                        </p>
                        <p>
                            <a style="color: #aaa;" href="https://citypost.com.vn/fqa.html"><i class="fa fa-caret-right"></i>Tôi muốn biết về Giá cước, thời gian chuyển thư/hà...</a>
                        </p>
                        <p>
                            <a style="color: #aaa;" href="https://citypost.com.vn/fqa.html"><i class="fa fa-caret-right"></i>
Tôi muốn được tư vấn trực tuyến các thông tin về...</a>
                        </p>
                        <p>
                            <a style="color: #aaa;" href="https://citypost.com.vn/fqa.html"><i class="fa fa-caret-right"></i>
Bảng giá công bố của CITYPOST trên trang web có ...</a>
                        </p>
                        <p>
                            <a style="color: #aaa;" href="https://citypost.com.vn/fqa.html"><i class="fa fa-caret-right"></i>Mạng lưới CPN của CityPost có mặt ở những tỉnh thà...</a>
                        </p>
                        <p>
                            <a style="color: #aaa;" href="https://citypost.com.vn/fqa.html"><i class="fa fa-caret-right"></i>
Tôi không hiểu về cách áp dụng trọng lượng để tí...</a>
                        </p>
            </div>
        </div>
    </aside>
</div>
<div class="col-xs-12 col-sm-6 col-md-4">
    <aside class="widget widget_text">
        <h3 class="widget-title"><span>THÔNG TIN LIÊN HỆ</span></h3>
        <div class="textwidget">
            <div class="office">
                    <p>
                        <i class="fa fa-map-marker"></i> <strong style="color: white">Hà Nội : </strong> Tầng 6, Tháp B, TN Sông Đà, Đường Phạm Hùng, P. Mỹ Đình 1, Nam Từ Liêm, Hà Nội.
                    </p>
                    <p>
                        <i class="fa fa-map-marker"></i> <strong style="color: white">Hồ Chí Minh : </strong> Lầu 5 Tòa Nhà Hải Âu, 39B Trường Sơn, phường 4, quận Tân Bình, Tp. Hồ Chí Minh.
                    </p>
                    <p>
                        <i class="fa fa-map-marker"></i> <strong style="color: white">Đà Nẵng : </strong>  66 Hoàng Đạo Thúy, quận Cẩm Lệ, Tp. Đà Nẵng..
                    </p>
                    <p>
                        <i class="fa fa-map-marker"></i> <strong style="color: white">Bình Dương : </strong> 14/15 KP Thống Nhất, Dĩ An, Bình Dương.
                    </p>
            </div>
        </div>
    </aside>
</div>
<div class="col-xs-12 col-sm-6 col-md-4">
    <aside class="widget widget_text">
        <h3 class="widget-title"><span>HỖ TRỢ TRỰC TUYẾN</span></h3>
        <div class="textwidget">
            <div class="office">
                <div class="col-xs-12 col-md-12 col-sm-12 padding-0">
                    <p>
                        <i class="fa fa-envelope"></i> info@citypost.com.vn
                    </p>
                </div>
                <div class="col-xs-12 col-md-12 col-sm-12 padding-0">
                        <div class="col-md-6 col-sm-6 col-xs-6 float-left padding-0-1">

                            <strong style="color: white">Hà Nội: </strong>
                            <p style="margin-bottom: 8px !important">
                                <a style="color: #aaa!important" href="skype:citypost_cskh_hn?chat">   <i style="color: #0078c1!important" class="fa fa-skype"></i> citypost_cskh_hn</a>
</p>
                            <p>
                                <i class="fa fa-phone"></i> 1900 2630 - ext: 408
                            </p>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 float-left padding-0-1">

                            <strong style="color: white">Hồ Chí Minh: </strong>
                            <p style="margin-bottom: 8px !important">
                                <a style="color: #aaa!important" href="skype:phongtran2603?chat">   <i style="color: #0078c1!important" class="fa fa-skype"></i> phongtran2603</a>
</p>
                            <p>
                                <i class="fa fa-phone"></i> 1900 2630 - ext: 401
                            </p>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 float-left padding-0-1">

                            <strong style="color: white">Đà Nẵng: </strong>
                            <p style="margin-bottom: 8px !important">
                                <a style="color: #aaa!important" href="skype: trangcitypostdn?chat">   <i style="color: #0078c1!important" class="fa fa-skype"></i>  trangcitypostdn</a>
</p>
                            <p>
                                <i class="fa fa-phone"></i> 1900 2630 - ext: 208
                            </p>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 float-left padding-0-1">

                            <strong style="color: white">Bình Dương: </strong>
                            <p style="margin-bottom: 8px !important">
                                <a style="color: #aaa!important" href="skype:ky.vo73?chat">   <i style="color: #0078c1!important" class="fa fa-skype"></i> ky.vo73</a>
</p>
                            <p>
                                <i class="fa fa-phone"></i> 1900 2630 - ext: 209
                            </p>
                        </div>
                </div>
                    
                    </div>
        </div>
    </aside>
</div>
                </div>
            </div>
        </footer>
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-xs-12 margin-bottom-20">
                        <div class="Center">
                            Copyright © 2017 CITYPOST. All rights reserved . © 2017 Powered by CITYPOST.<br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><div style="position: fixed; bottom: 0px; right: 240px;" class="chat">
    <a href="https://www.facebook.com/messages/t/buuchinhthanhpho" title="Chat với Citypost" target="_blank">
        <div class="bubble-msg1 chat-footer ">
            <img class="padding-right-10" src="./index_files/icon_chat_faceboook.png"><strong class="padding-right-10  ">Facebook Messenger</strong>
        </div>
    </a>
</div></div>
</body></html>