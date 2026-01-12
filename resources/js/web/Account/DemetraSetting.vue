<template>
    <div class="modal-content py-6 text-left px-6">
        <div class="flex justify-between items-center pb-2">
            <h2 class="can-school-h2 text-primary">Our Reverse Admissions</h2>
        </div>
        <div class="flex justify-between items-center pb-3">
            <p>We are seeking students with the following knowledge, abilities, and skills for our Reverse Admissions
            </p>
        </div>
        <div class="modal-body">
            <div class="w-full mt-2 relative">
                <label for="" class="block text-base lg:text-lg">Min GPA</label>
                <input type="text"
                    placeholder="Please specify whether it is out of 4, out of 5, or in %; e.g. “3.8 / 4”, “4.7 / 5”, or “95%”"
                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:ring-0.5 focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="min_cgpa" @input="clearError('min_cgpa')" step="any" />
                <error :fieldName="`min_cgpa`" :validationErros="errors" />
            </div>
            <!-- <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Max GPA</label
                >
                <input
                    type="text"
                    placeholder=""
                    class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:ring-0.5 focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="max_cgpa"
                    @input="clearError('max_cgpa')"
                    step="any"
                />
                <error :fieldName="`max_cgpa`" :validationErros="errors" />
            </div> -->

            <div class="w-full mt-2 relative">
                <div class="flex justify-between items-center">
                    <label for="" class="block text-base lg:text-lg">
                        Sport (Check all the ones that apply)
                    </label>
                    <button @click="toggleAddNewSport" class="can-edu-btn-fill">
                        Add new sport
                    </button>
                </div>

                <div
                    class="mt-2 border w-full border-l-[5px] border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300 p-4">
                    <div v-for="(sport, key) in sortedSports" :key="key" class="flex items-center space-x-2">
                        <input type="checkbox" :value="sport.id" v-model="sport_id"
                            class="form-checkbox h-5 w-5 text-primary" />
                        <span class="text-lg">{{ sport?.sport_detail?.[0]?.name || "" }}</span>
                    </div>
                </div>

                <error :fieldName="`sport_id`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative" v-if="add_sport">
                <label for="" class="block text-base lg:text-lg">Add desired sport</label>
                <input type="text"
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    placeholder="Please enter sport name" v-model="new_sport" />
                <br /><br />
                <div>
                    <button class="can-edu-btn-fill" @click="saveNewSport">
                        Save
                    </button>
                </div>
            </div>



            <div class="w-full mt-2 relative">
                <div class="flex justify-between items-center">
                    <label class="block text-base lg:text-lg">Extracurricular Activities (Check all that apply)</label>
                    <button @click="toggleAddNew('extracurricular')" class="can-edu-btn-fill">
                        Add new extracurricular activity
                    </button>
                </div>

                <div
                    class="mt-2 border w-full border-l-[5px] border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300 p-4">
                    <div v-for="activity in filteredActivities('extracurricular')" :key="activity.id"
                        class="flex items-center space-x-2">
                        <input type="checkbox" :value="activity.id" v-model="extracurricular_ids"
                            class="form-checkbox h-5 w-5 text-primary" />
                        <span class="text-lg">{{ activity?.details?.[0]?.name || "" }}</span>
                    </div>
                </div>

                <div class="w-full mt-2 relative" v-if="add_new.extracurricular">
                    <label class="block text-base lg:text-lg">Add desired extracurricular activity</label>
                    <input type="text"
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        placeholder="Please enter activity name" v-model="new_activity.extracurricular" />
                    <br><br>
                    <div>
                        <button class="can-edu-btn-fill" @click="saveNewActivity('extracurricular')">
                            Save
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-full mt-2 relative">
                <div class="flex justify-between items-center">
                    <label class="block text-base lg:text-lg">Curricular Activities (Check all that apply)</label>
                    <button @click="toggleAddNew('curricular')" class="can-edu-btn-fill">
                        Add new curricular activity
                    </button>
                </div>

                <div
                    class="mt-2 border w-full border-l-[5px] border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300 p-4">
                    <div v-for="activity in filteredActivities('curricular')" :key="activity.id"
                        class="flex items-center space-x-2">
                        <input type="checkbox" :value="activity.id" v-model="curricular_ids"
                            class="form-checkbox h-5 w-5 text-primary" />
                        <span class="text-lg">{{ activity?.details?.[0]?.name || "" }}</span>
                    </div>
                </div>

                <div class="w-full mt-2 relative" v-if="add_new.curricular">
                    <label class="block text-base lg:text-lg">Add desired curricular activity</label>
                    <input type="text"
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        placeholder="Please enter activity name" v-model="new_activity.curricular" />
                    <br><br>
                    <div>
                        <button class="can-edu-btn-fill" @click="saveNewActivity('curricular')">
                            Save
                        </button>
                    </div>
                </div>
            </div>

            <div class="w-full mt-2 relative">
                <div class="flex justify-between items-center">
                    <label class="block text-base lg:text-lg">Leadership (Check all that apply)</label>
                    <button @click="toggleAddNew('leadership')" class="can-edu-btn-fill">
                        Add new leadership
                    </button>
                </div>

                <div
                    class="mt-2 border w-full border-l-[5px] border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300 p-4">
                    <div v-for="activity in filteredActivities('leadership')" :key="activity.id"
                        class="flex items-center space-x-2">
                        <input type="checkbox" :value="activity.id" v-model="leadership_ids"
                            class="form-checkbox h-5 w-5 text-primary" />
                        <span class="text-lg">{{ activity?.details?.[0]?.name || "" }}</span>
                    </div>
                </div>

                <div class="w-full mt-2 relative" v-if="add_new.leadership">
                    <label class="block text-base lg:text-lg">Add desired leadership activity</label>
                    <input type="text"
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        placeholder="Please enter activity name" v-model="new_activity.leadership" />
                    <br><br>
                    <div>
                        <button class="can-edu-btn-fill" @click="saveNewActivity('leadership')">
                            Save
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-full mt-2 relative">
                <div class="flex justify-between items-center">
                    <label class="block text-base lg:text-lg">Media (Check all that apply)</label>
                    <button @click="toggleAddNew('media')" class="can-edu-btn-fill">
                        Add new media
                    </button>
                </div>

                <div
                    class="mt-2 border w-full border-l-[5px] border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300 p-4">
                    <div v-for="activity in filteredActivities('media')" :key="activity.id"
                        class="flex items-center space-x-2">
                        <input type="checkbox" :value="activity.id" v-model="media_ids"
                            class="form-checkbox h-5 w-5 text-primary" />
                        <span class="text-lg">{{ activity?.details?.[0]?.name || "" }}</span>
                    </div>
                </div>

                <div class="w-full mt-2 relative" v-if="add_new.media">
                    <label class="block text-base lg:text-lg">Add desired media activity</label>
                    <input type="text"
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        placeholder="Please enter activity name" v-model="new_activity.media" />
                    <br><br>
                    <div>
                        <button class="can-edu-btn-fill" @click="saveNewActivity('media')">
                            Save
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-full mt-2 relative">
                <div class="flex justify-between items-center">
                    <label class="block text-base lg:text-lg">Music performance (Check all that apply)</label>
                    <button @click="toggleAddNew('music_performance')" class="can-edu-btn-fill">
                        Add new music performance
                    </button>
                </div>

                <div
                    class="mt-2 border w-full border-l-[5px] border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300 p-4">
                    <div v-for="activity in filteredActivities('music_performance')" :key="activity.id"
                        class="flex items-center space-x-2">
                        <input type="checkbox" :value="activity.id" v-model="music_performance_ids"
                            class="form-checkbox h-5 w-5 text-primary" />
                        <span class="text-lg">{{ activity?.details?.[0]?.name || "" }}</span>
                    </div>
                </div>

                <div class="w-full mt-2 relative" v-if="add_new.music_performance">
                    <label class="block text-base lg:text-lg">Add desired music performance activity</label>
                    <input type="text"
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        placeholder="Please enter activity name" v-model="new_activity.music_performance" />
                    <br><br>
                    <div>
                        <button class="can-edu-btn-fill" @click="saveNewActivity('music_performance')">
                            Save
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-full mt-2 relative">
                <div class="flex justify-between items-center">
                    <label class="block text-base lg:text-lg">Social activism (Check all that apply)</label>
                    <button @click="toggleAddNew('social_activism')" class="can-edu-btn-fill">
                        Add new social activism
                    </button>
                </div>

                <div
                    class="mt-2 border w-full border-l-[5px] border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300 p-4">
                    <div v-for="activity in filteredActivities('social_activism')" :key="activity.id"
                        class="flex items-center space-x-2">
                        <input type="checkbox" :value="activity.id" v-model="social_activism_ids"
                            class="form-checkbox h-5 w-5 text-primary" />
                        <span class="text-lg">{{ activity?.details?.[0]?.name || "" }}</span>
                    </div>
                </div>

                <div class="w-full mt-2 relative" v-if="add_new.social_activism">
                    <label class="block text-base lg:text-lg">Add desired social activism activity</label>
                    <input type="text"
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        placeholder="Please enter activity name" v-model="new_activity.social_activism" />
                    <br><br>
                    <div>
                        <button class="can-edu-btn-fill" @click="saveNewActivity('social_activism')">
                            Save
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-full mt-2 relative">
                <div class="flex justify-between items-center">
                    <label class="block text-base lg:text-lg">Technology (Check all that apply)</label>
                    <button @click="toggleAddNew('technology')" class="can-edu-btn-fill">
                        Add new technology
                    </button>
                </div>

                <div
                    class="mt-2 border w-full border-l-[5px] border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300 p-4">
                    <div v-for="activity in filteredActivities('technology')" :key="activity.id"
                        class="flex items-center space-x-2">
                        <input type="checkbox" :value="activity.id" v-model="technology_ids"
                            class="form-checkbox h-5 w-5 text-primary" />
                        <span class="text-lg">{{ activity?.details?.[0]?.name || "" }}</span>
                    </div>
                </div>

                <div class="w-full mt-2 relative" v-if="add_new.technology">
                    <label class="block text-base lg:text-lg">Add desired technology activity</label>
                    <input type="text"
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        placeholder="Please enter activity name" v-model="new_activity.technology" />
                    <br><br>
                    <div>
                        <button class="can-edu-btn-fill" @click="saveNewActivity('technology')">
                            Save
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-full mt-2 relative">
                <div class="flex justify-between items-center">
                    <label class="block text-base lg:text-lg">Entrepreneurship (Check all that apply)</label>
                    <button @click="toggleAddNew('entrepreneurship')" class="can-edu-btn-fill">
                        Add new entrepreneurship
                    </button>
                </div>

                <div
                    class="mt-2 border w-full border-l-[5px] border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300 p-4">
                    <div v-for="activity in filteredActivities('entrepreneurship')" :key="activity.id"
                        class="flex items-center space-x-2">
                        <input type="checkbox" :value="activity.id" v-model="entrepreneurship_ids"
                            class="form-checkbox h-5 w-5 text-primary" />
                        <span class="text-lg">{{ activity?.details?.[0]?.name || "" }}</span>
                    </div>
                </div>

                <div class="w-full mt-2 relative" v-if="add_new.entrepreneurship">
                    <label class="block text-base lg:text-lg">Add desired entrepreneurship activity</label>
                    <input type="text"
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        placeholder="Please enter activity name" v-model="new_activity.entrepreneurship" />
                    <br><br>
                    <div>
                        <button class="can-edu-btn-fill" @click="saveNewActivity('entrepreneurship')">
                            Save
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-full mt-2 relative">
                <div class="flex justify-between items-center">
                    <label class="block text-base lg:text-lg">Environmental (Check all that apply)</label>
                    <button @click="toggleAddNew('environmental')" class="can-edu-btn-fill">
                        Add new environmental
                    </button>
                </div>

                <div
                    class="mt-2 border w-full border-l-[5px] border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300 p-4">
                    <div v-for="activity in filteredActivities('environmental')" :key="activity.id"
                        class="flex items-center space-x-2">
                        <input type="checkbox" :value="activity.id" v-model="environmental_ids"
                            class="form-checkbox h-5 w-5 text-primary" />
                        <span class="text-lg">{{ activity?.details?.[0]?.name || "" }}</span>
                    </div>
                </div>

                <div class="w-full mt-2 relative" v-if="add_new.environmental">
                    <label class="block text-base lg:text-lg">Add desired environmental activity</label>
                    <input type="text"
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        placeholder="Please enter activity name" v-model="new_activity.environmental" />
                    <br><br>
                    <div>
                        <button class="can-edu-btn-fill" @click="saveNewActivity('environmental')">
                            Save
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-full mt-2 relative">
                <div class="flex justify-between items-center">
                    <label class="block text-base lg:text-lg">Health wellness (Check all that apply)</label>
                    <button @click="toggleAddNew('health_wellness')" class="can-edu-btn-fill">
                        Add new health wellness
                    </button>
                </div>

                <div
                    class="mt-2 border w-full border-l-[5px] border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300 p-4">
                    <div v-for="activity in filteredActivities('health_wellness')" :key="activity.id"
                        class="flex items-center space-x-2">
                        <input type="checkbox" :value="activity.id" v-model="health_wellness_ids"
                            class="form-checkbox h-5 w-5 text-primary" />
                        <span class="text-lg">{{ activity?.details?.[0]?.name || "" }}</span>
                    </div>
                </div>

                <div class="w-full mt-2 relative" v-if="add_new.health_wellness">
                    <label class="block text-base lg:text-lg">Add desired health wellness activity</label>
                    <input type="text"
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        placeholder="Please enter activity name" v-model="new_activity.health_wellness" />
                    <br><br>
                    <div>
                        <button class="can-edu-btn-fill" @click="saveNewActivity('health_wellness')">
                            Save
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-full mt-2 relative">
                <div class="flex justify-between items-center">
                    <label class="block text-base lg:text-lg">Stem competitions (Check all that apply)</label>
                    <button @click="toggleAddNew('stem_competitions')" class="can-edu-btn-fill">
                        Add new stem competitions
                    </button>
                </div>

                <div
                    class="mt-2 border w-full border-l-[5px] border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300 p-4">
                    <div v-for="activity in filteredActivities('stem_competitions')" :key="activity.id"
                        class="flex items-center space-x-2">
                        <input type="checkbox" :value="activity.id" v-model="stem_competitions_ids"
                            class="form-checkbox h-5 w-5 text-primary" />
                        <span class="text-lg">{{ activity?.details?.[0]?.name || "" }}</span>
                    </div>
                </div>

                <div class="w-full mt-2 relative" v-if="add_new.stem_competitions">
                    <label class="block text-base lg:text-lg">Add desired stem competitions activity</label>
                    <input type="text"
                        class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                        placeholder="Please enter activity name" v-model="new_activity.stem_competitions" />
                    <br><br>
                    <div>
                        <button class="can-edu-btn-fill" @click="saveNewActivity('stem_competitions')">
                            Save
                        </button>
                    </div>
                </div>
            </div>






            <!-- <div class="w-full mt-2 relative">
                <div class="flex justify-between items-center">
                    <label for="" class="block text-base lg:text-lg">
                        Curricular activities (Check all the ones that apply)
                    </label>
                    <button @click="toggleAddNewCurricular" class="can-edu-btn-fill">
                        Add new curricular activity
                    </button>
                </div>

                <div
                    class="mt-2 border w-full border-l-[5px] border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300 p-4">
                    <div v-for="(curricular, key) in sortedCurricularActivities" :key="key"
                        class="flex items-center space-x-2">
                        <input type="checkbox" :value="curricular.id" v-model="curricular_id"
                            class="form-checkbox h-5 w-5 text-primary" />
                        <span class="text-lg">{{ curricular?.curricular_activity_detail?.[0]?.name || "" }}</span>
                    </div>
                </div>

                <error :fieldName="`curricular_id`" :validationErros="errors" />
            </div>

            <div class="w-full mt-2 relative" v-if="add_curricular">
                <label for="" class="block text-base lg:text-lg">Add desired curricular activity</label>
                <input type="text"
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    placeholder="Please enter curricular activity name" v-model="new_curricular" />
                <br /><br />
                <div>
                    <button class="can-edu-btn-fill" @click="saveNewCurricular">
                        Save
                    </button>
                </div>
            </div> -->

            <div class="w-full mt-2 relative">
                <div class="flex justify-between items-center">
                    <label for="" class="block text-base lg:text-lg">
                        Community service (Check all the ones that apply)
                    </label>
                    <button @click="toggleAddNewCS" class="can-edu-btn-fill">
                        Add new community service
                    </button>
                </div>
                <div
                    class="mt-2 border w-full border-l-[5px] border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300 p-4">
                    <div v-for="(cs, key) in comunity_services_array" :key="key" class="flex items-center space-x-2">
                        <input type="checkbox" :value="cs?.id" v-model="community_service"
                            class="form-checkbox h-5 w-5 text-primary" />
                        <span class="text-lg">
                            {{ cs?.comunity_service_detail[0].name || "" }}
                        </span>
                    </div>
                </div>
                <error :fieldName="`community_service`" :validationErros="errors" />
            </div>
            <div class="w-full mt-2 relative" v-if="add_cs">
                <label for="" class="block text-base lg:text-lg">Add desired community service</label>
                <input type="text"
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    placeholder="Please enter community service name" v-model="new_community_service" />
                <br /><br />
                <div>
                    <button class="can-edu-btn-fill" @click="saveNewCommunityService">
                        Save
                    </button>
                </div>
            </div>

            <!-- <div class="w-full mt-2 relative">
                <label
                    for=""
                    class="block text-base lg:text-lg"
                    >Conditional Acceptance</label
                >
                <select
                    class="mt-2 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded lg:text-lg border-gray-300"
                    v-model="conditional_acceptance"
                >
                    <option value="all" :selected="conditional_acceptance == 'all'">
                        All
                    </option>
                    <option value="yes" :selected="conditional_acceptance == 'yes'">
                        Yes
                    </option>
                    <option value="no" :selected="conditional_acceptance == 'no'">
                        No
                    </option>
                </select>
                <error
                    :fieldName="`conditional_acceptance`"
                    :validationErros="errors"
                />
            </div> -->
            <div class="flex justify-end items-center gap-3 mt-4">
                <div>
                    <button class="can-edu-btn-fill" @click="addUpdate">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
    <transition name="slide">
        <div id="defaultModal" tabindex="-1" aria-hidden="true"
            class="bg-black bg-opacity-50 inset-0 fixed flex justify-center items-center h-screen z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 md:h-full"
            v-if="showPopUpModal">
            <div class="relative w-full rounded-2xl shadow-2xl bg-white border-4 border-primary/30 h-full max-w-lg md:h-auto"
                ref="elementToDetectClick">
                <div class="relative">
                    <div class="absolute top-3 right-3 cursor-pointer" @click="togglePopUpModal">
                        <button type="button"
                            class="text-gray-400 bg-white hover:bg-gray-200 hover:text-gray-900 rounded-full border border-primary text-sm p-1 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="defaultModal">
                            <svg aria-hidden="true" class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="bg-white py-6 px-10 rounded-2xl shadow-2xl pt-10 ">
                        <p class="text-center can-edu-p mt-2">
                            {{
                                popupMsg
                            }} </p>
                        <div class="flex justify-center">
                            <button type="button" class="can-edu-btn-fill  whitespace-nowrap px-2.5 md:px-5 mt-4"
                                @click="togglePopUpModal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
