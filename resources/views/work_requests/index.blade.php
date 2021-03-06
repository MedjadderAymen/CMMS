@extends('layouts.app')

@section('headerScripts')

    <!-- Data Table JS============================================ -->
    <link rel="stylesheet" href="{{asset('../theme/css/jquery.dataTables.min.css')}}">

@endsection()

@section('content')


    <!-- Data Table area Start-->
    <div class="data-table-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="data-table-list">
                        <div class="basic-tb-hd">
                            <h4>Demandes de travail</h4>
                        </div>
                        <div class="table-responsive">
                            <table id="data-table-basic" class="table table-striped">
                                <thead>
                                <tr>
                                    @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super Admin'))
                                        <th><strong>Employé</strong></th>
                                    @endif
                                    <th>Date</th>
                                    <th>Heure</th>
                                    <th>Equipement</th>
                                    <th>Code</th>
                                    <th>Priorité</th>
                                    <th>Etat</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($workRequests as $workRequest)
                                    <tr>
                                        @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super Admin'))
                                            <th><strong>{{$workRequest->user->name}}</strong></th>
                                        @endif
                                        <td>{{$workRequest->created_at->toDateString()}}</td>
                                        <td>{{$workRequest->created_at->toTimeString()}}</td>
                                        <td>{{$workRequest->equipment->name}}</td>
                                        <td>{{$workRequest->equipment->code}}</td>
                                        <td>{{$workRequest->priority}}</td>
                                        <td>
                                            @switch($workRequest->status)

                                                @case(0) en attente @break
                                                @case(1) en cours @break
                                                @case(2) traitée @break
                                                @case(3) annullée @break
                                                @default N/A @break
                                            @endswitch
                                        </td>
                                        <td><a href="{{route("work_requests.show", ["work_request"=>$workRequest])}}">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Data Table area End-->

@endsection()
