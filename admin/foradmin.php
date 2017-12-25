<?php 

session_start();
if(!isset($_SESSION['admin']) || isset($_SESSION['user']) || isset($_SESSION['user'])){
	echo "<script>window.location.replace('../index.php');</script>";
}
$conn = mysqli_connect('localhost','root','','qlbh') or die('Không thể kết nối!');
$sql = "SELECT * FROM sanpham";
$result = mysqli_query($conn, $sql);
$_SESSION['total'] = mysqli_num_rows($result);

$sql = "SELECT * FROM giaodich";
$result = mysqli_query($conn, $sql);
$_SESSION['gd_all'] = mysqli_num_rows($result);

$sql = "SELECT * FROM giaodich WHERE tinhtrang = 1";
$result = mysqli_query($conn, $sql);
$_SESSION['gd_dagd'] = mysqli_num_rows($result);

$sql = "SELECT * FROM giaodich WHERE tinhtrang = 0";
$result = mysqli_query($conn, $sql);
$_SESSION['gd_chua'] = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Trang quản trị admin</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="libs/style.css">
	<link rel="stylesheet" href="../libs/bootstrap/css/bootstrap.css">
	<script src="../libs/jquery/jquery-latest.js"></script>
	<script src="../libs/bootstrap/js/bootstrap.min.js"></script>
	<script src="ajax.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#add-pr').hide();
			$('#add-dm').hide();
			$('#add-admin-area').hide();
			$('#sua_sp-area').hide();
			$('#addspbtn').click(function(){
				$('#add-pr').toggle(300);
				$('#tbl-sanpham-list').toggle(300);
				$('#loadmorebtn').toggle(300);
			});
			$('#adddmbtn').click(function(){
				$('#add-dm').toggle(300);
			});
			$('.xong').click(function(){
				$(this).closest('tr').children("td:nth-child(2)").html('<h4 class="label label-success">Đã giao hàng</h4>');
				$(this).remove();
			});
			$('#add-admin-btn').click(function(){
				$('#add-admin-area').toggle(300);
			});
		});
		function load_more(current,where){
			var fname = 'load_more';
			var x = current+1;
			$('#loadmorebtn').attr('onclick','load_more('+x+',`'+where+'`)');
			$.ajax({
				url : "for-ajax.php",
				type : "get",
				dataType:"text",
				data : {
					fname, current
				},
				success : function (result){
					if(result.search('hetcmnrdungbamnua') != -1){
						alert('Đã hết mục để hiển thị!');
						return;
					}
					$('#'+where).append(result);
				}
			});
		}
		function load_more_gd(current,where,stt){
			var fname = 'load_more_gd';
			var x = current+1;
			$('#loadmorebtngd').attr('onclick','load_more_gd('+x+',`'+where+'`,`'+stt+'`)');
			$.ajax({
				url : "for-ajax.php",
				type : "get",
				dataType:"text",
				data : {
					fname, current,stt
				},
				success : function (result){
					if(result.search('hetcmnrdungbamnua') != -1){
						alert("Đã hết mục để hiển thị!");
						return;
					}
					$('#'+where).append(result);
				}
			});
		}
	</script>
