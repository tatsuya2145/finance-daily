<style>
	.fixed-header {
		position: sticky;
		top: 0;
		left: 0;
	}
</style>
<div class="app">
	<div class="app-wrapper">
		<div class="app-content pt-3 p-md-3 p-lg-4">
			<div id="layout-wrapper">
				<div class="container-fluid row">
					<h4>家計簿</h4>
					<div class="col-md-8" style="font-size: 0.8em;">
						<div class="card">
							<div class="card-header p-3">
								<div class="row">
									<div class="col-auto">
										<form id="category_form" action="" method="post">
											<select name="category_id" id="category" class="form-select">
												<option hidden>カテゴリー選択</option>
												<?php foreach ($categories as $data) : ?>
													<option value="<?= $data['category_id'] ?>" <?php if ($data['category_id'] == $category_id) : ?>selected<?php endif; ?>>
														<?= $data['category_name'] ?>
													</option>
												<?php endforeach; ?>
											</select>
										</form>
									</div>
									<div class="col-auto">
										<button id="add_modal" class="btn btn-success" style="color: white;" data-bs-toggle="modal" data-bs-target="#modal_form" <?php if (empty($category_id)) : ?>disabled<?php endif; ?>>
											<i class="fas fa-plus"></i>
										</button>
									</div>
								</div>
							</div>
							<div class="card-body table-responsive">
								<div class="gx-3" style="height: 600px">
									<table class="table table-bordered table-sm" style="table-layout: fixed;">
										<thead class="table-success fixed-header">
											<tr style="text-align:center;">
												<th width="15%">日付</th>
												<th width="9%">種類</th>
												<th width="20%">タイトル</th>
												<th width="17%">金額</th>
												<th width="30%">説明</th>
												<th width="9%">操作</th>
											</tr>
										</thead>
										<tbody>
											<?php if (!empty($finances)) : ?>
												<?php foreach ($finances as $data) : ?>
													<tr>
														<td class="text-center align-middle"><?= date("Y年n月j日", strtotime($data['finance_date'])); ?>(<?= weekName($data['finance_date']); ?>)</td>
														<td class="text-center align-middle">
															<b class="rounded-3" style="background-color:<?= $data['payment_type_color'] ?>; padding: 5px;">
																<?= $data['payment_type_name'] ?>
															</b>
														</td>
														<td class="align-middle"><?= $data['finance_title'] ?></td>
														<td class="fs-6 text-end align-middle">
															<?php if ($data['amount_type']) : ?>
																<b><?= number_format($data['amount']); ?>円</b>
															<?php else : ?>
																<i class="fas fa-caret-up " style="color:red;"></i><b style="color:red;"><?= number_format($data['amount']); ?>円</b>
															<?php endif; ?>
														</td>
														<td class="align-middle"><?= $data['description'] ?></td>
														<td class="text-center align-middle">
															<button id="detail" class="detail btn btn-outline-secondary me-1" data-finance_id=<?= $data['finance_id'] ?> data-bs-toggle="modal" data-bs-target="#modal_form">
																<i class="fas fa-eye"></i>
															</button>
															<?= recently($data['updated_at']) ?>
														</td>
													</tr>
												<?php endforeach; ?>
											<?php else : ?>
												<tr class="text-center">
													<td colspan="5">データが存在しません</td>
												</tr>
											<?php endif; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="card-header p-3 text-center">
								<h4>計</h4>
							</div>
							<div class="card-body">
								<table class="table table-bordered table-sm" style="font-size: 0.8em;">
									<thead class="table-success text-center fs-6">
										<tr>
											<th>種類</th>
											<th>収入</th>
											<th>支出</th>
											<th>合計</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$income_sub_total = 0;
										$expense_sub_total = 0;
										foreach ($sub_total as $data) :
											$income_sub_total  += $data['income'];
											$expense_sub_total += $data['expense'];
										?>
											<tr class="align-middle">
												<td class="text-center p-3" style="text-align:center;">
													<b class="rounded-3 " style="background-color:<?= $data['payment_type_color'] ?>; padding: 5px;">
														<?= $data['payment_type_name'] ?>
													</b>
												</td>
												<td class="text-end fs-6">
													<b><?= number_format($data['income']); ?>円</b>
												</td>
												<td class="text-end fs-6">
													<i class="fas fa-caret-up " style="color:red;"></i><b style="color:red;"><?= number_format($data['expense']); ?>円</b>
												</td>
												<td class="text-end fs-6" style="border-left: 2px #ccc solid">
													<?php $total = $data['income'] - $data['expense']; ?>
													<span <?php if ($total < 0) : ?> style="color: red" <?php endif; ?>>
														<b><?= number_format($total); ?>円</b>
													</span>
												</td>
											</tr>
										<?php endforeach; ?>
										<tr class="align-middle" style="border-top: 3px #ccc solid">
											<td class="text-center">
												<strong class="fs-6">小計</strong>
											</td>
											<td class="text-end fs-6">
												<b><?= number_format($income_sub_total); ?>円</b>
											</td>
											<td class="text-end fs-6">
												<i class="fas fa-caret-up " style="color:red;"></i><b style="color:red;"><?= number_format($expense_sub_total); ?>円</b>
											</td>
											<td class="text-end fs-6" style="border-left: 2px #ccc solid">
												<?php $total = $income_sub_total - $expense_sub_total; ?>
												<span <?php if ($total < 0) : ?> style="color: red" <?php endif; ?>>
													<b><?= number_format($total); ?>円</b>
												</span>

											</td>
										</tr>
										<tr class="align-middle text-center fs-6">
											<td class="table-primary" colspan="4"><strong>総計</strong></td>
										</tr>
										<?php
										$income_grand_total = 0;
										$expense_grand_total = 0;
										foreach ($grand_total as $data) :
											$income_grand_total  += $data['income'];
											$expense_grand_total += $data['expense'];
										?>
											<tr class="align-middle">
												<td class="text-center p-3" style="text-align:center;">
													<b class="rounded-3 " style="background-color:<?= $data['payment_type_color'] ?>; padding: 5px;">
														<?= $data['payment_type_name'] ?>
													</b>
												</td>
												<td class="text-end fs-6">
													<b><?= number_format($data['income']); ?>円</b>
												</td>
												<td class="text-end fs-6">
													<i class="fas fa-caret-up " style="color:red;"></i><b style="color:red;"><?= number_format($data['expense']); ?>円</b>
												</td>
												<td class="text-end fs-6" style="border-left: 2px #ccc solid">
													<?php $total = $data['income'] - $data['expense']; ?>
													<span <?php if ($total < 0) : ?> style="color: red" <?php endif; ?>>
														<b><?= number_format($total); ?>円</b>
													</span>
												</td>
											</tr>
										<?php endforeach; ?>
										<tr class="align-middle" style="border-top: 3px #ccc solid">
											<td class="text-center">
												<strong class="fs-6">合計</strong>
											</td>
											<td class="text-end fs-6">
												<b><?= number_format($income_grand_total); ?>円</b>
											</td>
											<td class="text-end fs-6">
												<i class="fas fa-caret-up " style="color:red;"></i><b style="color:red;"><?= number_format($expense_grand_total); ?>円</b>
											</td>
											<td class="text-end fs-6" style="border-left: 2px #ccc solid">
												<?php $total = $income_grand_total - $expense_grand_total; ?>
												<span <?php if ($total < 0) : ?> style="color: red" <?php endif; ?>>
													<b><?= number_format($total); ?>円</b>
												</span>

											</td>
										</tr>

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- モーダルview -->
<div class="modal fade" id="modal_form" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form>
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="modal_title" value=""></h4>
					<div class="ok_gif mb-5 mt-1">
						<img id="ok_gif" width="48px" src="<?= base_url('assets/images/ok.gif') ?>" class="position-absolute end-50  me-2">
					</div>
					<div class="error_icon mb-4">
						<img id="error_icon" src="<?= base_url('assets/images//error.png') ?>" class="position-absolute end-50 me-2">
					</div>
					<span class="position-absolute start-50 fs-6 mt-2 text-danger" id="error_message"></span>
				</div>
				<div class="modal-body mb-5">
					<div class="form-group mb-2">
						<label for="finance_date" class="label">日付</label>
						<span class="text-danger fs-4">*</span>
						<input id="finance_date" name="finance_date" class="form-control" type="date" placeholder="日付" value="">
					</div>


					<div class="form-group mb-2">
						<div class="row">
							<div class="col">
								<label for="payment_type" class="label">種類</label>
								<span class="text-danger fs-4">*</span>
								<select name="payment_type" id="payment_type" class="form-select ">
									<option value="">種類を選択</option>
									<?php foreach ($payment_types as $data) : ?>
										<option style="background-color:<?= $data['payment_type_color'] ?>;" value=<?= $data['payment_type_id'] ?>>
											<?= $data['payment_type_name'] ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col">
								<label for="amount_type" class="label">収支</label>
								<span class="text-danger fs-4">*</span>
								<select name="amount_type" id="amount_type" class="form-select">
									<option value="">収支を選択</option>
									<?php foreach ($amount_types as $data) : ?>
										<option style="background-color:<?= $data['amount_type_color'] ?>;" value=<?= $data['amount_type'] ?>>
											<?= $data['amount_type_name'] ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group mb-2">
						<label for="finance_title" class="label">タイトル</label>
						<span class="text-danger fs-4">*</span>
						<input id="finance_title" name="finance_title" class="form-control" type="text" placeholder="タイトル" value="">
					</div>

					<div class="form-group mb-2">
						<label for="amount" class="label">金額</label>
						<span class="text-danger fs-4">*</span>
						<input id="amount" name="amount" class="form-control" type="number" placeholder="金額" value="">
					</div>


					<div class="form-group mb-2">
						<label for="description" class="label">説明</label>
						<input id="description" name="description" class="form-control" type="text" placeholder="説明" value="">
					</div>

					<div class="form-group mb-2">
						<label id="created_at_label" for="created_at" class="label">作成日時</label>
						<input id="created_at" name="created_at" class="form-control" type="text" placeholder="" value="" readonly>
					</div>

					<div class="form-group mb-2">
						<label id="updated_at_label" for="updated_at" class="label">更新日時</label>
						<input id="updated_at" name="updated_at" class="form-control" type="text" placeholder="" value="" readonly>
					</div>

					<div class="mt-2 me-3 form-group position-absolute  end-0 ">
						<button id="cancel" type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
						<button id="undo" type="button" class="btn btn-dark"><i class="fas fa-times"></i></button>
						<button id="add" type="button" class="btn btn-primary" style="color: white;">追加</button>
						<button id="edit" type="button" class="btn btn-warning">編集</button>
						<button id="update" type="button" class="btn btn-success" style="color: white;">更新</button>
						<button id="delete" type="button" class="btn btn-danger" style="color: white;">削除</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>


