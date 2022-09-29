@extends('main')
@section('title', __('admin.email_template'))
@section('content')
    <b-row>
        <b-col cols="12" class="text-center">
            <h1>{{__('admin.email_template')}}</h1>
        </b-col>
        <b-col md="12" lg="3" xl="2">
            <b-button variant="primary"
                      class="mb-3 w-100 border-0 shadow-2 main-button no-max-width"
                      onclick="window.location='/email-templates/list'">
                <b-icon icon="plus-square-fill"></b-icon>{{__('admin.email_template_list')}}
            </b-button>
            @include('menu')
            @include('layouts.recent-items')
        </b-col>
        <b-col md="12" lg="9" xl="10">
            <b-card no-body class="shadow-2">
                <template #header>
                    <h2 class="mb-0">{{__('admin.edit')}}</h2>
                </template>
                <b-card-body>
                    <b-form method="post" action="/email-templates/email-template">
                        <b-row>
                            <b-col cols="12">
                                <b-form-group label="{{__('admin.type')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-input type="text" name="type" value="{{$email_template->type}}"
                                                  min="0" max="40" required readonly>
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group label="{{__('admin.name')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-input type="text" name="name" maxlength="200" minlength="3"
                                                  value="{{$email_template->name}}"
                                                  required>
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group label="{{__('admin.subject')}}"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-input type="text" name="subject" maxlength="200" minlength="3"
                                                  value="{{$email_template->subject}}"
                                                  required>
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group label="{{__('admin.content')}} - HTML"
                                              label-cols="12" label-cols-md="4" label-cols-xl="3"
                                              label-class="text-secondary">
                                    <b-form-textarea name="post_content" id="postHTMLContent" rows="30"
                                                     style="max-width: none"
                                                     value="{{$email_template->content}}"
                                                     spellcheck="false"></b-form-textarea>
                                </b-form-group>
                            </b-col>
                            <b-col cols="12" class="text-right mt-3">
                                @csrf
                                <input type="hidden" name="id" value="{{$id}}">
                                <b-button type="button" variant="primary"
                                          onClick="html_preview(document.getElementById('postHTMLContent').value)"
                                          class="border-0 main-button bg-secondary">{{__('admin.preview')}}
                                </b-button>
                                <b-button type="submit" variant="primary"
                                          class="border-0 main-button">{{__('admin.save')}}
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
        </b-col>
    </b-row>
@endsection
<script type="application/javascript" defer src="/js/libs/html-preview.js"></script>