</head>
<body>
	<div class="container-fluid">
		<h2>9XWATCH - Trang quản trị dành cho admin</h2>
		<h3 id="big-error"></h3>
		<div role="tabpanel">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
					<a href="#sanpham" aria-controls="home" role="tab" data-toggle="tab">Sản phẩm</a>
				</li>
				<li role="presentation">
					<a href="#thanhvien" aria-controls="tab" role="tab" data-toggle="tab">Thành viên</a>
				</li>
				<li role="presentation">
					<a href="#giaodich" aria-controls="tab" role="tab" data-toggle="tab">Giao dịch</a>
				</li>
				<li role="presentation">
					<a href="#danhmuc" aria-controls="tab" role="tab" data-toggle="tab">Danh mục</a>
				</li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="sanpham">
					<div class="container-fluid">
						<h3>Danh sách sản phẩm</h3>
						<span class="glyphicon glyphicon-plus btn btn-success pull-right" id="addspbtn" style="z-index: 2;"></span>
						<div class="container-fluid">
							<div id='sua_sp-area'>
								<h4>Sửa Sản Phẩm</h4>
								<label>Tên sản phẩm</label>
								<input type="text" id='tensp-edit' class="form-control">
								<label>Giá</label>
								<input type="text" id='gia-edit' class="form-control">
								<label>Bảo hành</label>
								<input type="text" id='baohanh-edit' class="form-control">
								<label>Khuyến mãi</label>
								<input type="text" id='khuyenmai-edit' class="form-control">
								<label>Tình trạng</label>
								<input type="text" id='tinhtrang-edit' class="form-control"><br>
								<span class="btn btn-success" id="edit_sp_btn">Xong</span>
								<span class="btn btn-default" onclick="$('#sua_sp-area').hide(300)">Hủy</span>
							</div>

							<table class="table table-hover" id="tbl-sanpham-list">
								<?php require_once 'function.php'; product_list(); ?>
								<div class="container-fluid text-center lmbtnctn">
									<button onclick="load_more(0,'body-sp-list','sp')" id="loadmorebtn">Load more</button>
								</div>
							</table>
							
						</div>
						<!-- VÙNG LÀM VIỆC -->
						<div class="work-space">
							<!-- Thêm sản phẩm -->
							<div id="add-pr">
								<h3>Thêm sản phẩm</h3>
								<table class="table table-hover">
									<thead>
										<tr>
											<th>ĐẶC ĐIỂM</th><th>GIÁ TRỊ</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><label>Tên</label></td>
											<td><input type="text" class="form-control" id="tensp"></td>
										</tr>
										<tr>
											<td><label>Giá</label></td>
											<td><input type="text" class="form-control" id="gia"></td>
										</tr>
										<tr>
											<td><label>Bảo hành</label></td>
											<td><input type="text" class="form-control" id="baohanh"></td>
										</tr>
										<tr>
											<td><label>Trọng lượng</label></td>
											<td><input type="text" class="form-control" id="trongluong"></td>
										</tr>
										<tr>
											<td><label>Chất liệu</label></td>
											<td><input type="text" class="form-control" id="chatlieu"></td>
										</tr>
										<tr>
											<td><label>Chống nước</label></td>
											<td>
												<select class="form-control" id="chongnuoc">
													<option value="1">Có</option>
													<option value="0">Không</option>
												</select>
											</td>
										</tr>
										<tr>
											<td><label>Năng lượng</label></td>
											<td><input type="text" class="form-control" id="nangluong"></td>
										</tr>
										<tr>
											<td><label>Loại bảo hành</label></td>
											<td><input type="text" class="form-control" id="loaibh"></td>
										</tr>
										<tr>
											<td><label>Kích thước (d x r x c) (cm)</label></td>
											<td><input type="text" class="form-control" id="kichthuoc"></td>
										</tr>
										<tr>
											<td><label>Màu</label></td>
											<td><input type="text" class="form-control" id="mau"></td>
										</tr>
										<tr>
											<td><label>Dành cho</label></td>
											<td><input type="text" class="form-control" id="danhcho"></td>
										</tr>
										<tr>
											<td><label>Phụ kiện</label></td>
											<td><input type="text" class="form-control" id="phukien"></td>
										</tr>
										<tr>
											<td><label>Khuyến mãi</label></td>
											<td><input type="text" class="form-control" id="khuyenmai"></td>
										</tr>
										<tr>
											<td><label>Tình trạng</label></td>
											<td><input type="text" class="form-control" id="tinhtrang"></td>
										</tr>
										<tr>
											<td><label>Loại</label></td>
											<td>
												<?php require_once 'function.php'; list_type_pr_for_add(); ?>
											</td>
										</tr>
										<tr>
											<td><label>Link ảnh</label></td>
											<td><input type="text" class="form-control" id="anhchinh"></td>
										</tr>
										<tr>
											<td>
												<span onclick="them_sp()" class="btn btn-success">Thêm</span>
												<span class="btn btn-default" onclick="$('#add-pr').toggle(300);$('#tbl-sanpham-list').toggle(300);">Hủy</span>
												<span id="sp_error"></span>
											</td>
										</tr>
									</tbody>
								</table>
							</div>

							<!-- Danh sách sản phẩm -->


						</div>
					</div>
				</div>



				<!-- THÀNH VIÊN -->
				<div role="tabpanel" class="tab-pane" id="thanhvien">
					<h3>Danh sách thành viên</h3>
					<span class="btn btn-success" id="add-admin-btn"><i class="glyphicon glyphicon-plus"></i> Thêm admin</span>
					<div id="add-admin-area" class="form-inline">
						<h3>Thêm Admin</h3>
						<label>Tên:</label>
						<input type="text" class="form-control" id="admin-name">

						<label>Tên tài khoản:</label>
						<input type="text" class="form-control"  id="admin-username">

						<label>Mật khẩu:</label>
						<input type="password" class="form-control" id="admin-password">

						<span class="btn btn-success" onclick="them_admin()">Tạo</span>
						<span class="btn btn-default" onclick="$('#add-admin-area').toggle(300)">Hủy</span><br>
					</div>
					<div class="container-fluid">
						<table class="table table-hover" id="tbl-thanhvien-list">
							<?php require_once 'function.php'; member_list(); ?>
						</table>
					</div>
				</div>



				<!-- GIAO DỊCH -->
				<div role="tabpanel" class="tab-pane" id="giaodich">
					<h3>DANH SÁCH GIAO DỊCH</h3>
					<span class="btn btn-info" onclick="list_chuagh()">Chưa giao hàng</span>
					<span class="btn btn-info" onclick="list_dagh()">Đã giao hàng</span>
					<span class="btn btn-info" onclick="list_tatcagh()">Tất cả</span>
					<h4><b>Sắp xếp theo: </b><span id="loai_gd">Chưa giao hàng</span></h4>
					<div class="container-fluid" style="padding-bottom: 20px;">
						<table class="table table-hover" id="tbl-giaodich-list">
							<?php require_once 'function.php'; exchange_list(); ?>
						</table>
					</div>
				</div>



				<!-- DANH MỤC -->
				<div role="tabpanel" class="tab-pane" id="danhmuc">
					<h3>DANH MỤC SẢN PHẨM</h3>
					<div class="container">
						<div class="form-inline" id="add-dm">
							<h3>Thêm Danh Mục</h3>
							<label>Tên danh mục:</label>
							<input type="text" class="form-control" id="tendm">

							<label>Xuất xứ</label>
							<input type="text" class="form-control" id="xuatsu">

							<span class="btn btn-success" onclick="them_dm()">Thêm</span>
							<span class="btn btn-default" onclick="$('#add-dm').toggle(300);">Hủy</span>
						</div>

						<table class="table table-hover">
							<?php require_once 'function.php'; type_list(); ?>
							<h3 class="glyphicon glyphicon-plus btn btn-success pull-right" id="adddmbtn"></h3>
						</table>

					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
