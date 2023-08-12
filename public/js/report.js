$(function () {
    $('#cancel-button').click(function(e){
        e.preventDefault()
        if (confirm('Bạn có chắc chắn muốn hủy báo cáo?')) {
            $(e.target).closest('form').submit()
        }
    });

    $('#delete-button').click(function(e){
        e.preventDefault()
        if (confirm('Bạn có chắc chắn muốn xóa video báo cáo?')) {
            $(e.target).closest('form').submit()
        }
    });
});