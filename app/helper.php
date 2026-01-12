<?php

use App\Models\Banner;
use App\Models\Blog;
use App\Models\BusinessCategory;
use App\Models\BusinessCategoryDetail;
use Illuminate\Support\Str;
use App\Models\Event;
use App\Models\EventDetail;
use App\Models\Language;
use App\Models\Media;
use App\Models\Menu;
use App\Models\Page;
use App\Models\RegistrationPackage;
use App\Models\RegPageSetting;
use App\Models\RegPageSettingDetail;
use App\Models\SchoolQuickFactsFeature;
use App\Models\SchoolTeam;
use App\Models\Setting;
use App\Models\StaticTranslation;
use App\Models\StaticTranslationDetail;
use Cohensive\Embed\Facades\Embed;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

if (!function_exists('dateFormating')) {
    function dateFormating($date)
    {
        $dateString = $date; // Assuming you have the date in a different format

        // Parse the date string into a Unix timestamp
        $timestamp = strtotime($dateString);

        // Format the Unix timestamp in the desired format
        $formattedDate = date('M-d-Y', $timestamp);

        return $formattedDate; // Output: May-05-2023
    }
}

if (!function_exists('thumbnailImage')) {
    function thumbnailImage($image)
    {
        $array = explode('/', $image);
        if (isset($array[count($array) - 1])) {
            return '/images/thumbnail-' . $array[count($array) - 1];
        } else {
            return $image;
        }
        return Language::with('flagIcon')->get();
    }
}

if (!function_exists('largeImage')) {
    function largeImage($image)
    {
        $array = explode('/', $image);
        if (isset($array[count($array) - 1])) {
            return '/images/large-' . $array[count($array) - 1];
        } else {
            return $image;
        }
        return Language::with('flagIcon')->get();
    }
}

if (!function_exists('mediumImage')) {
    function mediumImage($image)
    {
        $array = explode('/', $image);
        if (isset($array[count($array) - 1])) {
            return '/images/medium-' . $array[count($array) - 1];
        } else {
            return $image;
        }
        return Language::with('flagIcon')->get();
    }
}

if (!function_exists('getAllLanguages')) {
    function getAllLanguages()
    {
        return Language::with('flagIcon')->get();
    }
}
if (!function_exists('langBasedURL')) {
    function langBasedURL($defaultLang, $url, $newLanguage = null)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(1);
        }

        if ($newLanguage) {
            $abbreviation = Language::whereId($newLanguage)->value('abbreviation');
            $temp = explode('/', $url);
            if (count($temp) == 3) {
                $url = str_replace(env('APP_URL'), env('APP_URL') . '/' . $abbreviation, $url);
            } else {
                $url = str_replace(env('APP_URL') . '/' . $defaultLang->abbreviation, env('APP_URL') . '/' . $abbreviation, $url);
            }
        } elseif (strpos($url, env('APP_URL')) !== false) {
            if (!str_contains($url, env('APP_URL') . '/' . $defaultLang->abbreviation)) {
                $url = str_replace(env('APP_URL'), env('APP_URL') . '/' . $defaultLang->abbreviation, $url);
                $url = url($url);
            }
        } else {
            if (!str_contains($url, env('APP_URL') . '/' . $defaultLang->abbreviation)) {
                $url = url($defaultLang->abbreviation . '/' . $url);
            } else {
                $url = $defaultLang->abbreviation . '/' . $url;
            }
        }
        return $url;
    }
}

