<?php

namespace App\Models;

class Data
{
    public static $perPage = 30;
    public static $cacheTime = 3600;
    public static $mailsLimit = 100;
    public static $securityRegex = '/^[^{|}|<|>|=]*$/';
    public static $vueRegex = '/^[^{|}]*$/';
    public static $cleanString = '/^[a-zA-Z0-9\S_%&-@!.,#\[\]():\-ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀẾỂưăạảấầẩẫậắằẳẵặẹẻẽềếểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵýỷỹ\s]+$/';
    public static $passwordRegex = '/^(?=.{6,})(?=.*[a-z]+)(?=.*\d+)(?=.*[A-Z]+)(?=.*[^\w])[ -~]+$/';
    public static $phoneRegex = '/^[0-9]{9,15}+$/';
    public static $uuidRegex = '/[0-9a-z\-]+/';
    public static $variableName = '/^[A-Za-z0-9_-]{2,40}$/';
    public static $hourRegex = '/^(0[0-9]|1[0-9]|2[0-3]):00$/';
    public static $capabilities = [
        'view-request' => 'View Request',
        'edit-request' => 'Edit Request',
        'delete-request' => 'Delete Request',
        'reply-request' => 'Reply Request',
        'view-problem' => 'View Problem',
        'edit-problem' => 'Edit Problem',
        'delete-problem' => 'Delete Problem',
        'reply-problem' => 'Reply Problem',
        'view-solution' => 'View Solution',
        'edit-solution' => 'Edit Solution',
        'delete-solution' => 'Delete Solution',
        'view-sla' => 'View SLA',
        'edit-sla' => 'Edit SLA',
        'delete-sla' => 'Delete SLA',
        'view-priority' => 'View Priority',
        'edit-priority' => 'Edit Priority',
        'delete-priority' => 'Delete Priority',
        'view-company' => 'View Company',
        'edit-company' => 'Edit Company',
        'delete-company' => 'Delete Company',
        'view-category' => 'View Category',
        'edit-category' => 'Edit Category',
        'delete-category' => 'Delete Category',
        'view-user' => 'View User',
        'edit-user' => 'Edit User',
        'delete-user' => 'Delete User',
        'view-group' => 'View Group',
        'edit-group' => 'Edit Group',
        'upload' => 'Upload',
        'view-customer' => 'View Customer',
        'edit-customer' => 'Edit Customer',
        'delete-customer' => 'Delete Customer',
        'view-role' => 'View Role',
        'edit-role' => 'Edit Role',
        'view-changes' => 'View Changes',
        'view-email-template' => 'View email template',
        'edit-email-template' => 'Edit email template',
        'view-email-history' => 'View email history',
        'view-report' => 'View Report',
    ];

    public static $cacheKeys = [
        'technician_id' => 'users_arr',
        'request_by' => 'users_arr',
        'company_id' => 'companies_arr',
        'group_id' => 'groups_arr',
        'sla_id' => 'sla_arr',
        'priority_id' => 'priorities_arr',
        'category_id' => 'categories_arr'
    ];

    public static $weekdays = [
        0 => 'Sunday',
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday'
    ];

    public static $daysInMonth = [
        '01',
        '02',
        '03',
        '04',
        '05',
        '06',
        '07',
        '08',
        '09',
        '10',
        '11',
        '12',
        '13',
        '14',
        '15',
        '16',
        '17',
        '18',
        '19',
        '20',
        '21',
        '22',
        '23',
        '24',
        '25',
        '26',
        '27',
        '28',
        '29',
        '30',
        '31',
    ];

    public static $slaForm = [
        'level' => 0,
        'difference_time' => 0,
        'action' => 'Notification',
        'email_type' => '',
        'role_type' => '',
        'time_type' => '',
        'cc' => []
    ];

    public static $slaTimeTypes = [
        'Before',
//        'Equal',
        'After'
    ];

    public static $slaResponseEmailTypes = [
        'ResponseReminderEmail',
        'ResponseLateEmail'
    ];

    public static $slaEmailTypes = [
        'BeforeEscalateEmail',
        'EscalateEmail',
        'AfterEscalateEmail',
        'ResolveReminderEmail',
        'ResolveLateEmail'
    ];

    public static $slaActions = [
        'Notification'
    ];

    public static $slaLevels = [
        0 => ['time_column' => '', 'data_column' => 'response_data', 'time_type' => 'After', 'difference_time' => 0, 'action' => 'Notification', 'email_type' => 'ResponseReminderEmail', 'tech_key' => 'TechnicianL1', 'label' => 'Level 1', 'cc' => []],
        2 => ['time_column' => 'time_to_l2', 'data_column' => 'l2_data', 'time_type' => 'Equal', 'difference_time' => 0, 'action' => 'Notification', 'email_type' => 'EscalateEmail', 'tech_key' => 'TechnicianL2', 'label' => 'Level 2', 'cc' => []],
        3 => ['time_column' => 'time_to_l3', 'data_column' => 'l3_data', 'time_type' => 'Equal', 'difference_time' => 0, 'action' => 'Notification', 'email_type' => 'EscalateEmail', 'tech_key' => 'TechnicianL3', 'label' => 'Level 3', 'cc' => []],
        4 => ['time_column' => 'time_to_l4', 'data_column' => 'l4_data', 'time_type' => 'Equal', 'difference_time' => 0, 'action' => 'Notification', 'email_type' => 'EscalateEmail', 'tech_key' => 'TechnicianL4', 'label' => 'Level 4', 'cc' => []]
    ];

