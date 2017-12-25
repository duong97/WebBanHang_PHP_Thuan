<?php 
$conn;
function connect(){
	$conn = mysqli_connect('localhost','root','','qlbh') or die('Không thể kết nối!');
	/*$conn = mysqli_connect("localhost","k2739nvdu_qlbh","cuchuoi258","k2739nvdu_qlbh") or die('Không thể kết nối!');*/
	return $conn;
}
function disconnect($conn){
	mysqli_close($conn);
}
//Danh sach thanh vien
function member_list(){
	$conn = connect();
	mysqli_set_charset($conn, 'utf8');
	$sql = "SELECT * FROM thanhvien ORDER BY date DESC";
	$result = mysqli_query($conn, $sql); ?>

	<thead>
		<tr>
			<th>ID</th> <th>Tên</th> <th>Tên tài khoản</th>
			<th>Mật khẩu</th> <th>Địa chỉ</th> <th>Số dt</th>
			<th>Email</th> <th>Ngày tham gia</th> <th>Quyền</th>
			<th></th>
		</tr>
	</thead>
	<tbody>

		<?php while ($row = mysqli_fetch_assoc($result)){?>


		<tr>
			<td><?php echo $row['id'] ?></td> <td><?php echo $row['ten'] ?></td>
			<td><?php echo $row['tentaikhoan'] ?></td> <td>*****</td>
			<td><?php echo $row['diachi'] ?></td> <td><?php echo $row['sodt'] ?></td>
			<td><?php echo $row['email'] ?></td> <td><?php echo $row['date'] ?></td>
			<td><?php if($row['quyen'])echo "Admin"; else echo "User";  ?></td>
			<td><span class="btn btn-danger" onclick="xoa_taikhoan('<?php echo $row["id"] ?>')">Xóa</span></td>
		</tr>

		<?php }	?>
	</tbody>
	<?php
	disconnect($conn);
}
//Danh sach giao dich
function exchange_list(){
	$conn = connect();
	mysqli_set_charset($conn, 'utf8');
	$sql = "SELECT * FROM giaodich WHERE tinhtrang = 0 LIMIT ".$_SESSION['limit']."";
	$i = 1;
	$result = mysqli_query($conn, $sql); ?>

	<thead>
		<tr>
			<th>STT</th> <th>Tình trạng</th> <th>Tên</th>
			<th>Quận</th> <th>Địa chỉ</th> <th>Số DT</th>
			<th>Tổng tiền</th> <th>Ngày</th> <th>isDone</th>
		</tr>
	</thead>
	<tbody id="body-gd-list">

		<?php while ($row = mysqli_fetch_assoc($result)){?>


		<tr>
			<td><?php echo $i++ ?></td>
			<td><?php if($row['tinhtrang']) echo "<h4 class='label label-success'>Đã giao hàng</h4>"; else echo "<h4 class='label label-danger'>Chưa giao hàng</h4>";  ?></td>
			<td><?php echo $row['user_name'] ?></td> <td><?php echo $row['user_dst'] ?></td>
			<td><?php echo $row['user_addr'] ?></td> <td><?php echo $row['user_phone'] ?></td>
			<td><?php echo $row['tongtien'] ?></td> <td><?php echo $row['date'] ?></td>
			<td>
				<?php if($row['tinhtrang'] == '0'){ ?>
				<span class="btn btn-success" onclick="xong('<?php echo $row['magd'] ?>')">Xong</span>
				<?php } ?>
			</td>
		</tr>

		<?php }	?>
		<div class="container-fluid text-center lmbtnctn">
			<button onclick="load_more_gd(0, 'body-gd-list','chuagd')" id="loadmorebtngd">Load more</button>
		</div>
	</tbody>
	
	<?php
	disconnect($conn);
}
//Danh sach danh muc san pham
function type_list(){
	$conn = connect();
	mysqli_set_charset($conn, 'utf8');
	$sql = "SELECT * FROM danhmucsp";
	$result = mysqli_query($conn, $sql); ?>

	<thead>
		<tr>
			<th>STT</th>
			<th>Tên danh mục</th><th>Xuất sứ</th>
			<th></th>
		</tr>
	</thead>
	<tbody>

		<?php while ($row = mysqli_fetch_assoc($result)){?>


		<tr>
			<td><?php echo $row['madm'] ?></td> <td><?php echo $row['tendm'] ?></td>
			<td><?php echo $row['xuatsu'] ?></td>
			<td>
				<span class="btn btn-danger" onclick="xoa_dm('<?php echo $row['madm'] ?>')">Xóa</span>
			</td>
		</tr>

		<?php }	?>
	</tbody>

	<?php
}
//Danh sach san pham
function product_list(){
	$conn = connect();
	mysqli_set_charset($conn, 'utf8');
	$sql = "SELECT * FROM sanpham s, danhmucsp d WHERE s.madm = d.madm ORDER BY ngay_nhap DESC LIMIT ".$_SESSION['limit']."";
	$i = 1;
	$result = mysqli_query($conn, $sql); ?>
	<thead>
		<tr>
			<th>STT</th>
			<th>Tên</th> <th>Giá</th> <th>Bảo Hành</th>
			<th>Trọng lượng</th> <th>Chất liệu</th> <th>Chống nước</th>
			<th>Năng lượng</th> <th>Loại bảo hành</th> <th>Kích thước</th>
			<th>Màu</th> <th>Dành cho</th> <th>Phụ kiện</th>
			<th>Khuyến Mãi</th> <th>Tình trạng</th> <th>Loại</th>
			<th>Ảnh</th> <th>Ngày nhập</th> <th></th> <th></th>
		</tr>
	</thead>
	<tbody id='body-sp-list'>

		<?php while ($row = mysqli_fetch_assoc($result)){?>


		<tr>
			<td><?php echo $i++ ?></td> <td><?php echo $row['tensp'] ?></td>
			<td><?php echo $row['gia'] ?></td> <td><?php echo $row['baohanh'] ?></td>
			<td><?php echo $row['trongluong'] ?></td> <td><?php echo $row['chatlieu'] ?></td>
			<td><?php echo $row['chongnuoc'] ?></td> <td><?php echo $row['nangluong'] ?></td>
			<td><?php echo $row['loaibh'] ?></td> <td><?php echo $row['kichthuoc'] ?></td>
			<td><?php echo $row['mau'] ?></td> <td><?php echo $row['danhcho'] ?></td>
			<td><?php echo $row['phukien'] ?></td> <td><?php echo $row['khuyenmai'] ?></td>
			<td><?php echo $row['tinhtrang'] ?></td> <td><?php echo $row['tendm'] ?></td>
			<td><img src="../<?php echo $row['anhchinh'] ?>"></td>
			<td><?php echo $row['ngay_nhap'] ?></td>
			<td><span onclick="display_edit_sanpham('<?php echo $row['masp'] ?>')"><a class="btn btn-warning" href="#sua_sp-area">Sửa</a></span></td>
			<td><span class="btn btn-danger" onclick="xoa_sp('<?php echo $row['masp'] ?>')">Xóa</span></td>
		</tr>

		<?php }	?>
	</tbody>
	<?php
}
//in ra cac loai sp
function list_type_pr_for_add(){
	$conn = connect();
	mysqli_set_charset($conn, 'utf8');
	$sql = "SELECT * FROM danhmucsp";
	?>	<select class="form-control" id="madm"> <?php
	$result = mysqli_query($conn, $sql); ?>
	<?php while ($row = mysqli_fetch_assoc($result)){?>
	<option value="<?php echo $row['madm'] ?>"><?php echo $row['tendm'] ?></option>
	<?php }	?>
</select>
<?php
}




?>