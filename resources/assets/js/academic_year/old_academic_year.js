let $run_once;
$(document).ready(function(){
    $run_once = false;
    $('#step3_goals_table_info_message').text('Hier komt een berekening te staan');

    $('#step1_school_level_id').on('change',function(){
       $run_once = false;
    });
    $('.btn_step').each(function(){
        if($(this).val() === '1')
        {
            $(this).prop('selected',true);
        }
        else
        {
            $(this).prop('disabled',true);
        }
    });
    var user_id = $('#user_id').val();
    if(user_id)
    {
        //User logged in, start creating a academic_year
        $('#step1').removeClass('hidden');
    }
    else if(!user_id)
    {
        //User not logged in, start account creation first
        $('#login_register').removeClass('hidden');
    }
    $('#btn_register').click(function ()
    {
       $('#register_user').removeClass('hidden');
       $('#login_register').addClass('hidden');
    });
    $('#btn_register_continue').click(function()
    {
        var host = window.location.origin;
        let data = {};
        data.step = 1;
        data._token = $('input[name="_token"]').val();
        data.first_name = $('#register_first_name').val();
        data.last_name = $('#register_last_name').val();
        data.avatar = $('#register_avatar').attr('src');
        data.email = $('#register_email').val();
        data.password = $('#register_password').val();
        data.password_confirmation = $('#register_password_confirm').val();
        $.ajax({
         type: "POST",
         url: host + '/validate_user',
         data: data,
         success: function( msg ) {
            console.log(msg);
             if(msg.errors)
             {
                 /*$.each( msg.errors, function( i, val ) {
                     toastr.error("Error: " + this);
                 });*/
                 if(msg.errors.first_name)
                 {
                     $('#register_first_name_div').addClass('has-error');
                     $('#register_first_name_error_message').text(msg.errors.first_name);
                 }
                 if(msg.errors.last_name)
                 {
                     $('#register_last_name_div').addClass('has-error');
                     $('#register_last_name_error_message').text(msg.errors.last_name);
                 }
                 if(msg.errors.avatar)
                 {
                     $('#register_avatar_div').addClass('has-error');
                     $('#register_avatar_error_message').text(msg.errors.avatar);
                 }
                 if(msg.errors.email)
                 {
                     $('#register_email_div').addClass('has-error');
                     $('#register_email_error_message').text(msg.errors.email);
                 }
                 if(msg.errors.password)
                 {
                     $('#register_password_div').addClass('has-error');
                     $('#register_password_error_message').text(msg.errors.password);
                 }
                 if(msg.errors.password_confirmation)
                 {
                     $('#register_password_confirm_div').addClass('has-error');
                     $('#register_password_confirm_error_message').text(msg.errors.password_confirmation);
                 }
             }
             else if(!msg.errors)
             {
                 $('#register_first_name_div').removeClass('has-error');
                 $('#register_first_name_error_message').empty();
                 $('#register_last_name_div').removeClass('has-error');
                 $('#register_last_name_error_message').empty();
                 $('#register_avatar_div').removeClass('has-error');
                 $('#register_avatar_error_message').empty();
                 $('#register_email_div').removeClass('has-error');
                 $('#register_email_error_message').empty();
                 $('#register_password_div').removeClass('has-error');
                 $('#register_password_error_message').empty();
                 $('#register_password_confirm_div').removeClass('has-error');
                 $('#register_password_confirm_error_message').empty();
                 //console.log("no errors @ validate_user");
                 $('#register_student').removeClass('hidden');
                 $('#register_user').addClass('hidden');
             }
         }
        });
    });
    $('#btn_register_final').click(function(){
        var host = window.location.origin;
        let data = {};
        data.step = 2;
        data._token = $('input[name="_token"]').val();
        data.first_name = $('#register_first_name').val();
        data.last_name = $('#register_last_name').val();
        data.avatar = $('#register_avatar').attr('src');
        data.email = $('#register_email').val();
        data.password = $('#register_password').val();
        data.password_confirmation = $('#register_password_confirm').val();
        data.iban = $('#iban').val();
        data.description = $('#register_student_description').val();
        data.date_of_birth = $('#register_student_date_of_birth').val();
        data.residence = $('#register_student_residence').val();
        data.zip_code = $('#register_student_zip_code').val();

        $.ajax({
            type: "POST",
            url: host + '/validate_user',
            data: data,
            success: function( msg ) {
                //console.log(msg);
                if(msg.errors)
                {
                    if(msg.errors.iban)
                    {
                        $('#register_iban_div').addClass('has-error');
                        $('#register_iban_error_message').text(msg.errors.iban);
                    }
                    if(msg.errors.description)
                    {
                        $('#register_description_div').addClass('has-error');
                        $('#register_description_error_message').text(msg.errors.description);
                    }
                    if(msg.errors.date_of_birth)
                    {
                        $('#register_date_of_birth_div').addClass('has-error');
                        $('#register_date_of_birth_error_message').text(msg.errors.date_of_birth);
                    }
                    if(msg.errors.residence)
                    {
                        $('#register_residence_div').addClass('has-error');
                        $('#register_residence_error_message').text(msg.errors.residence);
                    }
                    if(msg.errors.zip_code)
                    {
                        $('#register_zip_code_div').addClass('has-error');
                        $('#register_zip_code_error_message').text(msg.errors.zip_code);
                    }
                }
                else if(!msg.errors)
                {
                    $('#register_iban_div').removeClass('has-error');
                    $('#register_iban_error_message').empty();
                    $('#register_description_div').removeClass('has-error');
                    $('#register_description_error_message').empty();
                    $('#register_date_of_birth_div').removeClass('has-error');
                    $('#register_date_of_birth_error_message').empty();
                    $('#register_residence_div').removeClass('has-error');
                    $('#register_residence_error_message').empty();
                    $('#register_zip_code_div').removeClass('has-error');
                    $('#register_zip_code_error_message').empty();
                    //console.log(msg.user_id);
                    $('#user_id').val(msg.user_id);
                    $('#register_student').addClass('hidden');
                    $('#step1').removeClass('hidden');
                    //$('#register_user').addClass('hidden');
                }
            }
        });
    });
    $('.btn_step').click(function(){

        if(!$(this).hasClass('disabled'))
        {
            var button_group_id = $(this).parent().parent().attr('id');
            var button_step_id = $(this).text();
            var step = button_group_id.split('_')[3];
            if(button_step_id > step)
            {
                $.validate_step_input(step,button_step_id,false);
            }
            else if(button_step_id < step)
            {
                $.validate_step_input(step,button_step_id,true);
            }

        }

    });
    $('.next_step_button').click(function(){
        var step = +$(this).val();
        let next_step = +step + 1;
        $.validate_step_input(step,next_step,false);
    });

    $("#step3_new_goal_add").click(function() {
        if($.check_goal_input()){

            $('#step3_goals_table tbody').append('<tr>' +
                '<td> '+ $("#step3_new_goal_amount").val() +' </td>'+
                '<td> '+ $("#step3_new_goal_description").val() +' </td>'+
                '<td><span class="glyphicon glyphicon-remove" aria-hidden="true" onclick="$.remove_goal(this)" style="font-size: 0.9em;cursor:pointer;"></span></td>'+
                '</tr>');
            var index = $('#step3_goals_table').children('tbody').children('tr:last').index();

            $('#hidden_goals').append(
                '<input class="goal_'+index+'" id="goal_' + index + '_amount" name="goals['+ index +'][amount]" type="hidden" value="' + $('#step3_new_goal_amount').val() + '">' +
                '<input class="goal_'+index+'" id="goal_' + index + '_description" name="goals['+ index +'][description]" type="hidden" value="' + $('#step3_new_goal_description').val() + '">'
                /*'<input id="goal_' + index + '" name="' + $('#step3_new_goal_description').val() + '" type="hidden" value="' + $('#step3_new_goal_amount').val() + '">'*/
            );
            //$.validate_step_input(3,3,false);
            /*if(!$.calculate_validate_fees(index))
            {
                $('#hidden_goals').children().remove('.goal_'+index);
                console.log('removing .goal_'+index);
                //$('#step3_goals_table tbody').remove(this);
            }*/
            //console.log('trueorfalse?: ' + $.calculate_validate_fees(index));
            $.calculate_validate_fees(index);
            $('#step3_new_goal_amount').val("");
            $('#step3_new_goal_description').val("");

            $('#step3_goals_table').children('tbody').children('tr:last').attr('id', 'goal_' + index);
        }
    });

});

