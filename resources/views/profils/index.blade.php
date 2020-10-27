{{-- \resources\views\deposits\show.blade.php --}}
@extends('layouts.app')

@section('title', '| Mon profil')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5> Dashboard</h5>
                    <span>Mon profil</span>
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
                        <a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Mon profil</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-5">
        <div class="card">
            <div class="card-body">
                <div class="text-center"> 
                    <img src="{{url('/storage/profile_images/'.auth()->user()->profile_picture) }}" class="rounded-circle" width="150" />
                    <h4 class="card-title mt-10">{{auth()->user()->name}} {{auth()->user()->firstname}}</h4>
                    <p class="card-subtitle">Administrateur</p>
                    <!--<div class="row text-center justify-content-md-center">
                        <div class="col-4"><a href="javascript:void(0)" class="link"><i class="ik ik-user"></i> <font class="font-medium">254</font></a></div>
                        <div class="col-4"><a href="javascript:void(0)" class="link"><i class="ik ik-image"></i> <font class="font-medium">54</font></a></div>
                    </div>-->
                </div>
            </div>
            <hr class="mb-0"> 
            <div class="card-body"> 
                <small class="text-muted d-block">Adresse email</small>
                <h6>{{auth()->user()->email}}</h6> 
                <small class="text-muted d-block pt-10">Téléphone</small>
                <h6>{{auth()->user()->phone_number}}</h6> 
                <small class="text-muted d-block pt-10">Adresse</small>
                <h6>{{auth()->user()->address}}</h6>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-7">
      @include('inc.messages')
        <div class="card">
            <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">

                <li class="nav-item ">
                    <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="true">Profil</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">Paramètres</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-6"> <strong>Nom et prénom(s)</strong>
                                <br>
                                <p class="text-muted">{{auth()->user()->name}} {{auth()->user()->firstname}}</p>
                            </div>
                            <div class="col-md-3 col-6"> <strong>Téléphone</strong>
                                <br>
                                <p class="text-muted">{{auth()->user()->phone_number}}</p>
                            </div>
                            <div class="col-md-3 col-6"> <strong>Email</strong>
                                <br>
                                <p class="text-muted">{{auth()->user()->email}}</p>
                            </div>
                            <div class="col-md-3 col-6"> <strong>Adresse</strong>
                                <br>
                                <p class="text-muted">{{auth()->user()->address}}</p>
                            </div>
                        </div>
                        <hr>
                        <!--<p class="mt-30">Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.</p>-->
                    </div>
                </div>
                <div class="tab-pane fade" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
                    <div class="card-body">
                        <form class="form-horizontal" method="POST" action="{{ route('profils.store') }}">
                          @csrf
                            <div class="form-group">
                                <label for="example-name">Nom</label>
                                <input type="text" placeholder="Johnathan Doe" class="form-control" name="name" id="example-name" value="{{auth()->user()->name}}">
                            </div>

                            <div class="form-group">
                                <label for="example-firstname">Prénom(s)</label>
                                <input type="text" placeholder="Johnathan Doe" class="form-control" name="firstname" id="example-firstname" value="{{auth()->user()->firstname}}">
                            </div>

                            <div class="form-group">
                                <label for="example-email">Email</label>
                                <input type="email" placeholder="johnathan@admin.com" class="form-control" name="email" id="example-email" value="{{auth()->user()->email}}">
                            </div>

                            <div class="form-group">
                                <label for="example-phone">No de Téléphone</label>
                                <input type="text" placeholder="123 456 7890" id="example-phone" name="phone_number" class="form-control" value="{{auth()->user()->phone_number}}">
                            </div>

                            <div class="form-group">
                                <label for="example-address">Adresse</label>
                                <textarea id="example-address" name="address" class="form-control">{{auth()->user()->address}}</textarea>
                            </div>

                            <button class="btn btn-success" type="submit">Modifier mon profil</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Main content -->

 @endsection