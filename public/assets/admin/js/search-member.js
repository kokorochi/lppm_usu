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
            var reviewer_clone = $(".reviewer-wrapper").find("div.form-group:first").clone();
            reviewer_clone.find("select").remove();
            reviewer_clone.find(".chosen-container").remove();
            reviewer_clone = reviewer_clone.appendTo(".reviewer-wrapper");

            var reviewer_option = $(".reviewer-wrapper").find("div.form-group:first").find("select.chosen-select").find("option").clone();
            var reviewer_select = $("<select name='nidn[]' class='chosen-select'>").appendTo(reviewer_clone.find('.chosen-select-container'));
            reviewer_option.each(function (index) {
                reviewer_select.append($("<option>").attr('value', reviewer_option[index].value).text(this.text))
            });
            $(".chosen-select").chosen();
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

            //Get latest ID number of external indicator
            var id = 0;
            for (var i = 0; i < 100; i++) {
                if ($("input#external" + i).length) {
                    id = i;
                }
            }
            id++;
            //End Get

            var newtr = '<div class="form-group"><label class="control-label col-sm-4 col-md-3">Dosen Luar</label> <div class="col-sm-7 mb-10"> <div class="ckbox ckbox-default"> <input name="external' + id + '" id="external' + id + '" type="checkbox" value="1" class="external-checkbox"> <label for="external' + id + '">*Tick ini jika anggota merupakan dosen dari luar USU</label> </div> </div> <div class="external-member-wrapper"> <label for="external_name[]" class="col-sm-4 col-md-3 control-label">Nama</label> <div class="col-sm-7 input-icon right"> <input name="external_name[]" type="text" class="form-control input-sm mb-15" value=""/> </div> <label for="external_affiliation[]" class="col-sm-4 col-md-3 control-label">Afiliasi</label> <div class="col-sm-7 input-icon right"> <input name="external_affiliation[]" type="text" class="form-control input-sm mb-15" value=""/> </div> </div> <div class="internal-member-wrapper"><label for="member_nidn[]" class="col-sm-4 col-md-3 control-label">Anggota</label> <div class="col-sm-7 input-icon right"> <input name="member_display[]" type="text" class="input-member form-control input-sm mb-15" value=""/> <input name="member_nidn[]" type="text" class="input-value" hidden="hidden" value=""/> </div> </div><label for="member_areas_of_expertise[]" class="col-sm-4 col-md-3 control-label">Bidang Keahlian</label> <div class="col-sm-7"> <input name="member_areas_of_expertise[]" type="text" class="form-control input-sm mb-15" value=""/> </div> <div class="clearfix"></div> <div class="col-sm-offset-4 col-md-offset-3"> <div class="col-sm-1"> <a href="#" class="remove_field btn btn-sm btn-danger btn-stroke"> <i class="fa fa-minus"></i> </a> </div> </div> </div><!-- /.form-group -->';
            $(".member-wrapper").append(newtr); //add input box
            $('.input-member').autocomplete(autocomp_opt);
            $("input#external" + id).closest('.form-group').find('.external-member-wrapper').hide();
            $("input#external" + id).closest('.form-group').find('.internal-member-wrapper').show();
            $("input.external-checkbox").on("click", function () {
                if ($(this).is(":checked")) {
                    $(this).closest('.form-group').find('.external-member-wrapper').show();
                    $(this).closest('.form-group').find('.internal-member-wrapper').hide();
                } else {
                    $(this).closest('.form-group').find('.external-member-wrapper').hide();
                    $(this).closest('.form-group').find('.internal-member-wrapper').show();
                }
            });
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