if (!function_exists('getLangByCode')) {
    function getLangByCode($code)
    {
        $languageCodes = [
            ['code' => 'ab', 'name' => 'Abkhaz', 'nativeName' => 'аҧсуа'],
            ['code' => 'aa', 'name' => 'Afar', 'nativeName' => 'Afaraf'],
            ['code' => 'af', 'name' => 'Afrikaans', 'nativeName' => 'Afrikaans'],
            ['code' => 'ak', 'name' => 'Akan', 'nativeName' => 'Akan'],
            ['code' => 'sq', 'name' => 'Albanian', 'nativeName' => 'Shqip'],
            ['code' => 'am', 'name' => 'Amharic', 'nativeName' => 'አማርኛ'],
            ['code' => 'ar', 'name' => 'Arabic', 'nativeName' => 'العربية'],
            ['code' => 'an', 'name' => 'Aragonese', 'nativeName' => 'Aragonés'],
            ['code' => 'hy', 'name' => 'Armenian', 'nativeName' => 'Հայերեն'],
            ['code' => 'as', 'name' => 'Assamese', 'nativeName' => 'অসমীয়া'],
            ['code' => 'av', 'name' => 'Avaric', 'nativeName' => 'авар мацӀ'],
            ['code' => 'ae', 'name' => 'Avestan', 'nativeName' => 'avesta'],
            ['code' => 'ay', 'name' => 'Aymara', 'nativeName' => 'aymar aru'],
            ['code' => 'az', 'name' => 'Azerbaijani', 'nativeName' => 'azərbaycan dili'],
            ['code' => 'bm', 'name' => 'Bambara', 'nativeName' => 'bamanankan'],
            ['code' => 'ba', 'name' => 'Bashkir', 'nativeName' => 'башҡорт теле'],
            ['code' => 'eu', 'name' => 'Basque', 'nativeName' => 'euskara'],
            ['code' => 'be', 'name' => 'Belarusian', 'nativeName' => 'Беларуская'],
            ['code' => 'bn', 'name' => 'Bengali', 'nativeName' => 'বাংলা'],
            ['code' => 'bh', 'name' => 'Bihari', 'nativeName' => 'भोजपुरी'],
            ['code' => 'bi', 'name' => 'Bislama', 'nativeName' => 'Bislama'],
            ['code' => 'bs', 'name' => 'Bosnian', 'nativeName' => 'bosanski jezik'],
            ['code' => 'br', 'name' => 'Breton', 'nativeName' => 'brezhoneg'],
            ['code' => 'bg', 'name' => 'Bulgarian', 'nativeName' => 'български език'],
            ['code' => 'my', 'name' => 'Burmese', 'nativeName' => 'ဗမာစာ'],
            ['code' => 'ca', 'name' => 'Catalan; Valencian', 'nativeName' => 'Català'],
            ['code' => 'ch', 'name' => 'Chamorro', 'nativeName' => 'Chamoru'],
            ['code' => 'ce', 'name' => 'Chechen', 'nativeName' => 'нохчийн мотт'],
            ['code' => 'ny', 'name' => 'Chichewa', 'nativeName' => 'chiCheŵa'],
            ['code' => 'zh', 'name' => 'Chinese', 'nativeName' => '中文'],
            ['code' => 'cv', 'name' => 'Chuvash', 'nativeName' => 'чӑваш чӗлхи'],
            ['code' => 'kw', 'name' => 'Cornish', 'nativeName' => 'Kernewek'],
            ['code' => 'co', 'name' => 'Corsican', 'nativeName' => 'corsu'],
            ['code' => 'cr', 'name' => 'Cree', 'nativeName' => 'ᓀᐦᐃᔭᐍᐏᐣ'],
            ['code' => 'hr', 'name' => 'Croatian', 'nativeName' => 'hrvatski'],
            ['code' => 'cs', 'name' => 'Czech', 'nativeName' => 'česky'],
            ['code' => 'da', 'name' => 'Danish', 'nativeName' => 'dansk'],
            ['code' => 'dv', 'name' => 'Divehi', 'nativeName' => 'ދިވެހި'],
            ['code' => 'nl', 'name' => 'Dutch', 'nativeName' => 'Nederlands'],
            ['code' => 'en', 'name' => 'English', 'nativeName' => 'English'],
            ['code' => 'eo', 'name' => 'Esperanto', 'nativeName' => 'Esperanto'],
            ['code' => 'et', 'name' => 'Estonian', 'nativeName' => 'eesti'],
            ['code' => 'ee', 'name' => 'Ewe', 'nativeName' => 'Eʋegbe'],
            ['code' => 'fo', 'name' => 'Faroese', 'nativeName' => 'føroyskt'],
            ['code' => 'fj', 'name' => 'Fijian', 'nativeName' => 'vosa Vakaviti'],
            ['code' => 'fi', 'name' => 'Finnish', 'nativeName' => 'suomi'],
            ['code' => 'fr', 'name' => 'French', 'nativeName' => 'français'],
            ['code' => 'ff', 'name' => 'Fulfulde', 'nativeName' => 'Fulfulde'],
            ['code' => 'gl', 'name' => 'Galician', 'nativeName' => 'Galego'],
            ['code' => 'ka', 'name' => 'Georgian', 'nativeName' => 'ქართული'],
            ['code' => 'de', 'name' => 'German', 'nativeName' => 'Deutsch'],
            ['code' => 'el', 'name' => 'Greek, Modern', 'nativeName' => 'Ελληνικά'],
            ['code' => 'gn', 'name' => 'Guaraní', 'nativeName' => 'Avañeẽ'],
            ['code' => 'gu', 'name' => 'Gujarati', 'nativeName' => 'ગુજરાતી'],
            ['code' => 'ht', 'name' => 'Haitian', 'nativeName' => 'Kreyòl ayisyen'],
            ['code' => 'ha', 'name' => 'Hausa', 'nativeName' => 'Hausa, هَوُسَ'],
            ['code' => 'he', 'name' => 'Hebrew (modern)', 'nativeName' => 'עברית'],
            ['code' => 'hz', 'name' => 'Herero', 'nativeName' => 'Otjiherero'],
            ['code' => 'hi', 'name' => 'Hindi', 'nativeName' => 'हिन्दी, हिंदी'],
            ['code' => 'ho', 'name' => 'Hiri Motu', 'nativeName' => 'Hiri Motu'],
            ['code' => 'hu', 'name' => 'Hungarian', 'nativeName' => 'Magyar'],
            ['code' => 'ia', 'name' => 'Interlingua', 'nativeName' => 'Interlingua'],
            ['code' => 'id', 'name' => 'Indonesian', 'nativeName' => 'Bahasa Indonesia'],
            ['code' => 'ga', 'name' => 'Irish', 'nativeName' => 'Gaeilge'],
            ['code' => 'ig', 'name' => 'Igbo', 'nativeName' => 'Asụsụ Igbo'],
            ['code' => 'ik', 'name' => 'Inupiaq', 'nativeName' => 'Iñupiaq'],
            ['code' => 'io', 'name' => 'Ido', 'nativeName' => 'Ido'],
            ['code' => 'is', 'name' => 'Icelandic', 'nativeName' => 'Íslenska'],
            ['code' => 'it', 'name' => 'Italian', 'nativeName' => 'Italiano'],
            ['code' => 'iu', 'name' => 'Inuktitut', 'nativeName' => 'ᐃᓄᒃᑎᑐᑦ'],
            ['code' => 'ja', 'name' => 'Japanese', 'nativeName' => '日本語'],
            ['code' => 'jv', 'name' => 'Javanese', 'nativeName' => 'basa Jawa'],
            ['code' => 'kl', 'name' => 'Kalaallisut', 'nativeName' => 'kalaallisut'],
            ['code' => 'kn', 'name' => 'Kannada', 'nativeName' => 'ಕನ್ನಡ'],
            ['code' => 'kr', 'name' => 'Kanuri', 'nativeName' => 'Kanuri'],
            ['code' => 'ks', 'name' => 'Kashmiri', 'nativeName' => 'कश्मीरी, كشميري'],
            ['code' => 'kk', 'name' => 'Kazakh', 'nativeName' => 'Қазақ тілі'],
            ['code' => 'km', 'name' => 'Khmer', 'nativeName' => 'ភាសាខ្មែរ'],
            ['code' => 'ki', 'name' => 'Kikuyu', 'nativeName' => 'Gĩkũyũ'],
            ['code' => 'rw', 'name' => 'Kinyarwanda', 'nativeName' => 'Ikinyarwanda'],
            ['code' => 'ky', 'name' => 'Kirghiz', 'nativeName' => 'кыргыз тили'],
            ['code' => 'kv', 'name' => 'Komi', 'nativeName' => 'коми кыв'],
            ['code' => 'kg', 'name' => 'Kongo', 'nativeName' => 'KiKongo'],
            ['code' => 'ko', 'name' => 'Korean', 'nativeName' => '한국어'],
            ['code' => 'ku', 'name' => 'Kurdish', 'nativeName' => 'Kurdî, كوردی'],
            ['code' => 'kj', 'name' => 'Kwanyama', 'nativeName' => 'Kuanyama'],
            ['code' => 'la', 'name' => 'Latin', 'nativeName' => 'latine'],
            ['code' => 'lb', 'name' => 'Luxembourgish', 'nativeName' => 'Lëtzebuergesch'],
            ['code' => 'lg', 'name' => 'Luganda', 'nativeName' => 'Luganda'],
            ['code' => 'li', 'name' => 'Limburgish', 'nativeName' => 'Limburgs'],
            ['code' => 'ln', 'name' => 'Lingala', 'nativeName' => 'Lingála'],
            ['code' => 'lo', 'name' => 'Lao', 'nativeName' => 'ພາສາລາວ'],
            ['code' => 'lt', 'name' => 'Lithuanian', 'nativeName' => 'lietuvių kalba'],
            ['code' => 'lu', 'name' => 'Luba-Katanga', 'nativeName' => ''],
            ['code' => 'lv', 'name' => 'Latvian', 'nativeName' => 'latviešu valoda'],
            ['code' => 'gv', 'name' => 'Manx', 'nativeName' => 'Gaelg, Gailck'],
            ['code' => 'mk', 'name' => 'Macedonian', 'nativeName' => 'македонски јазик'],
            ['code' => 'mg', 'name' => 'Malagasy', 'nativeName' => 'Malagasy fiteny'],
            ['code' => 'ms', 'name' => 'Malay', 'nativeName' => 'بهاس ملايو'],
            ['code' => 'ml', 'name' => 'Malayalam', 'nativeName' => 'മലയാളം'],
            ['code' => 'mt', 'name' => 'Maltese', 'nativeName' => 'Malti'],
            ['code' => 'mi', 'name' => 'Māori', 'nativeName' => 'te reo Māori'],
            ['code' => 'mr', 'name' => 'Marathi (Marāṭhī)', 'nativeName' => 'मराठी'],
            ['code' => 'mh', 'name' => 'Marshallese', 'nativeName' => 'Kajin M̧ajeļ'],
            ['code' => 'mn', 'name' => 'Mongolian', 'nativeName' => 'монгол'],
            ['code' => 'na', 'name' => 'Nauru', 'nativeName' => 'Ekakairũ Naoero'],
            ['code' => 'nv', 'name' => 'Navajo', 'nativeName' => 'Diné bizaad'],
            ['code' => 'nb', 'name' => 'Norwegian Bokmål', 'nativeName' => 'Norsk bokmål'],
            ['code' => 'nd', 'name' => 'North Ndebele', 'nativeName' => 'isiNdebele'],
            ['code' => 'ne', 'name' => 'Nepali', 'nativeName' => 'नेपाली'],
            ['code' => 'ng', 'name' => 'Ndonga', 'nativeName' => 'Owambo'],
            ['code' => 'nn', 'name' => 'Norwegian Nynorsk', 'nativeName' => 'Norsk nynorsk'],
            ['code' => 'no', 'name' => 'Norwegian', 'nativeName' => 'Norsk'],
            ['code' => 'ii', 'name' => 'Nuosu', 'nativeName' => 'ꆈꌠ꒿ Nuosuhxop'],
            ['code' => 'nr', 'name' => 'South Ndebele', 'nativeName' => 'isiNdebele'],
            ['code' => 'oc', 'name' => 'Occitan', 'nativeName' => 'Occitan'],
            ['code' => 'oj', 'name' => 'Ojibwe', 'nativeName' => 'ᐊᓂᔑᓈᐯᒧᐎᓐ'],
            ['code' => 'om', 'name' => 'Oromo', 'nativeName' => 'Afaan Oromoo'],
            ['code' => 'or', 'name' => 'Oriya', 'nativeName' => 'ଓଡ଼ିଆ'],
            ['code' => 'os', 'name' => 'Ossetian, Ossetic', 'nativeName' => 'ирон æвзаг'],
            ['code' => 'pa', 'name' => 'Panjabi, Punjabi', 'nativeName' => 'پنجابی'],
            ['code' => 'pi', 'name' => 'Pāli', 'nativeName' => 'पाऴि'],
            ['code' => 'fa', 'name' => 'Persian', 'nativeName' => 'فارسی'],
            ['code' => 'pl', 'name' => 'Polish', 'nativeName' => 'polski'],
            ['code' => 'ps', 'name' => 'Pashto, Pushto', 'nativeName' => 'پښتو'],
            ['code' => 'pt', 'name' => 'Portuguese', 'nativeName' => 'Português'],
            ['code' => 'qu', 'name' => 'Quechua', 'nativeName' => 'Kichwa'],
            ['code' => 'rm', 'name' => 'Romansh', 'nativeName' => 'rumantsch grischun'],
            ['code' => 'rn', 'name' => 'Kirundi', 'nativeName' => 'kiRundi'],
            ['code' => 'ro', 'name' => 'Romanian', 'nativeName' => 'română'],
            ['code' => 'ru', 'name' => 'Russian', 'nativeName' => 'русский язык'],
            ['code' => 'sa', 'name' => 'Sanskrit', 'nativeName' => 'संस्कृतम्'],
            ['code' => 'sc', 'name' => 'Sardinian', 'nativeName' => 'sardu'],
            ['code' => 'sd', 'name' => 'Sindhi', 'nativeName' => 'سنڌي'],
            ['code' => 'se', 'name' => 'Northern Sami', 'nativeName' => 'Davvisámegiella'],
            ['code' => 'sm', 'name' => 'Samoan', 'nativeName' => 'gagana faa Samoa'],
            ['code' => 'sg', 'name' => 'Sango', 'nativeName' => 'yângâ tî sängö'],
            ['code' => 'sr', 'name' => 'Serbian', 'nativeName' => 'српски језик'],
            ['code' => 'gd', 'name' => 'Scottish Gaelic', 'nativeName' => 'Gàidhlig'],
            ['code' => 'sn', 'name' => 'Shona', 'nativeName' => 'chiShona'],
            ['code' => 'si', 'name' => 'Sinhala, Sinhalese', 'nativeName' => 'සිංහල'],
            ['code' => 'sk', 'name' => 'Slovak', 'nativeName' => 'slovenčina'],
            ['code' => 'sl', 'name' => 'Slovene', 'nativeName' => 'slovenščina'],
            ['code' => 'so', 'name' => 'Somali', 'nativeName' => 'Soomaaliga'],
            ['code' => 'st', 'name' => 'Southern Sotho', 'nativeName' => 'Sesotho'],
            ['code' => 'es', 'name' => 'Spanish; Castilian', 'nativeName' => 'español'],
            ['code' => 'su', 'name' => 'Sundanese', 'nativeName' => 'Basa Sunda'],
            ['code' => 'sw', 'name' => 'Swahili', 'nativeName' => 'Kiswahili'],
            ['code' => 'ss', 'name' => 'Swati', 'nativeName' => 'SiSwati'],
            ['code' => 'sv', 'name' => 'Swedish', 'nativeName' => 'svenska'],
            ['code' => 'ta', 'name' => 'Tamil', 'nativeName' => 'தமிழ்'],
            ['code' => 'te', 'name' => 'Telugu', 'nativeName' => 'తెలుగు'],
            ['code' => 'tg', 'name' => 'Tajik', 'nativeName' => 'тоҷикӣ'],
            ['code' => 'th', 'name' => 'Thai', 'nativeName' => 'ไทย'],
            ['code' => 'ti', 'name' => 'Tigrinya', 'nativeName' => 'ትግርኛ'],
            ['code' => 'bo', 'name' => 'Tibetan Standard, Tibetan, Central', 'nativeName' => 'བོད་ཡིག'],
            ['code' => 'tk', 'name' => 'Turkmen', 'nativeName' => 'Türkmen, Түркмен'],
            ['code' => 'tl', 'name' => 'Tagalog', 'nativeName' => 'Wikang Tagalog'],
            ['code' => 'tn', 'name' => 'Tswana', 'nativeName' => 'Setswana'],
            ['code' => 'to', 'name' => 'Tonga (Tonga Islands)', 'nativeName' => 'faka Tonga'],
            ['code' => 'tr', 'name' => 'Turkish', 'nativeName' => 'Türkçe'],
            ['code' => 'ts', 'name' => 'Tsonga', 'nativeName' => 'Xitsonga'],
            ['code' => 'tt', 'name' => 'Tatar', 'nativeName' => 'татар теле'],
            ['code' => 'tw', 'name' => 'Twi', 'nativeName' => 'Twi'],
            ['code' => 'ty', 'name' => 'Tahitian', 'nativeName' => 'Reo Tahiti'],
            ['code' => 'ug', 'name' => 'Uighur, Uyghur', 'nativeName' => 'Uyghurche'],
            ['code' => 'uk', 'name' => 'Ukrainian', 'nativeName' => 'українська'],
            ['code' => 'ur', 'name' => 'Urdu', 'nativeName' => 'اردو'],
            ['code' => 'uz', 'name' => 'Uzbek', 'nativeName' => "O'zbek, Ўзбек, أۇزبېك‎"],
            ['code' => 've', 'name' => 'Venda', 'nativeName' => 'Tshivenḓa'],
            ['code' => 'vi', 'name' => 'Vietnamese', 'nativeName' => 'Tiếng Việt'],
            ['code' => 'vo', 'name' => 'Volapük', 'nativeName' => 'Volapük'],
            ['code' => 'wa', 'name' => 'Walloon', 'nativeName' => 'Walon'],
            ['code' => 'cy', 'name' => 'Welsh', 'nativeName' => 'Cymraeg'],
            ['code' => 'wo', 'name' => 'Wolof', 'nativeName' => 'Wollof'],
            ['code' => 'fy', 'name' => 'Western Frisian', 'nativeName' => 'Frysk'],
            ['code' => 'xh', 'name' => 'Xhosa', 'nativeName' => 'isiXhosa'],
            ['code' => 'yi', 'name' => 'Yiddish', 'nativeName' => 'ייִדיש'],
            ['code' => 'yo', 'name' => 'Yoruba', 'nativeName' => 'Yorùbá'],
            ['code' => 'za', 'name' => 'Zhuang, Chuang', 'nativeName' => 'Saɯ cueŋƅ, Saw cuengh'],
            ['code' => 'zu', 'name' => 'Zulu', 'nativeName' => 'isiZulu'],
        ];
        foreach ($languageCodes as $languageCode) {
            if ($languageCode['code'] == $code) {
                return $languageCode['name'];
            }
        }
        return $code;
    }
}

