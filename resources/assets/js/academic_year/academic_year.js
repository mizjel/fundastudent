const host = window.location.origin;
let run_once;
let amount_total = 0;
let amount_with_fees = 0;
$(document).ready(function(){
    run_once = false;
   if($('#has_register_or_login').val() === 'true') {
      $.next_form(['step1_form']);
   }
   else if($('#has_register_or_login').val() === 'false') {
       $.next_form(['register_form','login_form']);
   }
   $('#register_form_user').submit(function(e){
      e.preventDefault();
      $.validate_user(1);
   });
   $('#register_form_student').submit(function(e){
      e.preventDefault();
      $.validate_user(2);
   });
   $('#register_form').submit(function(e){
      e.preventDefault();
      $.next_form(['register_form_user']);
   });
   $('#step1_form').submit(function(e) {
       e.preventDefault();
       $.validate_academic_year(1);
   });
   $('#step2_form').submit(function(e) {
       e.preventDefault();
       $.validate_academic_year(2);
   });
   $('#step3_form').submit(function(e) {
       e.preventDefault();
       $.validate_academic_year(3);
   });
    $("#new_goal_add").click(function() {
        $.validate_goal_input(3);
    });
    $('.btn_step').click(function(){
        $.go_to_form(this);
    });
    $('#school_level_id').change(function(){
       run_once = false;
       $('#school').empty();
       $('#enrollment').empty();
       $('#study_period').empty();
    });
    $('#thumbnail_url').change(function(e){
        let thumbnail = $('#thumbnail_url').val() !=  '' ? $('#thumbnail_url').prop('files')[0] : '';
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#thumbnail_url_preview')
                .attr('src', e.target.result)
        };
        reader.readAsDataURL(thumbnail);
        $('#thumbnail_url_preview').prop('src',thumbnail);
    });
});
$.show_spinner = function()
{
    $('#finish_registration').html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
};
$.go_to_form = function(element)
{
    var selected_step = $(element).val();
    var current_step = $(element).closest('.btn_nav').attr('id').split("_")[3];

    if(selected_step > current_step){
        $.validate_academic_year(current_step);
    } else {
        let shortDescription = $('#short_description').val();
        $('#short_desc').val(shortDescription);
        $.next_form(['step'+selected_step+'_form']);
    }
};
$.goal_calculation = function(amount,type)
{
    let amount_with_dot = parseFloat(amount.replace(',','.'));

    if(type === 'add'){
        amount_total += amount_with_dot;
    } else if(type === 'subtract'){
        amount_total -= amount_with_dot;
    }
    let fee_amount = +amount_total/100*9;
    amount_with_fees = amount_total - fee_amount;
    $('#goals_info_message').html('Totaal ingevoerde bedrag is: ' + amount_total.toFixed(2) + ', totaal bedrag dat Fund a Student overschrijft naar jouw rekening: ' + amount_with_fees.toFixed(2));
};
$.validate_goal_input = function(step)
{
    let formData = $.set_form_data('step'+step+'_form',['full_description','funder_motivation']);
    $.ajax({
        type: "POST",
        url: host + '/academic_years/validate_goal',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (msg) {
            if(msg.errors) {
                $.set_error_messages(msg.errors,step,'academic_year');
            }
            else if(!msg.errors) {
                $.goal_calculation(formData.get('new_goal_amount'),'add');
                $.set_goal_table_data(formData.get('new_goal_amount'),formData.get('new_goal_description'));
                $.clear_errors(['new_goal_amount','new_goal_description']);
                $.clear_errors(['goals']);
            }
        }
    });
};
$.clear_errors = function(elementIdArray)
{
    $.each(elementIdArray,function(key,value){
        let div_id = '#'+value+'_div';
        let error_message_id = '#'+value+'_error_message';
        $(div_id).removeClass('has-error');
        $(error_message_id).empty();
    });
};
$.set_goal_table_data = function(goalAmount,goalDescription)
{
    $('#new_goal_amount').val('');
    $('#new_goal_description').val('');
    $('#goals tbody').append('<tr>' +
        '<td class="amount"> '+ goalAmount +' </td>'+
        '<td class="description"> '+ goalDescription +' </td>'+
        '<td><span class="glyphicon glyphicon-remove" aria-hidden="true" onclick="$.remove_goal(this)" style="font-size: 0.9em;cursor:pointer;"></span></td>'+
        '</tr>');
};
$.remove_goal = function(element)
{
    var parent = $(element).closest('tr');
    $(parent).children().each(function(key,value){
        if($(this).hasClass('amount')){
            let amount = $(this).text();
            $.goal_calculation(amount,'subtract');
        }
    });
    $(parent).remove();
};
$.validate_academic_year = function(step)
{
   let formData;
   let next_step = +step+1;
   if(step === 3){
       formData = $.set_form_data('step'+step+'_form',['new_goal_amount','new_goal_description']);
       $('#goals tbody tr').each(function(key,value){
           let amount = $(value).find('.amount').html();
           let description = $(value).find('.description').html();
           formData.append('goals['+key+'][amount]',amount);
           formData.append('goals['+key+'][description]',description);
       });
   } else {
       formData = $.set_form_data('step'+step+'_form');
   }
   formData.append('step',step);
   if(step === 2){
       let thumbnail = $('#thumbnail_url').val() !=  '' ? $('#thumbnail_url').prop('files')[0] : '';
       formData.append('thumbnail_url' , thumbnail);
   }
    $.ajax({
        type: "POST",
        url: host + '/academic_years/validate',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (msg) {
            if(msg.errors) {
                $('#finish_registration').html('Ga naar de volgende stap');
                $.set_error_messages(msg.errors,step,'academic_year');
            }
            else if(!msg.errors) {
                if(step === 1) {
                    if(!run_once){
                        $.set_dropdown_data('study_period',msg.periods,'Kies je studiejaar');
                        $.set_dropdown_data('school',msg.schools,'Kies je school');
                        $.set_dropdown_data('enrollment',msg.enrollments,'Kies je opleiding');
                        run_once = true;
                    }
                    let shortDesc = $('#short_desc').val();
                    $('.title_header').text($('#title').val());
                    $('#short_description').val(shortDesc);
                }
                if(step !== 3){
                    $.next_form(['step'+next_step+'_form']);
                } else if(step === 3){
                    window.location.replace(host+'/'+msg.newPage);
                }
            }
        }
    });
};
$.validate_user = function(step)
{
   let formData = new FormData();
   let avatar;
   if(step === 1) {
      avatar = $('#avatar').val() !=  '' ? $('#avatar').prop('files')[0] : '';
      formData = $.set_form_data('register_form_user');
      formData.append('avatar', avatar);
   }
   if(step === 2) {
       formData = $.set_form_data('register_form_student');
   }
   formData.append('step', step);
   $.ajax({
       type: "POST",
       url: host + '/validate_user',
       data: formData,
       processData: false,
       contentType: false,
       dataType: 'json',
       success: function (msg) {
          if(msg.errors) {
             $.set_error_messages(msg.errors,step,'user');
          }
          else if(!msg.errors) {
             if(step === 1) {
                $.next_form(['register_form_student']);
             }
             else if(step === 2) {
                $.next_form(['step1_form']);
             }
             else if(step === 3) {
                 $('#has_register_or_login').val('true');
             }
          }
       }
   });
};
$.next_form = function(elementArray)
{
    $('form').each(function(i,val){
        let id = $(val).attr('id');
        let result = $.inArray(id,elementArray);
        if(result > -1) {
            $(val).removeClass('hidden');
        }
        else if(result === -1) {
            $(val).addClass('hidden');
        }
    });
};
$.set_form_data = function(elementID,excludedElements)
{
   let formData = new FormData();
   let data;
   if(typeof excludedElements === "undefined") {
       data = $('#'+elementID).serializeArray();
   } else {
       data = $('#'+elementID).serializeArray();
       $.each(excludedElements,function(key,value){
           data = $.grep(data, function(n) {
               return n.name !== value;
           });
       });
   }
   $.each(data,function(key,input){
      formData.append(input.name,input.value);
   });
   return formData;
};
$.set_dropdown_data = function(elementID,objectArray,labelText)
{
    $('#'+elementID).append($("<option></option>").attr("label", labelText)
        .prop("disabled", true)
        .prop("selected", true)
        .prop("hidden", true));
    $.each(objectArray, function (i,val) {
        let text;
        if(elementID === 'study_period'){
            text = this.period;
        } else if(elementID === 'school'){
            text = this.name;
        } else if(elementID === 'enrollment'){
            text = this.enrollment;
        }
        $('#'+elementID).append($("<option></option>").attr("value", this.id).text(text));
    });
};
$.set_error_messages = function(errors,step,type)
{
    let inputs;
    if(type === 'user') {
        if(step === 1) {
            inputs = $('#register_form_user').find('.form-control');
        }
        if(step === 2) {
            inputs = $('#register_form_student').find('.form-control');
        }
    }
    else if(type === 'academic_year') {
        inputs = $('#step'+step+'_form').find('.form-control');
    }
    $.each(inputs,function(i,val) {
        let element_div = '#' + $(val).attr('name') + '_div';
        let element_error = '#' + $(val).attr('name') + '_error_message';
        $(element_div).removeClass('has-error');
        $(element_error).empty();
    });
    $.each(errors,function(i,val){
        let element_div = '#' + i + '_div';
        let element_error = '#' + i + '_error_message';
        $(element_div).addClass('has-error');
        $(element_error).text(val);
    });
};
