<style>
.y_scroll_box {
  /* width: 600px; */
  border: 3px solid darkgray;
  height: 600px;/* IE6 max-height対応 */
  overflow-x: hidden; /* 横スクロール非表示 */
  overflow-y: scroll; /* 縦スクロール */
  word-break: break-all;
}
</style>
<div class="modal-header">
    <div class="row">
        <div class="col-auto">
            <h4 id="modal_title" data-date=""></h4>
        </div>
        <div class="col-auto">
            <button class="btn btn-success" style="color: white;" id="add">
                <i class="fa fa-plus"></i>
            </button>    
        </div>
    </div>
    <div>
        <button id="cancel" type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" style="color:black;">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
<div class="modal-body mb-5">
    <div class="row">
        <div class="col-md-4 ">
            <div class="y_scroll_box" >
                <table class="table table-bordered" id="title_table" style="font-size: 0.9em;">
                        <tbody id="new_tbody" hidden>
                            <tr>
                                <td class="daily_title">
                                    <img src="<?= base_url();?>assets/images/daily_add_pencil.gif" width="64px">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-end" style="border-bottom: 3px solid darkgray">                                    
                                    <button class="btn btn-primary btn-sm text-white edit" title="編集" data-uuid="">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button class="btn btn-danger text-white delete" title="削除" data-uuid="">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    
                        <?php foreach($data as $row):?>
                            <tbody class="tbody-<?= $row['uuid'];?>">
                                <tr>
                                    <td class="daily_title"><?=$row['daily_title']?></td>
                                </tr>
                                <tr>
                                    <td class="text-end" style="border-bottom: 3px solid darkgray">
                                        <button class="btn btn-primary btn-sm text-white edit" title="編集"  data-uuid="<?= $row['uuid'];?>">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button class="delete btn btn-danger text-white delete" title="削除" data-uuid="<?= $row['uuid'];?>">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        <?php endforeach;?>
                    
                </table>
            </div>
        </div>
        <div class="col-md-8" >
            <span id="new_badge" class="badge bg-danger rounded-3 fs-6 text-white px-2 py-2" hidden>新規</span>
            <input id="title_form" class="form-control" type="text" placeholder="タイトルを入力" value="" hidden>
            <textarea name="" id="editor" cols="30" rows="10" class="form-control" hidden></textarea>
            <div id="message">※ 変更はリアルタイムで保存されます。</div>
        </div>
    </div>
</div>
<div class="modal-footer">
    
</div>
<script>
var modal_date;
var content;
var uuid;
var daily_title;
var is_new = false;
    
$(function(){
    modal_date = $('#modal_title').data('date');
})

function createData()
{
    return {
        daily_date  : modal_date,
        daily_title : daily_title,
        content     : content,
        uuid        : uuid
    }
}

function createNewTitle(uuid)
{
    let obj = $('#new_tbody').clone(true);
    
    obj.addClass('tbody-'+uuid);
    obj.prop('hidden',false);
    obj.css('background-color', 'gainsboro');
    obj.find('button')
                    .prop('disabled',true)
                    .data('uuid',uuid);

    obj.appendTo('#title_table');
}

function showSaveMessage()
{
    $('#message').html('自動保存しました。').fadeIn(1000);
    setTimeout(function() {
        $('#message').html('').fadeOut(1000);    
    }, 3000);                    

}


function showEditor()
{
    $('#title_form').val(daily_title)
                    .prop('hidden',false);

    $('.ck-editor').remove();
    ClassicEditor
    .create( document.querySelector( '#editor' ))
    .then(editor => {
        editor.setData(content);
        
        editor.model.document.on('change:data',function(){
            if(is_new)
            {
                $('#add').prop('disabled',false);
                $('.tbody-'+uuid).find('.edit').prop('disabled',false);
                $('.tbody-'+uuid).find('.delete').prop('disabled',false);
                $('.tbody-'+uuid).find('.daily_title').text('');
            }

            is_new = false;
            content = editor.getData();
            data = createData();
            
            $.ajax(ajaxProperty('<?=base_url()?>daily/execute',data))
            .done(function(response){
                $('#new_badge').prop('hidden',true);
                $('#add').prop('disabled',false);
                $('.tbody-'+uuid).find('.edit').prop('disabled',false);
                $('.tbody-'+uuid).find('.delete').prop('disabled',false);
                $('#editor').html(content);
                showSaveMessage();
                
            })
            .fail(function(error){
                console.log(error);
            });
           
            

        })
    })
    .catch( error => {
        console.error( error );
    } );
    
}


$('#title_form').on('keyup',function(){
    if(is_new)
    {
        $('#add').prop('disabled',false);
        $('#new_badge').prop('hidden',true);
        $('.tbody-'+uuid).find('.edit').prop('disabled',false);
        $('.tbody-'+uuid).find('.delete').prop('disabled',false);
    }
    is_new      = false;
    daily_title = $(this).val();
    data        = createData();     
    $.ajax(ajaxProperty('<?=base_url()?>daily/execute',data))
    .done(function(response){
        $('.tbody-'+uuid).find('.daily_title').text(daily_title);
        showSaveMessage();

    })
    .fail(function(error){
        console.log(error);
    });

})

$('#cancel').on('click',function(){
    $('.ck-editor').remove();
    $.ajax(ajaxProperty('<?=base_url()?>daily/getArticles',{daily_date : modal_date}))
    .done(function(response){
        let count = response.articles.length;
        $('.tr-'+modal_date).find('.badge').prop('hidden',count == 0);
    })
    .fail(function(error){
        console.log(error);
    })


})


$('#add').on('click',function(){
    is_new      = true;
    uuid        = uniqueId();
    content     = '';
    daily_title = '';
    new_uuid    = uuid;

    $('tbody').css('background-color', '');
    $(this).prop('disabled', true);
    $('#new_badge').prop('hidden',false);

    createNewTitle(uuid);
    showEditor();
    

})



$('.edit').on('click',function(){
    uuid = $(this).data('uuid');

    $.ajax(ajaxProperty('<?=base_url()?>daily/fetchArticle',{ uuid : uuid }))
    .done(function(response){
        daily_title = response.article.daily_title
        content = response.article.content
        showEditor();
    })
    .fail(function(error){
        console.log(error);
    })


    $('tbody').css('background-color', '');
    $('.tbody-'+uuid).css('background-color', 'gainsboro');

    if(is_new)
    {
        $('.tbody-'+new_uuid).remove();
        $('#new_badge').prop('hidden',true);
        $('#add').prop('disabled',false);
    }


})

$('.delete').on('click',function(){
    let delete_uuid = $(this).data('uuid');
    let deleteAjax = function(){
        $.ajax(ajaxProperty('<?=base_url()?>daily/delete',{uuid : delete_uuid}))
        .done(function(response){
            callSwalAlert({title:'削除しました',timer:1500});
            $('.tbody-'+delete_uuid).remove();
    
            if(uuid == delete_uuid)
            {
                $('#title_form').prop('hidden',true);
                $('#new_badge').prop('hidden',true)
                $('.ck-editor').remove();
    
            }
        })
        .fail(function(error){
            console.log(error);
        })
    }
    callSwalQuestion({
        title: '削除しますか？', 
        text: '削除されたデータは復元できません', 
        confirmButtonText:"削除", 
        buttonColor:'#d33',
        callback: deleteAjax
    })

})


</script>