    public static $roleTypes = [
        'Undefined' => 'Undefined',
        'TechnicianL1' => 'Technician L1',
        'TechnicianL2' => 'Technician L2',
        'TechnicianL3' => 'Technician L3',
        'TechnicianL4' => 'Technician L4'
    ];

    public static $technicianTypeLevels = [
        1 => 'TechnicianL1',
        2 => 'TechnicianL2',
        3 => 'TechnicianL3',
        4 => 'TechnicianL4'
    ];

    public static $regions = [
        'MB' => 'Miền bắc',
        'MT' => 'Miền trung',
        'MN' => 'Miền nam'
    ];

    public static $sites = [
        'MB' => 'Miền bắc',
        'MT' => 'Miền trung',
        'MN' => 'Miền nam'
    ];

    public static $clientType = [
        'Normal' => 'Normal'
    ];

    public static $requestTypes = [
        'Event' => 'Event',
        'Incident' => 'Incident',
        'RequestForInformation' => 'Request For Information'
    ];

    public static $requestSOStatus = [
        '',
        'Đang triển khai',
        'Bảo hành',
        'Hết hạn bảo hành'
    ];

    public static $requestModes = [
        'EMail' => 'E-Mail',
        'PhoneCall' => 'Phone Call',
        'WebForm' => 'Web Form'
    ];

    public static $requestStatus = [
        'Open' => 'Open',
        'ReOpen' => 'ReOpen',
        'Answered' => 'Answered',
        'CustomerReply' => 'Customer Reply',
        'Pending' => 'Pending',
        'Cancelled' => 'Cancelled',
        'Closed' => 'Closed',
        'Draft' => 'Draft',
        'Resolved' => 'Resolved',
        'Solved' => 'Solved',
    ];

    public static $problemStatus = [
        'Open' => 'Open',
        'ReOpen' => 'ReOpen',
        'Answered' => 'Answered',
        'Pending' => 'Pending',
        'Cancelled' => 'Cancelled',
        'Closed' => 'Closed',
        'Draft' => 'Draft'
    ];

    public static $categoryTypes = [
        'Default' => 'Default'
    ];

    //Send by outlook mail
    public static $outlookMailTypes = [
        'OpenTicket',
//        'CloseTicket',
//        'ReplyTicketEmail'
    ];

    public static $noSignatureMails = [
    ];

