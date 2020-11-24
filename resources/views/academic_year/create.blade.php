@extends('layouts.app')

@push('scripts_head')
<script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
@endpush

@push('styles')
    <link href="{{ mix('css/datepicker.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container">
        <div class="section-block">
        {{ csrf_field() }}
        @if(Auth::check())
            {{--<input type="hidden" id="user_id" value="{{ Auth::user()->id }}">--}}
            <input type="hidden" id="has_register_or_login" value="true">
        @elseif(!Auth::check())
            {{--<input type="hidden" id="user_id" value="">--}}
            <input type="hidden" id="has_register_or_login" value="false">
        @endif

            {{--<div id="login_register" class="">--}}
                <form id="register_form" class="form-horizontal hidden">
                    <h3 class="text-center">Registreer een account door op de onderstaande knop te drukken</h3>

                    <div class="row">
                        <div class="col-xs-5 col-xs-offset-4">
                            <hr />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 col-xs-offset-4 text-center">
                            <button type="submit" id="btn_register" class="btn btn-primary">Registreren</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 col-xs-offset-4">
                            <hr />
                        </div>
                    </div>
                </form>
                <form id="login_form" class="form-horizontal hidden" action="{{route('login')}}" method="GET">
                    <div class="row">
                        <div class="col-xs-5 col-xs-offset-4 text-center">
                            <h3>Log in als je al een account hebt</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 col-xs-offset-4">
                            <hr />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 col-xs-offset-4">
                            <div class="form-group form-inline text-center">
                                <button type="submit" class="btn btn-primary">Inloggen</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 col-xs-offset-4">
                            <hr />
                        </div>
                    </div>
                </form>
            {{--</div>--}}
            <form id="register_form_user" class="form-horizontal hidden">
                {{--<input type="hidden" class="step" name="step" placeholder="step" value="1">--}}
                <div class="page-header text-center">
                    <h1>Registreer gebruikersaccount</h1>
                </div>
                <div class="row">
                    <div class="col-xs-8 col-xs-offset-2">
                        <div class="row">
                            <div class="form-group col-xs-6" id="first_name_div">
                                <input type="text" id="first_name" name="first_name" placeholder="Voornaam" class="form-control">
                                <span id="first_name_error_message" class="text-danger"><strong></strong></span>
                            </div>
                            <div class="form-group col-xs-6" id="last_name_div">
                                <input type="text" id="last_name" name="last_name" placeholder="Achternaam" class="form-control">
                                <span id="last_name_error_message" class="text-danger"><strong></strong></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-12" id="avatar_div">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon">Profiel foto</span>
                                    <input id="avatar" name="avatar" class="form-control input-sm" type="file">
                                    <span id="avatar_error_message" class="text-danger"><strong></strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-12" id="email_div">
                                <input type="text" id="email" name="email" class="form-control" placeholder="Email adres">
                                <span id="email_error_message" class="text-danger"><strong></strong></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-12" id="password_div">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Wachtwoord">
                                <span id="password_error_message" class="text-danger"><strong></strong></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-12" id="password_confirmation_div">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Wachtwoord bevestigen">
                                <span id="password_confirmation_error_message" class="text-danger"><strong></strong></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <button type="submit" class="btn btn-primary pull-right">Volgende stap</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <form id="register_form_student" class="form-horizontal hidden">
                {{--<input type="hidden" class="step" name="step" placeholder="step" value="2">--}}
                <div class="page-header text-center">
                    <h1>Registreer gebruikersaccount</h1>
                </div>
                <div class="row">
                    <div class="col-xs-8 col-xs-offset-2">
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <blockquote>Om het opgehaalde bedrag uit te keren hebben we je rekening nummer nodig</blockquote>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-12" id="iban_div">
                                <input type="text" id="iban" name="iban" class="form-control" placeholder="Rekening nummer(IBAN)">
                                <span id="iban_error_message" class="text-danger"><strong></strong></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <blockquote>Schrijf een kort verhaal over jezelf om potentiele donateurs te overtuigen</blockquote>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-12" id="description_div">
                                <input type="text" id="description" name="description" class="form-control" placeholder="Schrijf een kort verhaal over je zelf">
                                <span id="description_error_message" class="text-danger"><strong></strong></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <label for="date_of_birth" class="control-label">Selecteer je geboortedatum:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-12" id="date_of_birth_div">
                                <input type="text" data-provide="datepicker" data-date-format="yyyy/mm/dd" id="date_of_birth" class="form-control" name="date_of_birth">
                                <span id="date_of_birth_error_message" class="text-danger"><strong></strong></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <button type="submit" class="btn btn-primary pull-right">Registreer je account</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <form id="step1_form" class="form-horizontal hidden">
                <div class="page-header">
                    <h1>Start studiejaar</h1>
                </div>

                <div class="row">
                    <div class="col-xs-7">
                        <div class="row">
                            <div class="form-group" id="title_div">
                                <div class="col-xs-5">
                                    <label for="title" class="control-label">Titel van je campagne:</label>
                                </div>
                                <div class="col-xs-6">
                                    <input type="text" id="title" name="title" class="form-control">
                                    <span id="title_error_message" class="text-danger"><strong></strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="row"><br>
                            <div class="form-group" id="school_level_id_div">
                                <div class="col-xs-5">
                                    <label for="school_level_id" class="control-label">Niveau:</label>
                                </div>
                                <div class="col-xs-6">
                                    <select class="form-control" id="school_level_id" name="school_level_id" value="Kies je school niveau">
                                        <option label="Kies je leerniveau" disabled selected hidden></option>
                                        @foreach ($school_levels as $school_level)
                                            <option value="{{$school_level->id}}">{{$school_level->level}}</option>
                                        @endforeach
                                    </select>
                                    <span id="school_level_id_error_message" class="text-danger"><strong></strong></span>
                                </div>
                            </div>

                        </div>
                        <div class="row"><br>
                            <div id="short_desc_div">
                                <div class="form-group col-xs-6">
                                    <label for="short_desc" class="control-label">Korte omschrijving:</label>
                                </div>
                                <div class="form-group col-xs-6">
                                    <textarea id="short_desc" name="short_desc" class="form-control" style="resize:none;"></textarea>
                                    <span id="short_desc_error_message" class="text-danger"><strong></strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="row"><br>
                            <div class="form-group col-xs-12">
                                <button type="submit" class="btn btn-primary pull-right">Volgende</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <form id="step2_form" class="form-horizontal hidden">
                <div class="page-header">
                    <h1>Start studiejaar</h1>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4 center-block text-center">
                            <div id="btn_group_step_2" class="btn_nav btn-group btn-group-justified" role="group" aria-label="...">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn_step btn btn-primary" value="1">1</button>
                                </div>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn_step btn btn-primary" value="2">2</button>
                                </div>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn_step btn btn-primary" value="3">3</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12">
                        <h2 class="title_header">Studiejaar Titel</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="row">
                            <div class="form-group" id="study_period_div">
                                <div class="col-xs-5">
                                    <label for="study_period" class="control-label">Studiejaar:</label>
                                </div>
                                <div class="col-xs-6">
                                    <select id="study_period" name="study_period" class="form-control"></select>
                                    <span id="study_period_error_message" class="text-danger"><strong></strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group" id="school_div">
                                <div class="col-xs-5">
                                    <label for="school" class="control-label">Instelling:</label>
                                </div>
                                <div class="col-xs-6">
                                    <!-- Laat alleen scholen zien die passen bij geselecteerde school_level in step1-->
                                    <select id="school" name="school" class="form-control"></select>
                                    <span id="school_error_message" class="text-danger"><strong></strong></span>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group" id="enrollment_div">
                                <div class="col-xs-5">
                                    <label for="enrollment" class="control-label">Opleiding:</label>
                                </div>
                                <div class="col-xs-6">
                                    <select id="enrollment" name="enrollment" class="form-control"></select>
                                    <span id="enrollment_error_message" class="text-danger"><strong></strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group" id="academic_email_div">
                                <div class="col-xs-5">
                                    <label for="academic_email" class="control-label">School e-mail:</label>
                                </div>
                                <div class="col-xs-6">
                                    <input type="text" id="academic_email" name="academic_email" class="form-control">
                                    <span id="academic_email_error_message" class="text-danger"><strong></strong></span>
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div id="short_description_div">
                                <div class="form-group col-xs-6">
                                    <label for="short_description" class="control-label">Korte omschrijving:</label>
                                </div>
                                <div class="form-group col-xs-6">
                                    <textarea id="short_description" name="short_description" class="form-control" style="resize:none;"></textarea>
                                    <span id="short_description_error_message" class="text-danger"><strong></strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div id="thumbnail_url_div">
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <label for="thumbnail_url" class="control-label">Afbeelding:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <img class="img-responsive" id="thumbnail_url_preview" src="">
                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <label class="btn btn-primary btn-file pull-right">
                                    Kies een uitgelichte afbeelding <input id="thumbnail_url" name="thumbnail_url" type="file" style="display: none;">
                                </label>
                                <span id="thumbnail_url_error_message" class="text-danger"><strong></strong></span>
                                {{--<button type="button" class="btn btn-primary pull-right">Browse</button>--}}
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <button type="submit" class="btn btn-primary pull-right">Ga naar de volgende stap</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <form id="step3_form" onsubmit="$.show_spinner();" class="form-horizontal hidden">
            <div class="page-header">
                <h1>Start studiejaar</h1>
            </div>
            {{--<div id="hidden_goals" class="hidden"></div>--}}
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4 center-block text-center">
                        <div id="btn_group_step_3" class="btn_nav btn-group btn-group-justified" role="group" aria-label="...">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn_step btn btn-primary" value="1">1</button>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn_step btn btn-primary" value="2">2</button>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn_step btn btn-primary" value="3">3</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-12">
                    <h2 class="title_header">Studiejaar Titel</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div id="full_description_div">
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="full_description" class="control-label">Uitgebreide omschrijving:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <textarea id="full_description" name="full_description" class="form-control" style="resize:none;"></textarea>
                                <script>
                                    CKEDITOR.replace( 'full_description' );
                                </script>
                                <span id="full_description_error_message" class="text-danger"><strong></strong></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="row">
                        <div class="col-xs-12">
                            <label for="goals" class="control-label">Benodigdheden</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <blockquote>
                                Vul hieronder de benodigdheden die jij nodig hebt voor je studiejaar
                            </blockquote>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="form-group col-xs-12" id="goals_info_message_div">
                                    <span id="goals_info_message" style="display:block;" class="text-info"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-12" id="goals_div">
                                    <!-- Aangeven wat eindbedrag is min 9% -->
                                    <table class="table" id="goals">
                                        <thead>
                                        <tr>
                                            <th class="col-xs-5">Bedrag</th>
                                            <th class="col-xs-5">Omschrijving</th>
                                            <th class="col-xs-2"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <span id="goals_error_message" class="text-danger"><strong></strong></span>
                                </div>
                            </div>
                            <div class="row">
                                <div id="new_goal_amount_div">
                                    <div class="form-group col-xs-5">
                                        <input type="text" id="new_goal_amount" name="new_goal_amount" class="form-control" placeholder="Bedrag">
                                        <span id="new_goal_amount_error_message" class="text-danger"><strong></strong></span>
                                    </div>
                                </div>
                                <div id="new_goal_description_div">
                                    <div class="form-group col-xs-5">
                                        <input type="text" id="new_goal_description" name="new_goal_description" class="form-control" placeholder="Omschrijving">
                                        <span id="new_goal_description_error_message" class="text-danger"><strong></strong></span>
                                    </div>
                                </div>
                                <div class="form-group col-xs-2 text-center">
                                    <button id="new_goal_add" class="btn btn-primary btn-sm" type="button">Toevoegen</button>
                                    {{--<span  class="glyphicon glyphicon-plus" aria-hidden="true" style="font-size: 0.9em; cursor:pointer;"></span>--}}
                                </div>
                            </div><br>
                        </div>
                    </div>

                    <div class="row"><br>
                        <div class="col-xs-12">
                            <button type="submit" id="finish_registration" class="btn btn-primary pull-right">Ga naar de volgende stap</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ mix('js/datepicker.js') }}"></script>
<script src="{{ mix('js/academic_year.js') }}"></script>
@endpush