<?php
session_start();
$_SESSION['rights'] = "default";
$_SESSION['limit'] = 8;
$conn = mysqli_connect('localhost','root','','qlbh') or die('Không thể kết nối!');
/*$conn = mysqli_connect("localhost","k2739nvdu_qlbh","cuchuoi258","k2739nvdu_qlbh") or die('Không thể kết nối!');*/
mysqli_set_charset($conn, 'utf8');
if(isset($_COOKIE['usidtf'])){
  $s = "SELECT * FROM thanhvien WHERE id = '".$_COOKIE['usidtf']."'";
  $result = mysqli_query($conn, $s);
  while ($row = mysqli_fetch_assoc($result)) {
    $_SESSION['user'] = $row;
  }
}
$_SESSION['sql'] = "SELECT * FROM sanpham";
$sql = "SELECT * FROM sanpham";
$result = mysqli_query($conn, $sql);
$_SESSION['total'] = mysqli_num_rows($result);
require_once 'backend-index.php';
if(!isset($_SESSION['client_cart'])){
  $_SESSION['client_cart'][0] = "tmp";
}

$_SESSION['user_cart'] = "";
$_SESSION['user_cart'][0] = "tmp";
if(isset($_SESSION['user'])){
  $_SESSION['rights'] = "user";
  $_SESSION['like'] = "";
  $_SESSION['like'][0] = "tmp";
  $conn = connect();
  mysqli_set_charset($conn, 'utf8');
  $sql = "SELECT masp, soluong FROM giohang WHERE user_id = '".$_SESSION['user']['id']."'";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $_SESSION['user_cart'][] = $row['masp'];
  }
  $sql = "SELECT masp FROM sanphamyeuthich WHERE user_id = '".$_SESSION['user']['id']."'";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $_SESSION['like'][] = $row['masp'];
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title> 9XWatch - Thể hiện sự lịch lãm của phái mạnh! </title>
  <meta charset="utf-8">
  <!-- <link rel="SHORTCUT ICON"  href=> -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script type="text/javascript" src="libs/script/script.js"></script>
  <link rel="stylesheet" href="libs/css/style.css">

  <!-- File css -> file js -> file jquery -->
  <link rel="stylesheet" href="libs/bootstrap/css/bootstrap.css">
  <script src="libs/jquery/jquery-latest.js"></script>
  <script type="text/javascript" src="libs/bootstrap/js/bootstrap.min.js"></script>

  <!-- font used in this site -->
  <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="libs/animate.css">
  
  <script type="text/javascript">
    $(document).ready(function(){
      $(".cart-container").click(function(){
        $(this).toggleClass('cart-ordered');
      });
      $(".unlike-container").click(function(){
        if($('#s-s').data("stt") == "alreadysignin"){
          $(this).toggleClass('liked');
        }
      });
    });
    $(document).on("click", function () {
      $(".showup").hide();
    });
    window.onkeyup = function(e){
      var x = $('#srch-val').val();
      var y = $("#srch-val").is(":focus");
      if(e.keyCode == 13 && y && x != ""){
        ajax_search();
      }
    }
  </script>
</head>
<body>
  <header id='header'>
    <a href="index.php"><img src="images/logo.png"><h2 class="logo">9XWatch</h2></a>
    <ul class="header-menu">
      <?php 
      if($_SESSION['rights'] == "default"){ ?>
      <li><a onclick='ajax_dangnhap()' id="s-s" data-stt='nosignin'>Đăng nhập</a><div class='mn-ef'></div></li>
      <li><a onclick='ajax_dangky()'>Đăng ký</a><div class='mn-ef'></div></li>
      <?php } else { ?>
      <li><a onclick="$('#user-setting').toggle()" id="s-s" data-stt='alreadysignin'>Chào <?php echo $_SESSION['user']['ten'] ?></a><div class='mn-ef'></div></li>
      <div id='user-setting'>
        <ul>
          <li onclick='call_to_dangxuat()'>Đăng xuất</li>
          <li onclick="call_to_thongtin();$('#user-setting').toggle()">Thông tin tài khoản</li>
        </ul>
      </div>
      <?php }
      ?>
      <li><a onclick="ajax_giohang()"><i class="glyphicon glyphicon-shopping-cart"></i> Giỏ hàng</a><div class="mn-ef"></div></li>
    </ul>
    <div class="header-detail">
      <p>113 Hoàng Sa, Đa Kao, Tân Bình, Hồ Chí Minh, Việt Nam<br>
        <i>8h - 22h Hằng ngày, kể cả Ngày lễ và Chủ nhật</i>
      </p>
    </div>
  </header>

  <nav class="navbar navbar-default" role="navigation" id="nav">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand logo" href="index.php">9XWatch</a>
        <div id="custom-search-input">
          <div class="input-group col-md-12" style="background-color: white;">
            <input type="text" class="form-control input-lg" placeholder="Bạn tìm gì?" id='src-v' />
            <span class="input-group-btn">
              <button class="btn btn-info btn-lg" type="button" onclick="ajax_search()">
                <i class="glyphicon glyphicon-search"></i>
              </button>
            </span>
          </div>
        </div>
      </div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
          <li class="dropdown menu-name">
            <a class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer;">Danh mục sản phẩm <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a onclick="ajax_danhmucsp('all')">Tất cả sản phẩm</a></li>
              <li><a onclick="ajax_danhmucsp('rolex')">Rolex (Thụy Sĩ)</a></li>
              <li><a onclick="ajax_danhmucsp('cartier')">Cartier (Pháp)</a></li>
              <li><a onclick="ajax_danhmucsp('omega')">Omega (Thụy Sĩ)</a></li>
              <li><a onclick="ajax_danhmucsp('patek')">Patek Philippe (Thụy Sĩ)</a></li>
              <li><a onclick="ajax_danhmucsp('piaget')">Piaget (Thụy Sĩ)</a></li>
              <li><a onclick="ajax_danhmucsp('montblanc')">Montblanc (Đức)</a></li>
            </ul>
          </li>
          <li class="menu-name" id="dgg"><a onclick="ajax_saling()">Đang giảm giá</a></li>
          <li class="menu-name" id="spm"><a onclick="ajax_new()">Sản phẩm mới</a></li>
          <li class="menu-name" id="mntq"><a onclick="ajax_buy()">Mua nhiều tuần qua</a></li>

        </ul>
        <div onclick="ajax_like()" style="cursor: pointer;"><i class="glyphicon glyphicon-heart navbar-right btn-lg" id="like_count">
          <?php
          if(isset($_SESSION['like'])){echo count($_SESSION['like'])-1;}
          else{echo " 0";}
          ?>

        </i></div>
        <div onclick="ajax_giohang()" style="cursor: pointer;"><i class="glyphicon glyphicon-shopping-cart navbar-right btn-lg" id="cart_count">
          <?php
          if($_SESSION['rights'] == "default"){
            if(isset($_SESSION['client_cart'])){
              echo count($_SESSION['client_cart'])-1;
            } else {
              echo " 0";
            }
          } else {
            echo count($_SESSION['user_cart'])-1;
          }
          ?>

        </i></div>
        <div class="navbar-form navbar-right searchbox-desktop">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Bạn tìm gì?" id='srch-val'>
          </div>
          <span class="btn btn-default" onclick="ajax_search()">Tìm</span>
        </div>
      </div><!-- /.navbar-collapse -->
    </div>
  </nav>