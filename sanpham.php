<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
</div>
<?php
require_once 'backend-index.php';
$masp = "";
if(isset($_GET['masp'])){
	$masp = $_GET['masp'];
}
$conn = connect();
mysqli_set_charset($conn, 'utf8');
$sql = "SELECT * FROM sanpham sp, danhmucsp dm WHERE sp.madm = dm.madm AND masp = '".$masp."'";
$result = mysqli_query($conn, $sql);
$loaisp = "";
while ($row = mysqli_fetch_assoc($result)) {
	$loaisp = $row['madm'];
	?>
	<div class="container-fluid form" style="margin-top: -23px; padding: 20px">
		<div class="row">
			<div class="col-sm-12">
				<div class="main-prd">
					<img src="<?php echo $row['anhchinh'] ?>" class="main-prd-img">
					<div class="basic-info">
						<h2><?php echo $row['tensp'] ?></h2>
						<span class="main-prd-price"><?php echo $row['gia'] ?> VND</span>
						<h4><b>Thông tin cơ bản</b></h4>
						<ul>
							<li>Xuất xứ: <?php echo $row['xuatsu'] ?></li>
							<li>Màu sắc: <?php echo $row['mau'] ?></li>
							<li>Năng lượng sử dụng: <?php echo $row['nangluong'] ?></li>
							<li>Chống nước: <?php if($row['chongnuoc']){echo "Có";} else {echo "Không";} ?></li>
							<li>Bảo hành: <?php echo $row['baohanh'] ?> tháng</li>
							<li><span class="km">Khuyến mãi: <?php echo $row['khuyenmai'] ?> %</span></li>
							<br><a class="btn btn-primary" href="order.php?masp=<?php echo $masp ?>">Mua ngay</a>
						</ul>
					</div>
				</div>

				<div style="clear: both;"></div>

				<div class="introduce-prd">
					<h3>Thông số kỹ thuật</h3>
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Đặc điểm</th><th>Giá trị</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Bảo hành</td><td><?php echo $row['baohanh'] ?> tháng</td>
							</tr>
							<tr>
								<td>Trọng lượng(g)</td><td><?php echo $row['trongluong'] ?></td>
							</tr>
							<tr>
								<td>Chất liệu</td><td><?php echo $row['chatlieu'] ?></td>
							</tr>
							<tr>
								<td>Loại hình bảo hành</td><td><?php echo $row['loaibh'] ?></td>
							</tr>
							<tr>
								<td>Kích thước (d x r x c) (cm)</td><td><?php echo $row['kichthuoc'] ?></td>
							</tr>
							<tr>
								<td>Màu</td><td><?php echo $row['mau'] ?></td>
							</tr>
							<tr>
								<td>Dành cho</td><td><?php echo $row['danhcho'] ?></td>
							</tr>
							<tr>
								<td>Phụ kiện đi kèm</td><td><?php echo $row['phukien'] ?></td>
							</tr><tr>
								<td>Khuyễn mãi/ Quà tặng</td><td><?php echo $row['khuyenmai'] ?> %</td>
							</tr>
							<tr>
								<td>Tình trạng</td><td><?php echo $row['tinhtrang'] ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>