<script>
import axios from "axios";
import { mapState } from "vuex";
import ErrorHandling from "../../ErrorHandling";
import Error from "../Error.vue";
export default {
    components: { Error },
    props: ["logged_in_customer", "school_id", "school_demetra_setting"],
    computed: {
        ...mapState({
            sports: (state) => state.sports.sports,
            // curricular_activities: (state) => state.curricular_activities?.curricular_activities || [],
            comunity_services: (state) =>
                state.comunity_services.comunity_services,
            programs: (state) => state.programs.programs,
            activities: (state) => state.activities.activities,
        }),
        filteredActivities() {
            return (type) => {
                return this.activities
                    ?.filter((activity) => activity?.status == 1 && activity.type === type)
                    .slice()
                    .sort((a, b) => {
                        let nameA = a?.details?.[0]?.name?.toLowerCase() || "";
                        let nameB = b?.details?.[0]?.name?.toLowerCase() || "";
                        return nameA.localeCompare(nameB);
                    });
            };
        },
        sortedSports() {
            return this.sports
                ?.filter((sport) => sport?.status == 1)
                .slice()
                .sort((a, b) => {
                    let nameA = a?.sport_detail?.[0]?.name?.toLowerCase() || "";
                    let nameB = b?.sport_detail?.[0]?.name?.toLowerCase() || "";
                    return nameA.localeCompare(nameB);
                });
        },
        // sortedCurricularActivities() {
        //     return (this.curricular_activities || [])
        //         ?.filter((curricular) => curricular?.status == 1)
        //         .slice()
        //         .sort((a, b) => {
        //             let nameA = a?.curricular_activity_detail?.[0]?.name?.toLowerCase() || "";
        //             let nameB = b?.curricular_activity_detail?.[0]?.name?.toLowerCase() || "";
        //             return nameA.localeCompare(nameB);
        //         });
        // },
        comunity_services_array() {
            return this.comunity_services
                ?.filter((comunity_service) => comunity_service?.status == 1)
                .slice()
                .sort((a, b) => {
                    let nameA = a?.comunity_service_detail?.[0]?.name?.toLowerCase() || "";
                    let nameB = b?.comunity_service_detail?.[0]?.name?.toLowerCase() || "";
                    return nameA.localeCompare(nameB);
                });
        },
    },
    data() {
        return {
            activeTab: "en",
            sport_id: [],
            // curricular_id: [],
            min_cgpa: "",
            community_service: [],
            extracurricular_ids: [],
            curricular_ids: [],
            leadership_ids: [],
            media_ids: [],
            music_performance_ids: [],
            social_activism_ids: [],
            technology_ids: [],
            entrepreneurship_ids: [],
            stem_competitions_ids: [],
            health_wellness_ids: [],
            environmental_ids: [],
            add_new: {
                curricular: false,
                extracurricular: false,
                leadership: false,
                media: false,
                music_performance: false,
                social_activism: false,
                technology: false,
                entrepreneurship: false,
                stem_competitions: false,
                health_wellness: false,
                environmental: false,
                // Add other types...
            },
            new_activity: {
                curricular: "",
                extracurricular: "",
                leadership: "",
                media: "",
                music_performance: "",
                social_activism: "",
                technology: "",
                entrepreneurship: "",
                stem_competitions: "",
                health_wellness: "",
                environmental: "",
                // Add other types...
            },
            conditional_acceptance: false,
            school_demetra_setting_object: "",
            new_sport: "",
            new_curricular: "",
            new_community_service: "",
            new_conditional_acceptance: "",
            errors: new ErrorHandling(),
            add_cs: false,
            add_sport: false,
            add_curricular: false,
            showPopUpModal: false,
            popupMsg: ''
        };
    },
    methods: {
        togglePopUpModal() {
            this.showPopUpModal = !this.showPopUpModal;
            if (!this.showPopUpModal) {
                window.location.reload();
            }
        },
        handleClickOutsidePopup(event) {
            // // Check if the click target is not within the element
            if (
                this.$refs.elementToDetectClick &&
                event.target.contains(this.$refs.elementToDetectClick)
            ) {
                // Clicked outside the element, you can perform actions here
                if (this.showPopUpModal == true) {
                    this.showPopUpModal = false;
                    window.location.reload();
                }
            }
        },
        clearError(field) {
            if (this.errors.has(field)) {
                this.errors.clear(field);
            }
        },
        toggleAddNewCS() {
            this.add_cs = !this.add_cs;
        },
        toggleAddNewSport() {
            this.add_sport = !this.add_sport;
        },
        toggleAddNewCurricular() {
            this.add_curricular = !this.add_curricular;
        },
        toggleAddNew(type) {
            this.add_new[type] = !this.add_new[type];
            this.new_activity[type] = "";
        },
        handleSport(sport) {
            this.sport_id = sport;
        },
        addUpdate() {
            var data = {
                school_id: this.school_id,
                sport_id: this.sport_id,
                extracurricular_ids: this.extracurricular_ids,
                curricular_ids: this.curricular_ids,
                leadership_ids: this.leadership_ids,
                media_ids: this.media_ids,
                music_performance_ids: this.music_performance_ids,
                technology_ids: this.technology_ids,
                social_activism_ids: this.social_activism_ids,
                entrepreneurship_ids: this.entrepreneurship_ids,
                stem_competitions_ids: this.stem_competitions_ids,
                health_wellness_ids: this.health_wellness_ids,
                environmental_ids: this.environmental_ids,
                // curricular_id: this.curricular_id,
                min_cgpa: this.min_cgpa,
                max_cgpa: this.max_cgpa,
                community_service: this.community_service,
                conditional_acceptance: this.conditional_acceptance,
            };
            axios
                .post("/api/web/demetra-setting", data)
                .then((res) => {
                    console.log('res creating re', res)
                    this.errors = new ErrorHandling();
                    if (res.data.status == "Success") {
                        this.showPopUpModal = true;
                        this.popupMsg = res.data.message;

                    } else {
                        helper.swalErrorMessage(res.data.message);
                    }
                })
                .catch((error) => {
                    if (error.response && error.response.status == 422) {
                        this.errors.record(error.response.data.errors);
                    } else if (
                        error.response &&
                        error.response.data &&
                        error.response.data.status == "Error"
                    ) {
                        helper.swalErrorMessage(error.response.data.message);
                    }
                });
            ;
        },
        saveNewCommunityService() {
            if (this.new_community_service.trim() == "") {
                helper.swalErrorMessage("Please enter Comunity service name");
            } else {
                axios
                    .post("/api/web/save-comunity-service", {
                        name: this.new_community_service,
                    })
                    .then((res) => {
                        this.errors = new ErrorHandling();
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            this.$store.commit(
                                "comunity_services/setLimit",
                                2000
                            );
                            this.$store.commit(
                                "comunity_services/setSortBy",
                                "id"
                            );
                            this.$store.commit(
                                "comunity_services/setSortType",
                                "desc"
                            );
                            this.$store.dispatch(
                                "comunity_services/fetchComunityServices"
                            );
                            this.new_community_service = "";
                            this.add_cs = false;
                        } else {
                            helper.swalErrorMessage(res.data.message);
                        }
                    });
            }
        },
        saveNewSport() {
            if (this.new_sport.trim() == "") {
                helper.swalErrorMessage("Please enter sport name");
            } else {
                axios
                    .post("/api/web/save-sport", {
                        name: this.new_sport,
                    })
                    .then((res) => {
                        this.errors = new ErrorHandling();
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            this.$store.commit("sports/setLimit", 2000);
                            this.$store.commit("sports/setSortBy", "id");
                            this.$store.commit("sports/setSortType", "desc");
                            this.$store.dispatch("sports/fetchSports");
                            this.new_sport = "";
                            this.add_sport = false;
                        } else {
                            helper.swalErrorMessage(res.data.message);
                        }
                    });
            }
        },
        saveNewCurricular() {
            if (this.new_curricular.trim() == "") {
                helper.swalErrorMessage("Please enter curricular activity name");
            } else {
                axios
                    .post("/api/web/save-curricular-activity", {
                        name: this.new_curricular,
                    })
                    .then((res) => {
                        this.errors = new ErrorHandling();
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            this.$store.commit("curricular_activities/setLimit", 2000);
                            this.$store.commit("curricular_activities/setSortBy", "id");
                            this.$store.commit("curricular_activities/setSortType", "desc");
                            this.$store.dispatch("curricular_activities/fetchCurricularActivities");
                            this.new_curricular = "";
                            this.add_curricular = false;
                        } else {
                            helper.swalErrorMessage(res.data.message);
                        }
                    });
            }
        },
        saveNewActivity(type) {
            if (this.new_activity[type].trim() === "") {
                helper.swalErrorMessage(`Please enter ${this.getTypeName(type)} name`);
                return;
            }

            this.$store.dispatch("activities/saveDefaultLanguageActivity", {
                name: this.new_activity[type],
                type: type
            })
                .then((res) => {
                    if (res.data.status == "Success") {
                        console.log('acticvity res', res);
                        helper.swalSuccessMessage(res.data.message);
                        this.$store.commit("activities/setLimit", 2000);
                        this.$store.commit("activities/setSortBy", "id");
                        this.$store.commit("activities/setSortType", "desc");
                        this.$store.dispatch("activities/fetchActivities");
                        this.new_activity[type] = "";
                        this.add_new[type] = false;
                    }
                })
                .catch((error) => {
                    if (error.response && error.response.status == 422) {
                        this.errors.record(error.response.data.errors);
                    }
                });
        },
        getTypeName(type) {
            const typeNames = {
                curricular: 'curricular activity',
                extracurricular: 'extracurricular activity',
                leadership: 'leadership activity',
                media: 'media',
                music_performance: 'music performance',
                social_activism: 'social activism',
                technology: 'technology',
                entrepreneurship: 'entrepreneurship',
                stem_competitions: 'stem_competitions',
                health_wellness: 'health wellness',
                environmental: 'environmental',
            };
            return typeNames[type] || type;
        },
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutsidePopup);
    },
    mounted() {
        document.addEventListener("click", this.handleClickOutsidePopup);

        this.$store.commit("activities/setLimit", 2000);
        this.$store.commit("activities/setSortBy", "id");
        this.$store.commit("activities/setSortType", "desc");
        this.$store.dispatch("activities/fetchActivities");

        this.$store.commit("sports/setLimit", 2000);
        this.$store.commit("sports/setSortBy", "id");
        this.$store.commit("sports/setSortType", "desc");
        this.$store.dispatch("sports/fetchSports");

        this.$store.commit("curricular_activities/setLimit", 2000);
        this.$store.commit("curricular_activities/setSortBy", "id");
        this.$store.commit("curricular_activities/setSortType", "desc");
        this.$store.dispatch("curricular_activities/fetchCurricularActivities");

        this.$store.commit("comunity_services/setLimit", 2000);
        this.$store.commit("comunity_services/setSortBy", "id");
        this.$store.commit("comunity_services/setSortType", "desc");
        this.$store.dispatch("comunity_services/fetchComunityServices");

        this.school_demetra_setting_object = JSON.parse(
            this.school_demetra_setting
        );

        // Load existing selections if editing
        if (this.school_demetra_setting_object?.activities) {

            this.curricular_ids = this.school_demetra_setting_object.activities
                .filter(a => a.type === 'curricular')
                .map(a => a.activity_id);
            this.extracurricular_ids = this.school_demetra_setting_object.activities
                .filter(a => a.type === 'extracurricular')
                .map(a => a.activity_id);
            this.leadership_ids = this.school_demetra_setting_object.activities
                .filter(a => a.type === 'leadership')
                .map(a => a.activity_id);
            this.media_ids = this.school_demetra_setting_object.activities
                .filter(a => a.type === 'media')
                .map(a => a.activity_id);
            this.music_performance_ids = this.school_demetra_setting_object.activities
                .filter(a => a.type === 'music_performance')
                .map(a => a.activity_id);
            this.social_activism_ids = this.school_demetra_setting_object.activities
                .filter(a => a.type === 'social_activism')
                .map(a => a.activity_id);
            this.technology_ids = this.school_demetra_setting_object.activities
                .filter(a => a.type === 'technology')
                .map(a => a.activity_id);
            this.entrepreneurship_ids = this.school_demetra_setting_object.activities
                .filter(a => a.type === 'entrepreneurship')
                .map(a => a.activity_id);
            this.stem_competitions_ids = this.school_demetra_setting_object.activities
                .filter(a => a.type === 'stem_competitions')
                .map(a => a.activity_id);
            this.health_wellness_ids = this.school_demetra_setting_object.activities
                .filter(a => a.type === 'health_wellness')
                .map(a => a.activity_id);
            this.environmental_ids = this.school_demetra_setting_object.activities
                .filter(a => a.type === 'environmental')
                .map(a => a.activity_id);

            // Load other types...
        }


        if (this.school_demetra_setting_object) {
            this.min_cgpa = this.school_demetra_setting_object?.min_cgpa;
            this.max_cgpa = this.school_demetra_setting_object?.max_cgpa;
            this.conditional_acceptance =
                this.school_demetra_setting_object?.conditional_acceptance;
            this.community_service = [];

            this.school_demetra_setting_object?.community_services?.map(
                (obj) => {
                    this.community_service.push(obj.comunity_service_id);
                }
            );

            this.sport_id = [];

            this.school_demetra_setting_object?.sports?.map(
                (obj) => {
                    this.sport_id.push(obj.sport_id);
                }
            );

            // this.curricular_id = [];

            // this.school_demetra_setting_object?.curricular_activities?.map(
            //     (obj) => {
            //         this.curricular_id.push(obj.curricular_id);
            //     }
            // );
        }
        console.log('res asdasdasdqweqwe', this.school_demetra_setting_object);

    },
};
</script>

<style scoped>
/* Slide Animation */
.slide-enter-active,
.slide-leave-active {
    transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
}

.slide-enter-from,
.slide-leave-to {
    transform: translateY(-20px);
    opacity: 0;
}
</style>