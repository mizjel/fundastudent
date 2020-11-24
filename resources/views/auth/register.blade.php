@extends('layouts.app')

@push('styles')

@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Registreren</div>
                <div class="panel-body" id="account_register_el" v-cloak>
                    <div v-if="finalView.view">
                        @{{ finalView.message }}
                    </div>

                    <div v-if="!finalView.view">
                        <form v-show="getStep(1)" enctype="multipart/form-data" @submit.prevent="validate('step1',2)" autocomplete="off">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-xs-12 col-sm-4" :class="{'has-error': errors.first_name }">
                                        <input v-model="step1.first_name" name="first_name" class="form-control input-sm" placeholder="{{ ucfirst(trans('validation.attributes.first_name')) }}" type="text">
                                        <span v-if="errors.first_name" class="text-danger"><strong>@{{ errors.first_name[0] }}</strong></span>
                                    </div>
                                    <div class="form-group col-xs-12 col-sm-4" :class="{'has-error': errors.prefix }">
                                        <input v-model="step1.prefix" name="prefix" class="form-control input-sm" placeholder="{{ ucfirst(trans('validation.attributes.prefix')) }}" type="text">
                                        <span v-if="errors.prefix" class="text-danger"><strong>@{{ errors.prefix[0] }}</strong></span>
                                    </div>

                                    <div class="form-group form-group-sm col-xs-12 col-sm-4" :class="{'has-error': errors.last_name }">
                                        <input v-model="step1.last_name" name="last_name" class="form-control input-sm" placeholder="{{ ucfirst(trans('validation.attributes.last_name')) }}" type="text">
                                        <span v-if="errors.last_name" class="text-danger"><strong>@{{ errors.last_name[0] }}</strong></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-12">
                                        <div class="input-group input-group-sm" :class="{'has-error': errors.avatar }">
                                            <span class="input-group-addon">{{ ucfirst(trans('validation.attributes.avatar')) }}</span>
                                            <input id="avatar" name="avatar" class="form-control input-sm" type="file">
                                        </div>
                                        <span v-if="errors.avatar" class="text-danger"><strong>@{{ errors.avatar[0] }}</strong></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group form-group-sm col-xs-12" :class="{'has-error': errors.email }">
                                        <input v-model="step1.email" name="email" class="form-control input-sm" placeholder="{{ ucfirst(trans('validation.attributes.email')) }}" type="text">
                                        <span v-if="errors.email" class="text-danger"><strong>@{{ errors.email[0] }}</strong></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group form-group-sm col-xs-12" :class="{'has-error': errors.password }">
                                        <input v-model="step1.password" name="password" class="form-control input-sm" placeholder="{{ ucfirst(trans('validation.attributes.password')) }}" type="password">
                                        <span v-if="errors.password" class="text-danger"><strong>@{{ errors.password[0] }}</strong></span>
                                    </div>

                                    <div class="form-group form-group-sm col-xs-12" :class="{'has-error': errors.password_confirmation }">
                                        <input v-model="step1.password_confirmation" name="password_confirmation" class="form-control input-sm" placeholder="{{ ucfirst(trans('validation.attributes.password_confirmation')) }}" type="password">
                                        <span v-if="errors.password_confirmation" class="text-danger"><strong>@{{ errors.password_confirmation[0] }}</strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-sm btn-block btn-primary" v-bind:disabled="btnDisabled">@{{ btnNextText }}</button>
                            </div>
                        </form>

                        <!-- Step 2 : want to register as student? !-->
                        <form v-show="getStep(2)">
                            <div class="modal-body">
                                <p>Wilt u zich als student registeren?</p>
                            </div>
                            <div class="modal-footer">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <button type="button" v-on:click="setStep(1)" class="btn btn-sm btn-block btn-default" >{{ trans('buttons.previous') }}</button>
                                    </div>
                                    <div class="col-xs-4">
                                        <button type="button" v-on:click="validate('step2','final')" class="btn btn-sm btn-block btn-danger">{{ trans('buttons.no') }}</button>
                                    </div>
                                    <div class="col-xs-4">
                                        <button type="button" v-on:click="setStep(3)" class="btn btn-sm btn-block btn-primary">{{ trans('buttons.yes') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Step 3 : Register as student !-->
                        <form v-show="getStep(3)" @submit.prevent="validate('step3','final')" autocomplete="off">
                            <div class="modal-body">
                                <p v-if="!school_types">@{{ loadingText }}</p>
                                <div v-if="school_types" class="row">
                                    <div class="form-group form-group-sm col-xs-12" :class="{'has-error': errors.school_type }">
                                        <select v-model="step3.school_type" class="form-control" name="school_type">
                                            <option hidden value="">{{ trans('register.student.select_school_type') }}</option>
                                            <option v-for="data in school_types" v-bind:value="data.id">@{{ data.type }}</option>
                                        </select>
                                        <span v-if="errors.school_type" class="text-danger"><strong>@{{ errors.school_type[0] }}</strong></span>
                                    </div>
                                </div>

                                <small v-if="schoolsLoading">@{{ loadingText }}</small>
                                <div v-show="!schoolsLoading" class="row">
                                    <div class="form-group form-group-sm col-xs-12 col-sm-6" :class="{'has-error': errors.student_school }">
                                        <select  v-model="step3.student_school" class="form-control" name="student_school">
                                            <option hidden value="">{{ trans('register.student.select_school') }}</option>
                                            <option v-for="data in schools" v-bind:value="data.id">@{{ data.name }}</option>
                                        </select>
                                        <span v-if="errors.student_school" class="text-danger"><strong>@{{ errors.student_school[0] }}</strong></span>
                                    </div>

                                    <div class="form-group form-group-sm col-xs-12 col-sm-6" :class="{'has-error': errors.student_enrollment }">
                                        <select v-model="step3.student_enrollment" class="form-control" name="school_type">
                                            <option hidden value="">{{ trans('register.student.select_enrollment') }}</option>
                                            <option v-for="data in enrollments" v-bind:value="data.id">@{{ data.enrollment }}</option>
                                        </select>
                                        <span v-if="errors.student_enrollment" class="text-danger"><strong>@{{ errors.student_enrollment[0] }}</strong></span>
                                    </div>
                                </div>

                                <div v-show="!schoolsLoading" class="row">
                                    <div class="form-group form-group-sm col-xs-12 col-sm-6" :class="{'has-error': errors.date_of_birth }">
                                        <input v-model="step3.date_of_birth" id="date_of_birth" name="date_of_birth" class="form-control input-sm" placeholder="{{ ucfirst(trans('validation.attributes.date_of_birth')) }}" type="text">
                                        <span v-if="errors.date_of_birth" class="text-danger"><strong>@{{ errors.date_of_birth[0] }}</strong></span>
                                    </div>

                                    <div class="form-group form-group-sm col-xs-12 col-sm-6" :class="{'has-error': errors.student_email }">
                                        <input v-model="step3.student_email" name="student_email" class="form-control input-sm" placeholder="{{ ucfirst(trans('validation.attributes.student_email')) }}" type="text">
                                        <span v-if="errors.student_email" class="text-danger"><strong>@{{ errors.student_email[0] }}</strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <button type="button" v-bind:disabled="btnDisabled" v-on:click="setStep(2)" class="btn btn-sm btn-block btn-default">{{ trans('buttons.previous') }}</button>
                                    </div>
                                    <div v-if="!schoolsLoading" class="col-xs-6">
                                        <button type="submit" class="btn btn-sm btn-block btn-primary" v-bind:disabled="btnDisabled">@{{ btnCreateText }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ mix('js/register.js') }}"></script>
@endpush
