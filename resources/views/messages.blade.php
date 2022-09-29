@foreach($errors->all() as $error)
    <b-alert variant="danger" show>
        <b-icon icon="bell" variant="danger"></b-icon>{{$error}}
    </b-alert>
@endforeach
@if(Session::has('success'))
    <b-alert variant="success" show>
        <b-icon icon="bell" variant="success"></b-icon>{{Session::get('success')}}
    </b-alert>
@endif
@if(Session::has('failed'))
    <b-alert variant="danger" show>
        <b-icon icon="bell" variant="danger"></b-icon>{{Session::get('failed')}}
    </b-alert>
@endif