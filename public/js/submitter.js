/**
 * Created by jnahian on 6/1/2017.
 */
submit_form = function (t, e) {
    const form = $(t).parents('form');
    const action = $(form).attr('action');
    const method = $(form).attr('method');
    const mime = $(form).attr('enctype');
    const btn = $(t).html();
    $(form).one('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: action,
            type: method,
            beforeSend: function () {
                $(t).attr('disabled', 'disabled');
                $('.has-error').find('.text-danger').text('');
                $('.form-control').parent('.has-error').removeClass('has-error');
                $(t).children().html('<i class="fa fa-spinner fa-spin"></i>');
            },
            data: formData,
            processData: false,
            contentType: false,
            mimeType: mime,
            dataType: 'JSON',
            xhr: function () {
                //upload Progress
                let xhr = new window.XMLHttpRequest();
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', function (event) {
                        //console.log(event);
                        let percent = 0;
                        let position = event.loaded || event.position;
                        let total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }
                        //update progressbar
                        // bar.css("width", +percent + "%");
                        //$(progress_bar_id + " .status").text(percent +"%");
                    }, true);
                }
                return xhr;
            },
        })
            .done(function (ret) {
                // console.log(ret);
                let type = ret.type;
                let title = ret.title;
                if (ret.type == 'success') {
                    $(form)[0].reset();

                    // resetSummernote();
                    // resetMultiSelect();
                }
                swal({
                    type: type,
                    title: title,
                    text: ret.message,
                    timer: 5000
                }).then(function (res) {
                    if (ret.redirect && res) {
                        redirect(ret.redirect);
                    }
                    if (ret.redirect_newtab && res) {
                        redirect_newtab(ret.redirect_newtab);
                    }
                    
                    $('#select_result').html('');
                }, function (dismiss) {
                    if (ret.redirect && dismiss === 'timer') {
                        redirect(ret.redirect);
                    }

                });

            })
            .fail(function (res) {
                // errors = JSON.parse(res.responseText);
                errors = res.responseJSON;
                // console.log(res.responseText);
                if (errors) {
                    $.each(errors, function (index, error) {
                        $("[name=" + index + "]").parents('.form-group').find('.text-danger').text(error);
                        $("[name=" + index + "]").parent().addClass('has-error');
                        $(form).find("." + index).text(error);
                    });
                }
            })
            .always(function () {
                $(t).removeAttr('disabled');
                $(t).html(btn);
                // console.log('complete');
                // progress.fadeOut(300);
            });
    });
};

/**
 * Redirect to given url
 * @param $url
 * @returns {boolean}
 */
function redirect($url) {
    setTimeout(function () {
        window.location.href = $url;
    }, 200);
    return true;
}

/**
 * change by Belal
 * Redirect to given url in new tab
 * @param $url
 * @returns {boolean}
 */
function redirect_newtab($url) {
    setTimeout(function () {
        window.open($url)
    }, 200);
    return true;
}

/**
 * Reset Summernote
 * @returns {boolean}
 */
function resetSummernote() {
    if ($('html').find('.summernote').length > 0) {
        $('.summernote').summernote('reset');
    }
    return true;
}

/**
 * Reset multiselect
 * @returns {boolean}
 */
function resetMultiSelect() {
    if ($('html').find('.multi-select').length > 0) {
        $('.multi-select').multiSelect('refresh');
    }
    return true;
}

/**
 * Delete Function
 * @param t
 * @param e
 */
function deleteSwal(t, e) {
    e.preventDefault();
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4fa7f3',
        cancelButtonColor: '#d57171',
        confirmButtonText: 'Yes, delete it!'
    }).then(function (stat) {

        if (stat.value != undefined && stat.value) {
            // $(t).parent('form').submit();
            let form = $(t).parents('form'),
                action = $(form).attr('action'),
                method = $(form).attr('method'),
                btn = $(t).html();
            let formData = $(form).serialize();

            $.ajax({
                url: action,
                type: method,
                beforeSend: function () {
                    $(t).attr('disabled', 'disabled');
                    $(t).html('<i class="fa fa-spinner fa-spin"></i>');
                },
                data: formData,
                dataType: 'JSON',
                success: function (res) {
                    let type = res.type;
                    let title = res.title;
                    if (res.type == 'success') {
                        $(t).parents('tr').remove();
                    }
                    swal(
                        title,
                        res.msg,
                        type
                    );
                },
                complete: function () {
                    $(t).removeAttr('disabled');
                }
            });
        }

    });
}

/**
 * Confirmation Function
 * @param t
 * @param e
 */
function confirmSwal(t, e) {
    e.preventDefault();
    swal({
        title: 'Are you sure?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4fa7f3',
        cancelButtonColor: '#d57171',
        confirmButtonText: 'Yes, Do it'
    }).then(function (stat) {

        if (stat.value != undefined && stat.value) {
            // $(t).parent('form').submit();
            let form = $(t).parents('form'),
                action = $(form).attr('action'),
                method = $(form).attr('method'),
                btn = $(t).html();
            let formData = $(form).serialize();

            $.ajax({
                url: action,
                type: method,
                beforeSend: function () {
                    $(t).attr('disabled', 'disabled');
                    $(t).html('<i class="fa fa-spinner fa-spin"></i>');
                },
                data: formData,
                dataType: 'JSON',
                success: function (res) {
                    let type = res.type;
                    let title = res.title;
                    if (res.type == 'success') {
                        $(t).parents('tr').remove();
                    }
                    swal(
                        title,
                        res.msg,
                        type
                    );
                },
                complete: function () {
                    $(t).removeAttr('disabled');
                }
            });
        }

    });
}