<?php
include 'libs/config.php';

use libs\classes\DBAccess;

$oDBAccess = new DBAccess();
?>
<!DOCTYPE html>
<html>
		<head>
				<title>TODO supply a title</title>
				<meta charset="UTF-8">
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
		</head>
		<body>
				<h1>Quản lý Danh mục</h1>
				<table border="1">
						<thead>
								<tr>
										<th>#</th>
										<th>Danh mục</th>
										<th>Slug</th>
										<th>Danh mục cha</th>
										<th>Thao tác</th>
								</tr>
						</thead>
						<tbody>
								<tr>
										<th>1</th>
										<td>Danh mục 1</td>
										<td>danh-muc-1</td>
										<td>root</td>
										<td>
												<a href="#1" class="btnEdit">Sửa</a> |
												<a href="#1" class="btnDelete">Xóa</a>
										</td>
								</tr>
						</tbody>
				</table>
				<script src="js/jquery-2.1.4.min.js"></script>
		</body>
</html>


