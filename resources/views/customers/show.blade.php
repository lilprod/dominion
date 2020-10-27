@extends('layouts.app')

@section('title', '| Clients')

@section('content')
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-file-text bg-blue"></i>
                    <div class="d-inline">
                        <h5>Clients</h5>
                        <span>Profil du client</span>
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
                            <a href="#">Clients</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Profil du client</li>
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
                        <img src="{{ $customer->profile_picture }}" class="rounded-circle" width="150" />
                        <h4 class="card-title mt-10">{{$customer->name}} {{$customer->firstname}}</h4>
                        <!--<p class="card-subtitle">Front End Developer</p>
                        <div class="row text-center justify-content-md-center">
                            <div class="col-4"><a href="javascript:void(0)" class="link"><i class="ik ik-user"></i> <font class="font-medium">254</font></a></div>
                            <div class="col-4"><a href="javascript:void(0)" class="link"><i class="ik ik-image"></i> <font class="font-medium">54</font></a></div>
                        </div>-->
                    </div>
                </div>
                <hr class="mb-0"> 
                <div class="card-body"> 
                    <small class="text-muted d-block">Email </small>
                    <h6>{{$customer->email}}</h6> 
                    <small class="text-muted d-block pt-10">Téléphone</small>
                    <h6>{{$customer->phone_number}}</h6> 
                    <small class="text-muted d-block pt-10">Adresse</small>
                    <h6>{{$customer->address}}</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-7">
            <div class="card">
                <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-timeline-tab" data-toggle="pill" href="#current-month" role="tab" aria-controls="pills-timeline" aria-selected="true">Avis et commentaires</a>
                    </li>
                    
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                        <div class="card-body">
                            <div class="profiletimeline mt-0">
                            	<div class="sl-item">
                                    <div class="sl-left"> <img src="{{url('/storage/profile_images/'.auth()->user()->profile_picture)}}" alt="user" class="rounded-circle" /> </div>
                                    <div class="sl-right">
                                        <div>
                                            <p class="mt-10"> <b> Donner une note et un avis</b> </p>
                                            <p class="mt-10">  Partager votre expérience afin de nous à ameliorer nos services </p>
                                        </div>
                                        <div class="like-comm mt-20"> 
                                        	<form action="{{ route('postrating') }}" method="POST">
                        						{{ csrf_field() }}

                                            <div class="rating">
                                                    <input type="hidden" name="client_id" value="{{ $customer->id }}">
                                                <input id="input-1" name="rate" class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="{{ $customer->userAverageRating }}" data-size="xs">

                                            </div>
		                                        <!--<div class="stars stars-example-css">
		                                        	
		                                            <select id="example-css" class="rating-star" name="rate" autocomplete="off">
		                                            	<option value="" label="0"></option>
		                                                <option value="1">1</option>
		                                                <option value="2">2</option>
		                                                <option value="3">3</option>
		                                                <option value="4">4</option>
		                                                <option value="5">5</option>
		                                            </select>
	                                        	</div>-->
	                                        	<div class="like-comm mt-20"> 
	                                            <button type="submit" class="btn btn-primary mr-2">Publier</button>
	                                        </div> 
	                                    	</form>
	                                     </div>
                                        <!--<div class="like-comm mt-20"> 
                                            <a href="javascript:void(0)" class="link mr-10">2 comment</a> 
                                            <a href="javascript:void(0)" class="link mr-10"><i class="fa fa-heart text-danger"></i> 5 Love</a>
                                        </div>-->
                                    </div>
                                </div>
                                <hr>

                                <div class="sl-item">
                                	<div class="sl-right">
		                                <div class="">
                                            <input id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="{{ $customer->averageRating }}" data-size="xs" disabled="">
                                    	</div>
                                    </div>
                                </div>

                            	@foreach($comments as $comment)
                                <div class="sl-item">

                                    <div class="sl-left"> <img src="{{url('/storage/profile_images/'.$comment->user_profilImage)}}" alt="user" class="rounded-circle" /> </div>
                                    <div class="sl-right">
                                        <div>
                                            <a href="javascript:void(0)" class="link"> {{$comment->user_name}}  {{$comment->user_firstname}}</a> <span class="sl-date">5 minutes ago</span>

                                            <p class="mt-10">  {{$comment->body}} </p>
                                        </div>
                                        <!--<div class="like-comm mt-20"> 
                                            <a href="javascript:void(0)" class="link mr-10">2 comment</a> 
                                            <a href="javascript:void(0)" class="link mr-10"><i class="fa fa-heart text-danger"></i> 5 Love</a>
                                        </div>-->
                                    </div>
                                </div>
                                <hr>
                                @endforeach

                                <div class="sl-item">
                                    <div class="sl-right">
                                  <form class="forms-sample" method="POST" action="{{ route('comments.store') }}">
                                    		@csrf
                                           <div class="form-group">
                                           		<input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                                           		<input type="hidden" name="client_userid" value="{{$customer->user_id}}">
                                                <label for="exampleTextarea1">Votre commentaire</label>
                                                <textarea class="form-control" id="exampleTextarea1" rows="4" name="body"></textarea>
                                            </div>
	                                        <div class="like-comm mt-20"> 
	                                            <button type="submit" class="btn btn-primary mr-2">Envoyer</button>
	                                            <button type="reset" class="btn btn-light">Annuler</button>
	                                        </div> 
                                        </form>
                                        
                                    </div>
                                </div>
        					</div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
@endsection