if (!function_exists('getDefaultLanguage')) {
    function getDefaultLanguage($isWeb = false)
    {
        $lang = '';
        $webLanguage = Session::get('webLanguage');
        if ($isWeb && isset($webLanguage) && !empty($webLanguage)) {
            $lang = Language::where('id', $webLanguage)->first();
        } else {
            $lang = Language::whereIsDefault(1)->first();
        }

        return $lang ? $lang : Language::first();
    }
}

if (!function_exists('getPageSlug')) {
    function getPageSlug($template)
    {
        $page = Page::query();
        if ($template != '') {
            $page = $page->whereTemplate($template);
        }
        $slug = $page->get()->value('slug');
        return $slug != null ? $slug : '';
    }
}

if (!function_exists("getTopMenu")) {
    function getTopMenu($defaultLang)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(1);
        }
        $menu = Menu::where('is_top_menu', '1')->with(['menuDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);

        return $menu->first();
    }
}

if (!function_exists("getStaticTranslationByKey")) {
    function getStaticTranslationByKey($defaultLang = null, $type = null, $keys = [])
    {

        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(true);
        }

        $staticTranslation = StaticTranslation::where('type', $type)->pluck('id');

        $staticTranslationDetail = StaticTranslationDetail::whereIn('static_translation_id', $staticTranslation)->whereIn('key', $keys)->whereLanguageId($defaultLang->id)->pluck('value', 'key');

        return $staticTranslationDetail;
    }
}

