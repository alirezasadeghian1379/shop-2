var win = navigator.platform.indexOf('Win') > -1;
if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
        damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
}

$(document).on('change', '.btn-select', function () {
    const card = $(this).closest('.card-role');
    const checkboxes = card.find(
        '.items .item input[type="checkbox"]'
    ).not(this);
    const shouldCheck = $(this).is(':checked');
    checkboxes.prop('checked', shouldCheck);
});

$('.showAndHideSideMenu').on('click',()=>{
    $('.sidenav').toggleClass('active')
    $('.main-content').toggleClass('active')
})


$(document).ready(function() {
    function checkWidth() {
        if ($(window).width() < 1200) {
            $('.sidenav').addClass('active')
            $('.sidenav').css('top','65px')
        } else {
            $('.sidenav').removeClass('active')
            $('.sidenav').css('top','0')
        }
    }
    function checkMode() {
        if (localStorage.getItem('mode') && localStorage.getItem('mode') == 'dark'){
            $('body').addClass('dark-version')
            $('#dark-version').attr('checked','checked')
        } else {
            $('body').removeClass('dark-version')
            $('#dark-version').removeAttr('checked')
        }
    }
    checkWidth();
    checkMode();
    $(window).resize(function() {
        checkWidth();
        checkMode();
    });
});

$('#dark-version').on('click',(e)=>{
    if ($(e.target).attr('checked') == 'checked'){
        localStorage.setItem('mode','dark')
    } else {
        localStorage.setItem('mode','light')
    }
})


$('.showPass').on('click',(e)=>{
    if ($(e.currentTarget).parent().children('input').attr('type') == 'password'){
        $(e.currentTarget).parent().children('input').attr('type','text')
        $('.bi-eye-fill').removeClass('active')
        $('.bi-eye-slash-fill').addClass('active')
    } else {
        $(e.currentTarget).parent().children('input').attr('type','password')
        $('.bi-eye-fill').addClass('active')
        $('.bi-eye-slash-fill').removeClass('active')
    }
})

$('.select-image').on('change', function (e) {
    let file = e.target.files[0];
    let parent_images = $(e.target).parent().children('label.parent_images')
    let reader = new FileReader()
    reader.onload = function (e) {
        let result = e.target.result
        let image = `<img src=${result} alt="" width="100%" height="100%" class="h-100 w-100">`
        parent_images.html(image)
    }
    reader.readAsDataURL(file)
})

$('.select2').select2();

jalaliDatepicker.startWatch({
    time: true
});


tinymce.init({
    selector: 'textarea.tinyMce',
    plugins: 'code table lists',
    toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
});
