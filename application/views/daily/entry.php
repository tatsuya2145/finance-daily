<link id="daily-style" rel="stylesheet" href="<?= base_url();?>assets/css/daily.css">
<div class="app">
    <div class="app-wrapper">
        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div id="layout-wrapper">
                <div class="container-fluid">
                    <div class="col-md-9">
                        <h4>日記</h4>
                    </div>
                    <div class="card">
                        <div class="card-header" >
                            <div class="row">
                                <div class="col-md-10 mt-3 form-group">
                                    <form method="post">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group mb-3 daily-range">
                                                    <input id="from" type="date" name="from" class="form-control" value="<?=$from?>">
                                                    <span class="input-group-text">～</span>
                                                    <input id="to" type="date" name="to" class="form-control" value="<?=$to?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" id="word" class="form-control word" name="word" value="<?=$word?>" placeholder="検索ワード">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="hidden" id="is_filled_only_value" name="is_filled_only" value="<?= $is_filled_only;?>">
                                                <input type="checkbox" class="form-check-input mt-2" id="is_filled_only" data-is_filled_only="<?=$is_filled_only?>"
                                                <?php if($is_filled_only):?>checked<?php endif;?> <?php if(!empty($word)):?>disabled<?php endif;?>>
                                                <label class="form-check-label" for="is_filled_only">
                                                    <span class='badge rounded-3 fs-6 px-2 py-2' style='background-color:pink; color:dimgray'>記入あり</span>のみ 
                                                </label>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="submit" class="btn btn-success range-date" style="color: white;">検索</button>   
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead class="text-center table-success" style="vertical-align: middle; font-size: 0.8em;">
                                    <tr>
                                        <th>日付</th>
                                        <th>記入有無</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody style="vertical-align: middle; font-size: 0.9em;">
                                    <?php
                                $cnt = 0;
                                foreach($data as $date => $bool):
                                    $holiday = dailyHoliday($date)
                                    ?>
                                    
                                    <tr id="<?= $date?>" class="tr-<?=$date?>" 
                                    <?php if($is_filled_only && !$bool):?>style="display: none;" <?php endif;?>>
                                        <td 
                                        rowspan="1" 
                                        class="w-<?= date("w", strtotime($date));?>
                                        td-date
                                        text-center
                                        fw-bold
                                        <?= $holiday['class_name'];?>
                                        ">
                                        <?= dateFormat($date, 'n月j日', true);?>
                                        <br><?= $holiday['holiday_name'];?>
                                    </td>
                                    <td class="text-center">
                                        <span class='badge rounded-3 text-dark fs-6 px-2 py-2' style='background-color:pink; color:dimgray;' <?php if(!$bool):?>hidden<?php endif;?> >
                                            記入あり
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button
                                        data-date="<?=$date?>"
                                        class="detail btn btn-outline-secondary me-1" data-bs-toggle="modal" data-bs-target="#modal_form">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr style="border-bottom: .5rem #eee solid"></tr>
                                
                                <?php
                                    $cnt += $bool;
                                endforeach;?>
                                
                                <?php if($cnt == 0 && (!empty($word) || $is_filled_only)):?>
                                    <tr class="text-center">
                                        <td colspan="3">該当データが見つかりませんでした</td>
                                    </tr>
                                    <?php endif;?>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="modal fade" id="modal_form" data-bs-backdrop="static" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-fullscreen">
                                <div class="modal-content">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
            <div class="js-pagetop"><span><i class="fas fa-arrow-up"></i></span></div>
        </div>
    </div>
</div>

<script src='<?= base_url();?>assets/js/ckeditor/ckeditor.js'></script>
<script>
    var is_filled_only = $('#is_filled_only').data('is_filled_only');
    
    $('#is_filled_only').on('change', function(){
        is_filled_only = $('#is_filled_only').is(':checked') ? 1:0;
        $('#is_filled_only_value').val(is_filled_only);
    })

    $(function () {
        let pagetop = $('.js-pagetop');
        
        
    //スクロールの位置によってページトップ移動ボタンの表示を変える
    pagetop.hide();
    $(window).scroll(function () {
        $(this).scrollTop() > 500 ? pagetop.fadeIn() : pagetop.fadeOut();  
    });
    pagetop.click(function () {
        $('body, html').animate({
            scrollTop: 0
        }, 10);
        return false;
    });


});

var uniqueId = function(digits) {
    let strong = typeof digits !== 'undefined' ? digits : 1000;
    return Date.now().toString(16) + Math.floor(strong * Math.random()).toString(16);
}

//検索ワードが入力されたらチェックボックスをチェック状態に固定
$('.word').on('keyup',function(){
    let word = $(this).val().trim() != '' ? 1:0;
    $('#is_filled_only').prop('checked',word);
    $('#is_filled_only').prop('disabled',word); 
    $('#is_filled_only_value').val(word);


})

$('.detail').on('click', function(){
    let date = $(this).data('date');
    $.ajax({
        url: '<?= base_url();?>daily/modal',
        dataType: 'json',
        type: 'POST',
        data: {
            daily_date: date
        }
    })
    .done(function(response){
        
        $('.modal-content').html(response.modal);
        $('#modal_title').html(response.formated_date);
        $('#modal_title').data('date',response.date);
    })
    .fail(function(error){
        console.log(error);
    });
});

    


</script>