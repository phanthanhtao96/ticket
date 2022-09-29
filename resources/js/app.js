/***SaoBacDauTelecom***/
import Vue from 'vue'
import {BootstrapVue, BootstrapVueIcons} from 'bootstrap-vue'
import Axios from 'axios'
import Moment from 'vue-moment'
import DatePicker from 'vue2-datepicker'

Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)
Vue.use(Moment)
Vue.use(DatePicker)

Vue.mixin({
    data: function () {
        return {
            loading: false,
            in_process: false,
            mobile_menu_status: false,
            error: null,
            errors: [],
            socket_host: process.env.MIX_PORTAL_EXTEND_SOCKET_HOST,
            countries: {
                VN: "Việt Nam",
                AF: "Afghanistan",
                AX: "Aland Islands",
                AL: "Albania",
                DZ: "Algeria",
                AS: "American Samoa",
                AD: "Andorra",
                AO: "Angola",
                AI: "Anguilla",
                AQ: "Antarctica",
                AG: "Antigua And Barbuda",
                AR: "Argentina",
                AM: "Armenia",
                AW: "Aruba",
                AU: "Australia",
                AT: "Austria",
                AZ: "Azerbaijan",
                BS: "Bahamas",
                BH: "Bahrain",
                BD: "Bangladesh",
                BB: "Barbados",
                BY: "Belarus",
                BE: "Belgium",
                BZ: "Belize",
                BJ: "Benin",
                BM: "Bermuda",
                BT: "Bhutan",
                BO: "Bolivia",
                BA: "Bosnia And Herzegovina",
                BW: "Botswana",
                BV: "Bouvet Island",
                BR: "Brazil",
                IO: "British Indian Ocean Territory",
                BN: "Brunei Darussalam",
                BG: "Bulgaria",
                BF: "Burkina Faso",
                BI: "Burundi",
                KH: "Cambodia",
                CM: "Cameroon",
                CA: "Canada",
                CV: "Cape Verde",
                KY: "Cayman Islands",
                CF: "Central African Republic",
                TD: "Chad",
                CL: "Chile",
                CN: "China",
                CX: "Christmas Island",
                CC: "Cocos (Keeling) Islands",
                CO: "Colombia",
                KM: "Comoros",
                CG: "Congo",
                CD: "Congo, Democratic Republic",
                CK: "Cook Islands",
                CR: "Costa Rica",
                CI: "Cote D'Ivoire",
                HR: "Croatia",
                CU: "Cuba",
                CW: "Curacao",
                CY: "Cyprus",
                CZ: "Czech Republic",
                DK: "Denmark",
                DJ: "Djibouti",
                DM: "Dominica",
                DO: "Dominican Republic",
                EC: "Ecuador",
                EG: "Egypt",
                SV: "El Salvador",
                GQ: "Equatorial Guinea",
                ER: "Eritrea",
                EE: "Estonia",
                ET: "Ethiopia",
                FK: "Falkland Islands (Malvinas)",
                FO: "Faroe Islands",
                FJ: "Fiji",
                FI: "Finland",
                FR: "France",
                GF: "French Guiana",
                PF: "French Polynesia",
                TF: "French Southern Territories",
                GA: "Gabon",
                GM: "Gambia",
                GE: "Georgia",
                DE: "Germany",
                GH: "Ghana",
                GI: "Gibraltar",
                GR: "Greece",
                GL: "Greenland",
                GD: "Grenada",
                GP: "Guadeloupe",
                GU: "Guam",
                GT: "Guatemala",
                GG: "Guernsey",
                GN: "Guinea",
                GW: "Guinea-Bissau",
                GY: "Guyana",
                HT: "Haiti",
                HM: "Heard Island &amp; Mcdonald Islands",
                VA: "Holy See (Vatican City State)",
                HN: "Honduras",
                HK: "Hong Kong",
                HU: "Hungary",
                IS: "Iceland",
                IN: "India",
                ID: "Indonesia",
                IR: "Iran, Islamic Republic Of",
                IQ: "Iraq",
                IE: "Ireland",
                IM: "Isle Of Man",
                IL: "Israel",
                IT: "Italy",
                JM: "Jamaica",
                JP: "Japan",
                JE: "Jersey",
                JO: "Jordan",
                KZ: "Kazakhstan",
                KE: "Kenya",
                KI: "Kiribati",
                KR: "Korea",
                KW: "Kuwait",
                KG: "Kyrgyzstan",
                LA: "Lao People's Democratic Republic",
                LV: "Latvia",
                LB: "Lebanon",
                LS: "Lesotho",
                LR: "Liberia",
                LY: "Libyan Arab Jamahiriya",
                LI: "Liechtenstein",
                LT: "Lithuania",
                LU: "Luxembourg",
                MO: "Macao",
                MK: "Macedonia",
                MG: "Madagascar",
                MW: "Malawi",
                MY: "Malaysia",
                MV: "Maldives",
                ML: "Mali",
                MT: "Malta",
                MH: "Marshall Islands",
                MQ: "Martinique",
                MR: "Mauritania",
                MU: "Mauritius",
                YT: "Mayotte",
                MX: "Mexico",
                FM: "Micronesia, Federated States Of",
                MD: "Moldova",
                MC: "Monaco",
                MN: "Mongolia",
                ME: "Montenegro",
                MS: "Montserrat",
                MA: "Morocco",
                MZ: "Mozambique",
                MM: "Myanmar",
                NA: "Namibia",
                NR: "Nauru",
                NP: "Nepal",
                NL: "Netherlands",
                AN: "Netherlands Antilles",
                NC: "New Caledonia",
                NZ: "New Zealand",
                NI: "Nicaragua",
                NE: "Niger",
                NG: "Nigeria",
                NU: "Niue",
                NF: "Norfolk Island",
                MP: "Northern Mariana Islands",
                NO: "Norway",
                OM: "Oman",
                PK: "Pakistan",
                PW: "Palau",
                PS: "Palestine, State of",
                PA: "Panama",
                PG: "Papua New Guinea",
                PY: "Paraguay",
                PE: "Peru",
                PH: "Philippines",
                PN: "Pitcairn",
                PL: "Poland",
                PT: "Portugal",
                PR: "Puerto Rico",
                QA: "Qatar",
                RE: "Reunion",
                RO: "Romania",
                RU: "Russian Federation",
                RW: "Rwanda",
                BL: "Saint Barthelemy",
                SH: "Saint Helena",
                KN: "Saint Kitts And Nevis",
                LC: "Saint Lucia",
                MF: "Saint Martin",
                PM: "Saint Pierre And Miquelon",
                VC: "Saint Vincent And Grenadines",
                WS: "Samoa",
                SM: "San Marino",
                ST: "Sao Tome And Principe",
                SA: "Saudi Arabia",
                SN: "Senegal",
                RS: "Serbia",
                SC: "Seychelles",
                SL: "Sierra Leone",
                SG: "Singapore",
                SK: "Slovakia",
                SI: "Slovenia",
                SB: "Solomon Islands",
                SO: "Somalia",
                ZA: "South Africa",
                GS: "South Georgia And Sandwich Isl.",
                ES: "Spain",
                LK: "Sri Lanka",
                SD: "Sudan",
                SR: "Suriname",
                SJ: "Svalbard And Jan Mayen",
                SZ: "Swaziland",
                SE: "Sweden",
                CH: "Switzerland",
                SY: "Syrian Arab Republic",
                TW: "Taiwan",
                TJ: "Tajikistan",
                TZ: "Tanzania",
                TH: "Thailand",
                TL: "Timor-Leste",
                TG: "Togo",
                TK: "Tokelau",
                TO: "Tonga",
                TT: "Trinidad And Tobago",
                TN: "Tunisia",
                TR: "Turkey",
                TM: "Turkmenistan",
                TC: "Turks And Caicos Islands",
                TV: "Tuvalu",
                UG: "Uganda",
                UA: "Ukraine",
                AE: "United Arab Emirates",
                GB: "United Kingdom",
                US: "United States",
                UM: "United States Outlying Islands",
                UY: "Uruguay",
                UZ: "Uzbekistan",
                VU: "Vanuatu",
                VE: "Venezuela",
                VG: "Virgin Islands, British",
                VI: "Virgin Islands, U.S.",
                WF: "Wallis And Futuna",
                EH: "Western Sahara",
                YE: "Yemen",
                ZM: "Zambia",
                ZW: "Zimbabwe"
            },
            cities: {
                VN: {
                    0: "Hà Nội",
                    1: "Tp Hồ Chí Minh",
                    2: "An Giang",
                    3: "Bà Rịa - Vũng Tàu",
                    4: "Bình Dương",
                    5: "Bình Phước",
                    6: "Bình Thuận",
                    7: "Bình Định",
                    8: "Bạc Liêu",
                    9: "Bắc Giang",
                    10: "Bắc Kạn",
                    11: "Bắc Ninh",
                    12: "Bến Tre",
                    13: "Cao Bằng",
                    14: "Cà Mau",
                    15: "Cần Thơ",
                    16: "Gia Lai",
                    17: "Hà Giang",
                    18: "Đồng Tháp",
                    19: "Đồng Nai",
                    20: "Điện Biên",
                    21: "Đắk Nông",
                    22: "Đà Nẵng",
                    23: "Đắk Lắk",
                    24: "Hà Nam",
                    25: "Hà Tĩnh",
                    26: "Hải Dương",
                    27: "Hải Phòng",
                    28: "Hậu Giang",
                    29: "Hoà Bình",
                    30: "Hưng Yên",
                    31: "Khánh Hoà",
                    32: "Kiên Giang",
                    33: "Kon Tum",
                    34: "Lai Châu",
                    35: "Lạng Sơn",
                    36: "Lào Cai",
                    37: "Lâm Đồng",
                    38: "Long An",
                    39: "Nam Định",
                    40: "Nghệ An",
                    41: "Ninh Bình",
                    42: "Ninh Thuận",
                    43: "Phú Thọ",
                    44: "Phú Yên",
                    45: "Quảng Bình",
                    46: "Quảng Nam",
                    47: "Quảng Ngãi",
                    48: "Quảng Ninh",
                    49: "Quảng Trị",
                    50: "Sóc Trăng",
                    51: "Sơn La",
                    52: "Tây Ninh",
                    53: "Thanh Hoá",
                    54: "Thái Bình",
                    55: "Thái Nguyên",
                    56: "Thừa Thiên Huế",
                    57: "Tiền Giang",
                    58: "Trà Vinh",
                    59: "Tuyên Quang",
                    60: "Vĩnh Long",
                    61: "Vĩnh Phúc",
                    62: "Yên Bái"
                }
            },
            states: {
                "Hà Nội": {
                    0: "Ba Đình",
                    1: "Cầu Giấy",
                    2: "Đống Đa",
                    3: "Hoàn Kiếm",
                    4: "Hai Bà Trưng",
                    5: "Hà Đông",
                    6: "Hoàng Mai",
                    7: "Long Biên",
                    8: "Tây Hồ",
                    9: "Thanh Xuân",
                    10: "Ba Vì",
                    11: "Đông Anh",
                    12: "Gia Lâm",
                    13: "Nam Từ Liêm",
                    14: "Bắc Từ Liêm",
                    15: "Thanh Trì",
                    16: "Sóc Sơn",
                    17: "Phúc Thọ",
                    18: "Thạch Thất",
                    19: "Đan Phượng",
                    20: "Quốc Oai",
                    21: "Hoài Đức",
                    22: "Thường Tín",
                    23: "Phú Xuyên",
                    24: "Thanh Oai",
                    25: "Chương Mỹ",
                    26: "Mỹ Đức",
                    27: "Ứng Hòa",
                    28: "Tp.Sơn Tây"
                },
                "Tp Hồ Chí Minh": {
                    0: "Quận 1",
                    1: "Quận 2",
                    2: "Quận 3",
                    3: "Quận 4",
                    4: "Quận 5",
                    5: "Quận 6",
                    6: "Quận 7",
                    7: "Quận 8",
                    8: "Quận 9",
                    9: "Quận 10",
                    10: "Quận 11",
                    11: "Quận 12",
                    12: "Bình Tân",
                    13: "Bình Thạnh",
                    14: "Gò Vấp",
                    15: "Phú Nhuận",
                    16: "Tân Bình",
                    17: "Tân Phú",
                    18: "Thủ Đức",
                    19: "Huyện Nhà Bè",
                    20: "Huyện Hóc Môn",
                    21: "Huyện Củ Chi",
                    22: "Huyện Cần Giờ",
                    23: "Huyện Bình Chánh"
                },
                "An Giang": {
                    0: "Long Xuyên",
                    1: "Châu Đốc",
                    2: "Chợ Mới",
                    3: "Phú Tân",
                    4: "Tân Châu",
                    5: "An Phú",
                    6: "Tri Tôn",
                    7: "Tịnh Biên",
                    8: "Châu Thành",
                    9: "Châu Phú",
                    10: "Thoại Sơn"
                },
                "Bà Rịa - Vũng Tàu": {
                    0: "Tp.Vũng Tàu",
                    1: "Thị xã Bà Rịa",
                    2: "Huyện Châu Đức",
                    3: "Huyện Côn Đảo",
                    4: "Huyện Long Điền",
                    5: "Huyện Đất Đỏ",
                    6: "Huyện Tân Thành",
                    7: "Huyện Xuyên Mộc"
                },
                "Bình Dương": {
                    0: "Bến Cát",
                    1: "Dầu Tiếng",
                    2: "Dĩ An",
                    3: "Phú Giáo",
                    4: "Tân Uyên",
                    5: "Thuận An",
                    6: "Thủ Dầu Một"
                },
                "Bình Phước": {
                    0: "Đồng Xoài",
                    1: "Đồng Phù",
                    2: "Phước Long",
                    3: "Lộc Ninh",
                    4: "Bù Đăng",
                    5: "Bình Long",
                    6: "Bù Đốp",
                    7: "Chơn Thành"
                },
                "Bình Thuận": {0: "Hàm Thuận Bắc", 1: "Tánh Linh", 2: "Tuy phong", 3: "Hàm Thuận Nam"},
                "Bình Định": {
                    0: "TP Quy Nhơn",
                    1: "An Lão",
                    2: "Vĩnh Thạnh",
                    3: "Vân Canh",
                    4: "Hoài Ân",
                    5: "Hoài Nhơn",
                    6: "Phù Mỹ",
                    7: "Phù Cát",
                    8: "Tây Sơn",
                    9: "An Nhơn",
                    10: "Tuy Phước"
                },
                "Bạc Liêu": {
                    0: "Bạc Liêu",
                    1: "Hoà Bình",
                    2: "Đông Hải",
                    3: "Giá Rai",
                    4: "Hông Dân",
                    5: "Phước Long",
                    6: "Vĩnh Lợi"
                },
                "Bắc Giang": {
                    0: "TP Bắc Giang",
                    1: "Lạng Giang",
                    2: "Hiệp Hoà",
                    3: "Việt Yên",
                    4: "Yên Dũng",
                    5: "Tân Yên",
                    6: "Lục Nam",
                    7: "Lục Ngạn",
                    8: "Sơn Động",
                    9: "Yên Thế"
                },
                "Bắc Kạn": {
                    0: "Thị xã Bắc Kạn",
                    1: "Pác Nặm ",
                    2: "Chợ Đồn",
                    3: "Chợ Mới",
                    4: "Bạch Thông",
                    5: "Na Rì",
                    6: "Ngân Sơn",
                    7: "Ba Bể"
                },
                "Bắc Ninh": {
                    0: "Thị xã Bắc Ninh",
                    1: "Gia Bình",
                    2: "Lương Tài",
                    3: "Quế Võ",
                    4: "Yên Phong",
                    5: "Thuận Thành",
                    6: "Tiên Du",
                    7: "Từ Sơn"
                },
                "Bến Tre": {
                    0: "Thị xã Bến Tre",
                    1: "Châu Thành",
                    2: "Chợ Lách",
                    3: "Bình Đại",
                    4: "Giồng Trôm",
                    5: "Mỏ Cày",
                    6: "Ba Tri",
                    7: "Thạnh Phú"
                },
                "Cao Bằng": {
                    0: "Thị Xã Cao Bằng",
                    1: "Hoà An",
                    2: "Quảng Uyên",
                    3: "Phục Hoà",
                    4: "Trà Linh",
                    5: "Thạch An",
                    6: "Nguyên Bình",
                    7: "Bảo Lạc",
                    8: "Bảo Lâm",
                    9: "Trùng Khánh"
                },
                "Cà Mau": {
                    0: "Tp Cà Mau",
                    1: "Đầm Dơi",
                    2: "Thới Bình",
                    3: "Trần Văn Thời",
                    4: "Năm Căn",
                    5: "Ngọc Hiến",
                    6: "Phú Tân",
                    7: "Cái Nước",
                    8: "U Minh"
                },
                "Cần Thơ": {
                    0: "Ninh Kiều",
                    1: "Bình Thủy",
                    2: "Cái Răng",
                    3: "Ô Môn",
                    4: "Phong Điền",
                    5: "Cờ Đỏ",
                    6: "Vĩnh Thạnh",
                    7: "Thốt Nốt"
                },
                "Gia Lai": {
                    0: "Tp Pleiku",
                    1: "An Khê",
                    2: "Ayun Pa",
                    3: "Đăk Pơ",
                    4: "Đăk Đoa",
                    5: "A Yun Pa",
                    6: "Chư Păh",
                    7: "Chư Prông",
                    8: "Chư Sê",
                    9: "Đức Cơ",
                    10: "Ia Grai",
                    11: "Kbang",
                    12: "Krông Pa",
                    13: "Kông Chro",
                    14: "Mang Yang",
                    15: "Ia Pa",
                    16: "Phú Thiện"
                },
                "Hà Giang": {
                    0: "Thị xã Hà Giang",
                    1: "Bắc Mê",
                    2: "Đồng Văn",
                    3: "Hoàng Su Phì",
                    4: "Mèo Vạc",
                    5: "Quang Bình",
                    6: "Quản Bạ",
                    7: "Vị Xuyên",
                    8: "Xín Mần",
                    9: "Yên Minh",
                    10: "Bắc Quang"
                },
                "Đồng Tháp": {
                    0: "Thành phố Cao Lãnh",
                    1: "Thị xã Sa Đéc",
                    2: "Tháp Mười",
                    3: "Thanh Bình",
                    4: "Tân Hồng",
                    5: "Tam Nông",
                    6: "Lấp Vò",
                    7: "Lai Vung",
                    8: "Hồng Ngự",
                    9: "Châu Thành",
                    10: "Huyện Cao Lãnh"
                },
                "Đồng Nai": {
                    0: "Tp Biên Hòa",
                    1: "Long Khánh",
                    2: "Long Thành",
                    3: "Nhơn Trạch",
                    4: "Trảng Bom",
                    5: "Thống Nhất",
                    6: "Cẩm Mỹ",
                    7: "Vĩnh Cửu",
                    8: "Xuân Lộc",
                    9: "Định Quán",
                    10: "Tân Phú"
                },
                "Điện Biên": {
                    0: "Tp Điện Biên Phủ",
                    1: "Điện Biên",
                    2: "Điện Biên Đông",
                    3: "Mường Ảng",
                    4: "Mường Chà",
                    5: "Mường Nhé",
                    6: "Tủa Chùa",
                    7: "Tuần Giáo"
                },
                "Đắk Nông": {
                    0: "Thị xã Gia Nghĩa",
                    1: "Cư Jút",
                    2: "Đăk Glong",
                    3: "Đăk Mil",
                    4: "Đăk R'Lấp",
                    5: "Đăk Song",
                    6: "Krông Nô",
                    7: "Tuy Đức"
                },
                "Đà Nẵng": {
                    0: "Hải Châu",
                    1: "Thanh Khê",
                    2: "Liên Chiểu",
                    3: "Sơn Trà",
                    4: "Cẩm Lệ",
                    5: "Ngũ Hành Sơn",
                    6: "Hòa Vang",
                    7: "Hoàng Sa"
                },
                "Đaklak": {
                    0: "Tp Buôn Ma Thuột",
                    1: "Krông Buk",
                    2: "Krông Pak",
                    3: "Lắk",
                    4: "Ea Súp",
                    5: "M'Drăk",
                    6: "Krông Ana",
                    7: "Krông Bông",
                    8: "Ea H'leo",
                    9: "Cư M'gar",
                    10: "Krông Năng",
                    11: "Buôn Đôn",
                    12: "Ea Kar",
                    13: "Cư Kuin"
                },
                "Hà Nam": {0: "Tp Phủ Lý", 1: "Bình Lục", 2: "Duy Tiên", 3: "Kim Bảng", 4: "Ý Nhân", 5: "Thanh Liêm"},
                "Hà Tĩnh": {
                    0: "Tp Hà Tĩnh",
                    1: "Thị xã Hồng Lĩnh",
                    2: "Kỳ Anh",
                    3: "Lộc Hà",
                    4: "Thạch Hà",
                    5: "Can Lộc",
                    6: "Nghi Xuân",
                    7: "Đức Thọ",
                    8: "Hương Sơn",
                    9: "Vũ Quang",
                    10: "Cẩm Xuyên"
                },
                "Hải Dương": {
                    0: "Tp Hải Dương",
                    1: "Chí Linh",
                    2: "Nam Sách",
                    3: "Kinh Môn",
                    4: "Kim Thành",
                    5: "Thanh Hà",
                    6: "Ninh Giang",
                    7: "Gia Lộc",
                    8: "Tứ Kỳ",
                    9: "Thanh Miện",
                    10: "Cẩm Giàng",
                    11: "Bình Giang"
                },
                "Tp Hải Phòng": {
                    0: "Dương Kinh",
                    1: "Đồ Sơn",
                    2: "Hải An",
                    3: "Hồng Bàng",
                    4: "Kiến An",
                    5: "Lê Chân",
                    6: "Ngô Quyền",
                    7: "An Dương",
                    8: "An Lão",
                    9: "Bạch Long Vĩ",
                    10: "Cát Hải",
                    11: "Kiến Thụy",
                    12: "Thủy Nguyên",
                    13: "Tiên Lãng",
                    14: "Vĩnh Bảo"
                },
                "Hậu Giang": {
                    0: "Thị xã Vị Thanh",
                    1: "Thị xã Ngã Bảy",
                    2: "Long Mỹ",
                    3: "Phụng Hiệp",
                    4: "Châu Thành",
                    5: "Châu Thành A"
                },
                "Hoà Bình": {
                    0: "Thị xã Hoà Bình",
                    1: "Cao Phong",
                    2: "Lương Sơn",
                    3: "Kỳ Sơn",
                    4: "Kim Bôi",
                    5: "Lạc Thuỷ",
                    6: "Yên Thủy",
                    7: "Đà Bắc",
                    8: "Mai Châu"
                },
                "Hưng Yên": {
                    0: "Thị xã Hưng Yên",
                    1: "Ân Thi",
                    2: "Khoái Châu",
                    3: "Kim Động",
                    4: "Mỹ Hào",
                    5: "Phù Cừ",
                    6: "Tiên Lữ",
                    7: "Văn Giang",
                    8: "Văn Lâm",
                    9: "Yên Mỹ"
                },
                "Khánh Hoà": {
                    0: "Tp Nha Trang",
                    1: "Thị xã Cam Ranh",
                    2: "Ninh Hòa",
                    3: "Diên Khánh",
                    4: "Vạn Ninh",
                    5: "Cam Lâm",
                    6: "Khánh Sơn",
                    7: "Khánh Vĩnh",
                    8: "Trường Sa"
                },
                "Kiên Giang": {
                    0: "Tp Rạch Giá",
                    1: "Thị xã Hà Tiên",
                    2: "An Biên",
                    3: "An Minh",
                    4: "Kiên Lương",
                    5: "Hòn Đất",
                    6: "Tân Hiệp",
                    7: "Châu Thành",
                    8: "Giồng Riềng",
                    9: "Gò Quao",
                    10: "Vĩnh Thuận",
                    11: "Phú Quốc",
                    12: "Kiên Hải",
                    13: "U Minh Thượng"
                },
                "Kon Tum": {
                    0: "Thị xã Kontum",
                    1: "Đak Hà",
                    2: "Đăk Tô",
                    3: "Ngọc Hồi",
                    4: "Đăk Glei",
                    5: "Sa Thầy",
                    6: "Kon Rẩy",
                    7: "Kon Plong",
                    8: "Tu Mơ Rông"
                },
                "Lai Châu": {
                    0: "Thị xã Lai Châu",
                    1: "Mường Tè",
                    2: "Phong Thổ",
                    3: "Sìn Hồ",
                    4: "Tam Đường",
                    5: "Than Uyên"
                },
                "Lạng Sơn": {
                    0: "Tràng Định",
                    1: "Văn Lãng",
                    2: "Văn Quan",
                    3: "Bình Gia",
                    4: "Bắc Sơn",
                    5: "Chi Lăng",
                    6: "Cao Lộc",
                    7: "Lộc Bình",
                    8: "Đình Lập",
                    9: "Hữu Lũng"
                },
                "Lào Cai": {
                    0: "Tp Lào Cai",
                    1: "Bát Xát",
                    2: "Bắc Hà",
                    3: "Bảo Yên",
                    4: "Mường Khương",
                    5: "Si Ma Cai",
                    6: "Sa Pa",
                    7: "Văn Bàn"
                },
                "Lâm Đồng": {
                    0: "Tp Đà Lạt",
                    1: "Thị xã Bảo Lộc",
                    2: "Lạc Dương",
                    3: "Đơn Dương",
                    4: "Đức Trọng",
                    5: "Lâm Hà",
                    6: "Di Linh",
                    7: "Bảo Lâm",
                    8: "Đạ Huoai",
                    9: "Đạ Tẻh",
                    10: "Cát Tiên",
                    11: "Đam Rông"
                },
                "Long An": {
                    0: "Thị xã Tân An",
                    1: "Bến Lức",
                    2: "Cần Đước",
                    3: "Cần Giuộc",
                    4: "Châu Thành",
                    5: "Đức Hòa",
                    6: "Đức Huệ",
                    7: "Mộc Hóa",
                    8: "Tân Hưng",
                    9: "Tân Thạnh",
                    10: "Tân Trụ",
                    11: "Thạnh Hóa",
                    12: "Thủ Thừa",
                    13: "Vĩnh Hưng"
                },
                "Nam Định": {
                    0: "Tp Nam Định",
                    1: "Hải Hậu",
                    2: "Mỹ Lộc",
                    3: "Vụ Bản",
                    4: "Giao Thuỷ",
                    5: "Ý Yên",
                    6: "Nam Trực",
                    7: "Trực Ninh",
                    8: "Nghĩa Hưng",
                    9: "Xuân Trường"
                },
                "Nghệ An": {
                    0: "Thị xã Thái Hòa",
                    1: "Tp Vinh",
                    2: "Thị xã Cửa Lò",
                    3: "Anh Sơn",
                    4: "Diễn Châu",
                    5: "Con Cuông",
                    6: "Quỳnh Lưu",
                    7: "Nam Đàn",
                    8: "Đô Lương",
                    9: "Hưng Nguyên",
                    10: "Nghi Lộc",
                    11: "Quế Phong",
                    12: "Quỳ Hợp",
                    13: "Thanh Chương",
                    14: "Tương Dương",
                    15: "Kỳ Sơn",
                    16: "Nghĩa Đàn",
                    17: "Quỳ Châu",
                    18: "Tân Kỳ",
                    19: "Yên Thành"
                },
                "Ninh Bình": {
                    0: "Tp Ninh Bình",
                    1: "Thị xã Tam Điệp",
                    2: "Gia Viễn",
                    3: "Hoa Lư",
                    4: "Kim Sơn",
                    5: "Nho Quan",
                    6: "Yên Khánh",
                    7: "Yên Mô"
                },
                "Ninh Thuận": {
                    0: "Tp Phan Rang-Tháp Chàm",
                    1: "Bác Ái",
                    2: "Ninh Hải",
                    3: "Ninh Phước",
                    4: "Ninh Sơn",
                    5: "Thuận Bắc"
                },
                "Phú Thọ": {
                    0: "Tp Việt Trì",
                    1: "Thị xã Phú Thọ",
                    2: "Cẩm Khê",
                    3: "Đoan Hùng",
                    4: "Hạ Hòa",
                    5: "Lâm Thao",
                    6: "Phù Ninh",
                    7: "Tam Nông",
                    8: "Tân Sơn",
                    9: "Thanh Ba",
                    10: "Thanh Sơn",
                    11: "Thanh Thủy",
                    12: "Yên Lập"
                },
                "Phú Yên": {
                    0: "Tp Tuy Hòa",
                    1: "Đông Hòa",
                    2: "Đồng Xuân",
                    3: "Phú Hòa",
                    4: "Sơn Hòa",
                    5: "Sông Cầu",
                    6: "Sông Hinh",
                    7: "Tây Hòa",
                    8: "Tuy An"
                },
                "Quảng Bình": {
                    0: "Tp Đồng Hới",
                    1: "Bố Trạch",
                    2: "Lệ Thủy",
                    3: "Minh Hóa",
                    4: "Quảng Trạch",
                    5: "Quảng Ninh",
                    6: "Tuyên Hóa"
                },
                "Quảng Nam": {
                    0: "Tp Tam Kỳ",
                    1: "Tp Hội An",
                    2: "Duy Xuyên",
                    3: "Đại Lộc",
                    4: "Điện Bàn",
                    5: "Đông Giang",
                    6: "Nam Giang",
                    7: "Tây Giang",
                    8: "Quế Sơn",
                    9: "Hiệp Đức",
                    10: "Núi Thành",
                    11: "Nam Trà My",
                    12: "Bắc Trà My",
                    13: "Phú Ninh",
                    14: "Phước Sơn",
                    15: "Thăng Bình",
                    16: "Tiên Phước",
                    17: "Nông Sơn"
                },
                "Quảng Ngãi": {
                    0: "Tp Quảng Ngãi",
                    1: "Ba Tơ",
                    2: "Bình Sơn",
                    3: "Đức Phổ",
                    4: "Minh Long",
                    5: "Mộ Đức",
                    6: "Sơn Hà",
                    7: "Sơn Tây",
                    8: "Sơn Tịnh",
                    9: "Tây Trà",
                    10: "Trà Bồng",
                    11: "Tư Nghĩa",
                    12: "Lý Sơn"
                },
                "Quảng Ninh": {
                    0: "Tp Hạ Long",
                    1: "Thị xã Cẩm Phả",
                    2: "Thị xã Móng Cái",
                    3: "Thị xã Uông Bí",
                    4: "Ba Chẽ",
                    5: "Bình Liêu",
                    6: "Đầm Hà",
                    7: "Đông Triều",
                    8: "Hải Hà",
                    9: "Hoành Bồ",
                    10: "Tiên Yên",
                    11: "Vân Đồn",
                    12: "Yên Hưng"
                },
                "Quảng Trị": {
                    0: "Thị xã Đông Hà",
                    1: "Thị xã Quảng Trị",
                    2: "Cam Lộ",
                    3: "Cồn Cỏ",
                    4: "Đa Krông",
                    "5h": "Gio Linh",
                    6: "Hải Lăng",
                    7: "Hướng Hóa",
                    8: "Triệu Phong",
                    9: "Vĩnh Linh"
                },
                "Sóc Trăng": {
                    0: "Tp Sóc Trăng",
                    1: "Long Phú",
                    2: "Cù Lao Dung",
                    3: "Mỹ Tú",
                    4: "Thạnh Trị",
                    5: "Vĩnh Châu",
                    6: "Ngã Năm",
                    7: "Kế Sách",
                    8: "Mỹ Xuyên"
                },
                "Sơn La": {
                    0: "Tp Sơn La",
                    1: "Quỳnh Nhai",
                    2: "Mường La",
                    3: "Thuận Châu",
                    4: "Phù Yên",
                    5: "Bắc Yên",
                    6: "Mai Sơn",
                    7: "Sông Mã",
                    8: "Yên Châu",
                    9: "Mộc Châu",
                    10: "Sốp Cộp"
                },
                "Tây Ninh": {
                    0: "Thị xã Tây Ninh",
                    1: "Tân Biên",
                    2: "Tân Châu",
                    3: "Dương Minh Châu",
                    4: "Châu Thành",
                    5: "Hòa Thành",
                    6: "Bến Cầu",
                    7: "Gò Dầu",
                    8: "Trảng Bàng"
                },
                "Thanh Hoá": {
                    0: "Tp Thanh Hóa",
                    1: "Thị xã Bỉm Sơn",
                    2: "Thị xã Sầm Sơn",
                    3: "Bá Thước",
                    4: "Cẩm Thủy",
                    5: "Đông Sơn",
                    6: "Hà Trung",
                    7: "Hậu Lộc",
                    8: "Hoằng Hóa",
                    9: "Lang Chánh",
                    10: "Mường Lát",
                    11: "Nga Sơn",
                    12: "Ngọc Lặc",
                    13: "Như Thanh",
                    14: "Như Xuân",
                    15: "Nông Cống",
                    16: "Quan Hóa",
                    17: "Quan Sơn",
                    18: "Quảng Xương",
                    19: "Thạch Thành",
                    20: "Thiệu Hóa",
                    21: "Thọ Xuân",
                    22: "Thường Xuân",
                    23: "Tĩnh Gia",
                    24: "Triệu Sơn",
                    25: "Vĩnh Lộc",
                    26: "Yên Định"
                },
                "Thái Bình": {
                    0: "Tp Thái Bình",
                    1: "Thái Thuỵ",
                    2: "Tiền Hải",
                    3: "Đông Hưng",
                    4: "Vũ Thư",
                    5: "Kiến Xương",
                    6: "Quỳnh Phụ",
                    7: "Hưng Hà"
                },
                "Thái Nguyên": {
                    0: "Tp Thái Nguyên",
                    1: "Thị xã Sông Công",
                    2: "Phổ Yên",
                    3: "Phú Bình",
                    4: "Đồng Hỷ",
                    5: "Võ Nhai",
                    6: "Định Hóa",
                    7: "Đại Từ",
                    8: "Phú Lương"
                },
                "Thừa Thiên Huế": {
                    0: "Thành phố Huế",
                    1: "A Lưới",
                    2: "Phú Lộc",
                    3: "Hương Thủy",
                    4: "Phú Vang",
                    5: "Hương Trà",
                    6: "Quảng Điền",
                    7: "Nam Đông"
                },
                "Tiền Giang": {
                    0: "Tp Mỹ Tho",
                    1: "Thị xã Gò Công",
                    2: "Cái Bè",
                    3: "Cai Lậy",
                    4: "Châu Thành",
                    5: "Tân Phước",
                    6: "Chợ Gạo",
                    7: "Gò Công Tây",
                    8: "Gò Công Đông",
                    9: "Tân Phú Đông"
                },
                "Trà Vinh": {
                    0: "Thị xã Trà Vinh",
                    1: "Trà Cú",
                    2: "Duyên Hải",
                    3: "Cầu Ngang",
                    4: "Châu Thành",
                    5: "Cầu Kè",
                    6: "Tiểu Cần",
                    7: "Càng Long"
                },
                "Tuyên Quang": {
                    0: "Thị xã Tuyên Quang",
                    1: "Na Hang",
                    2: "Chiêm Hoá",
                    3: "Hàm Yên",
                    4: "Yên Sơn",
                    5: "Sơn Dương"
                },
                "Vĩnh Long": {
                    0: "Thị xã Vĩnh Long",
                    1: "Long Hồ",
                    2: "Mang Thít",
                    3: "Tam Bình",
                    4: "Bình Minh",
                    5: "Vũng Liêm",
                    6: "Trà Ôn"
                },
                "Vĩnh Phúc": {
                    0: "Tp Vĩnh Yên",
                    1: "Thị xã Phúc Yên",
                    2: "Vĩnh Tường",
                    3: "Bình Xuyên",
                    4: "Yên Lạc",
                    5: "Tam Dương",
                    6: "Tam Đảo",
                    7: "Lập Thạch"
                },
                "Yên Bái": {
                    0: "Tp Yên Bái",
                    1: "Thị xã Nghĩa Lộ",
                    2: "Lục Yên",
                    "3i": "Mù Cang Chải",
                    4: "Trấn Yên",
                    5: "Trạm Tấu",
                    6: "Văn Chấn",
                    7: "Văn Yên",
                    8: "Yên Bình"
                }
            },
            postal_codes: {
                "Hà Nội": "10000",
                "Tp Hồ Chí Minh": "70000",
                "An Giang": "90000",
                "Bà Rịa - Vũng Tàu": "78000",
                "Bình Dương": "75000",
                "Bình Phước": "67000",
                "Bình Thuận": "77000",
                "Bình Định": "55000",
                "Bạc Liêu": "97000",
                "Bắc Giang": "26000",
                "Bắc Kạn": "23000",
                "Bắc Ninh": "16000",
                "Bến Tre": "86000",
                "Cao Bằng": "21000",
                "Cà Mau": "98000",
                "Cần Thơ": "94000",
                "Gia Lai": "61000",
                "Hà Giang": "20000",
                "Đồng Tháp": "81000",
                "Đồng Nai": "76000",
                "Điện Biên": "32000",
                "Đắk Nông": "65000",
                "Đà Nẵng": "50000",
                "Đắk Lắk": "63000",
                "Hà Nam": "18000",
                "Hà Tĩnh": "45000",
                "Hải Dương": "03000",
                "Hải Phòng": "04000",
                "Hậu Giang": "95000",
                "Hoà Bình": "36000",
                "Hưng Yên": "17000",
                "Khánh Hoà": "57000",
                "Kiên Giang": "91000",
                "Kon Tum": "60000",
                "Lai Châu": "30000",
                "Lạng Sơn": "25000",
                "Lào Cai": "31000",
                "Lâm Đồng": "66000",
                "Long An": "82000",
                "Nam Định": "07000",
                "Nghệ An": "43000",
                "Ninh Bình": "08000",
                "Ninh Thuận": "59000",
                "Phú Thọ": "35000",
                "Phú Yên": "56000",
                "Quảng Bình": "47000",
                "Quảng Nam": "51000",
                "Quảng Ngãi": "53000",
                "Quảng Ninh": "01000",
                "Quảng Trị": "48000",
                "Sóc Trăng": "96000",
                "Sơn La": "34000",
                "Tây Ninh": "80000",
                "Thanh Hoá": "40000",
                "Thái Bình": "06000",
                "Thái Nguyên": "24000",
                "Thừa Thiên Huế": "49000",
                "Tiền Giang": "84000",
                "Trà Vinh": "87000",
                "Tuyên Quang": "22000",
                "Vĩnh Long": "85000",
                "Vĩnh Phúc": "15000",
                "Yên Bái": "33000"
            }
        }
    },
    methods: {
        get_data: function (url, no_loading = false) {
            if (no_loading !== true)
                this.loading = true
            return new Promise((resolve, reject) => {
                Axios.get(url).then(response => resolve(response.data))
                    .catch(() => reject)
                    .finally(() => {
                        this.loading = false
                    })
            })
        },
        post_data: function (url, data, headers = {}) {
            this.in_process = true
            return new Promise((resolve, reject) => {
                Axios.post(url, data, headers).then(response => resolve(response.data))
                    .catch(() => reject)
                    .finally(() => {
                        this.in_process = false
                    })
            })
        },
        make_toast: function (variant = null, title, content) {
            this.$bvToast.toast(content, {
                title: title,
                variant: variant
            })
        },
        go_to: function (url, type = '_self') {
            window.open(url, type)
        },
        insert_space: function (value) {
            if (value.length > 0) {
                value = value.replace(/_/g, ' ')
                value = value.replace(/([A-Z])/g, ' $1')
                return value.trim()
            }
            return ''
        },
        format_price: function (value) {
            let val = (value / 1).toFixed(0).replace('.', ',')
            val = val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            return val + ' VND'
        },
        hide_long_word: function (word) {
            let len = word.length
            return len > 100 && !/\s/g.test(word) ? '********' : word
        },
        sub_str: function (text, limit = 20) {
            if (text.length <= limit)
                return text
            else return text.substring(0, limit) + '...'
        },
        get_time_remaining: function (time_string) {
            let expired = false
            let remaining = ''
            let time = this.$moment(time_string).format('HH:mm YYYY-MM-DD')
            if (!this.$moment(time).isValid()) {
                return {
                    expired: true,
                    text: 'Invalid date'
                }
            }

            let now = this.$moment().format('HH:mm YYYY-MM-DD')
            if (this.$moment(time).isAfter(now)) {
                remaining = this.$moment.utc(this.$moment(time).diff(this.$moment(now)))
                let d = remaining.format("D")
                let h = remaining.format("H")
                d = parseInt(d)
                if (d > 0) d = d - 1
                if (d === 0) {
                    if (parseInt(h) === 0)
                        remaining = 'Còn ' + remaining.format("m") + ' phút'
                    else remaining = 'Còn ' + h + ' giờ'
                } else remaining = 'Còn ' + d + ' ngày ' + h + ' giờ'
            } else {
                expired = true
                remaining = 'Đã hết hạn'
            }
            return {
                expired: expired,
                text: remaining
            }
        },
        select_all: function (parent_id, checkbox_name) {
            let checkboxes = document.getElementsByName(checkbox_name)
            for (let i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = document.getElementById(parent_id).checked
            }
        },
        get_checked_list: function (checkbox_name) {
            let result = []
            let checkboxes = document.getElementsByName(checkbox_name)
            for (let i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked)
                    result.push(checkboxes[i].value)
            }
            return result
        }
    },
    directives: {
        'click-outside': {
            bind: function (el, binding, vNode) {
                if (typeof binding.value !== 'function') {
                    const compName = vNode.context.name
                    let warn = `[Vue-click-outside:] provided expression '${binding.expression}' is not a function, but has to be`
                    if (compName) {
                        warn += `Found in component '${compName}'`
                    }

                    console.warn(warn)
                }
                const bubble = binding.modifiers.bubble
                const handler = (e) => {
                    if (bubble || (!el.contains(e.target) && el !== e.target)) {
                        binding.value(e)
                    }
                }
                el.__vueClickOutside__ = handler
                document.addEventListener('click', handler)
            },

            unbind: function (el, binding) {
                document.removeEventListener('click', el.__vueClickOutside__)
                el.__vueClickOutside__ = null

            }
        }
    }
})

Vue.component('client-frm', require('./components/ClientFrm').default)
Vue.component('request-technician', require('./components/RequestTechnician').default)
Vue.component('request-client', require('./components/RequestClient').default)
Vue.component('request-times', require('./components/RequestTimes').default)
Vue.component('request-replies', require('./components/RequestReplies').default)
Vue.component('request-solutions', require('./components/RequestSolutions').default)
Vue.component('problem-requests', require('./components/ProblemRequests').default)
Vue.component('right-sidebar', require('./components/RightSidebar').default)
Vue.component('client-rating', require('./components/ClientRating').default)
Vue.component('request-report', require('./components/RequestReport').default)
Vue.component('user-tags', require('./components/UserTags').default)
Vue.component('duty-user-tags', require('./components/DutyUserTags').default)
Vue.component('request-sla', require('./components/RequestSLA').default)
Vue.component('sla-ruler', require('./components/SLARuler').default)

const app = new Vue({
    el: '#app',
    data: {}
})

history.pushState("", document.title, window.location.pathname + window.location.search)