<script>
	var finance_id;
	var data;

	function modalInitialize() {
		$('#finance_date, #finance_title, #amount, #description')
			.val('')
			.prop('disabled', false);
		$('#payment_type, #amount_type')
			.val('')
			.css('background-color', '')
			.prop('disabled', false);
		$('#ok_gif, #error_icon').hide();
		$('#error_message').html('');
	}

	$('#payment_type,#amount_type').on('change', function() {
		let bgcolor = $(this).children('option:selected').css('background-color');
		$(this).css('background-color', bgcolor);

	});

	$('#category').on('change', function() {
		$('#category_form').submit();
	})


	$('#add_modal').on('click', function() {
		modalInitialize();
		$('#created_at, #updated_at').hide();
		$('#created_at_label, #updated_at_label').hide();
		$('#undo, #edit, #update, #delete').hide();
		$('#add').show();
		$('#modal_title').html('新規追加');
	})

	$('#edit').on('click', function() {
		$('#finance_date, #payment_type, #amount_type, #finance_title, #amount, #description').prop('disabled', false);
		$('#edit, #delete').hide();
		$('#undo, #update').show();
	})

	$('#undo').on('click', function() {
		$('#finance_date, #payment_type, #amount_type, #finance_title, #amount, #description').prop('disabled', true);
		$('#edit, #delete').show();
		$('#undo, #update').hide();

	})

	$('#add').on('click', function() {

		data = $("form").serializeArray();

		$.ajax(ajaxProperty("<?= base_url(); ?>finance/add", data))
			.done(function(response) {
				if (response['validate']) {
					callSwalAlert({
						title: '登録しました',
						text: '元のページに戻ります'
					});
					setTimeout(function() {
						$('#category_form').submit();
					}, 1500)
				} else {
					$('#error_icon').show();
					$('#error_message').html('未入力の必須項目があります');
				}
			})
			.fail(function(error) {
				console.log(error);
			})

	})

	$('#update').on('click', function() {
		let finance_array = {
			name: 'finance_id',
			value: finance_id
		};
		data = $("form").serializeArray();
		data.push(finance_array);

		$.ajax(ajaxProperty("<?= base_url(); ?>finance/update", data))
			.done(function(response) {
				if (response['validate']) {
					callSwalAlert({
						title: '更新しました',
						text: '元のページに戻ります'
					});
					setTimeout(function() {
						$('#category_form').submit();
					}, 1500)
				} else {
					$('#error_icon').show();
					$('#error_message').html('未入力の必須項目があります');
				}
			})
			.fail(function(error) {
				console.log(error);
			})


	})

	$('#delete').on('click', function() {

		let deleteAjax = function() {
			$.ajax(ajaxProperty("<?= base_url(); ?>finance/delete", {
					finance_id: finance_id
				}))
				.done(function(response) {
					callSwalAlert({
						title: '削除しました',
						text: '元のページに戻ります'
					});
					setTimeout(function() {
						$('#category_form').submit();
					}, 1500)
				})
				.fail(function(error) {
					console.log(error);
				});
		}
		callSwalQuestion({
			title: '削除しますか？',
			text: '削除されたデータは復元できません',
			confirmButtonText: "削除",
			buttonColor: '#d33',
			callback: deleteAjax
		})

	});

	$('.detail').on('click', function() {
		finance_id = $(this).data('finance_id');

		modalInitialize();
		$('#created_at, #updated_at').show();
		$('#created_at_label, #updated_at_label').show();
		$('#add, #undo, #update').hide();
		$('#edit, #delete').show();

		$.ajax(ajaxProperty("<?= base_url(); ?>finance/detail", {
				finance_id: finance_id
			}))
			.done(function(response) {
				let detail = response.data;
				$('#finance_date')
					.val(detail.finance_date)
					.prop('disabled', true);
				$('#payment_type')
					.val(detail.payment_type_id)
					.prop('selected', true)
					.css('background-color', detail.payment_type_color)
					.prop('disabled', true);
				$('#amount_type')
					.val(detail.amount_type)
					.prop('selected', true)
					.css('background-color', detail.amount_type_color)
					.prop('disabled', true);
				$('#finance_title')
					.val(detail.finance_title)
					.prop('disabled', true);
				$('#amount')
					.val(detail.amount)
					.prop('disabled', true);
				$('#description')
					.val(detail.description)
					.prop('disabled', true);
				$('#created_at')
					.val(detail.created_at);
				$('#updated_at')
					.val(detail.updated_at);

				$('#modal_title')
					.html(detail.finance_title + ' ' + '詳細');
			})
			.fail(function(error) {
				console.log(error);
			})
	})
</script>