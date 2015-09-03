<?php
include 'libs/config.php';

use libs\classes\DBAccess;
use libs\classes\FlashMessage;

$oFlashMessage = new FlashMessage();
$oDBAccess = new DBAccess();
$isAddNew = true;
$category = null;
$id = 0;

$formError = array();
$fieldsRequired = array('title','slug');

if(isset($_GET['id'])) {
	$isAddNew = false;
	$id = $_GET['id'];
	$category = $oDBAccess->findOneById('tbl_category', $id);
}

//Check POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$attributes = $_POST;

	if(!isset($attributes['is_active'])) {
			$attributes['is_active'] = 0;
	}

	//Validate input data
	foreach($attributes as $key => $value){
		if(in_array($key, $fieldsRequired) && empty($value)) {
			$formError[] = "Cần nhập giá trị $key";
		}
	}

	if(empty($formError)) {
		if($isAddNew) {
			//Add Record
			$attributes['created_at'] = date('Y-m-d H:i:s');
			$category = $oDBAccess->save('tbl_category', $attributes);
			$oFlashMessage->setFlashMessage('success', 'Thêm mới bản ghi thành công');
		} else {
			//Update Record
			$attributes['updated_at'] = date('Y-m-d H:i:s');
			$category = $oDBAccess->save('tbl_category', $attributes, 'id');
			$oFlashMessage->setFlashMessage('success', 'Cập nhật bản ghi thành công');
		}
		header("Location: admin_category_form.php?id=".$category->id);
		exit;
	}
}
?>
<?php include "libs/include/header.inc.php"; ?>

<h2>Quản lý Danh mục - <?= ($isAddNew)?'Thêm mới':'Cập nhật' ?></h2>

<?php include "libs/include/flash_message.inc.php"; ?>

<form action="" method="post">
<?php if(!$isAddNew): ?>
<input type="hidden" name="id" value="<?= $id ?>"/>
<?php endif; ?>

<?php if(!empty($formError)): ?>
<ul class="errors">
	<?php foreach ($formError as $error): ?>
	<li><?= $error ?></li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>

<table>
	<tbody>
		<!--<tr>
			<th align="right">Danh mục cha:</th>
			<td>
				<select name="parent_id">
					<option value="0">-- Lựa chọn danh mục cha --</option>
				</select>
			</td>
		</tr>-->
		<tr>
			<th align="right">Tiêu đề <span class="required">*</span>:</th>
			<td>
				<input type="text" name="title" value="<?= (null !== $category)?$category->title:'' ?>" placeholder="Tiêu đề" size="50"/>
			</td>
		</tr>
		<tr>
			<th align="right">Slug <span class="required">*</span>:</th>
			<td>
				<input type="text" name="slug" value="<?= (null !== $category)?$category->slug:'' ?>" placeholder="Slug" size="50"/>
			</td>
		</tr>
		<tr>
			<th align="right">Trạng thái:</th>
			<td>
				<label>
					<input type="checkbox" name="is_active" value="1" <?= (null !== $category && $category->is_active==1)?'checked="checked"':'' ?>/>
					Hoạt động
				</label>
			</td>
		</tr>
		<?php if(!$isAddNew): ?>
		<tr>
			<th align="right">Ngày tạo:</th>
			<td><?= $category->created_at ?></td>
		</tr>
		<tr>
			<th align="right">Cập nhật:</th>
			<td><?= $category->updated_at ?></td>
		</tr>
		<?php endif; ?>
		<tr>
			<th align="right"></th>
			<td>
				<button type="submit"><?= ($isAddNew)?'Thêm mới':'Cập nhật' ?></button>
				<?php if(!$isAddNew): ?><a href="admin_category_form.php">Thêm mới</a> | <?php endif; ?>
				<a href="admin_category.php">Danh sách</a>
				<p>Các trường có dấu <span class="required">*</span> là bắt buộc phải nhập.</p>
			</td>
		</tr>
	</tbody>
</table>
</form>

<?php include "libs/include/footer.inc.php"; ?>