if (!function_exists("getMainMenu")) {
    function getMainMenu($defaultLang)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(1);
        }
        $menu = Menu::where('is_main_menu', '1')->with(['menuDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);

        return $menu->first();
    }
}

if (!function_exists('createSlug')) {
    function createSlug($string)
    {
        // Convert the string to lowercase
        $string = strtolower($string);

        // Remove spaces and special characters (except for hyphens and underscores)
        $string = preg_replace('/[^a-z0-9-_]+/', '-', $string);

        // Remove any leading or trailing hyphens
        $string = trim($string, '-');

        // Replace multiple consecutive hyphens with a single hyphen
        $string = preg_replace('/-+/', '-', $string);

        return $string;
    }
}

if (!function_exists('upload')) {
    function upload($file, $type)
    {
        if (isset($file)) {
            $fileName = preg_replace('/\s+/', '_', time() . ' ' . $file->getClientOriginalName());
            $path = $type . '/' . time() . '/' . $fileName;
            if (!file_exists($type . '/' . time())) {
                mkdir($type . '/' . time(), 0777);
            }
            if ($file->move($type . '/' . time(), $fileName)) {
                $media = Media::create([
                    'path' => $path,
                    'type' => 'customer_registration',
                    'extension' => pathinfo($path, PATHINFO_EXTENSION),
                ]);
                return $media->id;
            }
        }
        return null;
    }
}

