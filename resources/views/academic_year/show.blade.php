@extends('layouts.app')

@push('styles')

@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="section-block">
                        <div class="head-campaign-list">
                            <div class="head-campaign-list-item">
                                <h3 class="header-label"><span class="label label-primary">{{ $academicYear->donations->where('paid', 1)->count() }}</span></h3>
                                <span>Funders</span>
                            </div>
                            <div class="head-campaign-list-item">
                                <h3 class="header-label"><span class="label label-primary">{{ $academicYear->academic_year_period->period }}</span></h3>
                                <span>Studiejaar</span>
                            </div>
                            <div class="head-campaign-list-item">
                                <h3 class="header-label"><span class="label label-primary">{{ $daysLeft }}</span></h3>
                                <span>Dagen te gaan</span>
                            </div>
                            <div class="head-campaign-list-item">
                                <a href="{{ route('donation.get', ['id' => $academicYear->id]) }}" class="btn btn-default"><i class="fa fa-money" aria-hidden="true"></i> Doneren</a>
                            </div>
                    </div>
                </div>

                <div class="section-block">
                    <h1>{{ $academicYear->title }}</h1>
                    <p>
                        <h4><span class="label label-primary"><i class="fa fa-user-circle" aria-hidden="true"></i> {{ $academicYear->user->getFullname() }}</span></h4>
                    </p>
                    <div class="row">
                        <div class="col-xs-12 col-sm-7 form-group">
                            <img src="{{ $academicYear->getThumbnail() }}" class="img-responsive img-rounded"/>
                        </div>
                        <div class="col-xs-12 col-sm-5 form-group">
                            <p id="short_description">{{ $academicYear->short_description }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="section-block extra">
                                <p>
                                    <b>{{ $amountServiceClass->getReadableAmount($academicYear->donations->where('paid', 1)->sum('amount')) }}</b>
                                    behaald van de
                                    <b>{{ $amountServiceClass->getReadableAmount($academicYear->goals->sum('amount')) }}</b>
                                </p>
                                <div class="progress nm">
                                    <div class="progress-bar progress-bar-striped active" role="progressbar"
                                         aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"
                                         style="width: {{ $percentage }}%;">
                                        {{ $percentage }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-block" id="type-block">
                    <ul class="nav nav-pills">
                        @foreach(['campagne', 'updates', 'doelen', 'funders'] as $tab)
                            <li {{ $type == $tab ? 'class=active' : ''  }}><a href="{{ route('academic_years.show', [$academicYear, 'type' => $tab]) }}"><b>{{ ucfirst($tab) }}</b></a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="section-block">
                    <div class="tab-content">
                        <div id="campagne" class="tab-pane fade {{ $type == 'campagne' ? 'in active' : ''  }}">
                            @if(Auth::check() && Auth::user()->can('update', $academicYear))
                                <div class="form-group">
                                    <a href="{{ route('academic_years.campaign.edit', $academicYear) }}"
                                       class="btn btn-sm btn-primary">Campagne aanpassen</a>
                                </div>
                            @endif
                            <div class="section-block extra">
                                <h1>{{ $academicYear->title }}</h1>
                                <p>{!! $academicYear->full_description !!}</p>
                            </div>
                        </div>
                        <div id="updates" class="tab-pane fade {{ $type == 'updates' ? 'in active' : ''  }}">
                            <h1>Updates</h1>

                            @if(Auth::check() && Auth::user()->can('update', $academicYear))
                                <div class="form-group">
                                    <a href="{{ route('academic_years.updates.create', $academicYear) }}"
                                       class="btn btn-sm btn-primary">Update toevoegen</a>
                                </div>
                            @endif

                            @if($academicYear->updates->isEmpty())
                                <div class="section-block extra">
                                    Geen updates gevonden
                                </div>
                            @else
                                @foreach($academicYear->updates->sortByDesc('created_at') as $update)
                                    <div class="section-block extra">
                                        <h3 class="">{{ $update->title }} </h3>
                                        <b><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $update->created_at->format('d-m-Y') }}</b>
                                        <p><small>{!! $update->update !!}</small></p>
                                        @if(Auth::check() && Auth::user()->can('update', $academicYear))
                                            <hr>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <form id="delete-update-form" action="{{ route('academic_years.updates.destroy', [$academicYear, $update->id]) }}" method="post">
                                                        <a href="{{ route('academic_years.updates.edit', [$academicYear, $update->id]) }}" class="btn btn-primary btn-sm">Aanpassen</a>

                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button class="btn btn-primary btn-sm" type="submit">Verwijderen</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div id="doelen" class="tab-pane fade {{ $type == 'doelen' ? 'in active' : ''  }}">
                            <h1>Doelen </h1>

                            @if(Auth::check() && Auth::user()->can('update', $academicYear))
                                <div class="form-group">
                                    <a href="{{ route('academic_years.goals.create', $academicYear) }}"
                                       class="btn btn-sm btn-primary">Doel toevoegen</a>
                                </div>
                            @endif

                            @if($academicYear->goals->isEmpty())
                                <div class="section-block extra">
                                    Geen doelen gevonden
                                </div>
                            @else
                                @php $counter = 1; @endphp
                                @foreach($academicYear->goals->sortBy('amount') as $goal)
                                    <div class="section-block extra">
                                        <h3> Doel {{ $counter++ }} - {{ $amountServiceClass->getReadableAmount($goal->amount, true) }} </h3>
                                        <p><small>{{ $goal->description }}</small></p>
                                        @if(Auth::check() && Auth::user()->can('update', $academicYear))
                                            <hr>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <form id="delete-goal-form" action="{{ route('academic_years.goals.destroy', [$academicYear, $goal->id]) }}" method="post">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <a href="{{ route('academic_years.goals.edit', [$academicYear, $goal->id]) }}" class="btn btn-primary btn-sm">Aanpassen</a>
                                                        <button class="btn btn-primary btn-sm" type="submit">Verwijderen</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div id="funders" class="tab-pane fade {{ $type == 'funders' ? 'in active' : ''  }}">
                            <h1>Funders </h1>
                            @if($academicYear->donations->where('paid', 1)->isEmpty())
                                <div class="section-block extra">
                                    Er zijn nog geen donaties
                                </div>
                            @else
                                @foreach($academicYear->donations->where('paid', 1)->sortByDesc('created_at') as $donation)
                                    <div class="section-block extra">
                                        <h3>{{ $amountServiceClass->getReadableAmount($donation->amount) }}</h3>
                                        <b><i class="fa fa-user-circle" aria-hidden="true"></i> {{ $donation->getName() }}</b> |
                                        <b><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $donation->created_at->format('d-m-Y H:i') }}</b>
                                        <p><small>{{ $donation->message }}</small></p>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="section-block">
                    <h1>Donaties</h1>
                    @if($academicYear->donations->where('paid', 1)->isEmpty())
                        <div class="section-block extra">
                            Er zijn nog geen donaties
                        </div>
                    @else
                        @foreach($academicYear->donations->where('paid', 1)->sortByDesc('created_at') as $donation)
                            <div class="section-block extra">
                                {{ $donation->getName() }} heeft
                                <b>{{ $amountServiceClass->getReadableAmount($donation->amount) }}</b> gedoneerd
                            </div>
                        @endforeach
                    @endif
                    <div class="section-block extra">
                        <a href="{{ route('donation.get', ['id' => $academicYear->id]) }}" class=""><b>Ik wil een donatie doen <i class="fa fa-smile-o" aria-hidden="true"></i></b></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            var getUrlParameter = function getUrlParameter(sParam) {
                var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                    sURLVariables = sPageURL.split('&'),
                    sParameterName,
                    i;

                for (i = 0; i < sURLVariables.length; i++) {
                    sParameterName = sURLVariables[i].split('=');

                    if (sParameterName[0] === sParam) {
                        return sParameterName[1] === undefined ? true : sParameterName[1];
                    }
                }
            };

            var type = getUrlParameter('type');

            if (type !== undefined) {
                document.getElementById('type-block').scrollIntoView(true);
            }
        });
    </script>
@endpush