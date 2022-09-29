<b-form method="post" action="/solutions/solution">
    <b-row>
        <b-col cols="12" xl="6">
            <b-form-group label="{{__('admin.flag')}}"
                          label-cols="12" label-cols-md="4" label-cols-xl="3"
                          label-class="text-secondary" class="form-col-layout">
                <div class="custom-control custom-switch ml-4">
                    <input type="checkbox" class="custom-control-input" id="flagSwitch"
                           name="flag"
                           value="1" {{$solution->flag == 1 ? 'checked' : ''}}>
                    <label class="custom-control-label" for="flagSwitch"></label>
                </div>
            </b-form-group>
            <b-form-group label="{{__('admin.subject')}}"
                          label-cols="12" label-cols-md="4" label-cols-xl="3"
                          label-class="text-secondary">
                <b-form-input type="text" name="name" maxlength="100"
                              value="{{$solution->name}}">
                </b-form-input>
            </b-form-group>
            <b-form-group label="{{__('admin.category')}}"
                          label-cols="12" label-cols-md="4" label-cols-xl="3"
                          label-class="text-secondary">
                <select class="custom-select" name="category_id">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}" {{$solution->category_id == $category->id ? 'selected' : ''}}>
                            {{$category->name}}
                        </option>
                    @endforeach
                </select>
            </b-form-group>
        </b-col>
        <b-col cols="12">
            <textarea class="content" name="post_content" spellcheck="false" required>{{$solution->content}}</textarea>
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