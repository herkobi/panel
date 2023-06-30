@extends('layouts.app')
@section('content')
    @include('layouts.partials.page-title', ['title' => 'Genel Ayarlar'])
    <div class="page-content position-relative mb-4">
        <div class="page-content position-relative mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="card rounded-0 shadow-sm border-0 mb-3">
                        <div class="card-header border-0 bg-white pt-3 pb-3">
                            <h4 class="card-title mb-0">Genel Ayarlar</h4>
                            <small>Kullanıcı bazlı genel ayarlar. Her kullanıcı kendine özgü ayarlarla sistemi
                                kullanabilir.</small>
                        </div>
                        <div class="card-body">
                            <form id="app-settings-form" method="post">
                                @csrf
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label for="app-language-settings" class="col-md-4 fw-bold align-self-center">Sistem
                                            Dili</label>
                                        <div id="app-language-settings" class="col-md-8">
                                            <select class="form-select form-select-sm rounded-0 shadow-none" name="language"
                                                id="app-language">
                                                <option selected>Seçiniz</option>
                                                @foreach (config('app.available_locales') as $key => $locale)
                                                    <option value="{{ $locale }}">{{ $key }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label for="app-timezone-settings" class="col-md-4 fw-bold align-self-start">Zaman
                                            Dilimi</label>
                                        <div id="app-timezone-settings" class="col-md-8">
                                            <select class="form-select form-select-sm rounded-0 shadow-none" name="timezone"
                                                id="app-timezone">
                                                <option selected>Seçiniz</option>
                                                <optgroup label="Afrika">
                                                    <option value="Africa/Abidjan">Abidjan</option>
                                                    <option value="Africa/Accra">Accra</option>
                                                    <option value="Africa/Addis_Ababa">Addis Ababa</option>
                                                    <option value="Africa/Algiers">Algiers</option>
                                                    <option value="Africa/Asmara">Asmara</option>
                                                    <option value="Africa/Bamako">Bamako</option>
                                                    <option value="Africa/Bangui">Bangui</option>
                                                    <option value="Africa/Banjul">Banjul</option>
                                                    <option value="Africa/Bissau">Bissau</option>
                                                    <option value="Africa/Blantyre">Blantyre</option>
                                                    <option value="Africa/Brazzaville">Brazzaville</option>
                                                    <option value="Africa/Bujumbura">Bujumbura</option>
                                                    <option value="Africa/Cairo">Cairo</option>
                                                    <option value="Africa/Casablanca">Casablanca</option>
                                                    <option value="Africa/Ceuta">Ceuta</option>
                                                    <option value="Africa/Conakry">Conakry</option>
                                                    <option value="Africa/Dakar">Dakar</option>
                                                    <option value="Africa/Dar_es_Salaam">Dar es Salaam</option>
                                                    <option value="Africa/Djibouti">Djibouti</option>
                                                    <option value="Africa/Douala">Douala</option>
                                                    <option value="Africa/El_Aaiun">El Aaiun</option>
                                                    <option value="Africa/Freetown">Freetown</option>
                                                    <option value="Africa/Gaborone">Gaborone</option>
                                                    <option value="Africa/Harare">Harare</option>
                                                    <option value="Africa/Johannesburg">Johannesburg</option>
                                                    <option value="Africa/Juba">Juba</option>
                                                    <option value="Africa/Kampala">Kampala</option>
                                                    <option value="Africa/Khartoum">Khartoum</option>
                                                    <option value="Africa/Kigali">Kigali</option>
                                                    <option value="Africa/Kinshasa">Kinshasa</option>
                                                    <option value="Africa/Lagos">Lagos</option>
                                                    <option value="Africa/Libreville">Libreville</option>
                                                    <option value="Africa/Lome">Lome</option>
                                                    <option value="Africa/Luanda">Luanda</option>
                                                    <option value="Africa/Lubumbashi">Lubumbashi</option>
                                                    <option value="Africa/Lusaka">Lusaka</option>
                                                    <option value="Africa/Malabo">Malabo</option>
                                                    <option value="Africa/Maputo">Maputo</option>
                                                    <option value="Africa/Maseru">Maseru</option>
                                                    <option value="Africa/Mbabane">Mbabane</option>
                                                    <option value="Africa/Mogadishu">Mogadishu</option>
                                                    <option value="Africa/Monrovia">Monrovia</option>
                                                    <option value="Africa/Nairobi">Nairobi</option>
                                                    <option value="Africa/Ndjamena">Ndjamena</option>
                                                    <option value="Africa/Niamey">Niamey</option>
                                                    <option value="Africa/Nouakchott">Nouakchott</option>
                                                    <option value="Africa/Ouagadougou">Ouagadougou</option>
                                                    <option value="Africa/Porto-Novo">Porto-Novo</option>
                                                    <option value="Africa/Sao_Tome">Sao Tome</option>
                                                    <option value="Africa/Tripoli">Tripoli</option>
                                                    <option value="Africa/Tunis">Tunis</option>
                                                    <option value="Africa/Windhoek">Windhoek</option>
                                                </optgroup>
                                                <optgroup label="America">
                                                    <option value="America/Adak">Adak</option>
                                                    <option value="America/Anchorage">Anchorage</option>
                                                    <option value="America/Anguilla">Anguilla</option>
                                                    <option value="America/Antigua">Antigua</option>
                                                    <option value="America/Araguaina">Araguaina</option>
                                                    <option value="America/Argentina/Buenos_Aires">Arjantin - Buenos Aires
                                                    </option>
                                                    <option value="America/Argentina/Catamarca">Arjantin - Catamarca
                                                    </option>
                                                    <option value="America/Argentina/Jujuy">Arjantin - Jujuy</option>
                                                    <option value="America/Argentina/Cordoba">Arjantin - Kurtuba</option>
                                                    <option value="America/Argentina/La_Rioja">Arjantin - La Rioja</option>
                                                    <option value="America/Argentina/Mendoza">Arjantin - Mendoza</option>
                                                    <option value="America/Argentina/Rio_Gallegos">Arjantin - Rio Gallegos
                                                    </option>
                                                    <option value="America/Argentina/Salta">Arjantin - Salta</option>
                                                    <option value="America/Argentina/San_Juan">Arjantin - San Juan</option>
                                                    <option value="America/Argentina/San_Luis">Arjantin - San Luis</option>
                                                    <option value="America/Argentina/Tucuman">Arjantin - Tucuman</option>
                                                    <option value="America/Argentina/Ushuaia">Arjantin - Ushuaia</option>
                                                    <option value="America/Aruba">Aruba</option>
                                                    <option value="America/Asuncion">Asuncion</option>
                                                    <option value="America/Atikokan">Atikokan</option>
                                                    <option value="America/Bahia">Bahia</option>
                                                    <option value="America/Bahia_Banderas">Bahia Banderas</option>
                                                    <option value="America/Barbados">Barbados</option>
                                                    <option value="America/Belem">Belem</option>
                                                    <option value="America/Belize">Belize</option>
                                                    <option value="America/Blanc-Sablon">Blanc-Sablon</option>
                                                    <option value="America/Boa_Vista">Boa Vista</option>
                                                    <option value="America/Bogota">Bogota</option>
                                                    <option value="America/Boise">Boise</option>
                                                    <option value="America/Cambridge_Bay">Cambridge Bay</option>
                                                    <option value="America/Campo_Grande">Campo Grande</option>
                                                    <option value="America/Cancun">Cancun</option>
                                                    <option value="America/Caracas">Caracas</option>
                                                    <option value="America/Cayenne">Cayenne</option>
                                                    <option value="America/Cayman">Cayman</option>
                                                    <option value="America/Chihuahua">Chihuahua</option>
                                                    <option value="America/Creston">Creston</option>
                                                    <option value="America/Cuiaba">Cuiaba</option>
                                                    <option value="America/Curacao">Curacao</option>
                                                    <option value="America/Danmarkshavn">Danmarkshavn</option>
                                                    <option value="America/Dawson">Dawson</option>
                                                    <option value="America/Dawson_Creek">Dawson Creek</option>
                                                    <option value="America/Denver">Denver</option>
                                                    <option value="America/Detroit">Detroit</option>
                                                    <option value="America/Dominica">Dominica</option>
                                                    <option value="America/Edmonton">Edmonton</option>
                                                    <option value="America/Eirunepe">Eirunepe</option>
                                                    <option value="America/El_Salvador">El Salvador</option>
                                                    <option value="America/Fortaleza">Fortaleza</option>
                                                    <option value="America/Fort_Nelson">Fort Nelson</option>
                                                    <option value="America/Glace_Bay">Glace Bay</option>
                                                    <option value="America/Goose_Bay">Goose Bay</option>
                                                    <option value="America/Grand_Turk">Grand Turk</option>
                                                    <option value="America/Grenada">Grenada</option>
                                                    <option value="America/Guadeloupe">Guadeloupe</option>
                                                    <option value="America/Guatemala">Guatemala</option>
                                                    <option value="America/Guayaquil">Guayaquil</option>
                                                    <option value="America/Guyana">Guyana</option>
                                                    <option value="America/Halifax">Halifax</option>
                                                    <option value="America/Havana">Havana</option>
                                                    <option value="America/Hermosillo">Hermosillo</option>
                                                    <option value="America/Indiana/Indianapolis">Indiana - Indianapolis
                                                    </option>
                                                    <option value="America/Indiana/Knox">Indiana - Knox</option>
                                                    <option value="America/Indiana/Marengo">Indiana - Marengo</option>
                                                    <option value="America/Indiana/Petersburg">Indiana - Petersburg
                                                    </option>
                                                    <option value="America/Indiana/Tell_City">Indiana - Tell City</option>
                                                    <option value="America/Indiana/Vevay">Indiana - Vevay</option>
                                                    <option value="America/Indiana/Vincennes">Indiana - Vincennes</option>
                                                    <option value="America/Indiana/Winamac">Indiana - Winamac</option>
                                                    <option value="America/Inuvik">Inuvik</option>
                                                    <option value="America/Iqaluit">Iqaluit</option>
                                                    <option value="America/Jamaica">Jamaika</option>
                                                    <option value="America/Juneau">Juneau</option>
                                                    <option value="America/Kentucky/Louisville">Kentucky - Louisville
                                                    </option>
                                                    <option value="America/Kentucky/Monticello">Kentucky - Monticello
                                                    </option>
                                                    <option value="America/Costa_Rica">Kosta Rika</option>
                                                    <option value="America/Kralendijk">Kralendijk</option>
                                                    <option value="America/North_Dakota/Beulah">Kuzey Dakota - Beulah
                                                    </option>
                                                    <option value="America/North_Dakota/Center">Kuzey Dakota - Merkez
                                                    </option>
                                                    <option value="America/North_Dakota/New_Salem">Kuzey Dakota - New Salem
                                                    </option>
                                                    <option value="America/La_Paz">La Paz</option>
                                                    <option value="America/Lima">Lima</option>
                                                    <option value="America/Los_Angeles">Los Angeles</option>
                                                    <option value="America/Lower_Princes">Lower Princes</option>
                                                    <option value="America/Maceio">Maceio</option>
                                                    <option value="America/Managua">Managua</option>
                                                    <option value="America/Manaus">Manaus</option>
                                                    <option value="America/Marigot">Marigot</option>
                                                    <option value="America/Martinique">Martinique</option>
                                                    <option value="America/Matamoros">Matamoros</option>
                                                    <option value="America/Mazatlan">Mazatlan</option>
                                                    <option value="America/Mexico_City">Meksika</option>
                                                    <option value="America/Menominee">Menominee</option>
                                                    <option value="America/Merida">Merida</option>
                                                    <option value="America/Metlakatla">Metlakatla</option>
                                                    <option value="America/Miquelon">Miquelon</option>
                                                    <option value="America/Moncton">Moncton</option>
                                                    <option value="America/Monterrey">Monterrey</option>
                                                    <option value="America/Montevideo">Montevideo</option>
                                                    <option value="America/Montserrat">Montserrat</option>
                                                    <option value="America/Nassau">Nassau</option>
                                                    <option value="America/New_York">New York</option>
                                                    <option value="America/Nome">Nome</option>
                                                    <option value="America/Noronha">Noronha</option>
                                                    <option value="America/Nuuk">Nuuk</option>
                                                    <option value="America/Ojinaga">Ojinaga</option>
                                                    <option value="America/Panama">Panama</option>
                                                    <option value="America/Pangnirtung">Pangnirtung</option>
                                                    <option value="America/Paramaribo">Paramaribo</option>
                                                    <option value="America/Phoenix">Phoenix</option>
                                                    <option value="America/Port-au-Prince">Port-au-Prince</option>
                                                    <option value="America/Port_of_Spain">Port of Spain</option>
                                                    <option value="America/Puerto_Rico">Porto Riko</option>
                                                    <option value="America/Porto_Velho">Porto Velho</option>
                                                    <option value="America/Punta_Arenas">Punta Arena</option>
                                                    <option value="America/Rankin_Inlet">Rankin Inlet</option>
                                                    <option value="America/Recife">Recife</option>
                                                    <option value="America/Regina">Regina</option>
                                                    <option value="America/Resolute">Resolute</option>
                                                    <option value="America/Rio_Branco">Rio Branco</option>
                                                    <option value="America/Santarem">Santarem</option>
                                                    <option value="America/Santiago">Santiago</option>
                                                    <option value="America/Santo_Domingo">Santo Domingo</option>
                                                    <option value="America/Sao_Paulo">Sao Paulo</option>
                                                    <option value="America/Scoresbysund">Scoresbysund</option>
                                                    <option value="America/Sitka">Sitka</option>
                                                    <option value="America/St_Barthelemy">St Barthelemy</option>
                                                    <option value="America/St_Johns">St Johns</option>
                                                    <option value="America/St_Kitts">St Kitts</option>
                                                    <option value="America/St_Lucia">St Lucia</option>
                                                    <option value="America/St_Thomas">St Thomas</option>
                                                    <option value="America/St_Vincent">St Vincent</option>
                                                    <option value="America/Swift_Current">Swift Current</option>
                                                    <option value="America/Tegucigalpa">Tegucigalpa</option>
                                                    <option value="America/Thule">Thule</option>
                                                    <option value="America/Tijuana">Tijuana</option>
                                                    <option value="America/Toronto">Toronto</option>
                                                    <option value="America/Tortola">Tortola</option>
                                                    <option value="America/Vancouver">Vancouver</option>
                                                    <option value="America/Whitehorse">Whitehorse</option>
                                                    <option value="America/Winnipeg">Winnipeg</option>
                                                    <option value="America/Yakutat">Yakutat</option>
                                                    <option value="America/Yellowknife">Yellowknife</option>
                                                    <option value="America/Chicago">Şikago</option>
                                                </optgroup>
                                                <optgroup label="Antarctica">
                                                    <option value="Antarctica/Casey">Casey</option>
                                                    <option value="Antarctica/Davis">Davis</option>
                                                    <option value="Antarctica/DumontDUrville">DumontDUrville</option>
                                                    <option value="Antarctica/Macquarie">Macquarie</option>
                                                    <option value="Antarctica/Mawson">Mawson</option>
                                                    <option value="Antarctica/McMurdo">McMurdo</option>
                                                    <option value="Antarctica/Palmer">Palmer</option>
                                                    <option value="Antarctica/Rothera">Rothera</option>
                                                    <option value="Antarctica/Syowa">Syowa</option>
                                                    <option value="Antarctica/Troll">Troll</option>
                                                    <option value="Antarctica/Vostok">Vostok</option>
                                                </optgroup>
                                                <optgroup label="Arctic">
                                                    <option value="Arctic/Longyearbyen">Longyearbyen</option>
                                                </optgroup>
                                                <optgroup label="Asia">
                                                    <option value="Asia/Aden">Aden</option>
                                                    <option value="Asia/Almaty">Almaty</option>
                                                    <option value="Asia/Amman">Amman</option>
                                                    <option value="Asia/Anadyr">Anadyr</option>
                                                    <option value="Asia/Aqtau">Aqtau</option>
                                                    <option value="Asia/Aqtobe">Aqtobe</option>
                                                    <option value="Asia/Ashgabat">Ashgabat</option>
                                                    <option value="Asia/Atyrau">Atiro</option>
                                                    <option value="Asia/Bahrain">Bahreyn</option>
                                                    <option value="Asia/Baku">Bakü</option>
                                                    <option value="Asia/Bangkok">Bangok</option>
                                                    <option value="Asia/Barnaul">Barnaul</option>
                                                    <option value="Asia/Baghdad">Bağdat</option>
                                                    <option value="Asia/Beirut">Beyrut</option>
                                                    <option value="Asia/Bishkek">Bişkek</option>
                                                    <option value="Asia/Brunei">Brunei</option>
                                                    <option value="Asia/Jakarta">Cakarta</option>
                                                    <option value="Asia/Chita">Chita</option>
                                                    <option value="Asia/Choibalsan">Choibalsan</option>
                                                    <option value="Asia/Colombo">Colombo</option>
                                                    <option value="Asia/Dhaka">Dhaka</option>
                                                    <option value="Asia/Dili">Dili</option>
                                                    <option value="Asia/Dubai">Dubai</option>
                                                    <option value="Asia/Dushanbe">Dushanbe</option>
                                                    <option value="Asia/Famagusta">Famagusta</option>
                                                    <option value="Asia/Gaza">Gazze</option>
                                                    <option value="Asia/Hebron">Hebron</option>
                                                    <option value="Asia/Ho_Chi_Minh">Ho Chi Minh</option>
                                                    <option value="Asia/Hong_Kong">Hong Kong</option>
                                                    <option value="Asia/Hovd">Hovd</option>
                                                    <option value="Asia/Irkutsk">Irkutsk</option>
                                                    <option value="Asia/Jayapura">Jayapura</option>
                                                    <option value="Asia/Kamchatka">Kamçatka</option>
                                                    <option value="Asia/Khandyga">Kandiga</option>
                                                    <option value="Asia/Karachi">Karaçi</option>
                                                    <option value="Asia/Qatar">Katar</option>
                                                    <option value="Asia/Kathmandu">Katmandu</option>
                                                    <option value="Asia/Kolkata">Kolkata</option>
                                                    <option value="Asia/Krasnoyarsk">Krasnoyarsk</option>
                                                    <option value="Asia/Kuala_Lumpur">Kuala Lumpur</option>
                                                    <option value="Asia/Kuching">Kuching</option>
                                                    <option value="Asia/Jerusalem">Kudüs</option>
                                                    <option value="Asia/Kuwait">Kuveyt</option>
                                                    <option value="Asia/Kabul">Kâbil</option>
                                                    <option value="Asia/Macau">Macau</option>
                                                    <option value="Asia/Magadan">Magadan</option>
                                                    <option value="Asia/Makassar">Makassar</option>
                                                    <option value="Asia/Manila">Manila</option>
                                                    <option value="Asia/Muscat">Muscat</option>
                                                    <option value="Asia/Nicosia">Nicosia</option>
                                                    <option value="Asia/Novokuznetsk">Novokuznetsk</option>
                                                    <option value="Asia/Novosibirsk">Novosibirsk</option>
                                                    <option value="Asia/Omsk">Omsk</option>
                                                    <option value="Asia/Oral">Oral</option>
                                                    <option value="Asia/Phnom_Penh">Phnom Penh</option>
                                                    <option value="Asia/Pontianak">Pontianak</option>
                                                    <option value="Asia/Pyongyang">Pyongyang</option>
                                                    <option value="Asia/Qostanay">Qostanay</option>
                                                    <option value="Asia/Qyzylorda">Qyzylorda</option>
                                                    <option value="Asia/Riyadh">Riyadh</option>
                                                    <option value="Asia/Sakhalin">Sakhalin</option>
                                                    <option value="Asia/Samarkand">Semerkant</option>
                                                    <option value="Asia/Seoul">Seul</option>
                                                    <option value="Asia/Singapore">Singapur</option>
                                                    <option value="Asia/Srednekolymsk">Srednekolymsk</option>
                                                    <option value="Asia/Taipei">Taipei</option>
                                                    <option value="Asia/Tashkent">Taşkent</option>
                                                    <option value="Asia/Tehran">Tehran</option>
                                                    <option value="Asia/Thimphu">Thimphu</option>
                                                    <option value="Asia/Tbilisi">Tiflis</option>
                                                    <option value="Asia/Tokyo">Tokyo</option>
                                                    <option value="Asia/Tomsk">Tomsk</option>
                                                    <option value="Asia/Ulaanbaatar">Ulaanbaatar</option>
                                                    <option value="Asia/Urumqi">Urumqi</option>
                                                    <option value="Asia/Ust-Nera">Ust-Nera</option>
                                                    <option value="Asia/Vientiane">Vientiane</option>
                                                    <option value="Asia/Vladivostok">Vladivostok</option>
                                                    <option value="Asia/Yakutsk">Yakutsk</option>
                                                    <option value="Asia/Yangon">Yangon</option>
                                                    <option value="Asia/Yekaterinburg">Yekaterinburg</option>
                                                    <option value="Asia/Yerevan">Yerevan</option>
                                                    <option value="Asia/Damascus">Şam</option>
                                                    <option value="Asia/Shanghai">Şangay</option>
                                                </optgroup>
                                                <optgroup label="Atlantik">
                                                    <option value="Atlantic/Azores">Azores</option>
                                                    <option value="Atlantic/Bermuda">Bermuda</option>
                                                    <option value="Atlantic/Faroe">Faroe Adaları</option>
                                                    <option value="Atlantic/South_Georgia">Güney Georgia</option>
                                                    <option value="Atlantic/Canary">Kanarya</option>
                                                    <option value="Atlantic/Madeira">Madeira</option>
                                                    <option value="Atlantic/Reykjavik">Reykjavik</option>
                                                    <option value="Atlantic/Stanley">Stanley</option>
                                                    <option value="Atlantic/St_Helena">St Helena</option>
                                                    <option value="Atlantic/Cape_Verde">Yeşil Burun Adaları</option>
                                                </optgroup>
                                                <optgroup label="Avrupa">
                                                    <option value="Europe/Amsterdam">Amsterdam</option>
                                                    <option value="Europe/Andorra">Andorra</option>
                                                    <option value="Europe/Astrakhan">Astrakhan</option>
                                                    <option value="Europe/Athens">Atina</option>
                                                    <option value="Europe/Belgrade">Belgrad</option>
                                                    <option value="Europe/Berlin">Berlin</option>
                                                    <option value="Europe/Bratislava">Bratislava</option>
                                                    <option value="Europe/Brussels">Brüksel</option>
                                                    <option value="Europe/Budapest">Budapeşte</option>
                                                    <option value="Europe/Busingen">Busingen</option>
                                                    <option value="Europe/Bucharest">Bükreş</option>
                                                    <option value="Europe/Dublin">Dublin</option>
                                                    <option value="Europe/Gibraltar">Gibraltar</option>
                                                    <option value="Europe/Guernsey">Guernsey</option>
                                                    <option value="Europe/Helsinki">Helsinki</option>
                                                    <option value="Europe/Jersey">Jersey</option>
                                                    <option value="Europe/Kaliningrad">Kaliningrad</option>
                                                    <option value="Europe/Kyiv">Kiev</option>
                                                    <option value="Europe/Kirov">Kirov</option>
                                                    <option value="Europe/Chisinau">Kişinev</option>
                                                    <option value="Europe/Copenhagen">Kopenhag</option>
                                                    <option value="Europe/Lisbon">Lizbon</option>
                                                    <option value="Europe/Ljubljana">Ljubljana</option>
                                                    <option value="Europe/London">Londra</option>
                                                    <option value="Europe/Luxembourg">Lüksemburg</option>
                                                    <option value="Europe/Madrid">Madrid</option>
                                                    <option value="Europe/Malta">Malta</option>
                                                    <option value="Europe/Isle_of_Man">Man adası</option>
                                                    <option value="Europe/Mariehamn">Mariehamn</option>
                                                    <option value="Europe/Minsk">Minsk</option>
                                                    <option value="Europe/Monaco">Monako</option>
                                                    <option value="Europe/Moscow">Moskova</option>
                                                    <option value="Europe/Oslo">Oslo</option>
                                                    <option value="Europe/Paris">Paris</option>
                                                    <option value="Europe/Podgorica">Podgorica</option>
                                                    <option value="Europe/Prague">Prag</option>
                                                    <option value="Europe/Riga">Riga</option>
                                                    <option value="Europe/Rome">Roma</option>
                                                    <option value="Europe/Samara">Samara</option>
                                                    <option value="Europe/San_Marino">San Marino</option>
                                                    <option value="Europe/Saratov">Saratov</option>
                                                    <option value="Europe/Sarajevo">Saraybosna</option>
                                                    <option value="Europe/Simferopol">Simferopol</option>
                                                    <option value="Europe/Skopje">Skopje</option>
                                                    <option value="Europe/Sofia">Sofya</option>
                                                    <option value="Europe/Stockholm">Stokholm</option>
                                                    <option value="Europe/Tallinn">Tallinn</option>
                                                    <option value="Europe/Tirane">Tirane</option>
                                                    <option value="Europe/Ulyanovsk">Ulyanovsk</option>
                                                    <option value="Europe/Vaduz">Vaduz</option>
                                                    <option value="Europe/Warsaw">Varşova</option>
                                                    <option value="Europe/Vatican">Vatikan</option>
                                                    <option value="Europe/Vilnius">Vilnius</option>
                                                    <option value="Europe/Vienna">Viyana</option>
                                                    <option value="Europe/Volgograd">Volgograd</option>
                                                    <option value="Europe/Zagreb">Zagreb</option>
                                                    <option value="Europe/Zurich">Zürih</option>
                                                    <option value="Europe/Istanbul">İstanbul</option>
                                                </optgroup>
                                                <optgroup label="Avustralya">
                                                    <option value="Australia/Adelaide">Adelaide</option>
                                                    <option value="Australia/Brisbane">Brisbane</option>
                                                    <option value="Australia/Broken_Hill">Broken Hill</option>
                                                    <option value="Australia/Darwin">Darwin</option>
                                                    <option value="Australia/Eucla">Eucla</option>
                                                    <option value="Australia/Hobart">Hobart</option>
                                                    <option value="Australia/Lindeman">Lindeman</option>
                                                    <option value="Australia/Lord_Howe">Lord Howe</option>
                                                    <option value="Australia/Melbourne">Melbourne</option>
                                                    <option value="Australia/Perth">Perth</option>
                                                    <option value="Australia/Sydney">Sidney</option>
                                                </optgroup>
                                                <optgroup label="Hindistan">
                                                    <option value="Indian/Antananarivo">Antananarivo</option>
                                                    <option value="Indian/Christmas">Christmas</option>
                                                    <option value="Indian/Cocos">Cocos</option>
                                                    <option value="Indian/Comoro">Comoro</option>
                                                    <option value="Indian/Kerguelen">Kerguelen</option>
                                                    <option value="Indian/Mahe">Mahe</option>
                                                    <option value="Indian/Maldives">Maldivler</option>
                                                    <option value="Indian/Mauritius">Mauritius</option>
                                                    <option value="Indian/Mayotte">Mayotte</option>
                                                    <option value="Indian/Reunion">Reunion</option>
                                                    <option value="Indian/Chagos">Çagos</option>
                                                </optgroup>
                                                <optgroup label="Pasifik">
                                                    <option value="Pacific/Apia">Apia</option>
                                                    <option value="Pacific/Auckland">Auckland</option>
                                                    <option value="Pacific/Bougainville">Bougainville</option>
                                                    <option value="Pacific/Chatham">Chatham</option>
                                                    <option value="Pacific/Chuuk">Chuuk</option>
                                                    <option value="Pacific/Easter">Easter</option>
                                                    <option value="Pacific/Efate">Efate</option>
                                                    <option value="Pacific/Fakaofo">Fakaofo</option>
                                                    <option value="Pacific/Fiji">Fiji</option>
                                                    <option value="Pacific/Funafuti">Funafuti</option>
                                                    <option value="Pacific/Galapagos">Galapagos</option>
                                                    <option value="Pacific/Gambier">Gambier</option>
                                                    <option value="Pacific/Guadalcanal">Guadalcanal</option>
                                                    <option value="Pacific/Guam">Guam</option>
                                                    <option value="Pacific/Honolulu">Honolulu</option>
                                                    <option value="Pacific/Kanton">Kanton</option>
                                                    <option value="Pacific/Kiritimati">Kiritimati</option>
                                                    <option value="Pacific/Kosrae">Kosrae</option>
                                                    <option value="Pacific/Kwajalein">Kwajalein</option>
                                                    <option value="Pacific/Majuro">Majuro</option>
                                                    <option value="Pacific/Marquesas">Marquesas</option>
                                                    <option value="Pacific/Midway">Midway</option>
                                                    <option value="Pacific/Nauru">Nauru</option>
                                                    <option value="Pacific/Niue">Niue</option>
                                                    <option value="Pacific/Norfolk">Norfolk</option>
                                                    <option value="Pacific/Noumea">Noumea</option>
                                                    <option value="Pacific/Pago_Pago">Pago Pago</option>
                                                    <option value="Pacific/Palau">Palau</option>
                                                    <option value="Pacific/Pitcairn">Pitcairn</option>
                                                    <option value="Pacific/Pohnpei">Pohnpei</option>
                                                    <option value="Pacific/Port_Moresby">Port Moresby</option>
                                                    <option value="Pacific/Rarotonga">Rarotonga</option>
                                                    <option value="Pacific/Saipan">Saipan</option>
                                                    <option value="Pacific/Tahiti">Tahiti</option>
                                                    <option value="Pacific/Tarawa">Tarawa</option>
                                                    <option value="Pacific/Tongatapu">Tongatapu</option>
                                                    <option value="Pacific/Wake">Wake</option>
                                                    <option value="Pacific/Wallis">Wallis</option>
                                                </optgroup>
                                                <optgroup label="UTC">
                                                    <option value="UTC">UTC</option>
                                                </optgroup>
                                                <optgroup label="Manuel zaman farkları">
                                                    <option value="UTC-12">UTC-12</option>
                                                    <option value="UTC-11.5">UTC-11:30</option>
                                                    <option value="UTC-11">UTC-11</option>
                                                    <option value="UTC-10.5">UTC-10:30</option>
                                                    <option value="UTC-10">UTC-10</option>
                                                    <option value="UTC-9.5">UTC-9:30</option>
                                                    <option value="UTC-9">UTC-9</option>
                                                    <option value="UTC-8.5">UTC-8:30</option>
                                                    <option value="UTC-8">UTC-8</option>
                                                    <option value="UTC-7.5">UTC-7:30</option>
                                                    <option value="UTC-7">UTC-7</option>
                                                    <option value="UTC-6.5">UTC-6:30</option>
                                                    <option value="UTC-6">UTC-6</option>
                                                    <option value="UTC-5.5">UTC-5:30</option>
                                                    <option value="UTC-5">UTC-5</option>
                                                    <option value="UTC-4.5">UTC-4:30</option>
                                                    <option value="UTC-4">UTC-4</option>
                                                    <option value="UTC-3.5">UTC-3:30</option>
                                                    <option value="UTC-3">UTC-3</option>
                                                    <option value="UTC-2.5">UTC-2:30</option>
                                                    <option value="UTC-2">UTC-2</option>
                                                    <option value="UTC-1.5">UTC-1:30</option>
                                                    <option value="UTC-1">UTC-1</option>
                                                    <option value="UTC-0.5">UTC-0:30</option>
                                                    <option value="UTC+0">UTC+0</option>
                                                    <option value="UTC+0.5">UTC+0:30</option>
                                                    <option value="UTC+1">UTC+1</option>
                                                    <option value="UTC+1.5">UTC+1:30</option>
                                                    <option value="UTC+2">UTC+2</option>
                                                    <option value="UTC+2.5">UTC+2:30</option>
                                                    <option selected="selected" value="UTC+3">UTC+3</option>
                                                    <option value="UTC+3.5">UTC+3:30</option>
                                                    <option value="UTC+4">UTC+4</option>
                                                    <option value="UTC+4.5">UTC+4:30</option>
                                                    <option value="UTC+5">UTC+5</option>
                                                    <option value="UTC+5.5">UTC+5:30</option>
                                                    <option value="UTC+5.75">UTC+5:45</option>
                                                    <option value="UTC+6">UTC+6</option>
                                                    <option value="UTC+6.5">UTC+6:30</option>
                                                    <option value="UTC+7">UTC+7</option>
                                                    <option value="UTC+7.5">UTC+7:30</option>
                                                    <option value="UTC+8">UTC+8</option>
                                                    <option value="UTC+8.5">UTC+8:30</option>
                                                    <option value="UTC+8.75">UTC+8:45</option>
                                                    <option value="UTC+9">UTC+9</option>
                                                    <option value="UTC+9.5">UTC+9:30</option>
                                                    <option value="UTC+10">UTC+10</option>
                                                    <option value="UTC+10.5">UTC+10:30</option>
                                                    <option value="UTC+11">UTC+11</option>
                                                    <option value="UTC+11.5">UTC+11:30</option>
                                                    <option value="UTC+12">UTC+12</option>
                                                    <option value="UTC+12.75">UTC+12:45</option>
                                                    <option value="UTC+13">UTC+13</option>
                                                    <option value="UTC+13.75">UTC+13:45</option>
                                                    <option value="UTC+14">UTC+14</option>
                                                </optgroup>
                                            </select>
                                            <small>Kendi zaman diliminizde yer alan bir şehir ya da bir UTC zaman dilimi
                                                seçin.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label for="user-date-settings" class="col-md-4 fw-bold align-self-start">Tarih
                                            Formatı</label>
                                        <div id="user-date-settings" class="col-md-8">
                                            <div class="list-group list-group-flush">
                                                @foreach ($date_formats as $format)
                                                    <label class="list-group-item bg-white rounded-0 w-75">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div>
                                                                <input name="date"
                                                                    class="form-check-input me-1 rounded-0 shadow-none"
                                                                    type="radio" value="{{ $format }}">
                                                                {{ Carbon::now()->format($format) }}
                                                            </div>
                                                            <code>{{ $format }}</code>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="row">
                                        <label for="user-time-settings" class="col-md-4 fw-bold align-self-start">Saat
                                            Formatı</label>
                                        <div id="user-time-settings" class="col-md-8">
                                            <div class="list-group list-group-flush">
                                                @foreach ($time_formats as $format)
                                                    <label class="list-group-item bg-white rounded-0 w-75">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div>
                                                                <input name="time"
                                                                    class="form-check-input me-1 rounded-0 shadow-none"
                                                                    type="checkbox" value="{{ $format }}">
                                                                {{ Carbon::now()->format($format) }}
                                                            </div>
                                                            <code>{{ $format }}</code>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="offset-md-4 col-md-5">
                                            <button id="app-settings-save" type="button"
                                                class="btn add-btn btn-primary btn-sm rounded-0 shadow-none"><i
                                                    class="ri-add-line"></i> Kaydet</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
