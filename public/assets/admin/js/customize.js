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

    $(".input-score").keyup(function () {
        if ($.isNumeric($(this).val())) {
            // $(this).closest("output-score").val('2');
            var quality = $(this).parent().parent().parent().find("input[name='quality[]']").val();
            $(this).parent().parent().parent().find(".output-score").val($(this).val() * quality);
        }
        // console.log($.isNumeric($(this).val()));
    });

    $(".add-dedication-service-button").click(function (e) {
        e.preventDefault();
        countChild = $(".dedication-service-wrapper div.form-group").length;
        console.log(countChild);
        x = countChild;
        if (x < max_fields) { //max input box allowed
            x++; //text box increment
            $(".dedication-service-wrapper").append('<div class="form-group"> <div class="clearfix"></div> <label class="control-label col-sm-4 col-md-3">Unggah Dokumentasi</label> <div class="col-sm-6"> <div class="fileinput fileinput-new input-group" data-provides="fileinput"> <div class="form-control input-sm" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span> </div> <span class="input-group-addon btn btn-success btn-file"> <span class="fileinput-new">Pilih file</span> <span class="fileinput-exists">Ubah</span> <input type="file" name="file_name[]" value=""> </span> <a href="#" class="input-group-addon btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a> </div> </div> <div class="col-sm-1"><a href="#" class="remove_field btn btn-sm btn-danger btn-stroke"> <i class="fa fa-minus"></i> </a> </div></div> <!-- /.form-group -->'); //add input box
        }
    });

    $('.dedication-service-wrapper').on("click", ".remove_field", function (e) { //user click on remove text
        e.preventDefault();
        countChild = $(".dedication-service-wrapper div.form-group").length;
        x = countChild;
        if (x > 5) {
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

    $("form#submit-form").submit(function (e) {
        $(this).find('button#submit').attr('disabled', 'disabled');
    });
});