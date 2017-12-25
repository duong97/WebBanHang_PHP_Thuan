<?php 
require_once 'layout/second_header.php' ;
require_once 'backend-index.php';
$masp = $q = "";
$_SESSION['cost'] = "";
if(isset($_GET['masp'])){
	$masp = $_GET['masp'];
	$_SESSION['buynow'] = $masp;
}
if(isset($_GET['q'])){
	$q = $_GET['q'];
	if($q == 'multi'){
		if($_SESSION['rights'] == "default"){
			if(isset($_SESSION['client_cart']) && count($_SESSION['client_cart']) > 1){
				$tmpArr = $_SESSION['client_cart'];
				array_shift($tmpArr);
				$x = '('.implode(',',$tmpArr).')';
				$sql = "SELECT * FROM sanpham WHERE masp in ".$x."";
			}else {
				echo "<script>alert('Giỏ hàng trống!')</script>";
				return 0;
			}
		} else {
			$tmpArr = $_SESSION['user_cart'];
			array_shift($tmpArr);
			$x = '('.implode(',',$tmpArr).')';
			$sql = "SELECT * FROM sanpham WHERE masp in ".$x."";
		}
	} elseif($q = 'buylikepr'){
		$tmpArr = $_SESSION['like'];
		array_shift($tmpArr);
		$x = '('.implode(',',$tmpArr).')';
		$sql = "SELECT * FROM sanpham WHERE masp in ".$x."";
	} else {
		$_SESSION['buynow'] = $masp;
	}
} else {
	$sql = "SELECT * FROM sanpham WHERE masp = '".$masp."'";
}


$conn = connect();
mysqli_set_charset($conn, 'utf8');

$result = mysqli_query($conn, $sql);

?>
<script type="text/javascript">window.onload = function() {tinh_tien() }</script>
<form action="giaodich.php" method="POST" role="form">
	<div class="container-fluid form" style="margin-top: -23px; padding: 20px">
		<div class="row">
			<div class="col-lg-3"></div>
			<div class="col-lg-6">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>ẢNH</th><th>TÊN SẢN PHẨM</th><th>ĐƠN GIÁ</th><th>SỐ LƯỢNG</th>
						</tr>
					</thead>
					<tbody>
						<?php while ($row = mysqli_fetch_assoc($result)) { ?>


						<tr>
							<td><img src="<?php echo $row['anhchinh'] ?>" style="width: 70px"></td>
							<td><?php echo $row['tensp'] ?></td>
							<td class="cost" data-val="<?php echo $row['gia'] ?>">
								<?php echo $row['gia']; $_SESSION['cost'][] = $row['gia']; ?></td>
								<td width="30px"><input type="number" name="sl[]" value='1' min="0" onchange="tinh_tien()"></td>
							</tr>

							<?php }

							?>
							<tr style="color: green; font-size: 18px;"><th colspan="2">Tổng tiền</th><th id="tong_tien"></th><th>VND</th></tr>
						</tbody>
					</table>
					<legend>Thông tin giao hàng</legend>
					<p class="errorMes">Giao hàng tận nhà chỉ áp dụng ở TP HCM</p>
					<div class="form-group">
						<label for="">Tên: </label>
						<input type="text" class="form-control" id="s_ten" name="ten" value="<?php 
						if($_SESSION['rights'] == 'user'){
							echo $_SESSION['user']['ten'];
						}
						?>">
					</div>
					<div class="form-group">
						<label for="">Quận: </label>
						<select class="form-control" name="quan" id="s_quan">
							<option  value="q1">Quận 1</option>
							<option  value="q2">Quận 2</option>
							<option  value="q3">Quận 3</option>
							<option  value="q4">Quận 4</option>
							<option  value="q5">Quận 5</option>
							<option  value="q6">Quận 6</option>
							<option  value="q7">Quận 7</option>
							<option  value="q8">Quận 8</option>
							<option  value="q9">Quận 9</option>
							<option  value="q10">Quận 10</option>
							<option  value="q11">Quận 11</option>
							<option  value="q12">Quận 12</option>
							<option  value="qtd">Quận Thủ Đức</option>
							<option  value="qbt">Quận Bình Thạnh</option>
							<option  value="qgv">Quận Gò Vấp</option>
							<option  value="qtb">Quận Tân Bình</option>
							<option  value="qbt">Quận Bình Tân</option>
						</select>
					</div>
					<div class="form-group">
						<label for="">Địa chỉ: </label>
						<input type="text" class="form-control" name="dc" id="s_dc"  value="<?php 
						if($_SESSION['rights'] == 'user'){
							echo $_SESSION['user']['diachi'];
						}
						?>">
					</div>
					<div class="form-group">
						<label for="">Số điện thoại: </label>
						<input type="text" class="form-control" name="sodt" id="s_sdt" value="<?php 
						if($_SESSION['rights'] == 'user'){
							echo $_SESSION['user']['sodt'];
						}
						?>">
					</div>
					<button onclick="check_before_submit()" class="btn btn-primary" type="submit">Đặt Hàng</button><br><br>
				</form>
			</div>
		</div>
	</div>

	<?php require_once 'layout/second_footer.php' ?>