<div class="bg-white container mx-auto lg:pt-14 lg:pb-14 md:pt-10 md:pb-10 pt-8 pb-8">

    <div class="flex flex-col sm:flex-col md:flex-row lg:flex-row w-full items-center gap-3">
        <div class="border-b-4 pb-2 border-primary w-full">
            <h1 class="can-edu-h1">{{ isset($page->pageDetail[0]->name) ? $page->pageDetail[0]->name : '' }}
            </h1>
        </div>
    </div>
    <div class="mt-4 space-y-4">
        <div class="mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 xl:gap-8">
                <!-- <div class="grid grid-cols-2 gap-8 xl:col-span-3"> -->
                <!-- <div class="md:grid md:grid-cols-2 md2:gap-8"> -->
                <div class="flex justify-start mt-6 md:mt-0">
                    <div>
                        <h1>Sitemap</h1>
                        <p>This is the sitemap for our website:</p>
                        <div class=" mt-4">
                            <a class="can-edu-btn-fill" href="{{ url('sitemap.xml') }}">Download the XML sitemap</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br />
