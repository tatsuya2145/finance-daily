function callSwalAlert({title='', text='', timer})
{
    Swal.fire({
        position:'middle',
        icon: 'success',
        title: title,
        text: text,
        showConfirmButton: false,
        allowOutsideClick: false,
        timer: timer,
    })

}

function callSwalQuestion({title='', text='', confirmButtonText='決定', cancelButtonText='キャンセル', icon='warning', buttonColor='',callback})
{
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: buttonColor,
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
    }).then((result) => {
        if (result.isConfirmed) {
            callback()
        }
    })
}

function ajaxProperty(url, request={}, type='POST', dataType='json')
{
    return {
        url: url,
        dataType: dataType,
        type: type,
        data: request,
        
    }
}