    public static $requestReportFields = [
        0 => [
            'key' => 0,
            'type' => 'Number',
            'name' => 'Request ID',
            'table' => 'requests',
            'columns' => ['requests.id'],
            'function' => '',
            'default' => 1
        ],
        1 => [
            'key' => 1,
            'type' => 'String',
            'name' => 'Subject',
            'table' => 'requests',
            'columns' => ['requests.name'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 2,
            'type' => 'String',
            'name' => 'Content',
            'table' => 'requests',
            'columns' => ['requests.content'],
            'function' => '',
            'default' => 0
        ],
        3 => [
            'key' => 3,
            'type' => 'String',
            'name' => 'Request status',
            'table' => 'requests',
            'columns' => ['requests.status'],
            'function' => '',
            'default' => 1
        ],
        4 => [
            'key' => 4,
            'type' => 'DateTime',
            'name' => 'Created Time',
            'table' => 'requests',
            'columns' => ['requests.active_date'],
            'function' => '',
            'default' => 1
        ],
        5 => [
            'key' => 5,
            'type' => 'String',
            'name' => 'SLA',
            'table' => 'sla',
            'columns' => ['sla.name'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 6,
            'type' => 'Level',
            'name' => 'Priority',
            'table' => 'priorities',
            'columns' => ['priorities.name'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 7,
            'type' => 'Number',
            'name' => 'SO number',
            'table' => 'requests',
            'columns' => ['requests.so'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 8,
            'type' => 'String',
            'name' => 'Khách hàng',
            'table' => 'clients',
            'columns' => ['clients.name'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 9,
            'type' => '',
            'name' => 'Contact KH',
            'table' => 'clients',
            'columns' => ['clients.name', 'clients.email', 'clients.phone'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 10,
            'type' => 'String',
            'name' => 'Tình trạng SO',
            'table' => 'requests',
            'columns' => ['requests.so_status'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 11,
            'type' => 'String',
            'name' => 'Requester',
            'table' => 'requests',
            'columns' => ['requests.request_by'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 12,
            'type' => 'String',
            'name' => 'Assigned to',
            'table' => 'requests',
            'columns' => ['requests.technician_name'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 13,
            'type' => 'String',
            'name' => 'Part thiết bị',
            'table' => 'requests',
            'columns' => ['requests.part_device'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 14,
            'type' => 'Number',
            'name' => 'Serial Number',
            'table' => 'requests',
            'columns' => ['requests.serial_number'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 15,
            'type' => 'String',
            'name' => 'Lỗi sơ bộ',
            'table' => 'requests',
            'columns' => ['requests.root_cause'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 16,
            'type' => 'String',
            'name' => 'TAC case number (nếu có)',
            'table' => 'requests',
            'columns' => ['requests.tac'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 17,
            'type' => '',
            'name' => 'RMA number/ DOA number',
            'table' => 'requests',
            'columns' => ['requests.rma_doa'],
            'function' => '',
            'default' => 0
        ],
        [
            'key' => 18,
            'type' => '',
            'name' => 'ETA',
            'table' => 'requests',
            'columns' => ['requests.eta'],
            'function' => '',
            'default' => 0
        ],
        [
            'key' => 19,
            'type' => '',
            'name' => 'Tracking Number',
            'table' => 'requests',
            'columns' => ['requests.tracking_number'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 20,
            'type' => '',
            'name' => 'Tình trạng xử lý trong tuần',
            'table' => '',
            'columns' => [],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 21,
            'type' => 'DateTime',
            'name' => 'Last Update Time',
            'table' => 'requests',
            'columns' => ['requests.updated_at'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 22,
            'type' => 'DateTime',
            'name' => 'Response time dự kiến',
            'table' => 'requests',
            'columns' => ['requests.response_time_estimate_datetime'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 23,
            'type' => 'DateTime',
            'name' => 'Response time thực tế',
            'table' => 'requests',
            'columns' => ['requests.response_time_datetime'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 24,
            'type' => 'Number',
            'name' => 'Thời gian trễ response time',
            'table' => 'requests',
            'columns' => ['requests.response_time_late'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 25,
            'type' => 'String',
            'name' => 'Lý do trễ response time',
            'table' => 'requests',
            'columns' => ['requests.late_response_reason'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 26,
            'type' => 'DateTime',
            'name' => 'Resolve time dự kiến',
            'table' => 'requests',
            'columns' => ['requests.resolve_time_estimate_datetime'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 27,
            'type' => 'DateTime',
            'name' => 'Resolve time thực tế',
            'table' => 'requests',
            'columns' => ['requests.resolve_time_datetime'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 28,
            'type' => 'Number',
            'name' => 'Thời gian trễ resolve',
            'table' => 'requests',
            'columns' => ['requests.resolve_time_late'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 29,
            'type' => 'String',
            'name' => 'Lý do trễ resolve',
            'table' => 'requests',
            'columns' => ['requests.late_resolve_reason'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 30,
            'type' => 'Number',
            'name' => 'Time pending',
            'table' => 'requests',
            'columns' => ['requests.pending_time'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 31,
            'type' => 'String',
            'name' => 'Lý do pending',
            'table' => 'requests',
            'columns' => ['requests.pending_reason'],
            'function' => '',
            'default' => 1
        ],
        [
            'key' => 32,
            'type' => 'String',
            'name' => 'Company Name',
            'table' => 'companies',
            'columns' => ['companies.name'],
            'function' => '',
            'default' => 0
        ],
        [
            'key' => 33,
            'type' => 'String',
            'name' => 'Kiến thức & Trình độ chuyên môn của kỹ sư thực hiện dịch vụ',
            'table' => 'ratings',
            'columns' => ['ratings.rating1'],
            'function' => '',
            'default' => 0
        ],
        [
            'key' => 34,
            'type' => 'String',
            'name' => 'Thái độ phục vụ của kỹ sư thực hiện dịch vụ',
            'table' => 'ratings',
            'columns' => ['ratings.rating2'],
            'function' => '',
            'default' => 0
        ],
        [
            'key' => 35,
            'type' => 'String',
            'name' => 'Thời gian hoàn thành dịch vụ',
            'table' => 'ratings',
            'columns' => ['ratings.rating3'],
            'function' => '',
            'default' => 0
        ],
        [
            'key' => 36,
            'type' => 'String',
            'name' => 'Mức độ hài lòng của anh nói chung về dịch vụ',
            'table' => 'ratings',
            'columns' => ['ratings.rating4'],
            'function' => '',
            'default' => 0
        ],
        [
            'key' => 37,
            'type' => 'String',
            'name' => 'Kỹ sư liên lạc nhanh chóng để tiến hành xử lý, tối đa trong vòng 1 giờ kể từ khi bạn gọi cho ServiceDesk',
            'table' => 'ratings',
            'columns' => ['ratings.response_rating'],
            'function' => '',
            'default' => 0
        ],
        [
            'key' => 38,
            'type' => 'String',
            'name' => 'Last Update',
            'table' => 'requests',
            'columns' => ['requests.last_update'],
            'function' => '',
            'default' => 0
        ],
        [
            'key' => 39,
            'type' => 'String',
            'name' => 'Replies Content',
            'table' => 'requests',
            'columns' => ['requests.reply_content'],
            'function' => '',
            'default' => 1
        ],
    ];
}