if (!function_exists('getRegistrationPackage')) {
    function getRegistrationPackage($packageId)
    {
        return RegistrationPackage::whereId($packageId)->first();
    }
}

if (!function_exists('getVideoHtmlAttribute')) {
    function getVideoHtmlAttribute($url = null)
    {
        if (isset($url)) {
            $iframeUrl = isset($url) ? $url : '';

            // Remove 'www.' if present at the start
            $iframeUrl = preg_replace("/^https?:\/\/www\./", "https://", $iframeUrl);
            $iframeUrl = preg_replace("/^www\./", "", $iframeUrl);

            // Convert 'http' to 'https'
            $iframeUrl = str_replace("http://", "https://", $iframeUrl);

            // Add 'https://' if it's missing
            if (!preg_match("/^https?:\/\//", $iframeUrl)) {
                $iframeUrl = "https://" . $iframeUrl;
            }
            $embed = Embed::make($iframeUrl)->parseUrl();

            if (!$embed) {
                return '';
            }

            $embed->setAttribute(['width' => '100%', 'height' => 315]);
            return $embed->getHtml();
        } else {
            return null;
        }
    }
}

if (!function_exists('getAllBusinessCategories')) {
    function getAllBusinessCategories()
    {
        $defaultLang = getDefaultLanguage(true);
        $businessCategories = BusinessCategory::addSelect([
            'category_name' => BusinessCategoryDetail::whereColumn('business_category_id', 'business_categories.id')
                ->where('business_category_detail.language_id', $defaultLang->id)
                ->select('name'),
        ])
            ->orderBy('category_name', 'asc')
            ->get();
        return $businessCategories;
    }
}