$.calculate_validate_fees = function($goal_index)
{
    let amount = +0;
    let fee;
    let data = {};
    let goal = {};
    let goalAmount;
    let goalDescription;
    var successBool;
    var host = window.location.origin;
    //console.log($goal_index);
    //goals = $('#hidden_goals').find('input[name="goals[][]"]');

    //console.log(goals);
    $('#hidden_goals input').each(function(i,val)
    {
        if($(this).hasClass('goal_' + $goal_index))
        {
            if($(this).attr('name') === 'goals['+$goal_index+'][amount]')
            {
                //data.amount = $(this).val();
                goal.amount = $(this).val();
                //console.log('goalAmount: ' + goalAmount);
            }
            if($(this).attr('name') === 'goals['+$goal_index+'][description]')
            {
                //data.description = $(this).val();
                goal.description = $(this).val();
                //console.log('goalDescription: ' + goalDescription);
            }
        }
        amount += +$(this).attr('value');
    });
    //data.push(goal);
    data.goal = goal;
    fee = +amount/100*9;
    $.ajax({
        type: "POST",
        //contentType: 'application/json',
        url: host + '/academic_years/validate_goal',
        data: data,
        //cache: false,
        //processData: false,
        //contentType: false,
        //async: false,
        success: function (msg) {
            //console.log(msg);
            if (msg.errors) {
                //console.log(msg);
                if(msg.errors.amount)
                {
                    $('#step3_goals_table_div').addClass('has-error');
                    $('#step3_goals_table_error_message').text(msg.errors.amount);
                    $.remove_goal($('#step3_goals_table tbody #goal_'+$goal_index));
                }
            }
            else if(!msg.errors)
            {
                $('#step3_goals_table_info_message').html('Totaal bedrag is: ' + amount + '<br>' + 'Uiteindelijke bedrag: ' + (amount - fee));
            }
        }
    });
    //console.log('bruh?');
    return successBool;
};


