@extends('main')
@section('title', __('admin.customer'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.users')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            <b-button-group class="w-100 mb-3 shadow-2 bt-wrap">
                <b-button variant="primary"
                          class="border-0 main-button no-max-width w-50"
                          onclick="window.location='/customers/list'">
                    <b-icon icon="card-list"></b-icon>{{__('admin.customer_list')}}
                </b-button>
                <b-button variant="primary"
                          class="border-0 main-button no-max-width w-50"
                          onclick="window.location='/customers/customer/0'">
                    <b-icon icon="plus-square-fill"></b-icon>{{__('admin.add_new_customer')}}
                </b-button>
            </b-button-group>
            @include('menu')
            @include('layouts.recent-items')
        </b-col>
        <b-col md="12" lg="9" xl="10">
            <b-card no-body class="shadow-2">
                <template #header>
                    <h2 class="mb-0">{{__('admin.edit')}}</h2>
                </template>
                <b-card-body>
                    <b-form method="post" action="/customers/customer">
                        <b-row>
                            <b-col cols="12" xl="6">
                                <b-form-group label="{{__('admin.disable')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary" class="form-col-layout">
                                    <div class="custom-control custom-switch ml-4">
                                        <input type="checkbox" class="custom-control-input" id="disableSwitch"
                                               name="disable"
                                               value="1" {{$client->disable == 1 ? 'checked' : ''}}>
                                        <label class="custom-control-label" for="disableSwitch"></label>
                                    </div>
                                </b-form-group>
                                <b-form-group label="{{__('admin.type')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <select class="custom-select" name="type">
                                        @foreach(Data::$clientType as $key => $value)
                                            <option value="{{$key}}" {{$client->type == $key ? 'selected' : ''}}>
                                                {{$value}}
                                            </option>
                                        @endforeach
                                    </select>
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group label="{{__('admin.email')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-input type="email" name="email" maxlength="50" minlength="8"
                                                  value="{{$client->email}}"
                                                  required>
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group label="{{__('admin.name')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-input type="text" name="name" maxlength="100" minlength="3"
                                                  value="{{$client->name}}"
                                                  required>
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group label="{{__('admin.company_name')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-input type="text" name="company_name" maxlength="200" minlength="3"
                                                  value="{{$client->company_name}}"
                                                  required>
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group label="{{__('admin.phone')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-input type="text" name="phone" maxlength="15" minlength="10"
                                                  value="{{$client->phone}}"
                                                  pattern="[0-9]{9,20}">
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group label="{{__('admin.notes')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-textarea name="notes" rows="5" value="{{$client->notes}}"
                                                     maxlength="20000"
                                                     spellcheck="false">
                                    </b-form-textarea>
                                </b-form-group>
                            </b-col>
                            <b-col cols="12" xl="6">
                                <client-frm :client="{{json_encode($client)}}"></client-frm>
                                <b-form-group label="{{__('admin.address')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-textarea name="address" rows="5" value="{{$client->address}}"
                                                     maxlength="20000"
                                                     spellcheck="false">
                                    </b-form-textarea>
                                </b-form-group>
                            </b-col>
                            <b-col cols="12" class="text-right">
                                @csrf
                                <input type="hidden" name="id" value="{{$id}}">
                                <b-button type="submit" variant="primary"
                                          class="border-0 main-button mt-3">{{__('admin.save')}}
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
        </b-col>
    </b-row>
@endsection