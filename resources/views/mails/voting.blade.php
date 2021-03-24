@extends('index')
@section('content')
    <div class="row">
        <div class="col-12 text-muted ">
            <h2 class="text-center">VOTACIONES</h2>
            <h5 class="text-center">{{$data->user->instituto}}</h5>
            <br>
            <p>Este link tiene tiempo de duración de <b>10 min.</b> y es válido por <b>una sola ocasión</b>.</p>
            <br>
            <div class=" text-center">
                <a class="btn btn-primary text-center"
                   href="{{ $system->redirect }}/#/vote?token={{$data->token}}&user_name={{$data->user->user_name}}">
                    Votar
                </a>
            </div>
            <br>
            <br>
            <p class="text-muted">Si no puede acceder, copie la siguiente url:</p>
            <p class="text-muted">{{$system->redirect}}/#/vote?token={{$data->token}}&user_name={{$data->user->user_name}}</p>
            <br>
            <p>Si no ha solicitado este servicio, repórtelo a su Institución.</p>
        </div>
    </div>
@endsection
