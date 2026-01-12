<!DOCTYPE html>
<html>

<head>
    <title>Master Application</title>
    <style>
        body{
            color: #000 !important;
        }
    </style>
</head>

<body>
    <div style="width:100%;margin:auto 0;padding:10px;">
        <table style="width: 100%;margin-bottom: 24px;" cellpadding="0" cellspacing="0" role="none">
            <tr>
                <td style="width: 100%; padding: 0; margin: 0;">
                    <img src="{{ asset('assets/images/Email-Banner.jpg') }}" alt="Canedu Banner" style="width: 100%; display: block;">
                </td>
            </tr>
        </table>
        <p style="margin: 0 0 10px; text-align: left; font-size: 16px; color: #000;">The purpose of this email address is to receive copies of the "Master Application" whenever you send it to a school. By using this address, we will be able to keep track of how many times the "Master Application" has been sent to each school, allowing us to better support you throughout the application process.</p>
        @php
    $reasonOptions = [
                'both' => 'Both',
                'reverse_admissions' => 'Reverse Admissions',
                'apply_myself' => 'Apply Myself'
            ];

            $selectedReason = isset($emailData['for_demetra_or_master_app']) 
                ? ($reasonOptions[$emailData['for_demetra_or_master_app']] ?? $emailData['for_demetra_or_master_app']) 
                : '';
        @endphp
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="for_demetra_or_master_app" style="width:30%;color:#000;font-weight:600;">Reason for Filling the Master Application</label>
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">{{ $selectedReason }}</div>
        </div>
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="school_id" style="width:30%;color:#000;font-weight:600;">1- Select your school(s)</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">
            @if(isset($emailData['school_id']) && is_array($emailData['school_id']) && !empty($emailData['school_id']))
                @foreach($emailData['school_id'] as $schoolId)
                    @php
                        // Fetch the school name using the school ID
                        $school = \App\Models\School::with('schoolDetail')->find($schoolId);
                        $schoolName = $school ? ($school->schoolDetail->first()->school_name ?? 'N/A') : 'N/A';
                    @endphp
                    {{ $schoolName }}@if(!$loop->last), @endif
                @endforeach
            @else
                N/A
            @endif
            </div>
        </div>
        
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="first_name" style="width:30%;color:#000;font-weight:600;">2- First name</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">{{ isset($emailData['first_name']) ? $emailData['first_name'] : '' }} </div>
        </div>
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="last_name" style="width:30%;color:#000;font-weight:600;">3- Last name</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">{{ isset($emailData['last_name']) ? $emailData['last_name'] : '' }}</div>
        </div>
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="last_name" style="width:30%;color:#000;font-weight:600;">4- Date of birth</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">{{ isset($emailData['dob']) ? $emailData['dob'] : '' }}</div>
        </div>
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="gender" style="width:30%;color:#000;font-weight:600;">5- Gender</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">{{ isset($emailData['gender']) ? $emailData['gender'] : '' }}</div>
        </div>
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="last_name" style="width:30%;color:#000;font-weight:600;">6- Email address</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">{{ isset($emailData['email']) ? $emailData['email'] : '' }}</div>
        </div>
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="last_name" style="width:30%;color:#000;font-weight:600;">7- Confirm e-mail address</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">{{ isset($emailData['confirm_email']) ? $emailData['confirm_email'] : '' }}</div>
        </div>
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="phone" style="width:30%;color:#000;font-weight:600;">8- Cell phone number</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">{{ isset($emailData['phone']) ? $emailData['phone'] : '' }}</div>
        </div>
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="can_school_text_you" style="width:30%;color:#000;font-weight:600;">9- Can schools text you?</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">{{ isset($emailData['can_school_text_you']) ? $emailData['can_school_text_you'] : '' }}</div>
        </div>
        <div style="text-align: left;display: flex;width: 100%;">
            <label style="width:30%;color:#000;font-weight:600;">10- Messaging app(s)</label>
            <p style="width: 5%;text-align:center;margin:0;"> : </p> 
            <div style="margin: 0;width:65%;displat:flex;flex-wrap:wrap;"> 
            @if(isset($emailData['messaging_app']) && is_array($emailData['messaging_app']) && !empty($emailData['messaging_app']))
                @foreach($emailData['messaging_app'] as $index => $messagingAppId)
                    @php
                        // Fetch the messaging app name using the messaging app ID
                        $messagingApp = \App\Models\MessagingApp::with('messagingAppDetail')->find($messagingAppId);
                        $messagingAppName = $messagingApp ? ($messagingApp->messagingAppDetail->first()->name ?? 'N/A') : 'N/A';
                    @endphp
                    <div>
                        - {{ $messagingAppName }}  
                        (Username: {{ $emailData['messaging_app_username'][$index] ?? 'N/A' }})
                    </div>
                @endforeach
            @else
                N/A
            @endif
            </div>
        </div>
      

        <div style="text-align: left;display: flex;width: 100%;">
            <label style="width:30%;color:#000;font-weight:600;">11- Where do you want to study?</label>
            <p style="width: 5%;text-align:center;margin:0;"> : </p> 
            <div style="margin: 0;width:65%;display: inline-flex;">
                @if(isset($emailData['where_want_to_study']) && is_array($emailData['where_want_to_study']) && !empty($emailData['where_want_to_study']))
                    @foreach($emailData['where_want_to_study'] as $item)
                        {{ $item }}@if(!$loop->last), @endif
                    @endforeach
                @else
                    N/A
                @endif
            </div>
        </div>
        @php
            $countries = [
        'AF' => 'Afghanistan',
        'AX' => 'Aland Islands',
        'AL' => 'Albania',
        'DZ' => 'Algeria',
        'AS' => 'American Samoa',
        'AD' => 'Andorra',
        'AO' => 'Angola',
        'AI' => 'Anguilla',
        'AQ' => 'Antarctica',
        'AG' => 'Antigua and Barbuda',
        'AR' => 'Argentina',
        'AM' => 'Armenia',
        'AW' => 'Aruba',
        'AU' => 'Australia',
        'AT' => 'Austria',
        'AZ' => 'Azerbaijan',
        'BS' => 'Bahamas',
        'BH' => 'Bahrain',
        'BD' => 'Bangladesh',
        'BB' => 'Barbados',
        'BY' => 'Belarus',
        'BE' => 'Belgium',
        'BZ' => 'Belize',
        'BJ' => 'Benin',
        'BM' => 'Bermuda',
        'BT' => 'Bhutan',
        'BO' => 'Bolivia',
        'BQ' => 'Bonaire, Sint Eustatius and Saba',
        'BA' => 'Bosnia and Herzegovina',
        'BW' => 'Botswana',
        'BV' => 'Bouvet Island',
        'BR' => 'Brazil',
        'IO' => 'British Indian Ocean Territory',
        'BN' => 'Brunei Darussalam',
        'BG' => 'Bulgaria',
        'BF' => 'Burkina Faso',
        'BI' => 'Burundi',
        'KH' => 'Cambodia',
        'CM' => 'Cameroon',
        'CA' => 'Canada',
        'CV' => 'Cape Verde',
        'KY' => 'Cayman Islands',
        'CF' => 'Central African Republic',
        'TD' => 'Chad',
        'CL' => 'Chile',
        'CN' => 'China',
        'CX' => 'Christmas Island',
        'CC' => 'Cocos (Keeling) Islands',
        'CO' => 'Colombia',
        'KM' => 'Comoros',
        'CG' => 'Congo',
        'CD' => 'Congo, Democratic Republic of the Congo',
        'CK' => 'Cook Islands',
        'CR' => 'Costa Rica',
        'CI' => 'Cote D\'Ivoire',
        'HR' => 'Croatia',
        'CU' => 'Cuba',
        'CW' => 'Curacao',
        'CY' => 'Cyprus',
        'CZ' => 'Czech Republic',
        'DK' => 'Denmark',
        'DJ' => 'Djibouti',
        'DM' => 'Dominica',
        'DO' => 'Dominican Republic',
        'EC' => 'Ecuador',
        'EG' => 'Egypt',
        'SV' => 'El Salvador',
        'GQ' => 'Equatorial Guinea',
        'ER' => 'Eritrea',
        'EE' => 'Estonia',
        'ET' => 'Ethiopia',
        'FK' => 'Falkland Islands (Malvinas)',
        'FO' => 'Faroe Islands',
        'FJ' => 'Fiji',
        'FI' => 'Finland',
        'FR' => 'France',
        'GF' => 'French Guiana',
        'PF' => 'French Polynesia',
        'TF' => 'French Southern Territories',
        'GA' => 'Gabon',
        'GM' => 'Gambia',
        'GE' => 'Georgia',
        'DE' => 'Germany',
        'GH' => 'Ghana',
        'GI' => 'Gibraltar',
        'GR' => 'Greece',
        'GL' => 'Greenland',
        'GD' => 'Grenada',
        'GP' => 'Guadeloupe',
        'GU' => 'Guam',
        'GT' => 'Guatemala',
        'GG' => 'Guernsey',
        'GN' => 'Guinea',
        'GW' => 'Guinea-Bissau',
        'GY' => 'Guyana',
        'HT' => 'Haiti',
        'HM' => 'Heard Island and McDonald Islands',
        'VA' => 'Holy See (Vatican City State)',
        'HN' => 'Honduras',
        'HK' => 'Hong Kong',
        'HU' => 'Hungary',
        'IS' => 'Iceland',
        'IN' => 'India',
        'ID' => 'Indonesia',
        'IR' => 'Iran, Islamic Republic of',
        'IQ' => 'Iraq',
        'IE' => 'Ireland',
        'IM' => 'Isle of Man',
        'IL' => 'Israel',
        'IT' => 'Italy',
        'JM' => 'Jamaica',
        'JP' => 'Japan',
        'JE' => 'Jersey',
        'JO' => 'Jordan',
        'KZ' => 'Kazakhstan',
        'KE' => 'Kenya',
        'KI' => 'Kiribati',
        'KP' => 'Korea, Democratic People\'s Republic of',
        'KR' => 'Korea, Republic of',
        'XK' => 'Kosovo',
        'KW' => 'Kuwait',
        'KG' => 'Kyrgyzstan',
        'LA' => 'Lao People\'s Democratic Republic',
        'LV' => 'Latvia',
        'LB' => 'Lebanon',
        'LS' => 'Lesotho',
        'LR' => 'Liberia',
        'LY' => 'Libyan Arab Jamahiriya',
        'LI' => 'Liechtenstein',
        'LT' => 'Lithuania',
        'LU' => 'Luxembourg',
        'MO' => 'Macao',
        'MK' => 'Macedonia, the Former Yugoslav Republic of',
        'MG' => 'Madagascar',
        'MW' => 'Malawi',
        'MY' => 'Malaysia',
        'MV' => 'Maldives',
        'ML' => 'Mali',
        'MT' => 'Malta',
        'MH' => 'Marshall Islands',
        'MQ' => 'Martinique',
        'MR' => 'Mauritania',
        'MU' => 'Mauritius',
        'YT' => 'Mayotte',
        'MX' => 'Mexico',
        'FM' => 'Micronesia, Federated States of',
        'MD' => 'Moldova, Republic of',
        'MC' => 'Monaco',
        'MN' => 'Mongolia',
        'ME' => 'Montenegro',
        'MS' => 'Montserrat',
        'MA' => 'Morocco',
        'MZ' => 'Mozambique',
        'MM' => 'Myanmar',
        'NA' => 'Namibia',
        'NR' => 'Nauru',
        'NP' => 'Nepal',
        'NL' => 'Netherlands',
        'AN' => 'Netherlands Antilles',
        'NC' => 'New Caledonia',
        'NZ' => 'New Zealand',
        'NI' => 'Nicaragua',
        'NE' => 'Niger',
        'NG' => 'Nigeria',
        'NU' => 'Niue',
        'NF' => 'Norfolk Island',
        'MP' => 'Northern Mariana Islands',
        'NO' => 'Norway',
        'OM' => 'Oman',
        'PK' => 'Pakistan',
        'PW' => 'Palau',
        'PS' => 'Palestinian Territory, Occupied',
        'PA' => 'Panama',
        'PG' => 'Papua New Guinea',
        'PY' => 'Paraguay',
        'PE' => 'Peru',
        'PH' => 'Philippines',
        'PN' => 'Pitcairn',
        'PL' => 'Poland',
        'PT' => 'Portugal',
        'PR' => 'Puerto Rico',
        'QA' => 'Qatar',
        'RE' => 'Reunion',
        'RO' => 'Romania',
        'RU' => 'Russian Federation',
        'RW' => 'Rwanda',
        'BL' => 'Saint Barthelemy',
        'SH' => 'Saint Helena',
        'KN' => 'Saint Kitts and Nevis',
        'LC' => 'Saint Lucia',
        'MF' => 'Saint Martin',
        'PM' => 'Saint Pierre and Miquelon',
        'VC' => 'Saint Vincent and the Grenadines',
        'WS' => 'Samoa',
        'SM' => 'San Marino',
        'ST' => 'Sao Tome and Principe',
        'SA' => 'Saudi Arabia',
        'SN' => 'Senegal',
        'RS' => 'Serbia',
        'CS' => 'Serbia and Montenegro',
        'SC' => 'Seychelles',
        'SL' => 'Sierra Leone',
        'SG' => 'Singapore',
        'SX' => 'St Martin',
        'SK' => 'Slovakia',
        'SI' => 'Slovenia',
        'SB' => 'Solomon Islands',
        'SO' => 'Somalia',
        'ZA' => 'South Africa',
        'GS' => 'South Georgia and the South Sandwich Islands',
        'SS' => 'South Sudan',
        'ES' => 'Spain',
        'LK' => 'Sri Lanka',
        'SD' => 'Sudan',
        'SR' => 'Suriname',
        'SJ' => 'Svalbard and Jan Mayen',
        'SZ' => 'Swaziland',
        'SE' => 'Sweden',
        'CH' => 'Switzerland',
        'SY' => 'Syrian Arab Republic',
        'TW' => 'Taiwan, Province of China',
        'TJ' => 'Tajikistan',
        'TZ' => 'Tanzania, United Republic of',
        'TH' => 'Thailand',
        'TL' => 'Timor-Leste',
        'TG' => 'Togo',
        'TK' => 'Tokelau',
        'TO' => 'Tonga',
        'TT' => 'Trinidad and Tobago',
        'TN' => 'Tunisia',
        'TR' => 'Turkey',
        'TM' => 'Turkmenistan',
        'TC' => 'Turks and Caicos Islands',
        'TV' => 'Tuvalu',
        'UG' => 'Uganda',
        'UA' => 'Ukraine',
        'AE' => 'United Arab Emirates',
        'GB' => 'United Kingdom',
        'US' => 'United States',
        'UM' => 'United States Minor Outlying Islands',
        'UY' => 'Uruguay',
        'UZ' => 'Uzbekistan',
        'VU' => 'Vanuatu',
        'VE' => 'Venezuela',
        'VN' => 'Viet Nam',
        'VG' => 'Virgin Islands, British',
        'VI' => 'Virgin Islands, U.s.',
        'WF' => 'Wallis and Futuna',
        'EH' => 'Western Sahara',
        'YE' => 'Yemen',
        'ZM' => 'Zambia',
        'ZW' => 'Zimbabwe',
            ];
        @endphp
        <div style="text-align: left;display: flex;width: 100%;">
            <label style="width:30%;color:#000;font-weight:600;">12- What is your country of citizenship?</label>
            <p style="width: 5%;text-align:center;margin:0;"> : </p> 
            <div style="margin: 0;width:65%;display: inline-flex;">
            @if(isset($emailData['country_of_citizenship']))
                @php
                    // Decode the JSON string into an array
                    $countryCodes = json_decode($emailData['country_of_citizenship'], true);
                    // Get the country names from the $countries array
                    $countryNames = [];
                    foreach ($countryCodes as $countryCode) {
                        $countryNames[] = $countries[$countryCode] ?? $countryCode; // Fallback to code if name not found
                    }
                @endphp
                {{ implode(', ', $countryNames) }}
            @else
                N/A
            @endif
            </div>
        </div>
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="live_in_your_country_citizenship" style="width:30%;color:#000;font-weight:600;">13- Are you currently residing in your country of citizenship? </label>
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">{{ isset($emailData['live_in_your_country_citizenship']) ? $emailData['live_in_your_country_citizenship'] : '' }}</div>
        </div>
        {{-- <div style="text-align: left;">
            <label for="current_residance">14- Where do you currently reside?</label> : {{ isset($emailData['current_residance']) ? $emailData['current_residance'] : '' }}
        </div> --}}
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="current_residance" style="width:30%;color:#000;font-weight:600;">14- Where do you currently reside?</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">
            @if(isset($emailData['current_residance']))
                @php
                    // Fetch the country name using the country code
                    $countryCode = $emailData['current_residance'];
                    $countryName = $countries[$countryCode] ?? $countryCode; // Fallback to code if name not found
                @endphp
                {{ $countryName }}
            @else
                N/A
            @endif
            </div>
        </div>
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="current_residance_status" style="width:30%;color:#000;font-weight:600;">15- Status in the country of residence</label>
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">
            {{ isset($emailData['current_residance_status']) ? $emailData['current_residance_status'] : '' }}
            </div>
        </div>
    
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="mailing_address" style="width:30%;color:#000;font-weight:600;">16- Mailing address in the currently where you currently reside</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">
            {{ isset($emailData['mailing_address']) ? $emailData['mailing_address'] : '' }}
            </div>
        </div>
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="high_school_name" style="width:30%;color:#000;font-weight:600;">17- High school name</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">
            {{ isset($emailData['high_school_name']) ? $emailData['high_school_name'] : '' }}
            </div>
        </div>
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="high_school_cgpa" style="width:30%;color:#000;font-weight:600;">18- High school GPA</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">
            {{ isset($emailData['high_school_cgpa']) ? $emailData['high_school_cgpa'] : '' }}
            </div>
        </div>
        {{-- <div style="text-align: left;">
            <label for="high_school_country">19- High school location - country</label> : {{ isset($emailData['high_school_country']) ? $emailData['high_school_country'] : '' }}
        </div> --}}
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="high_school_country" style="width:30%;color:#000;font-weight:600;">19- High school location - country</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">
            @if(isset($emailData['high_school_country']))
                @php
                    // Fetch the country name using the country code
                    $countryCode = $emailData['high_school_country'];
                    $countryName = $countries[$countryCode] ?? $countryCode; // Fallback to code if name not found
                @endphp
                {{ $countryName }}
            @else
                N/A
            @endif
            </div>
        </div>

        <div style="text-align: left;display: flex;width: 100%;">
            <label for="high_school_city" style="width:30%;color:#000;font-weight:600;">20- High school location - city</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">
            {{ isset($emailData['high_school_city']) ? $emailData['high_school_city'] : '' }}
            </div>
        </div>


        <div style="text-align: left;display: flex;width: 100%;">
            <label for="when_plan_to_start" style="width:30%;color:#000;font-weight:600;">21- When are you planning to start?</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p> 
            <div style="margin: 0;width:65%;display: inline-flex;">
            @if(isset($emailData['when_plan_to_start']))
                @php
                    // Replace underscores with spaces and capitalize each word
                    $formattedValue = ucwords(str_replace('_', ' ', $emailData['when_plan_to_start']));
                @endphp
                {{ $formattedValue }}
            @else
                N/A
            @endif
            </div>
        </div>
        {{-- <div style="text-align: left;">
            <label for="interested_in">22- I am interested in</label> : {{ isset($emailData['interested_in']) ? $emailData['interested_in'] : '' }}
        </div> --}}
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="interested_in" style="width:30%;color:#000;font-weight:600;">22- I am interested in</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p> 
            <div style="margin: 0;width:65%;display: inline-flex;">
            @if(isset($emailData['interested_in']))
                @php
                    // Fetch the degree name using the degree ID
                    $degree = \App\Models\Degree::with('degreeDetail')->find($emailData['interested_in']);
                    $degreeName = $degree ? ($degree->degreeDetail->first()->name ?? 'N/A') : 'N/A';
                @endphp
                {{ $degreeName }}
            @else
                N/A
            @endif
            </div>
        </div>
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="would_like_to_study" style="width:30%;color:#000;font-weight:600;">23- I would like to study</label>
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">
            @if(isset($emailData['would_like_to_study']))
                @php
                    // Decode the JSON string into an array of program IDs
                    $programIds = json_decode($emailData['would_like_to_study'], true);
                    
                    // Get the default language
                    $defaultLang = getDefaultLanguage(1);
                @endphp
                
                @if(!empty($programIds))
                    @foreach($programIds as $programId)
                        @php
                            $program = \App\Models\Program::with(['programDetail' => function($q) use ($defaultLang) {
                                $q->where('language_id', $defaultLang->id);
                            }])->find($programId);
                        @endphp
                        <div style="margin-right: 10px;display:flex;">
                            <p>
                                Program Name: 
                                {{ $program->programDetail->first()->name ?? 'N/A' }}
                            </p>
                            <p style="margin-top: 20px;">,</p>
                        </div>
                    @endforeach
                @else
                    <p>N/A</p>
                @endif
            @else
                <p>N/A</p>
            @endif
            </div>
        </div>

        <div style="text-align: left;display: flex;width: 100%;">
            <label for="student_type" style="width:30%;color:#000;font-weight:600;">24- I am this kind of student</label>
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">
            {{ isset($emailData['student_type']) ? ucfirst(str_replace('_', ' ', strtolower($emailData['student_type']))) : '' }}
            </div>
        </div>

        {{-- <div style="text-align: left;">
            <label for="tuition_funding_source">Tuition funding source</label> : {{ isset($emailData['tuition_funding_source']) ? $emailData['tuition_funding_source'] : '' }}
            
        </div> --}}
        <div style="text-align: left;display: flex;width: 100%;">
            <label style="width:30%;color:#000;font-weight:600;">25- Tuition fees source(s)</label>
            <p style="width: 5%;text-align:center;margin:0;"> : </p> 
            <div style="margin: 0;width:65%;display: inline-flex;">
            @if(isset($emailData['tuition_funding_source']) && is_array($emailData['tuition_funding_source']) && !empty($emailData['tuition_funding_source']))
                @foreach($emailData['tuition_funding_source'] as $source)
                    {{ ucfirst(str_replace('_', ' ', strtolower($source))) }}@if(!$loop->last), @endif
                @endforeach
            @else
                N/A
            @endif
            </div>
        </div>
        {{-- <div style="text-align: left;">
            <label class="text-lg font-medium mb-2">26- Tests taken</label>
            @if(isset($emailData['test_taken']) && is_array($emailData['test_taken']) && !empty($emailData['test_taken']))
                @foreach($emailData['test_taken'] as $test)
                    @php
                        // Fetch the test name using the test ID
                        $testModel = \App\Models\Test::with('testDetail')->find($test['test']);
                        $testName = $testModel ? ($testModel->testDetail->first()->name ?? 'N/A') : 'N/A';
                    @endphp
                    <p>
                        <label>Test Name: {{ $testName }}</label>
                        <br />
                        <label>Score: {{ $test['score'] }}</label>
                    </p>
                @endforeach
            @else
                <p>N/A</p>
            @endif
        </div>
        <div style="text-align: left;">
            <label class="text-lg font-medium mb-2">26- Other Tests</label>
            <p>
                <label>Other Test 1 Name: {{ isset($emailData['other_name_1']) ? $emailData['other_name_1'] : 'N/A' }}</label>
                <br />
                <label>Other Test 1 Score: {{ isset($emailData['other_score_1']) ? $emailData['other_score_1'] : 'N/A' }}</label>
            </p>
            <p>
                <label>Other Test 2 Name: {{ isset($emailData['other_name_2']) ? $emailData['other_name_2'] : 'N/A' }}</label>
                <br />
                <label>Other Test 2 Score: {{ isset($emailData['other_score_2']) ? $emailData['other_score_2'] : 'N/A' }}</label>
            </p>
            <p>
                <label>Other Test 3 Name: {{ isset($emailData['other_name_3']) ? $emailData['other_name_3'] : 'N/A' }}</label>
                <br />
                <label>Other Test 3 Score: {{ isset($emailData['other_score_3']) ? $emailData['other_score_3'] : 'N/A' }}</label>
            </p>
            <p>
                <label>Other Test 4 Name: {{ isset($emailData['other_name_4']) ? $emailData['other_name_4'] : 'N/A' }}</label>
                <br />
                <label>Other Test 4 Score: {{ isset($emailData['other_score_4']) ? $emailData['other_score_4'] : 'N/A' }}</label>
            </p>
            <p>
                <label>Other Test 5 Name: {{ isset($emailData['other_name_5']) ? $emailData['other_name_5'] : 'N/A' }}</label>
                <br />
                <label>Other Test 5 Score: {{ isset($emailData['other_score_5']) ? $emailData['other_score_5'] : 'N/A' }}</label>
            </p>
        </div> --}}
        <div style="text-align: left;display: flex;width: 100%;">
            <label  style="width:30%;color:#000;font-weight:600;font-size: 18px;">26- Tests taken</label>
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display:flex; flex-wrap: wrap;">
            @php
                $hasTests = isset($emailData['test_taken']) && is_array($emailData['test_taken']) && !empty($emailData['test_taken']);
                $hasOtherTests = isset($emailData['other_name_1']) || isset($emailData['other_name_2']) || isset($emailData['other_name_3']) || isset($emailData['other_name_4']) || isset($emailData['other_name_5']);
            @endphp
            
            @if($hasTests)
                @foreach($emailData['test_taken'] as $test)
                    @php
                        $testModel = \App\Models\Test::with('testDetail')->find($test['test']);
                        $testName = $testModel ? ($testModel->testDetail->first()->name ?? 'N/A') : 'N/A';
                    @endphp
                    <div style="margin-right: 10px;display:flex;">
                    <p>
                        Test Name: {{ $testName }}
                        <br />
                        Score: {{ $test['score'] }}
                    </p>
                    <p style="margin-top: 20px;">,</p>
                    </div>
                @endforeach
            @endif
        
            @if($hasOtherTests)
                @for($i = 1; $i <= 5; $i++)
                    @php
                        $otherName = $emailData['other_name_'.$i] ?? null;
                        $otherScore = $emailData['other_score_'.$i] ?? null;
                    @endphp
                    
                    @if($otherName)
                        <p>
                            <label>Other Test {{ $i }} Name: {{ $otherName }}</label>
                            <br />
                            <label>Other Test {{ $i }} Score: {{ $otherScore ?? 'N/A' }}</label>
                        </p>
                    @endif
                @endfor
            @endif
            
            @if(!$hasTests && !$hasOtherTests)
                <p>N/A</p>
            @endif
            </div>
        </div>
        

        <div style="text-align: left;display: flex;width: 100%;">
            <label for="addtional" style="width:30%;color:#000;font-weight:600;">27- Anything else to add?</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">
            {{ isset($emailData['addtional']) ? $emailData['addtional'] : '' }}
            </div>
        </div>

        <div style="text-align: left;display: flex;width: 100%;">
            <label for="add_anything" style="width:30%;color:#000;font-weight:600;">28- Your Bio</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">
            {{ isset($emailData['add_anything']) ? $emailData['add_anything'] : '' }}
            </div>
        </div>
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="study_permit_candian_embassy" style="width:30%;color:#000;font-weight:600;">29- Do you already have a study permit (a student visa) to study in Canada?</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">
                {{ isset($emailData['study_permit_candian_embassy']) ? $emailData['study_permit_candian_embassy'] : '' }}
            </div>
        </div>
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="currently_student_anywhere" style="width:30%;color:#000;font-weight:600;">30- Are you currently a student anywhere?</label>
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">
                {{ isset($emailData['currently_student_anywhere']) ? $emailData['currently_student_anywhere'] : '' }}
            </div>
        </div>
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="currently_living_in_canada" style="width:30%;color:#000;font-weight:600;">31- Are you a transfer student currently living in Canada?</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p>
            <div style="margin: 0;width:65%;display: inline-flex;">
                {{ isset($emailData['currently_living_in_canada']) ? $emailData['currently_living_in_canada'] : '' }}
            </div>
        </div>
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="statement_of_purpose" style="width:30%;color:#000;font-weight:600;">32- Statement of Purpose</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p> 
            <div style="margin: 0;width:65%;display: inline-flex;">
            @if(isset($emailData['statement_of_purpose']) && filter_var($emailData['statement_of_purpose'], FILTER_VALIDATE_URL))
                <a href="{{ $emailData['statement_of_purpose'] }}" target="_blank" style="color: #000;font-weight: 500; text-decoration: underline;">
                    {{ $emailData['statement_of_purpose'] }}
                </a>
            @else
                {{ isset($emailData['statement_of_purpose']) ? $emailData['statement_of_purpose'] : '' }}
            @endif
            </div>
        </div>
        
        <div style="text-align: left;display: flex;width: 100%;">
            <label for="letter_of_intent" style="width:30%;color:#000;font-weight:600;">33- Letter of Intent</label> 
            <p style="width: 5%;text-align:center;margin:0;"> : </p> 
            <div style="margin: 0;width:65%;display: inline-flex;">
            @if(isset($emailData['letter_of_intent']) && filter_var($emailData['letter_of_intent'], FILTER_VALIDATE_URL))
                <a href="{{ $emailData['letter_of_intent'] }}" target="_blank" style="color: #000;font-weight: 500; text-decoration: underline;">
                    {{ $emailData['letter_of_intent'] }}
                </a>
            @else
                {{ isset($emailData['letter_of_intent']) ? $emailData['letter_of_intent'] : '' }}
            @endif
            </div>
        </div>

        <table style="width: 100%;margin-top: 24px;" cellpadding="0" cellspacing="0" role="none">
            <tr>
                <td class="sm-px-6" style="background-color: #f3f4f6; padding: 16px 48px; text-align: left; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05)">
                    {{-- <table style="margin-left: auto; margin-right: auto; margin-bottom: 8px" cellpadding="0" cellspacing="0" role="none">
                        <tr>
                            <td>
                                <img src="{{ asset('assets/images/canedu-black-logo.png') }}" alt="Canedu Logo" style="max-width: 100%; vertical-align: middle; margin-left: auto; margin-right: auto; width: 192px">
                            </td>
                        </tr>
                    </table> --}}
                    <table style="margin-bottom: 24px; margin-top: 16px; width: 100%" cellpadding="0" cellspacing="0" role="none">
                        <tr>
                            <td align="center" style="display: flex;">
                                <div style="display: flex; margin: 0 auto;">
                                    <a aria-label="Proxima Study" target="_blank" href="https://facebook.com" style="border: 1px solid #d1d5db; display: flex; height: 40px; width: 40px; border-radius: 9999px; background-color: #fffffe;margin-right: 16px;">
                                        <img src="{{ asset('assets/images/facebook.png') }}" alt="facebook icon" style="max-width: 100%; vertical-align: middle; height: 20px;margin-top: 10px;margin-left: 13px;">
                                    </a>
                                    <a aria-label="Proxima Study" target="_blank" href="https://twitter.com" style="border: 1px solid #d1d5db; display: flex; height: 40px; width: 40px; border-radius: 9999px; background-color: #fffffe;margin-right: 16px;">
                                        <img src="{{ asset('assets/images/twitter.png') }}" alt="twiiter icon" style="max-width: 100%; vertical-align: middle; height: 16px;margin-top: 11px;margin-left: 10px;">
                                    </a>
                                    <a aria-label="Proxima Study" target="_blank" href="https://www.instagram.com" style="border: 1px solid #d1d5db; display: flex; height: 40px; width: 40px; border-radius: 9999px; background-color: #fffffe;margin-right: 16px;">
                                        <img src="{{ asset('assets/images/instagram.png') }}" alt="google icon" style="max-width: 100%; vertical-align: middle; height: 20px;margin-top: 9px;margin-left: 9px;">
                                    </a>
                                    <a aria-label="Proxima Study" target="_blank" href="https://youtube.com" style="border: 1px solid #d1d5db; display: flex; height: 40px; width: 40px; border-radius: 9999px; background-color: #fffffe;margin-right: 16px;">
                                        <img src="{{ asset('assets/images/youtube.png') }}" alt="youtube icon" style="max-width: 100%; vertical-align: middle; height: 16px;margin-top: 11px;margin-left: 8px;">
                                    </a>
                                    <a aria-label="Proxima Study" target="_blank" href="https://www.linkedin.com" style="border: 1px solid #d1d5db; display: flex; height: 40px; width: 40px; border-radius: 9999px; background-color: #fffffe;">
                                        <img src="{{ asset('assets/images/linkedin.png') }}" alt="linkedin icon" style="max-width: 100%; vertical-align: middle; height: 16px;margin-top: 10px;margin-left: 12px;">
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table style="margin: 8px auto" cellpadding="0" cellspacing="0" role="none">
                        <tr>
                            <td>
                                <p style="margin: 0; white-space: nowrap; padding-left: 8px; padding-right: 8px; font-size: 16px; color: #000;">©2025 Proxima Study. All rights reserved.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
