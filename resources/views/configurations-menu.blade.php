<b-card no-body class="shadow-2 mb-3 show-desktop">
    <template #header>
        <h2 class="mb-0">{{__('admin.configurations')}}</h2>
    </template>
    <b-card-body class="p-0">
        <ul class="vertical-menu">
            <li><a href="/configurations">
                    <b-icon icon="circle"></b-icon>{{__('admin.general')}}</a></li>
            <li><a href="/configurations/report">
                    <b-icon icon="circle"></b-icon>{{__('admin.report')}}</a></li>
        </ul>
    </b-card-body>
</b-card>