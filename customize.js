/**
 * Created by Surya on 24/10/2016.
 */
$(document).ready(function () {
    var getUrl = window.location,
        baseUrl = getUrl.protocol + "//" + getUrl.host;// + "/";
    // baseUrl = baseUrl + "lppm_usu/public";

    // Handle Additional Fields For Appraisal
    var max_fields = 20; //maximum input boxes allowed
    var wrapper = $(".input_fields_wrap"); //Fields wrapper
    var add_button = $(".add_field_button"); //Add button ID
    var countChild;
    var x; //initlal text box count

    $(add_button).click(function (e) { //on add input button click
        e.preventDefault();
        countChild = $(".input_fields_wrap div.form-group").length;
        x = countChild - 1;
        if (x < max_fields) { //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="form-group"><label for="aspect[]" class="col-sm-2 control-label">Deskripsi Aspek</label> <div class="col-sm-6"> <input name="aspect[]" class="form-control input-sm" type="text"> </div> <label for="quality[]" class="col-sm-1 control-label">Bobot</label> <div class="col-sm-2"> <input name="quality[]" class="form-control input-sm" type="text"> </div> <div class="col-sm-1"> <a href="#" class="remove_field btn btn-sm btn-danger btn-stroke"> <i class="fa fa-minus"></i> </a> </div> </div><!-- /.form-group -->'); //add input box
        }
    });

    $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
        e.preventDefault();
        countChild = $(".input_fields_wrap div.form-group").length;
        x = countChild - 1;
        if (x > 1) {
            $(this).parents('div.form-group').remove();
            x--;
        }
    })
    // End Handle Additional Fields For Appraisal

    //Handle Add fields for dedication partner
    $(".add-partner-button").click(function (e) {
        e.preventDefault();
        countChild = $(".partner-wrapper div.form-group").length;
        x = countChild;
        if (x < max_fields) { //max input box allowed
            x++; //text box increment
            $(".partner-wrapper").append('<div class="form-group"><label for="partner_name[]" class="col-sm-3 control-label">Nama Mitra</label> <div class="col-sm-7"> <input name="partner_name[]" class="form-control input-sm mb-10" type="text"> </div><!-- /.col-sm-7 --> <label for="partner_territory[]" class="col-sm-3 control-label">Wilayah Mitra (Desa/Kecamatan)</label> <div class="col-sm-7"> <input name="partner_territory[]" class="form-control input-sm mb-10" type="text"> </div><!-- /.col-sm-7 --> <label for="partner_city[]" class="col-sm-3 control-label">Kabupaten/Kota</label> <div class="col-sm-7"> <input name="partner_city[]" class="form-control input-sm mb-10" type="text"> </div><!-- /.col-sm-7 --> <label for="partner_province[]" class="col-sm-3 control-label">Provinsi</label> <div class="col-sm-7"> <input name="partner_province[]" class="form-control input-sm mb-10" type="text"> </div><!-- /.col-sm-7 --> <label for="partner_distance[]" class="col-sm-3 control-label">Jarak PT ke lokasi mitra (KM)</label> <div class="col-sm-7"> <input name="partner_distance[]" class="form-control input-sm mb-10" type="text"> </div><!-- /.col-sm-7 --> <div class="clearfix"></div> <label class="control-label col-sm-4 col-md-3">Unggah Surat Kesediaan Kerjasama</label> <div class="col-sm-7"> <div class="fileinput fileinput-new input-group" data-provides="fileinput"> <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span> </div> <span class="input-group-addon btn btn-success btn-file"> <span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span> <input type="file" name="file_partner_contract[]" value=""> </span> <a href="#" class="input-group-addon btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a> </div> </div> <div class="col-sm-offset-3 col-sm-7"><a href="#" class="remove_field btn btn-sm btn-danger btn-stroke btn-slideright"> <i class="fa fa-minus"></i> </a> </div></div><!-- /.form-group -->'); //add input box
        }
    });


    $('.partner-wrapper').on("click", ".remove_field", function (e) { //user click on remove text
        e.preventDefault();
        countChild = $(".partner-wrapper div.form-group").length;
        x = countChild;
        if (x > 1) {
            $(this).parents('div.form-group').remove();
            x--;
        }
    })
    //End Handle Add fields for dedication partner

    // Handle Delete Confirmation Modal
    $(".modal_delete").on('click', function () {
        var id = $(this).data('id');
        removeForm = $("form.delete_action");
        removeForm.attr('action', removeForm.attr('action').replace(/actionid/, id));
    });
    // End Handle Delete Confirmation Modal

    if ($("#checkbox-primary1").is(":checked")) {
        $("#own-wrapper").show();
        $("#scheme-wrapper").hide();
    } else {
        $("#own-wrapper").hide();
        $("#scheme-wrapper").show();
    }
    $("#checkbox-primary1").on("click", function () {
        if ($("#checkbox-primary1").is(":checked")) {
            $("#own-wrapper").show("");
            $("#scheme-wrapper").hide("");
        } else {
            $("#own-wrapper").hide("");
            $("#scheme-wrapper").show("");
        }
    });

    for (var i = 0; i < 10; i++) {
        if ($("input#external" + i).is(":checked")) {
            // console.log($(this).closest('.form-group').find('.external-member-wrapper').length);
            $("input#external" + i).closest('.form-group').find('.external-member-wrapper').show();
            $("input#external" + i).closest('.form-group').find('.internal-member-wrapper').hide();
        } else {
            $("input#external" + i).closest('.form-group').find('.external-member-wrapper').hide();
            $("input#external" + i).closest('.form-group').find('.internal-member-wrapper').show();
        }
    }
    $("input.external-checkbox").on("click", function () {
        if ($(this).is(":checked")) {
            $(this).closest('.form-group').find('.external-member-wrapper').show();
            $(this).closest('.form-group').find('.internal-member-wrapper').hide();
        } else {
            $(this).closest('.form-group').find('.external-member-wrapper').hide();
            $(this).closest('.form-group').find('.internal-member-wrapper').show();
        }
    });

    $("select[name='period_id']").change(function () {
        $.get(baseUrl + '/ajax/periods/get', {period_id: $(this).val()}, function (data) {
            // data = JSON.parse(data);
            $.each(data, function (key, value) {
                if (key == 'annotation') {
                    $("textarea[name='" + key + "']").val(data[key]);
                } else {
                    $("input[name='" + key + "']").val(data[key]);
                }
            });
        })
    });

    $(".input-reviewer").on('change', function () {
        $.get(baseUrl + '/ajax/members/lecturerNIDN', {key_input: $('.input-value').val()}, function (data) {
            $.each(data, function (key, value) {
                $("input[name='" + key + "']").val(data[key]);
            });
        })
    });

    $(".input-score").change(function () {
        if ($.isNumeric($(this).val())) {
            // $(this).closest("output-score").val('2');
            var quality = $(this).parent().parent().parent().find("input[name='quality[]']").val();
            $(this).parent().parent().parent().find(".output-score").val($(this).val() * quality);
        }
        // console.log($.isNumeric($(this).val()));
    });

    $(".add-research-general-button").click(function (e) {
        e.preventDefault();
        countChild = $(".research-general-wrapper div.form-group").length;
        x = countChild;
        if (x < max_fields) { //max input box allowed
            x++; //text box increment
            var research_clone = $('.research-general-wrapper').find('div.form-group:last').clone();
            var idx = research_clone.find('input[name^=status]:first').attr("name").substring(7,8);
            idx++;
            research_clone.find('input[name^=status]').attr("name", "status[" + idx + "]");
            research_clone.find('input[id^=radio-draft]').attr("id", "radio-draft[" + idx + "]");
            research_clone.find('label[for^=radio-draft]').attr("for", "radio-draft[" + idx + "]");
            research_clone.find('input[id^=radio-submitted]').attr("id", "radio-submitted[" + idx + "]");
            research_clone.find('label[for^=radio-submitted]').attr("for", "radio-submitted[" + idx + "]");
            research_clone.find('input[id^=radio-accepted]').attr("id", "radio-accepted[" + idx + "]");
            research_clone.find('label[for^=radio-accepted]').attr("for", "radio-accepted[" + idx + "]");
            research_clone.find('input[id^=radio-publish]').attr("id", "radio-publish[" + idx + "]");
            research_clone.find('label[for^=radio-publish]').attr("for", "radio-publish[" + idx + "]");
            research_clone.find('input[name^=output_description]').attr("value", "");
            research_clone.find('input[name^=url_address]').attr("value", "");
            $('.research-general-wrapper').append(research_clone);
            BlankonApp.handleSound();
            // $(".research-general-wrapper").append('<div class="form-group"><input name="delete_output[]" type="hidden" value="0"><div class="clearfix"></div> <label for="output_description[]" class="control-label col-sm-4 col-md-3">Deskripsi Luaran</label> <div class="col-sm-6 mb-10"> <input name="output_description[]" class="form-control input-sm" type="text" value=""> </div><div class="clearfix"></div> <label class="control-label col-sm-4 col-md-3">Unggah Luaran</label> <div class="col-sm-6"> <div class="fileinput fileinput-new input-group" data-provides="fileinput"> <div class="form-control input-sm" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span> </div> <span class="input-group-addon btn btn-success btn-file"> <span class="fileinput-new">Pilih file</span> <span class="fileinput-exists">Ubah</span> <input type="file" name="file_name[]" value=""> </span> <a href="#" class="input-group-addon btn btn-danger fileinput-exists" data-dismiss="fileinput">Hapus</a> </div> </div> <div class="col-sm-1"><a href="#" class="remove_field btn btn-sm btn-danger btn-stroke"> <i class="fa fa-minus"></i> </a> </div></div> <!-- /.form-group -->'); //add input box
        }
    });

    $('.research-general-wrapper').on("click", ".remove_field", function (e) { //user click on remove text
        e.preventDefault();
        countChild = $(".research-general-wrapper div.form-group").length;
        x = countChild;
        if (x > 1) {
            $(this).parents('div.form-group').remove();
            x--;
        }
    })

    if ($("#radio-no").is(":checked")) {
        $("#revision-text-wrapper").show();
    } else {
        $("#revision-text-wrapper").hide();
    }
    $("input[name='is_approved']").on("change", function () {
        if ($("#radio-no").is(":checked")) {
            $("#revision-text-wrapper").show("");
        } else {
            $("#revision-text-wrapper").hide("");
        }
    });

    $("form.submit-form").submit(function (e) {
        var form = $(this);
        $(this).find('button[type="submit"]').each(function (index) {
            // Create a disabled clone of the submit button
            $(this).clone(false).removeAttr('id').prop('disabled', true).insertBefore($(this));

            // Hide the actual submit button and move it to the beginning of the form
            $(this).hide();
            form.prepend($(this));
        });
    });
});