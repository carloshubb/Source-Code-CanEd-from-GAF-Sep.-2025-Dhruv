<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\EventResource;
use App\Models\Customer;
use Illuminate\Support\Str;
use App\Models\Event;
use App\Models\EventContact;
use App\Models\EventDetail;
use App\Models\EventImage;
use App\Models\Language;
use App\Models\Setting;
use App\Rules\CheckCategorySlug;
use App\Rules\FacebookUrl;
use App\Rules\InstagramUrl;
use App\Rules\LinkedInUrl;
use App\Rules\MaxKeywords;
use App\Rules\PinterestUrl;
use App\Rules\SnapchatUrl;
use App\Rules\TwitterUrl;
use App\Rules\ValidUrl;
use App\Rules\YoutubeUrl;
use App\Services\FomSubmissionCountService;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $events = Event::query();

        $events = $this->whereClause($events);
        $events = $this->loadRelations($events);
        $events = $this->sortingAndLimit($events);

        return $this->apiSuccessResponse(EventResource::collection($events), 'Data Get Successfully!');
    }

    public function show(Event $Event)
    {
        if (isset($_GET['withEventDetail']) && $_GET['withEventDetail'] == '1') {
            $Event = $Event->loadMissing('eventDetail');
        }

        return $this->apiSuccessResponse(new EventResource($Event), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validationRule = [];
        $errorMessages = [];
        $niceNames = [];
        $languages = getAllLanguages();
        $defaultLang = getDefaultLanguage(1);
        if (isset($request->is_web) && $request->is_web == 1) {
            $validationRule = array_merge($validationRule, ['title.title_' . $defaultLang->id => ['required', 'string']]);
            $errorMessages = array_merge($errorMessages, ['title.title_' . $defaultLang->id . '.required' => 'Event’s name  is required']);
            $validationRule = array_merge($validationRule, ['description.description_' . $defaultLang->id => ['required', 'string', 'maxwords:300']]);
            $errorMessages = array_merge($errorMessages, [
                'description.description_' . $defaultLang->id . '.required' => 'Event description is required',
                'description.description_' . $defaultLang->id . '.maxwords' => 'Please limit your event description to 300 words'
            ]);
            $validationRule = array_merge($validationRule, ['short_description.short_description_' . $defaultLang->id => ['required', 'string', 'maxwords:30']]);
            $errorMessages = array_merge($errorMessages, [
                'short_description.short_description_' . $defaultLang->id . '.required' => 'Short description is required',
                'short_description.short_description_' . $defaultLang->id . '.maxwords' => 'Please limit your short description to 30 words'
            ]);
            $niceNames['short_description.short_description_' . $defaultLang->id] = 'short description';
            $niceNames['description.description_' . $defaultLang->id] = 'description';
        } else {
            foreach ($languages as $language) {
                $requiredVal = 'nullable';
                if ($language->is_default == '1') {
                    $requiredVal = 'required';
                }
                $validationRule = array_merge($validationRule, ['title.title_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
                $errorMessages = array_merge($errorMessages, ['title.title_' . $language->id . '.required' => 'Event’s name is required']);
                $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string', 'maxwords:300']]);
                $errorMessages = array_merge($errorMessages, [
                    'description.description_' . $language->id . '.required' => 'Event description is required',
                    'description.description_' . $language->id . '.maxwords' => 'Please limit your event description to 300 words'
                ]);
                $validationRule = array_merge($validationRule, ['short_description.short_description_' . $language->id => [$requiredVal, 'string', 'maxwords:30']]);
                $errorMessages = array_merge($errorMessages, [
                    'short_description.short_description_' . $language->id . '.required' => 'Short description is required',
                    'short_description.short_description_' . $language->id . '.maxwords' => 'Please limit your short description to 30 words'
                ]);
                $niceNames['short_description.short_description_' . $language->id] = 'short description';
                $niceNames['description.description_' . $language->id] = 'description';
            }
        }
        $validationRule = array_merge($validationRule, ['veneue' => ['required', 'string']]);
        $niceNames['veneue'] = 'address of the event';
        $errorMessages = array_merge(
            $errorMessages,
            [
                'veneue.required' => 'Address of the event is required',
                // 'veneue.string' => 'The address of the event must be a valid string.',
            ]
        );
        $validationRule = array_merge($validationRule, ['product_search' => [new MaxKeywords]]);
        $errorMessages = array_merge(
            $errorMessages,
            [
                'product_search.required' => 'Keywords are required',
                // 'product_search.string' => 'The keywords must be a valid string.',
            ]
        );
        $niceNames['product_search'] = 'keywords';
        $validationRule = array_merge($validationRule, ['location' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['location.required' => 'Location is required']);
        $validationRule = array_merge($validationRule, ['start_date' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['start_date.required' => 'Start date is required']);
        $validationRule = array_merge($validationRule, ['featured_image' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['featured_image.required' => 'Image is required']);
        $validationRule = array_merge($validationRule, ['end_date' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['end_date.required' => 'End date is required']);
        $validationRule = array_merge($validationRule, ['event_website' => ['nullable']]);
        $errorMessages = array_merge($errorMessages, ['event_website.required' => 'Event’s website is required']);
        $validationRule = array_merge($validationRule, ['exibiters_url' => ['nullable', new ValidUrl()]]);
        $errorMessages = array_merge($errorMessages, ['exibiters_url.required' => 'Event in the media is required']);
        $validationRule = array_merge($validationRule, ['visitor_url' => ['nullable', new ValidUrl()]]);
        $errorMessages = array_merge($errorMessages, ['visitor_url.required' => 'Visitor’s URL is required']);
        $validationRule = array_merge($validationRule, ['press_url' => ['nullable', new ValidUrl()]]);
        $errorMessages = array_merge($errorMessages, ['press_url.required' => 'Press is required']);
        $validationRule = array_merge($validationRule, ['video_url' => ['nullable', new YoutubeUrl()]]);
        $errorMessages = array_merge($errorMessages, ['video_url.required' => 'Welcome video is required']);

        $validationRule = array_merge($validationRule, ['facebook_url' => [ 'nullable', new FacebookUrl()]]);
        $errorMessages = array_merge($errorMessages, ['facebook_url.required' => 'Facebook link is required']);

        $validationRule = array_merge($validationRule, ['instagram_url' => ['nullable',new InstagramUrl()]]);
        $errorMessages = array_merge($errorMessages, ['instagram_url.required' => 'Instagram link is required']);
        $validationRule = array_merge($validationRule, ['linkedin_url' => ['nullable', new LinkedInUrl()]]);
        $errorMessages = array_merge($errorMessages, ['linkedin_url.required' => 'Linkedin link is required']);
        $validationRule = array_merge($validationRule, ['youtube_url' => ['nullable', new YoutubeUrl()]]);
        $errorMessages = array_merge($errorMessages, ['youtube_url.required' => 'Youtube link is required']);
        $validationRule = array_merge($validationRule, ['pintrest_url' => ['nullable', new PinterestUrl()]]);
        $errorMessages = array_merge($errorMessages, ['pintrest_url.required' => 'Pintrest link is required']);
        $validationRule = array_merge($validationRule, ['snapchat_url' => ['nullable', new SnapchatUrl()]]);
        $errorMessages = array_merge($errorMessages, ['snapchat_url.required' => 'Snapchat link is required']);
        $validationRule = array_merge($validationRule, ['twitter_url' => ['nullable', new TwitterUrl()]]);
        $errorMessages = array_merge($errorMessages, ['twitter_url.required' => 'Twitter link is required']);

        $validationRule = array_merge($validationRule, ['contact_name' => 'required|array', 'contact_name.*' => 'required']);
        $errorMessages = array_merge($errorMessages, ['contact_name.required' => 'Contact person’s name is required','contact_name.*.required' => 'Contact person’s name is required']);

        $validationRule = array_merge($validationRule, ['contact_email' => 'required|array', 'contact_email.*' => 'required']);
        $errorMessages = array_merge($errorMessages, ['contact_email.required' => 'Contact person’s email is required','contact_email.*.required' => 'Contact person’s email is required']);

        // $validationRule = array_merge($validationRule, ['contact_phone' => 'required|array', 'contact_phone.*' => 'required']);
        // $errorMessages = array_merge($errorMessages, ['contact_phone.required' => 'Contact person’s phone is required','contact_phone.*.required' => 'Contact person’s phone is required']);
        $validationRule = array_merge($validationRule, [
            'contact_phone' => 'required|array',
            
        ]);
        
        $errorMessages = array_merge($errorMessages, [
            'contact_phone.required' => 'Contact person’s phone is required',
            'contact_phone.*.required' => 'Contact person’s phone is required',
        ]);

        // $validationRule = array_merge($validationRule, ['contact_title' => 'required|array', 'contact_title.*' => 'required']);
        // $errorMessages = array_merge($errorMessages, ['contact_title.required' => 'this field is required.']);

        $validationRule = array_merge($validationRule, ['contact_photo' => 'nullable|array', 'contact_photo.*' => 'nullable']);
        // $errorMessages = array_merge($errorMessages, ['contact_photo.required' => 'Contact person’s photo is required','contact_photo.*.required' => 'Contact person’s photo is required']);

        $niceNames['contact_photo.*'] = "contact person's photo";

        $this->validate($request, $validationRule, $errorMessages, $niceNames);
        if (isset($request->is_web)) {
            $customer = Customer::where('id', $request->customer_id)->first();
            if ($customer->user_type == 'school') {
                $count = Event::where('customer_id', $request->customer_id)->count();
                // dd($customer->registrationPackage->events);
                if ($customer->payment_frequency == 'annually') {
                    $allowedEvents = $customer->registrationPackage->events * 12;
                } elseif ($customer->payment_frequency == 'semi_annually') {
                    $allowedEvents = $customer->registrationPackage->events * 6;
                } elseif ($customer->payment_frequency == 'quarterly') {
                    $allowedEvents = $customer->registrationPackage->events * 3;
                } else {
                    $allowedEvents = $customer->registrationPackage->events;
                }
                
                if ($allowedEvents <= $count) {
                    return $this->errorResponse("You've reached your package limit. Upgrade your package to continue creating more.");
                }
            }

            $allowedEventImages = Setting::where('type', 'general')->where('key', 'event_multiple_images_allowed')->value('value');
            if (isset($request->images) && count($request->images) > $allowedEventImages) {
                return $this->errorResponse('Please limit the number of photos to ' . $allowedEventImages);
            }
            $formSubmissionService = new FomSubmissionCountService();
            $result = $formSubmissionService->advertiserForm();
            if ($result['status'] == 'Error') {
                return $result;
            }
        }
        // dd($request->featured_image);
        // $media = json_decode($request->featured_image, 1);
        // $files = $this->moveFile($media, 'media/images', 'event_image');

        if (isset($request->featured_image)) {
            $media = json_decode($request->featured_image, true);

            if (is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files = $this->moveFile($media['media'], 'media/images', 'featured_image');
            } else {    
                return response()->json(['error' => 'Invalid media data'], 400);
            }
        } else {
            return response()->json(['error' => 'No featured image provided'], 400);
        }

        $Event = Event::create([
            'slug' => $request->slug,
            'start_date' => $request->start_date,
            'location' => $request->location,
            'end_date' => $request->end_date,
            'event_website' => $request->event_website,
            'exibiters_url' => $request->exibiters_url,
            'visitor_url' => $request->visitor_url,
            'press_url' => $request->press_url,
            'video_url' => $request->video_url,
            'video_frame' => $request->video_url ? getVideoHtmlAttribute($request->video_frame) : null,
            'facebook_url' => $request->facebook_url,
            'instagram_url' => $request->instagram_url,
            'linkedin_url' => $request->linkedin_url,
            'youtube_url' => $request->youtube_url,
            'pintrest_url' => $request->pintrest_url,
            'snapchat_url' => $request->snapchat_url,
            'twitter_url' => $request->twitter_url,
            'featured_image' => isset($files, $files[0]) ? $files[0]->id : null,
            'status' => $request->status ?? 0,
            'veneue' => $request->veneue,
            'product_search' => $request->product_search,
            'customer_id' => isset($request->customer_id) ? $request->customer_id : null,
            'school_id' => $request->school_id,
        ]);

        if ($Event) {
            foreach ($request->contact_name as $key => $contact_name) {
                $contact = EventContact::create([
                    'event_id' => $Event->id,
                    'contact_name' => $contact_name,
                    'contact_email' => $request->contact_email[$key] ?? null,
                    'contact_phone' => $request->contact_phone[$key] ?? null,
                    'contact_title' => $request->contact_title[$key] ?? null,
                    'contact_photo' => $request->contact_photo[$key] ?? null,
                ]);
            }
            if (isset($request->images)) {
                for ($i = 0; $i < count($request->images); $i++) {
                    EventImage::create([
                        'image' => $request->images[$i],
                        'event_id' => $Event->id,
                    ]);
                }
            }
            foreach ($languages as $language) {
                if (isset($request['title']['title_' . $language->id])) {
                    EventDetail::create([
                        'event_id' => $Event->id,
                        'language_id' => $language->id,
                        'title' => $request['title']['title_' . $language->id] ?? null,
                        'description' => $request['description']['description_' . $language->id] ?? null,
                        'short_description' => $request['short_description']['short_description_' . $language->id] ?? null,
                        'slug' => isset($request['title']['title_' . $language->id]) ? Str::slug($request['title']['title_' . $language->id]) : null,
                    ]);

                    if ($language->is_default) {
                        $Event->update([
                            'slug' => $this->generateUniqueEventSlug($request['title']['title_' . $language->id])
                        ]);
                    }
                }
            }
            return $this->apiSuccessResponse(new EventResource($Event), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, Event $Event)
    {
        // dd($request->all());
        $validationRule = [];
        $errorMessages = [];
        $niceNames = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['title.title_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['title.title_' . $language->id . '.required' => 'Event’s name is required']);
            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string', 'maxwords:300']]);
            $errorMessages = array_merge($errorMessages, [
                'description.description_' . $language->id . '.required' => 'Event description is required.',
                'description.description_' . $language->id . '.maxwords' => 'Please limit your event description to 300 words.'
            ]);
            $validationRule = array_merge($validationRule, ['short_description.short_description_' . $language->id => [$requiredVal, 'string', 'maxwords:30']]);
            $errorMessages = array_merge($errorMessages, [
                'short_description.short_description_' . $language->id . '.required' => 'Short description is required.',
                'short_description.short_description_' . $language->id . '.maxwords' => 'Please limit your short description to 30 words.'
            ]);
            $niceNames['short_description.short_description_' . $language->id] = 'short description';
            $niceNames['description.description_' . $language->id] = 'description';
        }
        $validationRule = array_merge($validationRule, ['veneue' => ['required', 'string']]);
        $errorMessages = array_merge(
            $errorMessages,
            [
                'veneue.required' => 'Address of the event is required',
            ]
        );
        $niceNames['veneue'] = 'address of the event';
        $validationRule = array_merge($validationRule, ['product_search' => ['required', 'string', new MaxKeywords]]);
        $errorMessages = array_merge(
            $errorMessages,
            [
                'product_search.required' => 'Keywords are required',
            ]
        );
        $niceNames['product_search'] = 'keywords';
        $validationRule = array_merge($validationRule, ['location' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['location.required' => 'Location is required']);
        $validationRule = array_merge($validationRule, ['start_date' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['start_date.required' => 'Start date is required']);
        $validationRule = array_merge($validationRule, ['featured_image' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['featured_image.required' => 'Image is required.']);
        $validationRule = array_merge($validationRule, ['end_date' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['end_date.required' => 'End date is required.']);
        $errorMessages = array_merge($errorMessages, ['event_website.required' => 'Event’s website is required']);
        $validationRule = array_merge($validationRule, ['event_website' => ['nullable']]);
        $validationRule = array_merge($validationRule, ['exibiters_url' => ['required', new ValidUrl()]]);
        $errorMessages = array_merge($errorMessages, ['exibiters_url.required' => 'Event in the media is required']);
        $validationRule = array_merge($validationRule, ['visitor_url' => ['nullable', new ValidUrl()]]);
        $errorMessages = array_merge($errorMessages, ['visitor_url.required' => 'Visitor’s URL is required']);
        $validationRule = array_merge($validationRule, ['press_url' => ['nullable', new ValidUrl()]]);
        $errorMessages = array_merge($errorMessages, ['press_url.required' => 'Press is required']);
        $validationRule = array_merge($validationRule, ['video_url' => ['nullable', new YoutubeUrl()]]);
        $errorMessages = array_merge($errorMessages, ['video_url.required' => 'Welcome video is required']);
        $validationRule = array_merge($validationRule, ['facebook_url' => ['nullable', new FacebookUrl()]]);
        $errorMessages = array_merge($errorMessages, ['facebook_url.required' => 'Facebook link is required']);
        $validationRule = array_merge($validationRule, ['instagram_url' => ['nullable', new InstagramUrl()]]);
        $errorMessages = array_merge($errorMessages, ['instagram_url.required' => 'Instagram link is required']);
        $validationRule = array_merge($validationRule, ['linkedin_url' => ['nullable', new LinkedInUrl()]]);
        $errorMessages = array_merge($errorMessages, ['linkedin_url.required' => 'Linkedin link is required']);
        $validationRule = array_merge($validationRule, ['youtube_url' => ['nullable', new YoutubeUrl()]]);
        $errorMessages = array_merge($errorMessages, ['youtube_url.required' => 'Youtube link is required']);
        $validationRule = array_merge($validationRule, ['pintrest_url' => ['nullable', new PinterestUrl()]]);
        $errorMessages = array_merge($errorMessages, ['pintrest_url.required' => 'Pintrest link is required']);
        $validationRule = array_merge($validationRule, ['snapchat_url' => ['nullable', new SnapchatUrl()]]);
        $errorMessages = array_merge($errorMessages, ['snapchat_url.required' => 'Snapchat link is required']);
        $validationRule = array_merge($validationRule, ['twitter_url' => ['nullable', new TwitterUrl()]]);
        $errorMessages = array_merge($errorMessages, ['twitter_url.required' => 'Twitter link is required']);

        $validationRule = array_merge($validationRule, ['contact_name' => 'required|array', 'contact_name.*' => 'required']);
        $errorMessages = array_merge($errorMessages, ['contact_name.required' => 'Contact person’s name is required','contact_name.*.required' => 'Contact person’s name is required']);

        $validationRule = array_merge($validationRule, ['contact_email' => 'required|array', 'contact_email.*' => 'required']);
        $errorMessages = array_merge($errorMessages, ['contact_email.required' => 'Contact person’s email is required','contact_email.*.required' => 'Contact person’s email is required']);
        $validationRule = array_merge($validationRule, ['contact_phone' => 'required|array', 'contact_phone.*' => 'required']);
        $errorMessages = array_merge($errorMessages, ['contact_phone.required' => 'Contact person’s phone is required','contact_phone.*.required' => 'Contact person’s phone is required']);
        // $validationRule = array_merge($validationRule, ['contact_title' => 'required|array', 'contact_title.*' => 'required']);
        // $errorMessages = array_merge($errorMessages, ['contact_title.required' => 'this field is required.']);
        $validationRule = array_merge($validationRule, ['contact_photo' => 'nullable|array', 'contact_photo.*' => 'nullable']);
        $errorMessages = array_merge($errorMessages, ['contact_photo.required' => 'Contact person’s photo is required','contact_photo.*.required' => 'Contact person’s photo is required']);

        $niceNames['contact_photo.*'] = "contact person's photo";

        $this->validate($request, $validationRule, $errorMessages, $niceNames);

        if ($request->has('featured_image') && !empty($request->featured_image)) {
            $media = is_array($request->featured_image)
                ? $request->featured_image
                : json_decode($request->featured_image, true);
        
            if ($media && is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files = $this->moveFile($media['media'], 'media/images', 'featured_image');
        
                if (isset($existingImagePath) && !empty($existingImagePath)) {
                    $this->deleteFile($existingImagePath);
                }
            } else {
                $files = $existingImagePath ?? null;
            }
        } else {
            $files = $existingImagePath ?? null;
        }
        
        $Event->update([
            'start_date' => $request->start_date,
            'location' => $request->location,
            'end_date' => $request->end_date,
            'event_website' => $request->event_website,
            'exibiters_url' => $request->exibiters_url,
            'visitor_url' => $request->visitor_url,
            'press_url' => $request->press_url,
            'video_url' => $request->video_url,
            'video_frame' => $request->video_url ? getVideoHtmlAttribute($request->video_frame) : null,
            'facebook_url' => $request->facebook_url,
            'instagram_url' => $request->instagram_url,
            'linkedin_url' => $request->linkedin_url,
            'youtube_url' => $request->youtube_url,
            'pintrest_url' => $request->pintrest_url,
            'snapchat_url' => $request->snapchat_url,
            'twitter_url' => $request->twitter_url,
            'featured_image' => !isset($request->featured_image) ? null : (isset($files, $files[0]) ? $files[0]->id : $Event->featured_image),
            'veneue' => $request->veneue,
            'product_search' => $request->product_search,
        ]);
        EventContact::where('event_id', $Event->id)->delete();
        foreach ($request->contact_name as $key => $contact_name) {
            $contact = EventContact::create([
                'event_id' => $Event->id,
                'contact_name' => $contact_name,
                'contact_email' => $request->contact_email[$key],
                'contact_phone' => $request->contact_phone[$key],
                'contact_title' => $request->contact_title[$key],
                'contact_photo' => $request->contact_photo[$key] ?? null,
            ]);
        }
        EventImage::where('event_id', $Event->id)->delete();
        for ($i = 0; $i < count($request->images); $i++) {
            EventImage::create([
                'image' => $request->images[$i],
                'event_id' => $Event->id,
            ]);
        }

        foreach ($languages as $language) {
            $EventDetail = EventDetail::whereLanguageId($language->id)
                ->whereEventId($Event->id)
                ->exists();
            if ($EventDetail) {
                EventDetail::whereLanguageId($language->id)
                    ->whereEventId($Event->id)
                    ->update([
                        'event_id' => $Event->id,
                        'language_id' => $language->id,
                        'title' => $request['title']['title_' . $language->id] ?? null,
                        'description' => $request['description']['description_' . $language->id] ?? null,
                        'short_description' => $request['short_description']['short_description_' . $language->id] ?? null,
                        'slug' => isset($request['title']['title_' . $language->id]) ? Str::slug($request['title']['title_' . $language->id]) : null,
                    ]);
            } else {
                EventDetail::create([
                    'event_id' => $Event->id,
                    'language_id' => $language->id,
                    'title' => $request['title']['title_' . $language->id] ?? null,
                    'description' => $request['description']['description_' . $language->id] ?? null,
                    'short_description' => $request['short_description']['short_description_' . $language->id] ?? null,
                    'slug' => isset($request['title']['title_' . $language->id]) ? Str::slug($request['title']['title_' . $language->id]) : null,
                ]);
            }

            if ($language->is_default) {
                $eventName = $request['title']['title_' . $language->id] ?? null;
                $slug = Str::slug($eventName);
                if (trim($Event->slug) != trim($slug)) {
                    $slug = $this->generateUniqueEventSlug($eventName);
                    $Event->update([
                        'slug' => $slug
                    ]);
                }
            }
        }

        if ($Event) {
            return $this->apiSuccessResponse(new EventResource($Event), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
    protected function deleteFile($filePath)
    {
        if (\File::exists($filePath)) {
            \File::delete($filePath);
        }
    }

    public function destroy(Request $request, Event $Event)
    {
        if ($Event->EventDetail()->delete() && $Event->delete()) {
            return $this->apiSuccessResponse(new EventResource($Event), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($events)
    {
        $defaultLang = getDefaultLanguage();
        $events = $events->with([
            'eventDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ]);
        if (isset($_GET['withEventDetail']) && $_GET['withEventDetail'] == '1') {
            $events = $events->with('eventDetail');
        }
        return $events;
    }

    protected function sortingAndLimit($events)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'title', 'abbreviation', 'event_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $events = $events->addSelect(['event_name' => EventDetail::whereColumn('events.id', 'event_details.event_id')->whereLanguageId($defaultLang->id)->select('title')->limit(1)]);

            $events = $events->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $events->paginate($limit);
    }

    protected function whereClause($events)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $events = $events->whereHas('eventDetail', function ($q) {
                $q->where('title', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $events;
    }

    protected function generateUniqueEventSlug($initialSlug): string
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
