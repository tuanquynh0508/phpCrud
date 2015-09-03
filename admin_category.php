<?php
include 'libs/config.php';

use libs\classes\DBAccess;

$oDBAccess = new DBAccess();

if(isset($_GET['action']) && isset($_GET['id']) && $_GET['action']=='delete'){
	$oDBAccess->deleteById('tbl_category', $_GET['id']);
	header("Location: admin_category.php");
	exit;
}

//Pagination calculator
$page = 1;
if(isset($_GET['page'])) {
	$page = intval($_GET['page']);
	$page = ($page > 0)?$page:1;
}
$perpage = 10;
$offset = ($page-1) * $perpage;
$countRecord = intval($oDBAccess->scalarBySQL("SELECT COUNT(*) FROM tbl_category"));
$maxPage = ceil($countRecord/$perpage);

//Get list
$categories = $oDBAccess->findAllBySql("SELECT * FROM tbl_category ORDER BY created_at DESC LIMIT $offset, $perpage");
?>
<?php include "libs/include/header.inc.php"; ?>

<h2>Quản lý Danh mục</h2>
<p><a href="admin_category_form.php">Thêm mới</a></p>

<?php if(!empty($categories)): ?>
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
		<?php foreach ($categories as $item): ?>
		<tr>
			<th><?= $item->id ?></th>
			<td><?= $item->title ?></td>
			<td><?= $item->slug ?></td>
			<td>root</td>
			<td>
				<a href="admin_category_form.php?id=<?= $item->id ?>" class="btnEdit">Sửa</a> |
				<a href="admin_category.php?id=<?= $item->id ?>&action=delete" class="btnDelete">Xóa</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>

<?php if($maxPage > 1): ?>
<?php
$prevPage = ($page-1 > 0)?$page-1:1;
$nextPage = ($page+1 <= $maxPage)?$page+1:$maxPage;
?>
<p class="paginationLink">
	<a href="admin_category.php?page=<?= $prevPage ?>">&lt;</a>
	<?php for($p = 1; $p <= $maxPage; $p++): ?>
		<?php if($p === $page): ?>
		<span><?= $p?></span>
		<?php else: ?>
		<a href="admin_category.php?page=<?= $p ?>"><?= $p?></a>
		<?php endif; ?>
	<?php endfor; ?>
	<a href="admin_category.php?page=<?= $nextPage ?>">&gt;</a>
</p>
<?php endif; ?>

<?php include "libs/include/footer.inc.php"; ?>