$.validate_step_input = function($step, $nav_next_step, $nav_tolower)
{
    if($nav_tolower)
    {
        if($step === '2')
        {
            $('#step1_academic_year_short_desc').val($('#step2_academic_year_short_desc').val());
        }
        $('#step' + $step).addClass('hidden');
        $('#step' + $nav_next_step).removeClass('hidden');
        return;
    }
    let next_step = +$step + 1;
    let data = {};
    //let data = new FormData();
    let goals = [];
    //let goals = new FormData();

    if($step === 3)
    {
        //let newElement = true;
        let currentID = -1;
        let goal = {};
        $('#step3_goals_table tbody tr').each(function(row, tr){
            TableData[row]={
                "taskNo" : $(tr).find('td:eq(0)').text()
                , "date" :$(tr).find('td:eq(1)').text()
                , "description" : $(tr).find('td:eq(2)').text()
                , "task" : $(tr).find('td:eq(3)').text()
            }
        });
        $('#hidden_goals input').each(function(i,val)
        {
            var ele = $(val).attr('id');
            var id = ele.split("_")[1];
            //console.log($(this).attr('name'));
            //console.log('currentID: ' + currentID + ', id: ' + id);
            if(currentID !== id)
            {
                if(currentID !== -1)
                {
                    goals.push(goal);
                }
                currentID = id;
                goal = {};
                //console.log(currentID + ', not same as ' + id);
            }
            if($(this).attr('name') === 'goals['+id+'][amount]')
            {
                //console.log('AMOOOOUNT');
                //console.log('i: ' + i + ', val.id: ' + $(val).attr('id') + ', ele id: ' + id);
                goal.amount = $(this).val();
            }
            else if($(this).attr('name') === 'goals['+id+'][description]')
            {
                //console.log('DESCRIPTION');
                //console.log('i: ' + i + ', val.id: ' + $(val).attr('id') + ', ele id: ' + id);
                goal.description = $(this).val();
            }

        });
        //console.log(goals);
        //goals = $('#hidden_goals input').serializeArray();
        //goals = $.makeArray($('#hidden_goals input'));
        //console.log('goals');
        //console.log(goals);
    }
    var host = window.location.origin;
    /*data.append('step',$step);
    data.append('_token',$('input[name="_token"]').val());
    data.append('user_id',$('#user_id').val());
    data.append('title',$('#step1_academic_year_title').val());
    data.append('school_level_id',$('#step1_school_level_id').find(":selected").val());
    data.append('short_desc',$('#step1_academic_year_short_desc').val());
    data.append('academic_year_study_period',$('#step2_academic_year_study_period').find(":selected").val());
    data.append('school_id',$('#step2_academic_year_school').find(":selected").val());
    data.append('academic_enrollment',$('#step2_academic_year_enrollment').find(":selected").val());
    data.append('academic_email',$('#step2_academic_email').val());
    data.append('slogan',$('#step2_academic_year_slogan').val());
    data.append('thumbnail_url',$('#step2_academic_year_avatar').val());
    data.append('full_desc',$('#step3_academic_year_full_desc').val());
    data.append('funder_motivation',$('#step3_academic_year_funder_motivation').val());
    data.append('goals', goals);*/

    data.step = $step;
    //data._token = $('input[name="_token"]').val();
    data.user_id = $('#user_id').val();
    data.title = $('#step1_academic_year_title').val();
    data.school_level_id = $('#step1_school_level_id').find(":selected").val();
    data.short_desc = $('#step1_academic_year_short_desc').val();
    data.academic_year_study_period = $('#step2_academic_year_study_period').find(":selected").val();
    data.school_id = $('#step2_academic_year_school').find(":selected").val();
    data.academic_enrollment = $('#step2_academic_year_enrollment').find(":selected").val();
    data.academic_email = $('#step2_academic_email').val();
    data.slogan = $('#step2_academic_year_slogan').val();
    //data.thumbnail_url = $('#step2_academic_year_avatar_file').val() !=  '' ? $('#step2_academic_year_avatar_file').prop('files')[0] : '';
    data.thumbnail = $('#step2_academic_year_avatar_file').val() !=  '' ? $('#step2_academic_year_avatar_file').prop('files')[0] : '';
    //data.thumbnail_url = $('#step2_academic_year_avatar').attr('src');
    data.full_desc = $('#step3_academic_year_full_desc').val();
    data.funder_motivation = $('#step3_academic_year_funder_motivation').val();
    //data.goals = goals;
    //console.log(avatar);
        $.ajax({
            type: "POST",
            //contentType: 'application/json',
            url: host + '/academic_years/validate',
            data: data,
            //processData: false,
            contentType: false,
            success: function( msg ) {
                console.log(msg);
                if(msg.errors)
                {
                    $.each( msg.errors, function( i, val ) {

                        if($step === 1)
                        {
                            if(msg.errors.title)
                            {
                                $('#step1_title_div').addClass('has-error');
                                $('#step1_title_error_message').text(msg.errors.title);
                            }
                            if(msg.errors.school_level_id)
                            {
                                $('#step1_school_level_div').addClass('has-error');
                                $('#step1_school_level_error_message').text(msg.errors.school_level_id);
                            }
                        }
                        if($step === 2)
                        {
                            if(msg.errors.academic_year_study_period)
                            {
                                $('#step2_academic_year_study_period_div').addClass('has-error');
                                $('#step2_academic_year_study_period_error_message').text(msg.errors.academic_year_study_period);
                            }
                            if(msg.errors.school_id)
                            {
                                $('#step2_academic_year_school_div').addClass('has-error');
                                $('#step2_academic_year_school_error_message').text(msg.errors.school_id);
                            }
                            if(msg.errors.academic_enrollment)
                            {
                                $('#step2_academic_year_enrollment_div').addClass('has-error');
                                $('#step2_academic_year_enrollment_error_message').text(msg.errors.academic_enrollment);
                            }
                            if(msg.errors.academic_email)
                            {
                                $('#step2_academic_email_div').addClass('has-error');
                                $('#step2_academic_email_error_message').text(msg.errors.academic_email);
                            }
                        }
                        if($step === 3)
                        {
                            if(msg.errors.goals)
                            {
                                $('#step3_goals_table_div').addClass('has-error');
                                $('#step3_goals_table_error_message').text(msg.errors.goals);
                            }
                        }
                        //toastr.error(msg.errors);
                    });
                    $('.btn_step').each(function(){
                        if(+$(this).val() === +$nav_next_step)
                        {
                            $(this).prop('disabled',true);
                            $(this).prop('active',false);
                        }
                        if($(this).val() === $step)
                        {
                            $(this).prop('active',true);
                        }
                    });
                }
                else if(!msg.errors)
                {
                    $('#step' + $step).addClass('hidden');
                    $('#step' + $nav_next_step).removeClass('hidden');
                    //console.log(msg);
                    //console.log("no errors: " + msg);
                    if($step === 1)
                    {
                        //Clear title and school_level_id of errors
                        $('#step1_title_div').removeClass('has-error');
                        $('#step1_title_error_message').empty();
                        $('#step1_school_level_div').removeClass('has-error');
                        $('#step1_school_level_error_message').empty();

                        //console.log('short_desc.val: ' + $('#step1_academic_year_short_desc').val());
                        $('#step2_academic_year_short_desc').val($('#step1_academic_year_short_desc').val());
                        $('.btn_step').each(function(){
                           if($(this).val() === '2')
                           {
                               $(this).prop('disabled',false);
                               $(this).prop('active',true);
                           }
                        });
                        $('.academic_year_title_header').text($('#step1_academic_year_title').val());
                        //Set school and enrollment dropdown, set title and short_desc according to previously entered data
                        if(!$run_once)
                        {
                            $('#step2_academic_year_school').empty();
                            $('#step2_academic_year_enrollment').empty();
                            $('#step2_academic_year_study_period').empty();
                            //<option label="Kies je studiejaar" disabled selected hidden></option>
                            $('#step2_academic_year_school').append($("<option></option>").attr("label", "Kies je school")
                                .prop("disabled", true)
                                .prop("selected", true)
                                .prop("hidden", true));
                            $('#step2_academic_year_enrollment').append($("<option></option>").attr("label", "Kies je opleiding")
                                .prop("disabled", true)
                                .prop("selected", true)
                                .prop("hidden", true));
                            $('#step2_academic_year_study_period').append($("<option></option>").attr("label", "Kies je studiejaar")
                                .prop("disabled", true)
                                .prop("selected", true)
                                .prop("hidden", true));
                            $.each(msg.schools, function () {
                                $('#step2_academic_year_school').append($("<option></option>").attr("value", this.id).text(this.name));
                            });
                            $.each(msg.enrollments, function () {
                                $('#step2_academic_year_enrollment').append($("<option></option>").attr("value", this.id).text(this.enrollment));
                            });
                            $.each(msg.periods, function () {
                                $('#step2_academic_year_study_period').append($("<option></option>").attr("value", this.id).text(this.period));
                            });
                            $run_once = true;
                        }
                    }
                    if($step === 2)
                    {
                        $('#step2_academic_year_study_period_div').removeClass('has-error');
                        $('#step2_academic_year_study_period_error_message').empty();
                        $('#step2_academic_year_school_div').removeClass('has-error');
                        $('#step2_academic_year_school_error_message').empty();
                        $('#step2_academic_year_enrollment_div').removeClass('has-error');
                        $('#step2_academic_year_enrollment_error_message').empty();
                        $('#step2_academic_email_div').removeClass('has-error');
                        $('#step2_academic_email_error_message').empty();

                        $('.btn_step').each(function(){
                            $(this).prop('active',false);
                            if($(this).val() === '3')
                            {
                                $(this).prop('disabled',false);
                                $(this).prop('active',true);
                            }
                        });
                    }
                    if($step === 3)
                    {
                        $('#step3_goals_table_div').removeClass('has-error');
                        $('#step3_goals_table_error_message').empty();
                    }
                }
            }
            /*cache: false,
            contentType: false,
            processData: false*/
        });
};

