@extends('layouts.app')

@section('content')

    <!-- Content Header (Page header) -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5> Paiements</h5>
                    <span>Détails de paiement</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <nav class="breadcrumb-container" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">Articles</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Détails de paiement</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">Détails de paiement</h3>
                </div>
                
                <div class="card-body">
                    <div class="col-lg-10 offset-lg-1">

                            <table class="table table-bordered" style="border: none;">
                            	<thead>
                                    <tr>
                            		  <th colspan="5" style="">
                                        Paiment de la commande : {{$payment->order_code}}
                                      </th>
                                    </tr>
                            		<!--<th>Téléphone</th>
                                    <th>Type de service</th>
                                    <th>Mode de paiment</th>
                                    <th>Montant</th>-->
                            	</thead>
                                <tbody>
                                	<td>
	                                    <p>
	                                        <strong>Nom du Client :</strong> {{$payment->client_name}} {{$payment->client_firstname}} 
                                        </p>
                                        <p>
	                                        <strong>Téléphone :</strong> {{$payment->client_phone}}
                                        </p>

                                        <p>                                           
                                             <strong>Type de service : </strong> {{$payment->order_service}}
                                            
                                        </p>
                                        <p>
                                        
                                            <strong>Mode de paiment :</strong> {{$payment->paymentmode_title}}
                                          
                                        </p>
                                        <p>
                                            
                                            <strong>Montant payé :</strong> {{$payment->order_amount}} GNF
                                        
	                                    </p>
                                    </td>
                                </tbody>
                            </table> 
                        </div>

                    <br><br><br><br><br><br><br><br>
                    <div class="col-md-12">
					        <a href="{{ url()->previous() }}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-arrow-left"></i> Retour</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
            
@endsection