if (!function_exists('getRegPageSetting')) {
    function getRegPageSetting()
    {
        $defaultLang = getDefaultLanguage(true);
        $regPageSetting = RegPageSetting::with([
            'regPageSettingDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ])->first();
        return $regPageSetting;
    }
}

if (!function_exists('getSignleGeneralSettingByKey')) {
    function getSignleGeneralSettingByKey($keys = [])
    {
        return Setting::whereIn('key', $keys)->pluck('value', 'key');
    }
}

if (!function_exists('getMarkedQuickFactFeaturesById')) {
    function getMarkedQuickFactFeaturesById($school_quick_fact_id)
    {
        return SchoolQuickFactsFeature::where('school_quick_fact_id', $school_quick_fact_id)->where('is_featured', '1')->orderByRaw('CAST(sorting_order AS SIGNED) ASC')->get();
    }
}

if (!function_exists('getBlogNewsBySchoolId')) {
    function getBlogNewsBySchoolId($schoolId, $limit = 2, $order = 'latest', $defaultLang = null)
    {
        if (!isset($defaultLang)) {
            $defaultLang = getDefaultLanguage(true);
        }
        $blog = Blog::with(['blogDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->where('school_id', $schoolId)->limit($limit);
        if ($order == 'latest') {
            $blog = $blog->latest();
        } else {
            $blog = $blog->inRandomOrder();
        }
        return $blog = $blog->get();
    }
}

if (!function_exists('getTeamMembersBySchoolId')) {
    function getTeamMembersBySchoolId($schoolId)
    {
        $members = SchoolTeam::where('school_id', $schoolId);

        return $members = $members->get();
    }
}

if (!function_exists('getGeneralTranslation')) {
    function getGeneralTranslation()
    {
        $defaultLang = getDefaultLanguage(true);
        $staticTranslation = StaticTranslation::where('type', 'general')->pluck('id');
        $staticTranslationDetail = StaticTranslationDetail::whereIn('static_translation_id', $staticTranslation)
            ->whereLanguageId($defaultLang->id)
            ->pluck('value', 'key');
        return $staticTranslationDetail;
    }
}

if (!function_exists('getStaticTranslation')) {
    function getStaticTranslation($type)
    {
        $defaultLang = getDefaultLanguage(true);
        $staticTranslation = StaticTranslation::where('type', $type)->pluck('id');
        $staticTranslationDetail = StaticTranslationDetail::whereIn('static_translation_id', $staticTranslation)
            ->whereLanguageId($defaultLang->id)
            ->pluck('value', 'key');
        return $staticTranslationDetail;
    }
}

if (!function_exists('getRawLanguages')) {
    function getRawLanguages()
    {
        $languageCodes = [
            ['code' => 'ab', 'name' => 'Abkhaz', 's' => 'аҧсуа'],
            ['code' => 'aa', 'name' => 'Afar', 's' => 'Afaraf'],
            ['code' => 'af', 'name' => 'Afrikaans', 's' => 'Afrikaans'],
            ['code' => 'ak', 'name' => 'Akan', 's' => 'Akan'],
            ['code' => 'sq', 'name' => 'Albanian', 's' => 'Shqip'],
            ['code' => 'am', 'name' => 'Amharic', 's' => 'አማርኛ'],
            ['code' => 'ar', 'name' => 'Arabic', 's' => 'العربية'],
            ['code' => 'an', 'name' => 'Aragonese', 's' => 'Aragonés'],
            ['code' => 'hy', 'name' => 'Armenian', 's' => 'Հայերեն'],
            ['code' => 'as', 'name' => 'Assamese', 's' => 'অসমীয়া'],
            ['code' => 'av', 'name' => 'Avaric', 's' => 'авар мацӀ'],
            ['code' => 'ae', 'name' => 'Avestan', 's' => 'avesta'],
            ['code' => 'ay', 'name' => 'Aymara', 's' => 'aymar aru'],
            [
                'code' => 'az',
                'name' => 'Azerbaijani',
                's' => 'azərbaycan dili',
            ],
            ['code' => 'bm', 'name' => 'Bambara', 's' => 'bamanankan'],
            ['code' => 'ba', 'name' => 'Bashkir', 's' => 'башҡорт теле'],
            ['code' => 'eu', 'name' => 'Basque', 's' => 'euskara'],
            ['code' => 'be', 'name' => 'Belarusian', 's' => 'Беларуская'],
            ['code' => 'bn', 'name' => 'Bengali', 's' => 'বাংলা'],
            ['code' => 'bh', 'name' => 'Bihari', 's' => 'भोजपुरी'],
            ['code' => 'bi', 'name' => 'Bislama', 's' => 'Bislama'],
            ['code' => 'bs', 'name' => 'Bosnian', 's' => 'bosanski jezik'],
            ['code' => 'br', 'name' => 'Breton', 's' => 'brezhoneg'],
            ['code' => 'bg', 'name' => 'Bulgarian', 's' => 'български език'],
            ['code' => 'my', 'name' => 'Burmese', 's' => 'ဗမာစာ'],
            [
                'code' => 'ca',
                'name' => 'Catalan; Valencian',
                's' => 'Català',
            ],
            ['code' => 'ch', 'name' => 'Chamorro', 's' => 'Chamoru'],
            ['code' => 'ce', 'name' => 'Chechen', 's' => 'нохчийн мотт'],
            ['code' => 'ny', 'name' => 'Chichewa', 's' => 'chiCheŵa'],
            ['code' => 'zh', 'name' => 'Chinese', 's' => '中文'],
            ['code' => 'cv', 'name' => 'Chuvash', 's' => 'чӑваш чӗлхи'],
            ['code' => 'kw', 'name' => 'Cornish', 's' => 'Kernewek'],
            ['code' => 'co', 'name' => 'Corsican', 's' => 'corsu'],
            ['code' => 'cr', 'name' => 'Cree', 's' => 'ᓀᐦᐃᔭᐍᐏᐣ'],
            ['code' => 'hr', 'name' => 'Croatian', 's' => 'hrvatski'],
            ['code' => 'cs', 'name' => 'Czech', 's' => 'česky'],
            ['code' => 'da', 'name' => 'Danish', 's' => 'dansk'],
            ['code' => 'dv', 'name' => 'Divehi', 's' => 'ދިވެހި'],
            ['code' => 'nl', 'name' => 'Dutch', 's' => 'Nederlands'],
            ['code' => 'en', 'name' => 'English', 's' => 'English'],
            ['code' => 'eo', 'name' => 'Esperanto', 's' => 'Esperanto'],
            ['code' => 'et', 'name' => 'Estonian', 's' => 'eesti'],
            ['code' => 'ee', 'name' => 'Ewe', 's' => 'Eʋegbe'],
            ['code' => 'fo', 'name' => 'Faroese', 's' => 'føroyskt'],
            ['code' => 'fj', 'name' => 'Fijian', 's' => 'vosa Vakaviti'],
            ['code' => 'fi', 'name' => 'Finnish', 's' => 'suomi'],
            ['code' => 'fr', 'name' => 'French', 's' => 'français'],
            ['code' => 'ff', 'name' => 'Fula', 's' => 'Fulfulde'],
            ['code' => 'gl', 'name' => 'Galician', 's' => 'Galego'],
            ['code' => 'ka', 'name' => 'Georgian', 's' => 'ქართული'],
            ['code' => 'de', 'name' => 'German', 's' => 'Deutsch'],
            ['code' => 'el', 'name' => 'Greek, Modern', 's' => 'Ελληνικά'],
            ['code' => 'gn', 'name' => 'Guaraní', 's' => 'Avañeẽ'],
            ['code' => 'gu', 'name' => 'Gujarati', 's' => 'ગુજરાતી'],
            ['code' => 'ht', 'name' => 'Haitian', 's' => 'Kreyòl ayisyen'],
            ['code' => 'ha', 'name' => 'Hausa', 's' => 'Hausa, هَوُسَ'],
            ['code' => 'he', 'name' => 'Hebrew (modern)', 's' => 'עברית'],
            ['code' => 'hz', 'name' => 'Herero', 's' => 'Otjiherero'],
            ['code' => 'hi', 'name' => 'Hindi', 's' => 'हिन्दी, हिंदी'],
            ['code' => 'ho', 'name' => 'Hiri Motu', 's' => 'Hiri Motu'],
            ['code' => 'hu', 'name' => 'Hungarian', 's' => 'Magyar'],
            ['code' => 'ia', 'name' => 'Interlingua', 's' => 'Interlingua'],
            [
                'code' => 'id',
                'name' => 'Indonesian',
                's' => 'Bahasa Indonesia',
            ],
            ['code' => 'ga', 'name' => 'Irish', 's' => 'Gaeilge'],
            ['code' => 'ig', 'name' => 'Igbo', 's' => 'Asụsụ Igbo'],
            ['code' => 'ik', 'name' => 'Inupiaq', 's' => 'Iñupiaq'],
            ['code' => 'io', 'name' => 'Ido', 's' => 'Ido'],
            ['code' => 'is', 'name' => 'Icelandic', 's' => 'Íslenska'],
            ['code' => 'it', 'name' => 'Italian', 's' => 'Italiano'],
            ['code' => 'iu', 'name' => 'Inuktitut', 's' => 'ᐃᓄᒃᑎᑐᑦ'],
            ['code' => 'ja', 'name' => 'Japanese', 's' => '日本語'],
            ['code' => 'jv', 'name' => 'Javanese', 's' => 'basa Jawa'],
            ['code' => 'kl', 'name' => 'Kalaallisut', 's' => 'kalaallisut'],
            ['code' => 'kn', 'name' => 'Kannada', 's' => 'ಕನ್ನಡ'],
            ['code' => 'kr', 'name' => 'Kanuri', 's' => 'Kanuri'],
            ['code' => 'ks', 'name' => 'Kashmiri', 's' => 'कश्मीरी, كشميري'],
            ['code' => 'kk', 'name' => 'Kazakh', 's' => 'Қазақ тілі'],
            ['code' => 'km', 'name' => 'Khmer', 's' => 'ភាសាខ្មែរ'],
            ['code' => 'ki', 'name' => 'Kikuyu', 's' => 'Gĩkũyũ'],
            ['code' => 'rw', 'name' => 'Kinyarwanda', 's' => 'Ikinyarwanda'],
            ['code' => 'ky', 'name' => 'Kirghiz', 's' => 'кыргыз тили'],
            ['code' => 'kv', 'name' => 'Komi', 's' => 'коми кыв'],
            ['code' => 'kg', 'name' => 'Kongo', 's' => 'KiKongo'],
            ['code' => 'ko', 'name' => 'Korean', 's' => '한국어'],
            ['code' => 'ku', 'name' => 'Kurdish', 's' => 'Kurdî, كوردی'],
            ['code' => 'kj', 'name' => 'Kwanyama', 's' => 'Kuanyama'],
            ['code' => 'la', 'name' => 'Latin', 's' => 'latine'],
            [
                'code' => 'lb',
                'name' => 'Luxembourgish',
                's' => 'Lëtzebuergesch',
            ],
            ['code' => 'lg', 'name' => 'Luganda', 's' => 'Luganda'],
            ['code' => 'li', 'name' => 'Limburgish', 's' => 'Limburgs'],
            ['code' => 'ln', 'name' => 'Lingala', 's' => 'Lingála'],
            ['code' => 'lo', 'name' => 'Lao', 's' => 'ພາສາລາວ'],
            [
                'code' => 'lt',
                'name' => 'Lithuanian',
                's' => 'lietuvių kalba',
            ],
            ['code' => 'lu', 'name' => 'Luba-Katanga', 's' => ''],
            ['code' => 'lv', 'name' => 'Latvian', 's' => 'latviešu valoda'],
            ['code' => 'gv', 'name' => 'Manx', 's' => 'Gaelg, Gailck'],
            [
                'code' => 'mk',
                'name' => 'Macedonian',
                's' => 'македонски јазик',
            ],
            ['code' => 'mg', 'name' => 'Malagasy', 's' => 'Malagasy fiteny'],
            ['code' => 'ms', 'name' => 'Malay', 's' => 'بهاس ملايو'],
            ['code' => 'ml', 'name' => 'Malayalam', 's' => 'മലയാളം'],
            ['code' => 'mt', 'name' => 'Maltese', 's' => 'Malti'],
            ['code' => 'mi', 'name' => 'Māori', 's' => 'te reo Māori'],
            ['code' => 'mr', 'name' => 'Marathi (Marāṭhī)', 's' => 'मराठी'],
            ['code' => 'mh', 'name' => 'Marshallese', 's' => 'Kajin M̧ajeļ'],
            ['code' => 'mn', 'name' => 'Mongolian', 's' => 'монгол'],
            ['code' => 'na', 'name' => 'Nauru', 's' => 'Ekakairũ Naoero'],
            ['code' => 'nv', 'name' => 'Navajo', 's' => 'Diné bizaad'],
            [
                'code' => 'nb',
                'name' => 'Norwegian Bokmål',
                's' => 'Norsk bokmål',
            ],
            ['code' => 'nd', 'name' => 'North Ndebele', 's' => 'isiNdebele'],
            ['code' => 'ne', 'name' => 'Nepali', 's' => 'नेपाली'],
            ['code' => 'ng', 'name' => 'Ndonga', 's' => 'Owambo'],
            [
                'code' => 'nn',
                'name' => 'Norwegian Nynorsk',
                's' => 'Norsk nynorsk',
            ],
            ['code' => 'no', 'name' => 'Norwegian', 's' => 'Norsk'],
            ['code' => 'ii', 'name' => 'Nuosu', 's' => 'ꆈꌠ꒿ Nuosuhxop'],
            ['code' => 'nr', 'name' => 'South Ndebele', 's' => 'isiNdebele'],
            ['code' => 'oc', 'name' => 'Occitan', 's' => 'Occitan'],
            ['code' => 'oj', 'name' => 'Ojibwe', 's' => 'ᐊᓂᔑᓈᐯᒧᐎᓐ'],
            ['code' => 'om', 'name' => 'Oromo', 's' => 'Afaan Oromoo'],
            ['code' => 'or', 'name' => 'Oriya', 's' => 'ଓଡ଼ିଆ'],
            [
                'code' => 'os',
                'name' => 'Ossetian, Ossetic',
                's' => 'ирон æвзаг',
            ],
            ['code' => 'pa', 'name' => 'Panjabi, Punjabi', 's' => 'پنجابی'],
            ['code' => 'pi', 'name' => 'Pāli', 's' => 'पाऴि'],
            ['code' => 'fa', 'name' => 'Persian', 's' => 'فارسی'],
            ['code' => 'pl', 'name' => 'Polish', 's' => 'polski'],
            ['code' => 'ps', 'name' => 'Pashto, Pushto', 's' => 'پښتو'],
            ['code' => 'pt', 'name' => 'Portuguese', 's' => 'Português'],
            ['code' => 'qu', 'name' => 'Quechua', 's' => 'Kichwa'],
            [
                'code' => 'rm',
                'name' => 'Romansh',
                's' => 'rumantsch grischun',
            ],
            ['code' => 'rn', 'name' => 'Kirundi', 's' => 'kiRundi'],
            ['code' => 'ro', 'name' => 'Romanian', 's' => 'română'],
            ['code' => 'ru', 'name' => 'Russian', 's' => 'русский язык'],
            ['code' => 'sa', 'name' => 'Sanskrit', 's' => 'संस्कृतम्'],
            ['code' => 'sc', 'name' => 'Sardinian', 's' => 'sardu'],
            ['code' => 'sd', 'name' => 'Sindhi', 's' => 'سنڌي'],
            [
                'code' => 'se',
                'name' => 'Northern Sami',
                's' => 'Davvisámegiella',
            ],
            ['code' => 'sm', 'name' => 'Samoan', 's' => 'gagana faa Samoa'],
            ['code' => 'sg', 'name' => 'Sango', 's' => 'yângâ tî sängö'],
            ['code' => 'sr', 'name' => 'Serbian', 's' => 'српски језик'],
            ['code' => 'gd', 'name' => 'Scottish Gaelic', 's' => 'Gàidhlig'],
            ['code' => 'sn', 'name' => 'Shona', 's' => 'chiShona'],
            ['code' => 'si', 'name' => 'Sinhala, Sinhalese', 's' => 'සිංහල'],
            ['code' => 'sk', 'name' => 'Slovak', 's' => 'slovenčina'],
            ['code' => 'sl', 'name' => 'Slovene', 's' => 'slovenščina'],
            ['code' => 'so', 'name' => 'Somali', 's' => 'Soomaaliga'],
            ['code' => 'st', 'name' => 'Southern Sotho', 's' => 'Sesotho'],
            [
                'code' => 'es',
                'name' => 'Spanish; Castilian',
                's' => 'español',
            ],
            ['code' => 'su', 'name' => 'Sundanese', 's' => 'Basa Sunda'],
            ['code' => 'sw', 'name' => 'Swahili', 's' => 'Kiswahili'],
            ['code' => 'ss', 'name' => 'Swati', 's' => 'SiSwati'],
            ['code' => 'sv', 'name' => 'Swedish', 's' => 'svenska'],
            ['code' => 'ta', 'name' => 'Tamil', 's' => 'தமிழ்'],
            ['code' => 'te', 'name' => 'Telugu', 's' => 'తెలుగు'],
            ['code' => 'tg', 'name' => 'Tajik', 's' => 'تاجیکی'],
            ['code' => 'th', 'name' => 'Thai', 's' => 'ไทย'],
            ['code' => 'ti', 'name' => 'Tigrinya', 's' => 'ትግርኛ'],
            ['code' => 'bo', 'name' => 'Tibetan', 's' => 'བོད་ཡིག'],
            ['code' => 'tk', 'name' => 'Turkmen', 's' => 'Türkmen'],
            ['code' => 'tl', 'name' => 'Tagalog', 's' => 'ᜏᜒᜃᜅ᜔ ᜆᜄᜎᜓᜄ᜔'],
            ['code' => 'tn', 'name' => 'Tswana', 's' => 'Setswana'],
            ['code' => 'to', 'name' => 'Tonga', 's' => 'faka Tonga'],
            ['code' => 'tr', 'name' => 'Turkish', 's' => 'Türkçe'],
            ['code' => 'ts', 'name' => 'Tsonga', 's' => 'Xitsonga'],
            ['code' => 'tt', 'name' => 'Tatar', 's' => 'تاتارچا'],
            ['code' => 'tw', 'name' => 'Twi', 's' => 'Twi'],
            ['code' => 'ty', 'name' => 'Tahitian', 's' => 'Reo Tahiti'],
            ['code' => 'ug', 'name' => 'Uighur, Uyghur', 's' => 'Uyƣurqə'],
            ['code' => 'uk', 'name' => 'Ukrainian', 's' => 'українська'],
            ['code' => 'ur', 'name' => 'Urdu', 's' => 'اردو'],
            ['code' => 'uz', 'name' => 'Uzbek', 's' => 'zbek'],
            ['code' => 've', 'name' => 'Venda', 's' => 'Tshivenḓa'],
            ['code' => 'vi', 'name' => 'Viet"name"se', 's' => 'Tiếng Việt'],
            ['code' => 'vo', 'name' => 'Volapük', 's' => 'Volapük'],
            ['code' => 'wa', 'name' => 'Walloon', 's' => 'Walon'],
            ['code' => 'cy', 'name' => 'Welsh', 's' => 'Cymraeg'],
            ['code' => 'wo', 'name' => 'Wolof', 's' => 'Wollof'],
            ['code' => 'fy', 'name' => 'Western Frisian', 's' => 'Frysk'],
            ['code' => 'xh', 'name' => 'Xhosa', 's' => 'isiXhosa'],
            ['code' => 'yi', 'name' => 'Yiddish', 's' => 'ייִדיש'],
            ['code' => 'yo', 'name' => 'Yoruba', 's' => 'Yorùbá'],
            ['code' => 'za', 'name' => 'Zhuang', 's' => 'Saɯ cueŋƅ'],
        ];
        return $languageCodes;
    }
}


if (!function_exists("getWidgetDetail")) {
    function getWidgetDetail($short_code, $defaultLang = null)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(true);
        }
        $banner = Banner::where('short_code', $short_code)->with(['bannerDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }])->first();
        return $banner;
    }
}


if (!function_exists("getEventListing")) {
    function getEventListing($defaultLang = null, $search = null)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(true);
        }
        $events = Event::with([
            'eventDetail' => function ($q) use ($defaultLang) {
                $q = $q->where('language_id', $defaultLang->id);
            },
            'customer.school.schoolDetail',
        ])
            ->addSelect([
                'name_order' => EventDetail::where('language_id', $defaultLang->id)
                    ->whereColumn('event_id', 'events.id')
                    ->limit(1)
                    ->select('title'),
            ]);
        if ($search) {
            $events = $events->where('product_search', 'like', '%' . $search . '%');
            $events = $events->orWhereHas('eventDetail', function ($q) use ($search, $defaultLang) {
                $q->where('event_details.language_id', $defaultLang->id);
                $q->where(function ($q1) use ($search) {

                    $q1->where('title', 'like', '%' . $search . '%')->orWhere('short_description', 'like', '%' . $search . '%')->orWhere('description', 'like', '%' . $search . '%');
                });
            });
        }

        // $events = $events->addSelect([
        //     'package_type' => Customer::whereColumn('customers.id', 'events.customer_id')
        //         ->select(['package_type' => RegistrationPackage::whereColumn('customers.registration_package_id', 'registration_packages.id')->select('package_type')])
        // ]);
        $events = $events->addSelect([
            'package_type' => \DB::raw('IF(
                events.customer_id IS NULL, 
                "free", 
                (SELECT IFNULL(rp.package_type, "Default Package Type") 
                 FROM customers c 
                 JOIN registration_packages rp ON c.registration_package_id = rp.id 
                 WHERE c.id = events.customer_id)
            ) as package_type')
        ]);

        $events = $events->orderByRaw("FIELD(package_type, 'featured', 'premium', 'free') ASC");
        $events = $events->orderBy('name_order', 'asc');


        $events = $events->paginate(10);
        return $events;
    }
}

if (!function_exists("generateUniqueEventSlug")) {
    function generateUniqueEventSlug($initialSlug)
    {
        $slug = Str::slug($initialSlug);
        $count = 1;

        while (Event::where('slug', $slug)->exists()) {
            $slug = Str::slug($initialSlug . '-' . $count);
            $count++;
        }

        return $slug;
    }
}


if (!function_exists("getSponsorListing")) {
    function getSponsorListing($defaultLang)
    {
        if (!$defaultLang) {
            $defaultLang = getDefaultLanguage(true);
        }
        return $sponsors = App\Models\Sponsor::with([
            'sponsorDetail' => function ($q) use ($defaultLang) {
                $q = $q->where('language_id', $defaultLang->id);
            },
        ])
            ->addSelect([
                'name_order' => App\Models\SponsorDetail::where('language_id', $defaultLang->id)->whereColumn('sponsor_id', 'sponsors.id')
                    ->limit(1)
                    ->select('title'),
            ])
            ->whereStatus('yes')
            ->orderBy('name_order')
            ->paginate(10);
    }
}
if (!function_exists('checkImageUrl')) {
    function checkImageUrl($url): bool
    {
        if (!$url) {
            return false;
        }

        try {
            $headers = @get_headers($url);
            if (!$headers || strpos($headers[0], '200') === false) {
                return false;
            }

            $invalidContent = ['404', '403', '301', '302', '500'];
            foreach ($invalidContent as $error) {
                if (strpos($headers[0], $error) !== false) {
                    return false;
                }
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