$.check_goal_input = function()
{
    if($("#step3_new_goal_amount").val() && $("#step3_new_goal_description").val()) {
        //console.log("All goal values are filled")
        return true;
    }
    else if(!$("#step3_new_reward_amount").val() || !$("#step3_new_reward_title").val() || !$("#step3_new_reward_description").val()){
        //console.log("Some goal values are not filled");
        return false;
    }
};
$.check_reward_input = function()
{
    if($("#new_reward_amount").val() && $("#new_reward_title").val() && $("#new_reward_description").val()) {
        //console.log("All reward values are filled")
        return true;
    }
    else if(!$("#new_reward_amount").val() || !$("#new_reward_title").val() || !$("#new_reward_description").val()){
        //console.log("Some reward values are not filled");
        return false;
    }
};
/*$.remove_reward = function(element)
{
    var parent = $(element).closest('tr');
    var parent_id = $(parent).attr('id');
    var parent_id_split = parent_id.split("_")[1];
    var hidden_rewards_div = $('#hidden_rewards').children('input').each(function(){
        var split_id = this.id.split("_")[1];
        if(split_id == parent_id_split)
        {
            console.log("parent_id_split is same: " + parent_id_split +"id: " + this.id + " , split_id: " + split_id);
            $(this).remove();
        }
    });
    $(parent).remove();
};*/
$.remove_goal = function(element)
{
    var parent = $(element).closest('tr');
    var parent_id = $(parent).attr('id');
    var parent_id_split = parent_id.split("_")[1];
    var hidden_goals_div = $('#hidden_goals').children('input').each(function(){
        var split_id = this.id.split("_")[1];
        if(split_id === parent_id_split)
        {
            //console.log("parent_id_split is same: " + parent_id_split +"id: " + this.id + " , split_id: " + split_id);
            $(this).remove();
        }
    });
    $(parent).remove();
};