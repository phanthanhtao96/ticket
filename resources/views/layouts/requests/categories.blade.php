<b-card no-body class="shadow-2 mb-3 show-desktop">
    <template #header>
        <h2 class="mb-0">{{__('admin.categories')}}</h2>
    </template>
    <b-card-body class="p-0">
        <ul class="vertical-menu">
            @foreach($categories as $category)
                <li><a href="/requests/list/category_id/{{$category->id}}">
                        <b-icon icon="circle"></b-icon>{{$category->name}}
                    </a></li>
            @endforeach
        </ul>
    </b-card-body>
</b-card>