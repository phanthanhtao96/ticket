<b-card no-body class="shadow-2 mb-3 show-desktop">
    <template #header>
        <h2 class="mb-0">{{__('admin.menu')}}</h2>
    </template>
    <b-card-body class="p-0">
        <ul class="vertical-menu">
            <li><a href="/requests/list">
                    <b-icon icon="circle"></b-icon>{{__('admin.requests')}}</a></li>
            <li><a href="/problems/list">
                    <b-icon icon="circle"></b-icon>{{__('admin.problems')}}</a></li>
            <li class="li-divide"><a href="/solutions/list">
                    <b-icon icon="circle"></b-icon>{{__('admin.knowledge')}}</a></li>
            <li><a href="/priorities/list">
                    <b-icon icon="circle"></b-icon>{{__('admin.priorities')}}</a></li>
            <li><a href="/sla/list">
                    <b-icon icon="circle"></b-icon>{{__('admin.sla')}}</a></li>
            <li><a href="/companies/list">
                    <b-icon icon="circle"></b-icon>{{__('admin.companies')}}</a></li>
            <li><a href="/groups/list">
                    <b-icon icon="circle"></b-icon>{{__('admin.groups')}}</a></li>
            <li><a href="/categories/list">
                    <b-icon icon="circle"></b-icon>{{__('admin.categories')}}</a></li>
            <li><a href="/changes/list">
                    <b-icon icon="circle"></b-icon>{{__('admin.changes')}}</a></li>
            <li><a href="/report">
                    <b-icon icon="circle"></b-icon>{{__('admin.report')}}</a></li>
            <li class="li-divide"><a href="/imgs">
                    <b-icon icon="circle"></b-icon>{{__('admin.images')}}</a></li>
            <li><a href="/users/list">
                    <b-icon icon="circle"></b-icon>{{__('admin.users')}}</a></li>
            <li><a href="/duty-list">
                    <b-icon icon="circle"></b-icon>{{__('admin.duty_list')}}</a></li>
            <li class="li-divide"><a href="/roles/list">
                    <b-icon icon="circle"></b-icon>{{__('admin.roles')}}</a></li>
            <li><a href="/customers/list">
                    <b-icon icon="circle"></b-icon>{{__('admin.customers')}}</a></li>
            <li><a href="/email-templates/list">
                    <b-icon icon="circle"></b-icon>{{__('admin.email_templates')}}</a></li>
            <li><a href="/emails/sent-list">
                    <b-icon icon="circle"></b-icon>{{__('admin.email_sent_history')}}</a></li>
            <li><a href="/configurations">
                    <b-icon icon="circle"></b-icon>{{__('admin.configurations')}}</a></li>
        </ul>
    </b-card-body>
</b-card>
