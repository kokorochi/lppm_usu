$(document).ready(function () {
    var getUrl = window.location,
        baseUrl = getUrl.protocol + "//" + getUrl.host + "/";
    // baseUrl = baseUrl + "lppm_usu/public";

    //Handle search member
    var autocomp_opt = {
        source: function (request, response) {
            $.ajax({
                url: baseUrl + '/ajax/members/search',
                dataType: "json",
                data: {
                    key_input: request.term
                },
                success: function (data) {
                    var transformed = $.map(data, function (el) {
                        return {
                            label: el.full_name,
                            id: el.employee_card_serial_number
                        };
                    });
                    response(transformed);
                }
            });
        },
        select: function (event, ui) {
            $(this).siblings(".input-value").val(ui.item.id);
            $('.input-member').trigger('change');
        }
    };

    $('.input-member').autocomplete(autocomp_opt);
    //End Handle search member

    //Handle search reviewer
    var autocomp_reviewer = {
        source: function (request, response) {
            $.ajax({
                url: baseUrl + '/ajax/reviewers/search',
                dataType: "json",
                data: {
                    key_input: request.term
                },
                success: function (data) {
                    var transformed = $.map(data, function (el) {
                        return {
                            label: el.full_name,
                            id: el.nidn
                        };
                    });
                    response(transformed);
                }
            });
        },
        select: function (event, ui) {
            $(this).siblings(".input-reviewer-value").val(ui.item.id);
            $('.input-reviewer-auto').trigger('change');
        }
    };

    $('.input-reviewer-auto').autocomplete(autocomp_reviewer);
    //End Handle search reviewer

    //Handle add new reviewer
    $(".add-reviewer-button").click(function (e) {
        e.preventDefault();
        countChild = $(".reviewer-wrapper div.form-group").length;
        x = countChild;
        if (x < 10) { //max input box allowed
            x++; //text box increment
            var newtr = '<div class="form-group"><label for="nidn[]" class="col-sm-4 col-md-3 control-label">Reviewer</label> <div class="col-sm-6 input-icon right"> <input name="display[]" type="text" class="input-reviewer-auto form-control input-sm mb-15" value=""/> <input name="nidn[]" type="text" class="input-reviewer-value" hidden="hidden" value=""/> </div> <div class="col-sm-1"> <a href="#" class="remove_field btn btn-sm btn-danger btn-stroke"> <i class="fa fa-minus"></i> </a> </div> </div><!-- /.form-group -->';
            $(".reviewer-wrapper").append(newtr); //add input box
            $('.input-reviewer-auto').autocomplete(autocomp_reviewer);
        }
    });

    $('.reviewer-wrapper').on("click", ".remove_field", function (e) { //user click on remove text
        e.preventDefault();
        countChild = $(".reviewer-wrapper div.form-group").length;
        x = countChild;
        if (x > 1) {
            $(this).parents('div.form-group').remove();
            x--;
        }
    })
    //End Handle add new reviewer

    //Handle add new member
    $(".add-member-button").click(function (e) {
        e.preventDefault();
        countChild = $(".member-wrapper div.form-group").length;
        x = countChild;
        if (x < 10) { //max input box allowed
            x++; //text box increment
            var newtr = '<div class="form-group"><label for="member_nidn[]" class="col-sm-4 col-md-3 control-label">Anggota</label> <div class="col-sm-7"> <input name="member_display[]" type="text" class="input-member form-control input-sm mb-15" autocomplete="off"/> <input name="member_nidn[]" type="text" class="input-value" hidden="hidden" value=""/> </div> <label for="member_areas_of_expertise[]" class="col-sm-4 col-md-3 control-label">Bidang Keahlian</label> <div class="col-sm-7"><input name="member_areas_of_expertise[]" type="text" class="form-control input-sm mb-15" value="" /> </div> <div class="clearfix"></div> <div class="col-sm-offset-4 col-md-offset-3"> <div class="col-sm-1"> <a href="#" class="remove_field btn btn-sm btn-danger btn-stroke"> <i class="fa fa-minus"></i> </a> </div> </div> </div><!-- /.form-group -->';
            $(".member-wrapper").append(newtr); //add input box
            $('.input-member').autocomplete(autocomp_opt);
        }
    });

    $('.member-wrapper').on("click", ".remove_field", function (e) { //user click on remove text
        e.preventDefault();
        countChild = $(".member-wrapper div.form-group").length;
        x = countChild;
        if (x > 1) {
            $(this).parents('div.form-group').remove();
            x--;
        }
    })
    //End Handle add new member
});