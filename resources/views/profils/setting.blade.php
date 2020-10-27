{{-- \resources\views\profils\setting.blade.php --}}
@extends('layouts.app')

@section('title', '| Changer mot de passe')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5> Dashboard</h5>
                    <span>Paramètres</span>
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
                    <li class="breadcrumb-item active" aria-current="page">Paramètres</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- Main content -->
    <div class="row">
        <div class="col-md-8">
        @include('inc.messages')
              <div class="card">
	            <div class="card-header with-border">
	              <h3 class="card-title">Changer mot de passe</h3>
	            </div>
	            <!-- /.card-header -->
	            <!-- form start -->
	            <form class="form-horizontal" method="POST" action="{{route('updatepassword')}}">
	            	@csrf
	              <div class="card-body">

	              	<div class="form-group is-empty">
	                  <label for="inputPassword3" class="col-sm-4 control-label">Ancien mot de passe</label>

	                  <div class="col-sm-8">
	                    <input type="password" class="form-control" id="inputPassword3" placeholder="Ancien mot de passe" name="old_password">
	                  </div>
	                </div>

	                <div class="form-group is-empty">
	                  <label for="inputPassword3" class="col-sm-4 control-label">Nouveau Mot de passe</label>

	                  <div class="col-sm-8">
	                    <input type="password" class="form-control" id="inputPassword3" placeholder="Nouveau mot de passe" name="new_password">
	                  </div>
	                </div>

	                <div class="form-group is-empty">
	                  <label for="inputPassword3" class="col-sm-4 control-label">Confirmation mot de passe</label>

	                  <div class="col-sm-8">
	                    <input type="password" class="form-control" id="inputPassword3" placeholder="Confirmation du mot de passe" name="confirm_password">
	                  </div>
	                </div>

	              </div>
	              <!-- /.card-body -->
	              <div class="card-footer">
	                <button type="reset" class="btn btn-default">Annuler</button>
	                <button type="submit" class="btn btn-info pull-right">Modifier</button>
	              </div>
	              <!-- /.card-footer -->
	            </form>
	          </div>
            <!-- /.card -->
        </div>
      </div>
@endsection