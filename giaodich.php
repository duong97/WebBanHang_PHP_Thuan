<?php 
session_start();
require_once 'backend-index.php';
require_once 'layout/second_header.php';
$ten = $quan = $dc = $sodt = $money = $sl = "";
if(isset($_POST['ten'])){
	$ten = $_POST['ten'];
}
if(isset($_POST['quan'])){
	$quan = $_POST['quan'];
}
if(isset($_POST['dc'])){
	$dc = $_POST['dc'];
}
if(isset($_POST['sodt'])){
	$sodt = $_POST['sodt'];
}
if(isset($_POST['sl'])){
	$sl = $_POST['sl'];
}

if($ten == "" || $quan == "" || $dc == "" ||$sodt == ""){
	echo "Không được để trống bất kỳ ô nào!";
	require_once 'layout/second_footer.php';
	return 0;
}

date_default_timezone_set('Asia/Ho_Chi_Minh');
$now = date("Y-m-d h:i:s");
$conn = connect();
mysqli_set_charset($conn, 'utf8');
/*$sql = "SELECT * FROM sanpham sp WHERE ";
$result = mysqli_query($conn, $sql);*/
for($i = 0; $i < count($sl); $i++){
	if($sl[$i] < 0){
		echo "<h3 style='color: red; padding: 30px;'>Số lượng tối thiểu phải bằng 0</h3>";
		require_once 'layout/second_footer.php';
		return 0;
	}
	$x = str_replace(' ','',$_SESSION['cost'][$i]);
	$money += $sl[$i]*$x;
	
}
if($money == 0){
	echo "<h3 style='color: red; padding: 30px;'>Không có sản phẩm nào được đặt!</h3>";
	require_once 'layout/second_footer.php';
	return 0;
}
?>

<div class="row">
	<div class="col-sm-12">
		<div style="text-align: center;">
			<h3 style="color: green;">Đơn hàng của quý khách đã được đặt <b>THÀNH CÔNG</b>, cảm ơn quý khách!</h3>
			<i>Quý khách sẽ sớm nhậm được cuộc gọi xác nhận của chúng tôi, giá trị đơn hàng này là <b><?php echo number_format($money, 0, ","," ") ?> VND</b> và sẽ được thanh toán sau khi nhận hàng!</i>
			<a href="index.php">Quay lại trang chủ</a>
			<img src="images/tks4buying.png">
		</div>
		
	</div>
</div>

<?php
$user_id = "";
if($_SESSION['rights'] == "user"){
	$user_id = $_SESSION['user']['id'];
}
$sql = "INSERT INTO giaodich VALUES ('',0,'".$user_id."','".$ten."','".$quan."','".$dc."','".$sodt."','".$money."','".$now."')";
if(!mysqli_query($conn, $sql)){
	echo "Đã xảy ra một lỗi nhỏ trong quá trình đặt hàng, vui lòng đặt hàng lại!";
}
$sql = "SELECT magd FROM giaodich WHERE magd = LAST_INSERT_ID()";
$result = mysqli_query($conn, $sql);
if(!$result){echo "Lỗi không xác định, nhưng không sao, đơn hàng của bạn đã được đặt thành công!";}
while($row = mysqli_fetch_assoc($result)){
	$last_magd = $row['magd'];
}
$sql_multi = array();
$buynow = "";
if(isset($_SESSION['buynow'])){
	$buynow = $_SESSION['buynow'];
	$sql = "INSERT INTO chitietgd VALUES ('".$last_magd."','".$buynow."','".$sl[0]."')";
	require_once 'layout/second_footer.php';
	return 0;
}

if($_SESSION['rights'] == "user"){
	$new_masp = $_SESSION['user_cart'];
} else{
	$new_masp = $_SESSION['client_cart'];
}

array_shift($new_masp);
for($i = 0; $i < count($new_masp); $i++){
	$sql_multi[] = "INSERT INTO chitietgd VALUES ('".$last_magd."','".$new_masp[$i]."','".$sl[$i]."')";
}
for($i = 0; $i < count($sl); $i++){
	$result = mysqli_query($conn, $sql_multi[$i]);
}
require_once 'layout/second_footer.php';
?>
