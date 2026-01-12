<div class="my-10">
    <h2 class="can-edu-h2 mb-2 ">
        Articles by, and about, {{ isset($school->schoolDetail[0]->school_name) ? $school->schoolDetail[0]->school_name : 'this school' }}
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
        @foreach ($articles as $article)
            @php
            // dd($articles);
                $url = '#';
                if (isset($article->ArticleDetail[0])) {
                    $url = url('/'.getDefaultLanguage(1)['abbreviation'].'/article/' . $article->id . '/' . $article->ArticleDetail[0]->slug);
                }
            @endphp
            <a href="{{ $url }}">
                <div class="border rounded shadow">
                    <?php $image = isset($article->ArticleImage->thumbnail_image) ? $article->ArticleImage->thumbnail_image : "" ?>
                    <div class="h-48 border bg-white rounded-t overflow-hidden"> <img class="w-full object-cover h-full"
                            src="{{ asset($image) }}" alt=""></div>
                    <div class="bg-Dark p-2 w-full">
                        <div class="text-Dark truncate can-edu-card-h">
                            {{ isset($article->ArticleDetail[0]) ? $article->ArticleDetail[0]->name : '' }}
                        </div>
                        <div class="text-sm card_text text-Dark line-clamp-1">
                            {!! isset($article->ArticleDetail[0]) ? $article->ArticleDetail[0]->short_description : '' !!}
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>