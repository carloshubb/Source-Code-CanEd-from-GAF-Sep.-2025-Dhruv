<?php
$defaultLang = getDefaultLanguage(1);
$lang = $defaultLang['abbreviation'];

$schoolAmbassadors = App\Models\SchoolAmbassador::with([
    'schoolAmbassadorDetail' => function ($q) use ($defaultLang) {
        $q->where('language_code', $defaultLang->abbreviation);
    }, 'school'
])
->join('school_ambassador_details', 'school_ambassadors.id', '=', 'school_ambassador_details.school_ambassador_id')
->where('school_id', $school->id)
->orderBy('school_ambassador_details.name', 'asc')
->select('school_ambassadors.*') 
->get();

// Fetch Proxima Study ambassadors (where school_id and customer_id are null)
// $proximaAmbassadors = App\Models\SchoolAmbassador::with('schoolAmbassadorDetail')
//     ->whereNull('school_id')
//     ->whereNull('customer_id')
//     ->get();
$proximaAmbassadors = App\Models\SchoolAmbassador::with([
    'schoolAmbassadorDetail' => function ($q) use ($defaultLang) {
        $q->where('language_code', $defaultLang->abbreviation);
    }
])
->whereNull('school_id')
->whereNull('customer_id')
->orderBy(
    App\Models\SchoolAmbassadorDetail::select('name')
        ->whereColumn('school_ambassador_details.school_ambassador_id', 'school_ambassadors.id')
        ->where('language_code', $defaultLang->abbreviation)
        ->limit(1)
)
->get();


// Fetch ambassadors with the same degree level or school type
// $degreeLevelAmbassadors = App\Models\SchoolAmbassador::with('schoolAmbassadorDetail')
//     ->join('schools', 'school_ambassadors.school_id', '=', 'schools.id')
//     ->join('degrees', 'schools.degree_id', '=', 'degrees.id')
//     ->join('degree_details', 'degrees.id', '=', 'degree_details.degree_id')
//     ->where(function($query) use ($school) {
//         $query->where('school_ambassadors.degree_level', '=', 'degree_details.name');
//     })
//     ->where('school_ambassadors.school_id', '!=', $school->id)
//     ->get();
$degreeLevelAmbassadors = App\Models\SchoolAmbassador::with([
    'schoolAmbassadorDetail' => function ($q) use ($defaultLang) {
        $q->where('language_code', $defaultLang->abbreviation);
    }
])
->join('schools', 'school_ambassadors.school_id', '=', 'schools.id')
->join('degrees', 'schools.degree_id', '=', 'degrees.id')
->join('degree_details', 'degrees.id', '=', 'degree_details.degree_id')
->whereColumn('school_ambassadors.degree_level', 'degree_details.name')
->where('school_ambassadors.school_id', '!=', $school->id)
->orderBy(
    App\Models\SchoolAmbassadorDetail::select('name')
        ->whereColumn('school_ambassador_details.school_ambassador_id', 'school_ambassadors.id')
        ->where('language_code', $defaultLang->abbreviation)
        ->limit(1)
)
->select('school_ambassadors.*') // Ensure no duplication issues
->get();

// Fetch all other ambassadors (excluding the above ones)
// $otherAmbassadors = App\Models\SchoolAmbassador::with('schoolAmbassadorDetail')
//     ->whereNotIn('id', $schoolAmbassadors->pluck('id'))
//     ->whereNotIn('id', $proximaAmbassadors->pluck('id'))
//     ->whereNotIn('id', $degreeLevelAmbassadors->pluck('id'))
//     ->get();
$otherAmbassadors = App\Models\SchoolAmbassador::with([
    'schoolAmbassadorDetail' => function ($q) use ($defaultLang) {
        $q->where('language_code', $defaultLang->abbreviation);
    }
])
->whereNotIn('id', $schoolAmbassadors->pluck('id'))
->whereNotIn('id', $proximaAmbassadors->pluck('id'))
->whereNotIn('id', $degreeLevelAmbassadors->pluck('id'))
->orderBy(
    App\Models\SchoolAmbassadorDetail::select('name')
        ->whereColumn('school_ambassador_details.school_ambassador_id', 'school_ambassadors.id')
        ->where('language_code', $defaultLang->abbreviation)
        ->limit(1)
)
->get();


$ambassadorTranslations = getStaticTranslation('ambassadors');
?>
<div class="grid grid-cols-2 gap-4">
@isset($school->schoolAmbassadorSetting)
    <div class="mt-10">
        <p class="text-black">
            {!! isset($school->schoolAmbassadorSetting->heading_text)
                ? $school->schoolAmbassadorSetting->heading_text
                : '' !!}
        </p>
    </div>
@endisset
@isset($school->schoolAmbassadorSetting)
    <div class="mt-10 max-h-96 h-64 lg:h-80 border bg-white">
        <img class="w-full h-full object-contain mx-auto"
        src="{{ asset($school->schoolAmbassadorSetting->main_photo) }}" 
        alt="School Image">
    </div>
@endisset
</div>
<ambassador-tab
    lang="{{ $lang }}"
    ambassador_translations="{{ json_encode($ambassadorTranslations) }}"
    school="{{ $school }}"
    showTitle='1'
    :school-ambassadors="{{ json_encode($schoolAmbassadors) }}"
    :proxima-ambassadors="{{ json_encode($proximaAmbassadors) }}"
    :degree-level-ambassadors="{{ json_encode($degreeLevelAmbassadors) }}"
    :other-ambassadors="{{ json_encode($otherAmbassadors) }}"
/>


{{-- {!! $articles->withQueryString()->onEachSide(1)->links('custom_pagination') !!} --}}