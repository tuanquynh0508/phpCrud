<?php
include 'libs/config.php';

use libs\classes\DBAccess;
use libs\classes\FlashMessage;

$oFlashMessage = new FlashMessage();
$oDBAccess = new DBAccess();

$keyword = '';
if(isset($_GET['keyword'])) {
	$keyword = $_GET['keyword'];
}

$where = '';
if(!empty($keyword)) {
$where = "WHERE title LIKE '%$keyword%' OR slug LIKE '%$keyword%'";
}

if(isset($_GET['action']) && isset($_GET['id']) && $_GET['action']=='delete'){
	$oDBAccess->deleteById('tbl_category', $_GET['id']);
	$oFlashMessage->setFlashMessage('warning', 'Đã xóa bản ghi có id là '.$_GET['id']);
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
$countRecord = intval($oDBAccess->scalarBySQL("SELECT COUNT(*) FROM tbl_category ".$where));
$maxPage = ceil($countRecord/$perpage);

//Get list
$categories = $oDBAccess->findAllBySql("SELECT * FROM tbl_category $where ORDER BY created_at DESC LIMIT $offset, $perpage");

function addPageToQueryString($key, $value)
{
	$params = array();
	$_GET[$key] = $value;
	foreach($_GET as $key => $value) {
		$params[] = $key.'='.$value;
	}
	return implode('&', $params);
}
?>
<?php include "libs/include/header.inc.php"; ?>

<h2>Quản lý Danh mục</h2>
<p><a href="admin_category_form.php">Thêm mới</a></p>

<?php include "libs/include/flash_message.inc.php"; ?>

<?php if(!empty($categories)): ?>
<form id="frmSearch" action="" method="get">
<p>
	<input type="text" name="keyword" value="<?= $keyword ?>" placeholder="Từ khóa"/>
	<img src="img/search.png" class="btnSearch"/>
	<a href="admin_category.php"><img src="img/refresh.png"></a>
</p>
</form>

<table border="1">
	<thead>
		<tr>
			<th>#</th>
			<th>Danh mục</th>
			<th>Slug</th>
			<th>Trạng thái</th>
			<th>Thao tác</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($categories as $item): ?>
		<tr>
			<th><?= $item->id ?></th>
			<td><?= $item->title ?></td>
			<td><?= $item->slug ?></td>
			<td align="center">
				<?php if($item->is_active == 1): ?>
				<img src="img/check.png"/>
				<?php else: ?>
				<img src="img/close.png"/>
				<?php endif; ?>
			</td>
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
	<a href="admin_category.php?<?= addPageToQueryString('page', $prevPage) ?>">&lt;</a>
	<?php for($p = 1; $p <= $maxPage; $p++): ?>
		<?php if($p === $page): ?>
		<span><?= $p?></span>
		<?php else: ?>
		<a href="admin_category.php?<?= addPageToQueryString('page', $p) ?>"><?= $p?></a>
		<?php endif; ?>
	<?php endfor; ?>
	<a href="admin_category.php?<?= addPageToQueryString('page', $nextPage) ?>">&gt;</a>
</p>
<?php endif; ?>

<?php include "libs/include/footer.inc.php"; ?>