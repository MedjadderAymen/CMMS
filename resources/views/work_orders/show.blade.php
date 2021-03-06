@extends('layouts.app')

@section('headerScripts')

    <!-- Data Table JS============================================ -->
    <link rel="stylesheet" href="{{asset('../theme/css/jquery.dataTables.min.css')}}">

@endsection()

@section('content')

    <!-- Breadcomb area Start-->
    <div class="breadcomb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcomb-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcomb-wp">
                                    <div class="breadcomb-icon">
                                        <a href="{{route("work_orders.print",["work_order"=>$work_order])}}" target="_blank"><i
                                                class="notika-icon notika-print"></i></a>
                                    </div>
                                    <div class="breadcomb-ctn">
                                        <h2>Demande de Travail N°: <a
                                                href="{{route("work_requests.show",["work_request"=>$work_order->workRequest])}}">DT{{$work_order->workRequest->id}}</a>
                                        </h2>
                                        <p>Etat de l'ordre:
                                            <span class="bread-ntd">
                                                @switch($work_order->workOrderLogs->last()->status)
                                                    @case("created") en attente @break
                                                    @case("opened") ouvert @break
                                                    @case("started") débuté @break
                                                    @case("done") terminé @break
                                                    @case("canceled") annullé @break
                                                    @default Erreur @break
                                                @endswitch
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @can("work_order_delete")
                                @if($work_order->workOrderLogs->last()->status == "created")
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-3">
                                        <div class="breadcomb-report">
                                            <a href="#"
                                               onclick="event.preventDefault(); document.getElementById('delete-form').submit();"
                                               class="btn btn-danger notika-btn-success"><i
                                                    class="notika-icon notika-close"></i> Annuller</a>
                                            <form id="delete-form"
                                                  action="{{ route('work_orders.destroy',['work_order'=>$work_order]) }}"
                                                  method="post" class="d-none">
                                                @csrf
                                                @method("DELETE")
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcomb area End-->

    <!-- Data Table area Start-->
    <div class="data-table-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="normal-table-list mg-t-10">
                        <div class="table-responsive text-center">
                            <table class="table table-bordered ">
                                <thead>
                                <tr>
                                    <th colspan="12" class="text-center"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="3"><img src="{{asset('../theme/img/logo/logo.png')}}"
                                                         style="height: 30px" alt=""/></td>
                                    <td colspan="6"><h3>ORDRE DE TRAVAIL</h3></td>
                                    <td colspan="3">N° OT: <strong>OT{{$work_order->id}}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Intervenant :</strong></td>
                                    <td colspan="3">{{$work_order->maintenanceTechnician->user->name}}</td>
                                    <td colspan="3"><strong>Priorité :</strong></td>
                                    <td colspan="3">{{$work_order->workRequest->priority}}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Equipement :</strong></td>
                                    <td colspan="3">{{$work_order->workRequest->equipment->name}}</td>
                                    <td colspan="3"><strong>Code :</strong></td>
                                    <td colspan="3">{{$work_order->workRequest->equipment->code}}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Type :</strong></td>
                                    <td colspan="3">{{$work_order->type}}</td>
                                    <td colspan="3"><strong>N° DT: </strong></td>
                                    <td colspan="3">DT{{$work_order->workRequest->id}}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Date :</strong></td>
                                    <td colspan="3">{{$work_order->created_at->toDateString()}}</td>
                                    <td colspan="3"><strong>Heure :</strong></td>
                                    <td colspan="3">{{$work_order->created_at->toTimeString()}}</td>
                                </tr>
                                <tr>
                                    <td colspan="12" class="text-left" style="height: 200px">
                                        <strong>Instructions :</strong> {{$work_order->description}} </td>
                                </tr>
                                @if(str_contains($work_order->workOrderLogs->last()->status,"canceled"))
                                    <tr>
                                        <td colspan="12" class="text-left" style="height: 200px">
                                            <strong>Motif d'annulation
                                                :</strong> {{$work_order->reason}} </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Data Table area End-->

    @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super Admin'))
        <!-- Data Table area Start-->
        <div class="data-table-area mg-t-30">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="data-table-list">
                            <div class="basic-tb-hd">
                                <h4>Log</h4>
                            </div>
                            <div class="table-responsive">
                                <table id="data-table-basic" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Heure</th>
                                        <th>Etat</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($work_order->workOrderLogs as $workOrderLog)
                                        <tr>
                                            <td>{{$workOrderLog->created_at->toDateString()}}</td>
                                            <td>{{$workOrderLog->created_at->toTimeString()}}</td>
                                            <th>
                                                @switch($workOrderLog->status)
                                                    @case("created") en attente @break
                                                    @case("opened") ouvert @break
                                                    @case("started") débuté @break
                                                    @case("done") terminé @break
                                                    @case("canceled") annullé @break
                                                    @default Erreur @break
                                                @endswitch
                                            </th>
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
    @endif

    @if(isset($work_order->interventionReport))
        <!-- Data Table area Start-->
        <div class="data-table-area mg-t-10">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mg-t-10">
                        <div class="normal-table-list mg-t-10">
                            <div class="table-responsive text-center">
                                <table class="table table-bordered ">
                                    <thead>
                                    <tr>
                                        <th colspan="12" class="text-center"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td colspan="3"><img src="{{asset('../theme/img/logo/logo.png')}}"
                                                             style="height: 30px" alt=""/></td>
                                        <td colspan="6"><h3>Rapprt d'intervention</h3></td>
                                        <td colspan="3">N° RI:
                                            <strong>RI{{$work_order->interventionReport->id}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><strong>Nature :</strong></td>
                                        <td colspan="9">{{$work_order->interventionReport->nature}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" class="text-left" style="height: 200px">
                                            <strong>Détails Intervention
                                                :</strong> {{$work_order->interventionReport->observation}} </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" class="text-left" style="height: 200px">
                                            <div class="basic-tb-hd">
                                                <h4>Piéces de Rechange utilisées</h4>
                                            </div>
                                            <div class="table-responsive">
                                                <table id="data-table-basic" class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>Code</th>
                                                        <th>Designation</th>
                                                        <th>Catégories</th>
                                                        <th>Quantité</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($work_order->interventionReport->spareParts as $sparePart)
                                                        <tr>
                                                            <td>{{$sparePart->code}}</td>
                                                            <td>{{$sparePart->designation}}</td>
                                                            <td>{{$sparePart->sparePartCategory->tag}}</td>
                                                            <td>{{$sparePart->pivot->quantity}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Data Table area End-->
    @endif

    <br>
    <br>
    <br>

@endsection()
