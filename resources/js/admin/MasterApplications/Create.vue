<template>
    <AppLayout>
        <div class="relative shadow-md rounded-lg bg-white py-4">
            <header class="">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="can-edu-h1">View master application</h1>
                        <router-link :to="{ name: 'admin.master-applications.index' }" class="can-edu-btn-fill">
                            Back
                        </router-link>
                    </div>
                </div>
            </header>
            <form class="px-4 md:px-6 lg:px-8" @submit.prevent="addUpdateForm()">
                <div class="grid my-5 md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full group">
                        <label for="for_demetra_or_master_app" class="block text-base lg:text-lg">
                            Reason for Filling the Master Application
                        </label>
                        <input type="text" disabled name="for_demetra_or_master_app" id="for_demetra_or_master_app"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleInput($event.target.value, 'for_demetra_or_master_app')"
                            :value="formattedReason" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`for_demetra_or_master_app`)"
                            v-text="validationErros.get(`for_demetra_or_master_app`)">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="school_id" class="block text-base lg:text-lg">Your school</label>
                        <input type="text" disabled name="school_id" id="school_id"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" "
                            :value="form.school && form.school.school_detail && form.school.school_detail.length > 0 ? form.school.school_detail[0].school_name : ''" />
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="first_name" class="block text-base lg:text-lg">First Name</label>
                        <input type="text" disabled name="first_name" id="first_name"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleInput($event.target.value, 'first_name')"
                            :value="form['first_name'] ? form['first_name'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`first_name`)"
                            v-text="validationErros.get(`first_name`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="last_name" class="block text-base lg:text-lg">Last Name</label>
                        <input type="text" disabled name="last_name" id="last_name"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleInput($event.target.value, 'last_name')"
                            :value="form['last_name'] ? form['last_name'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`last_name`)"
                            v-text="validationErros.get(`last_name`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="dob" class="block text-base lg:text-lg">Date of birth</label>
                        <input type="text" disabled name="dob" id="dob"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleInput($event.target.value, 'dob')"
                            :value="form['dob'] ? form['dob'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`dob`)"
                            v-text="validationErros.get(`dob`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="gender" class="block text-base lg:text-lg">Gender</label>
                        <input type="text" disabled name="gender" id="gender"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleInput($event.target.value, 'gender')"
                            :value="form['gender'] ? form['gender'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`gender`)"
                            v-text="validationErros.get(`gender`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="email" class="block text-base lg:text-lg">Email address</label>
                        <input type="text" disabled name="email" id="email"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleInput($event.target.value, 'email')"
                            :value="form['email'] ? form['email'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`email`)"
                            v-text="validationErros.get(`email`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="confirm_email" class="block text-base lg:text-lg">Confirm e-mail address</label>
                        <input type="text" disabled name="confirm_email" id="confirm_email"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleInput($event.target.value, 'confirm_email')"
                            :value="form['confirm_email'] ? form['confirm_email'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`confirm_email`)"
                            v-text="validationErros.get(`confirm_email`)"></p>
                    </div>


                    <div class="relative z-0 w-full group">
                        <label for="phone" class="block text-base lg:text-lg">Cell phone number</label>
                        <input type="text" disabled name="phone" id="phone"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleInput($event.target.value, 'phone')"
                            :value="form['phone'] ? form['phone'] : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`phone`)"
                            v-text="validationErros.get(`phone`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="can_school_text_you" class="block text-base lg:text-lg">Can school text you?</label>
                        <input type="text" disabled name="can_school_text_you" id="can_school_text_you"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleInput(
                                    $event.target.value,
                                    'can_school_text_you'
                                )
                                " :value="form['can_school_text_you']
                                    ? form['can_school_text_you']
                                    : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`can_school_text_you`)"
                            v-text="validationErros.get(`can_school_text_you`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="where_want_to_study" class="block text-base lg:text-lg">Where do you want to study -
                            select province(s)</label>
                        <div id="where_want_to_study"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary">
                            <!-- Use v-for to loop through where_want_to_study -->
                            <span v-for="(a, index) in where_want_to_study" :key="index" class="block">
                                {{ a.text || a }} <!-- Fallback to `a` if `a.text` doesn't exist -->
                            </span>
                        </div>
                        <!-- Display validation error if it exists -->
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has('where_want_to_study')"
                            v-text="validationErros.get('where_want_to_study')"></p>
                    </div>
                    <!-- <div class="relative z-0 w-full group">
                        <label for="country_of_citizenship" class="block text-base lg:text-lg">Country of
                            citizenship</label>
                        <input type="text" disabled name="country_of_citizenship" id="country_of_citizenship"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleInput(
                                    $event.target.value,
                                    'country_of_citizenship'
                                )
                                " :value="form['country_of_citizenship']
                                ? form['country_of_citizenship']
                                : ''
                            " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`country_of_citizenship`)"
                            v-text="validationErros.get(`country_of_citizenship`)"></p>
                    </div>
                 -->
                    <div class="relative z-0 w-full group">
                        <label for="country_of_citizenship" class="block text-base lg:text-lg">
                            What is your country of citizenship?
                        </label>
                        <div id="country_of_citizenship"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary">
                            <span v-for="(code, index) in country_of_citizenship" :key="index" class="block">
                                {{ getCountryName(code) }}
                            </span>
                        </div>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has('country_of_citizenship')"
                            v-text="validationErros.get('country_of_citizenship')">
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="live_in_your_country_citizenship" class="block text-base lg:text-lg">Are you
                            currently residing in your country of citizenship?</label>
                        <input type="text" disabled name="live_in_your_country_citizenship"
                            id="live_in_your_country_citizenship"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleInput(
                                    $event.target.value,
                                    'live_in_your_country_citizenship'
                                )
                                " :value="form['live_in_your_country_citizenship']
                                    ? form['live_in_your_country_citizenship']
                                    : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(
                                `live_in_your_country_citizenship`
                            )
                        " v-text="validationErros.get(
                            `live_in_your_country_citizenship`
                        )
                            "></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="current_residance" class="block text-base lg:text-lg">Where do you currently
                            reside?</label>
                        <input type="text" disabled name="current_residance" id="current_residance"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleInput(
                                    $event.target.value,
                                    'current_residance'
                                )
                                " :value="form['current_residance']
                                    ? getCountryName(form['current_residance'])
                                    : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`current_residance`)"
                            v-text="validationErros.get(`current_residance`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="current_residance_status" class="block text-base lg:text-lg">Status in the country
                            of residence</label>
                        <input type="text" disabled name="current_residance_status" id="current_residance_status"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleInput(
                                    $event.target.value,
                                    'current_residance_status'
                                )
                                " :value="form['current_residance_status']
                                    ? form['current_residance_status']
                                    : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`current_residance_status`)"
                            v-text="validationErros.get(`current_residance_status`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="mailing_address" class="block text-base lg:text-lg">Mailing address in the currently
                            where you currently reside</label>
                        <input type="text" disabled name="mailing_address" id="mailing_address"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleInput($event.target.value, 'mailing_address')
                                " :value="form['mailing_address']
                                    ? form['mailing_address']
                                    : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`mailing_address`)"
                            v-text="validationErros.get(`mailing_address`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="high_school_name" class="block text-base lg:text-lg">High school name</label>
                        <input type="text" disabled name="high_school_name" id="high_school_name"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleInput($event.target.value, 'high_school_name')
                                " :value="form['high_school_name']
                                    ? form['high_school_name']
                                    : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`high_school_name`)"
                            v-text="validationErros.get(`high_school_name`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="high_school_cgpa" class="block text-base lg:text-lg">High school GPA</label>
                        <input type="text" disabled name="high_school_cgpa" id="high_school_cgpa"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleInput($event.target.value, 'high_school_cgpa')
                                " :value="form['high_school_cgpa']
                                    ? form['high_school_cgpa']
                                    : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`high_school_cgpa`)"
                            v-text="validationErros.get(`high_school_cgpa`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="high_school_country" class="block text-base lg:text-lg">High school location -
                            country</label>
                        <input type="text" disabled name="high_school_country" id="high_school_country"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleInput(
                                    $event.target.value,
                                    'high_school_country'
                                )
                                " :value="form['high_school_country']
                                    ? getCountryName(form['high_school_country'])
                                    : ''" />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`high_school_country`)"
                            v-text="validationErros.get(`high_school_country`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="high_school_city" class="block text-base lg:text-lg">High school location -
                            city</label>
                        <input type="text" disabled name="high_school_city" id="high_school_city"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleInput($event.target.value, 'high_school_city')
                                " :value="form['high_school_city']
                                    ? form['high_school_city']
                                    : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`high_school_city`)"
                            v-text="validationErros.get(`high_school_city`)"></p>
                    </div>

                    <div class="relative z-0 w-full group">
                        <label for="when_plan_to_start" class="block text-base lg:text-lg">When are you planning to
                            start?</label>
                        <input type="text" disabled name="when_plan_to_start" id="when_plan_to_start"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleInput(
                                    $event.target.value,
                                    'when_plan_to_start'
                                )
                                " :value="form['when_plan_to_start']
                                    ? form['when_plan_to_start'].replace(/[^a-zA-Z0-9]/g, ' ')
                                    : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`when_plan_to_start`)"
                            v-text="validationErros.get(`when_plan_to_start`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="interested_in" class="block text-base lg:text-lg">I am interested in</label>
                        <input type="text" disabled name="interested_in" id="interested_in"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleInput($event.target.value, 'interested_in')
                                " :value="form?.interested_in?.degree_detail?.length > 0
                                    ? form?.interested_in?.degree_detail[0]?.name
                                    : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`interested_in`)"
                            v-text="validationErros.get(`interested_in`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="student_type" class="block text-base lg:text-lg">I am this kind of student</label>
                        <input type="text" disabled name="student_type" id="student_type"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleInput($event.target.value, 'student_type')
                                " :value="form['student_type'] ? form['student_type'].replace(/[^a-zA-Z0-9]/g, ' ') : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`student_type`)"
                            v-text="validationErros.get(`student_type`)"></p>
                    </div>
                    <!-- <div class="relative z-0 w-full group">
                        <label for="tuition_funding_source" class="block text-base lg:text-lg">Tuition fees source(s)</label>
                            <div  id="tuition_funding_source"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary">
                        <span v-for="a in tuition_funding_source">
                            {{ a.replace(/[^a-zA-Z0-9]/g, ' ') }}                        </span>
                        </div>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`tuition_funding_source`)"
                            v-text="validationErros.get(`tuition_funding_source`)"></p>
                    </div> -->
                    <div class="relative z-0 w-full group">
                        <label for="tuition_funding_source" class="block text-base lg:text-lg">Tuition fees
                            source(s)</label>
                        <div id="tuition_funding_source"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary">

                            <span v-if="tuition_funding_source && tuition_funding_source.length">
                                {{ formattedTuitionSources }}
                            </span>

                        </div>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`tuition_funding_source`)"
                            v-text="validationErros.get(`tuition_funding_source`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="addtional" class="block text-base lg:text-lg">Anything else to add?</label>
                        <textarea type="text" disabled name="addtional" id="addtional"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleInput($event.target.value, 'addtional')">{{
                                form["addtional"] ? form["addtional"] : ""
                            }}</textarea>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`addtional`)"
                            v-text="validationErros.get(`addtional`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="add_anything" class="block text-base lg:text-lg">Your Bio</label>
                        <textarea type="text" disabled name="add_anything" id="add_anything"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleInput($event.target.value, 'add_anything')
                                ">{{
                                    form["add_anything"] ? form["add_anything"] : ""
                                }}</textarea>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`add_anything`)"
                            v-text="validationErros.get(`add_anything`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="study_permit_candian_embassy" class="block text-base lg:text-lg">Do you already have
                            a study permit (a student visa) to study in Canada?</label>
                        <input type="text" disabled name="study_permit_candian_embassy"
                            id="study_permit_candian_embassy"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleInput(
                                    $event.target.value,
                                    'study_permit_candian_embassy'
                                )
                                " :value="form['study_permit_candian_embassy']
                                    ? form['study_permit_candian_embassy']
                                    : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(`study_permit_candian_embassy`)
                        " v-text="validationErros.get(`study_permit_candian_embassy`)
                            "></p>
                    </div>

                    <div class="relative z-0 w-full group">
                        <label for="currently_student_anywhere" class="block text-base lg:text-lg">Are you currently a
                            student anywhere?</label>
                        <input type="text" disabled name="currently_student_anywhere" id="currently_student_anywhere"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleInput(
                                    $event.target.value,
                                    'currently_student_anywhere'
                                )
                                " :value="form['currently_student_anywhere']
                                    ? form['currently_student_anywhere']
                                    : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(`currently_student_anywhere`)
                        " v-text="validationErros.get(`currently_student_anywhere`)
                            "></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="currently_living_in_canada" class="block text-base lg:text-lg">Are you a transfer
                            student currently living in Canada?</label>
                        <input type="text" disabled name="currently_living_in_canada" id="currently_living_in_canada"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="
                                handleInput(
                                    $event.target.value,
                                    'currently_living_in_canada'
                                )
                                " :value="form['currently_living_in_canada']
                                    ? form['currently_living_in_canada']
                                    : ''
                                    " />
                        <p class="mt-2 text-base text-primary" v-if="
                            validationErros.has(`currently_living_in_canada`)
                        " v-text="validationErros.get(`currently_living_in_canada`)
                            "></p>
                    </div>



                    <!-- <div v-if="form.for_demetra_or_master_app" class="relative z-0 w-full group">
                        <label for="for_demetra_or_master_app" class="block text-base lg:text-lg">Reasons for
                            Admission</label>
                        <textarea type="text" disabled name="for_demetra_or_master_app" id="for_demetra_or_master_app"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleInput($event.target.value, 'for_demetra_or_master_app')">{{ form["for_demetra_or_master_app"] && (form["for_demetra_or_master_app"] == 'apply_myself' || form["for_demetra_or_master_app"] == 'both') ? "Apply Myself" : "" }}
{{ form["for_demetra_or_master_app"] && (form["for_demetra_or_master_app"] == 'reverse_admissions' || form["for_demetra_or_master_app"] == 'both') ? "Reverse Admission" : "" }}
                        </textarea>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`for_demetra_or_master_app`)"
                            v-text="validationErros.get(`for_demetra_or_master_app`)"></p>
                    </div> -->

                    <div class="relative z-0 w-full group">
                        <label for="statement_of_purpose" class="block text-base lg:text-lg">Statement of
                            Purpose</label>
                        <textarea type="text" disabled name="statement_of_purpose" id="statement_of_purpose"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleInput($event.target.value, 'statement_of_purpose')">{{
                                form["statement_of_purpose"] ? form["statement_of_purpose"] : ""
                            }}</textarea>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`statement_of_purpose`)"
                            v-text="validationErros.get(`statement_of_purpose`)"></p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <label for="letter_of_intent" class="block text-base lg:text-lg">Letter of intent</label>
                        <textarea type="text" disabled name="letter_of_intent" id="letter_of_intent"
                            class="mt-2 border w-full focus:ring-primary focus:border-primary focus:outline-none px-4 py-1.5 rounded border-gray-300 border-l-[5px] rounded-l border-l-primary"
                            placeholder=" " @input="handleInput($event.target.value, 'letter_of_intent')">{{
                                form["letter_of_intent"] ? form["letter_of_intent"] : ""
                            }}</textarea>
                        <p class="mt-2 text-base text-primary" v-if="validationErros.has(`letter_of_intent`)"
                            v-text="validationErros.get(`letter_of_intent`)"></p>
                    </div>

                    <div class="w-full group bg-white shadow-md p-4 rounded-md border border-gray-100"
                        v-if="form?.messaging_app?.length > 0">
                        <h1 class="text-lg font-medium mb-2">Messaging apps</h1>
                        <p v-for="(app, key) in form?.messaging_app" :key="key">
                            Name :
                            {{
                                app?.messaging_app.messaging_app_detail?.length > 0
                                    ? app?.messaging_app.messaging_app_detail[0]
                                        .name
                                    : ""
                            }}
                            <br />
                            User Name :
                            {{ app?.user_name ? app?.user_name : "" }}
                        </p>
                    </div>
                    <div class="w-full group bg-white shadow-md p-4 rounded-md border border-gray-100"
                        v-if="form?.would_like_to_study?.length > 0">
                        <h1 class="text-lg font-medium mb-2">I would like to study</h1>

                        <!-- Loop over the parsed study preferences -->
                        <p v-for="(program, key) in parsedStudyPreferences" :key="key">
                            <!-- Find the program name by matching the program id with local_programs -->
                            <span v-if="local_programs.length > 0">
                                Program Name:
                                {{ getProgramName(program) }}
                            </span>
                        </p>
                    </div>


                    <div class="w-full mb-6 group bg-white shadow-md p-4 rounded-md border border-gray-100"
                        v-if="form?.tests?.length > 0 || hasOtherTests()">
                        <h1 class="text-lg font-medium mb-2">Tests Taken</h1>
                        <p v-for="(test, key) in form?.tests" :key="key">
                            <lable>Name :
                                {{
                                    test?.test.test_detail?.length > 0
                                        ? test?.test.test_detail[0].name
                                        : ""
                                }}</lable>
                            <br />
                            <lable>
                                Score :
                                {{ test?.score > 0 ? test?.score : "" }}</lable>
                        </p>

                        <p v-for="a in 5" :key="'other-'+a">
                            <template v-if="form['other_test_' + a + '_score'] > 0">
                                <lable>Name :
                                    {{ form["other_test_" + a + "_name"] || 'N/A' }}</lable>
                                <br />
                                <lable>
                                    Score :
                                    {{ form["other_test_" + a + "_score"] }}</lable>
                            </template>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script>
import { mapState } from "vuex";
export default {
    computed: {
        parsedStudyPreferences() {
            // Safely parse the JSON string
            try {
                return JSON.parse(this.form?.would_like_to_study);
            } catch (e) {
                return null; // Return null or a default value if parsing fails
            }
        },
        ...mapState({
            programs: (state) => state.programs.programs,
            form: (state) => state.master_applications.form,
            validationErros: (state) =>
                state.master_applications.validationErros,
            languages: (state) => state.languages.languages,
        }),
        formattedTuitionSources() {
            if (!this.tuition_funding_source || this.tuition_funding_source.length === 0) {
                return 'N/A'; // Fallback in case no data
            }
            return this.tuition_funding_source
                .map(source => {
                    let cleaned = source.replace(/[^a-zA-Z0-9 ]/g, ' '); // Remove special characters except spaces
                    return cleaned.replace(/\b\w/g, char => char.toUpperCase()); // Capitalize each word
                })
                .join(', '); // Join by comma
        },
        formattedReason() {
            const reasonMap = {
                "both": "Both",
                "reverse_admissions": "Reverse Admissions",
                "apply_myself": "Apply Myself"
            };

            return reasonMap[this.form?.for_demetra_or_master_app] || "";
        }
    },
    data() {
        return {
            local_programs: [],
            where_want_to_study: [],
            tuition_funding_source: [],
            country_of_citizenship: [],
            activeTab: null,
            countries: [
                { name: "Afghanistan", code: "AF", phoneCode: "+93" },
                { name: "Aland Islands", code: "AX", phoneCode: "+358" },
                { name: "Albania", code: "AL", phoneCode: "+355" },
                { name: "Algeria", code: "DZ", phoneCode: "+213" },
                { name: "American Samoa", code: "AS", phoneCode: "+1" },
                { name: "Andorra", code: "AD", phoneCode: "+376" },
                { name: "Angola", code: "AO", phoneCode: "+244" },
                { name: "Anguilla", code: "AI", phoneCode: "+1" },
                { name: "Antarctica", code: "AQ", phoneCode: "+672" },
                { name: "Antigua and Barbuda", code: "AG", phoneCode: "+1" },
                { name: "Argentina", code: "AR", phoneCode: "+54" },
                { name: "Armenia", code: "AM", phoneCode: "+374" },
                { name: "Aruba", code: "AW", phoneCode: "+297" },
                { name: "Australia", code: "AU", phoneCode: "+61" },
                { name: "Austria", code: "AT", phoneCode: "+43" },
                { name: "Azerbaijan", code: "AZ", phoneCode: "+994" },
                { name: "Bahamas", code: "BS", phoneCode: "+1" },
                { name: "Bahrain", code: "BH", phoneCode: "+973" },
                { name: "Bangladesh", code: "BD", phoneCode: "+880" },
                { name: "Barbados", code: "BB", phoneCode: "+1" },
                { name: "Belarus", code: "BY", phoneCode: "+375" },
                { name: "Belgium", code: "BE", phoneCode: "+32" },
                { name: "Belize", code: "BZ", phoneCode: "+501" },
                { name: "Benin", code: "BJ", phoneCode: "+229" },
                { name: "Bermuda", code: "BM", phoneCode: "+1" },
                { name: "Bhutan", code: "BT", phoneCode: "+975" },
                { name: "Bolivia", code: "BO", phoneCode: "+591" },
                {
                    name: "Bonaire, Sint Eustatius and Saba",
                    code: "BQ",
                    phoneCode: "+599",
                },
                {
                    name: "Bosnia and Herzegovina",
                    code: "BA",
                    phoneCode: "+387",
                },
                { name: "Botswana", code: "BW", phoneCode: "+267" },
                { name: "Bouvet Island", code: "BV", phoneCode: "+47" },
                { name: "Brazil", code: "BR", phoneCode: "+55" },
                {
                    name: "British Indian Ocean Territory",
                    code: "IO",
                    phoneCode: "+246",
                },
                { name: "Brunei Darussalam", code: "BN", phoneCode: "+673" },
                { name: "Bulgaria", code: "BG", phoneCode: "+359" },
                { name: "Burkina Faso", code: "BF", phoneCode: "+226" },
                { name: "Burundi", code: "BI", phoneCode: "+257" },
                { name: "Cambodia", code: "KH", phoneCode: "+855" },
                { name: "Cameroon", code: "CM", phoneCode: "+237" },
                { name: "Canada", code: "CA", phoneCode: "+1" },
                { name: "Cape Verde", code: "CV", phoneCode: "+238" },
                { name: "Cayman Islands", code: "KY", phoneCode: "+1" },
                {
                    name: "Central African Republic",
                    code: "CF",
                    phoneCode: "+236",
                },
                { name: "Chad", code: "TD", phoneCode: "+235" },
                { name: "Chile", code: "CL", phoneCode: "+56" },
                { name: "China", code: "CN", phoneCode: "+86" },
                { name: "Christmas Island", code: "CX", phoneCode: "+61" },
                {
                    name: "Cocos (Keeling) Islands",
                    code: "CC",
                    phoneCode: "+61",
                },
                { name: "Colombia", code: "CO", phoneCode: "+57" },
                { name: "Comoros", code: "KM", phoneCode: "+269" },
                { name: "Congo", code: "CG", phoneCode: "+242" },
                {
                    name: "Congo, Democratic Republic of the Congo",
                    code: "CD",
                    phoneCode: "+243",
                },
                { name: "Cook Islands", code: "CK", phoneCode: "+682" },
                { name: "Costa Rica", code: "CR", phoneCode: "+506" },
                { name: "Cote D'Ivoire", code: "CI", phoneCode: "+225" },
                { name: "Croatia", code: "HR", phoneCode: "+385" },
                { name: "Cuba", code: "CU", phoneCode: "+53" },
                { name: "Curacao", code: "CW", phoneCode: "+599" },
                { name: "Cyprus", code: "CY", phoneCode: "+357" },
                { name: "Czech Republic", code: "CZ", phoneCode: "+420" },
                { name: "Denmark", code: "DK", phoneCode: "+45" },
                { name: "Djibouti", code: "DJ", phoneCode: "+253" },
                { name: "Dominica", code: "DM", phoneCode: "+1" },
                { name: "Dominican Republic", code: "DO", phoneCode: "+1" },
                { name: "Ecuador", code: "EC", phoneCode: "+593" },
                { name: "Egypt", code: "EG", phoneCode: "+20" },
                { name: "El Salvador", code: "SV", phoneCode: "+503" },
                { name: "Equatorial Guinea", code: "GQ", phoneCode: "+240" },
                { name: "Eritrea", code: "ER", phoneCode: "+291" },
                { name: "Estonia", code: "EE", phoneCode: "+372" },
                { name: "Ethiopia", code: "ET", phoneCode: "+251" },
                {
                    name: "Falkland Islands (Malvinas)",
                    code: "FK",
                    phoneCode: "+500",
                },
                { name: "Faroe Islands", code: "FO", phoneCode: "+298" },
                { name: "Fiji", code: "FJ", phoneCode: "+679" },
                { name: "Finland", code: "FI", phoneCode: "+358" },
                { name: "France", code: "FR", phoneCode: "+33" },
                { name: "French Guiana", code: "GF", phoneCode: "+594" },
                { name: "French Polynesia", code: "PF", phoneCode: "+689" },
                {
                    name: "French Southern Territories",
                    code: "TF",
                    phoneCode: "+262",
                },
                { name: "Gabon", code: "GA", phoneCode: "+241" },
                { name: "Gambia", code: "GM", phoneCode: "+220" },
                { name: "Georgia", code: "GE", phoneCode: "+995" },
                { name: "Germany", code: "DE", phoneCode: "+49" },
                { name: "Ghana", code: "GH", phoneCode: "+233" },
                { name: "Gibraltar", code: "GI", phoneCode: "+350" },
                { name: "Greece", code: "GR", phoneCode: "+30" },
                { name: "Greenland", code: "GL", phoneCode: "+299" },
                { name: "Grenada", code: "GD", phoneCode: "+1" },
                { name: "Guadeloupe", code: "GP", phoneCode: "+590" },
                { name: "Guam", code: "GU", phoneCode: "+1" },
                { name: "Guatemala", code: "GT", phoneCode: "+502" },
                { name: "Guernsey", code: "GG", phoneCode: "+44" },
                { name: "Guinea", code: "GN", phoneCode: "+224" },
                { name: "Guinea-Bissau", code: "GW", phoneCode: "+245" },
                { name: "Guyana", code: "GY", phoneCode: "+592" },
                { name: "Haiti", code: "HT", phoneCode: "+509" },
                {
                    name: "Heard Island and McDonald Islands",
                    code: "HM",
                    phoneCode: "+672",
                },
                {
                    name: "Holy See (Vatican City State)",
                    code: "VA",
                    phoneCode: "+379",
                },
                { name: "Honduras", code: "HN", phoneCode: "+504" },
                { name: "Hong Kong", code: "HK", phoneCode: "+852" },
                { name: "Hungary", code: "HU", phoneCode: "+36" },
                { name: "Iceland", code: "IS", phoneCode: "+354" },
                { name: "India", code: "IN", phoneCode: "+91" },
                { name: "Indonesia", code: "ID", phoneCode: "+62" },
                {
                    name: "Iran, Islamic Republic of",
                    code: "IR",
                    phoneCode: "+98",
                },
                { name: "Iraq", code: "IQ", phoneCode: "+964" },
                { name: "Ireland", code: "IE", phoneCode: "+353" },
                { name: "Isle of Man", code: "IM", phoneCode: "+44" },
                { name: "Israel", code: "IL", phoneCode: "+972" },
                { name: "Italy", code: "IT", phoneCode: "+39" },
                { name: "Jamaica", code: "JM", phoneCode: "+1" },
                { name: "Japan", code: "JP", phoneCode: "+81" },
                { name: "Jersey", code: "JE", phoneCode: "+44" },
                { name: "Jordan", code: "JO", phoneCode: "+962" },
                { name: "Kazakhstan", code: "KZ", phoneCode: "+7" },
                { name: "Kenya", code: "KE", phoneCode: "+254" },
                { name: "Kiribati", code: "KI", phoneCode: "+686" },
                {
                    name: "Korea, Democratic People's Republic of",
                    code: "KP",
                    phoneCode: "+850",
                },
                { name: "Korea, Republic of", code: "KR", phoneCode: "+82" },
                { name: "Kosovo", code: "XK", phoneCode: "+383" },
                { name: "Kuwait", code: "KW", phoneCode: "+965" },
                { name: "Kyrgyzstan", code: "KG", phoneCode: "+996" },
                {
                    name: "Lao People's Democratic Republic",
                    code: "LA",
                    phoneCode: "+856",
                },
                { name: "Latvia", code: "LV", phoneCode: "+371" },
                { name: "Lebanon", code: "LB", phoneCode: "+961" },
                { name: "Lesotho", code: "LS", phoneCode: "+266" },
                { name: "Liberia", code: "LR", phoneCode: "+231" },
                {
                    name: "Libyan Arab Jamahiriya",
                    code: "LY",
                    phoneCode: "+218",
                },
                { name: "Liechtenstein", code: "LI", phoneCode: "+423" },
                { name: "Lithuania", code: "LT", phoneCode: "+370" },
                { name: "Luxembourg", code: "LU", phoneCode: "+352" },
                { name: "Macao", code: "MO", phoneCode: "+853" },
                {
                    name: "Macedonia, the Former Yugoslav Republic of",
                    code: "MK",
                    phoneCode: "+389",
                },
                { name: "Madagascar", code: "MG", phoneCode: "+261" },
                { name: "Malawi", code: "MW", phoneCode: "+265" },
                { name: "Malaysia", code: "MY", phoneCode: "+60" },
                { name: "Maldives", code: "MV", phoneCode: "+960" },
                { name: "Mali", code: "ML", phoneCode: "+223" },
                { name: "Malta", code: "MT", phoneCode: "+356" },
                { name: "Marshall Islands", code: "MH", phoneCode: "+692" },
                { name: "Martinique", code: "MQ", phoneCode: "+596" },
                { name: "Mauritania", code: "MR", phoneCode: "+222" },
                { name: "Mauritius", code: "MU", phoneCode: "+230" },
                { name: "Mayotte", code: "YT", phoneCode: "+262" },
                { name: "Mexico", code: "MX", phoneCode: "+52" },
                {
                    name: "Micronesia, Federated States of",
                    code: "FM",
                    phoneCode: "+691",
                },
                { name: "Moldova, Republic of", code: "MD", phoneCode: "+373" },
                { name: "Monaco", code: "MC", phoneCode: "+377" },
                { name: "Mongolia", code: "MN", phoneCode: "+976" },
                { name: "Montenegro", code: "ME", phoneCode: "+382" },
                { name: "Montserrat", code: "MS", phoneCode: "+1" },
                { name: "Morocco", code: "MA", phoneCode: "+212" },
                { name: "Mozambique", code: "MZ", phoneCode: "+258" },
                { name: "Myanmar", code: "MM", phoneCode: "+95" },
                { name: "Namibia", code: "NA", phoneCode: "+264" },
                { name: "Nauru", code: "NR", phoneCode: "+674" },
                { name: "Nepal", code: "NP", phoneCode: "+977" },
                { name: "Netherlands", code: "NL", phoneCode: "+31" },
                { name: "Netherlands Antilles", code: "AN", phoneCode: "+599" },
                { name: "New Caledonia", code: "NC", phoneCode: "+687" },
                { name: "New Zealand", code: "NZ", phoneCode: "+64" },
                { name: "Nicaragua", code: "NI", phoneCode: "+505" },
                { name: "Niger", code: "NE", phoneCode: "+227" },
                { name: "Nigeria", code: "NG", phoneCode: "+234" },
                { name: "Niue", code: "NU", phoneCode: "+683" },
                { name: "Norfolk Island", code: "NF", phoneCode: "+672" },
                {
                    name: "Northern Mariana Islands",
                    code: "MP",
                    phoneCode: "+1",
                },
                { name: "Norway", code: "NO", phoneCode: "+47" },
                { name: "Oman", code: "OM", phoneCode: "+968" },
                { name: "Pakistan", code: "PK", phoneCode: "+92" },
                { name: "Palau", code: "PW", phoneCode: "+680" },
                {
                    name: "Palestinian Territory, Occupied",
                    code: "PS",
                    phoneCode: "+970",
                },
                { name: "Panama", code: "PA", phoneCode: "+507" },
                { name: "Papua New Guinea", code: "PG", phoneCode: "+675" },
                { name: "Paraguay", code: "PY", phoneCode: "+595" },
                { name: "Peru", code: "PE", phoneCode: "+51" },
                { name: "Philippines", code: "PH", phoneCode: "+63" },
                { name: "Pitcairn", code: "PN", phoneCode: "+870" },
                { name: "Poland", code: "PL", phoneCode: "+48" },
                { name: "Portugal", code: "PT", phoneCode: "+351" },
                { name: "Puerto Rico", code: "PR", phoneCode: "+1" },
                { name: "Qatar", code: "QA", phoneCode: "+974" },
                { name: "Reunion", code: "RE", phoneCode: "+262" },
                { name: "Romania", code: "RO", phoneCode: "+40" },
                { name: "Russian Federation", code: "RU", phoneCode: "+7" },
                { name: "Rwanda", code: "RW", phoneCode: "+250" },
                { name: "Saint Barthelemy", code: "BL", phoneCode: "+590" },
                { name: "Saint Helena", code: "SH", phoneCode: "+290" },
                { name: "Saint Kitts and Nevis", code: "KN", phoneCode: "+1" },
                { name: "Saint Lucia", code: "LC", phoneCode: "+1" },
                { name: "Saint Martin", code: "MF", phoneCode: "+590" },
                {
                    name: "Saint Pierre and Miquelon",
                    code: "PM",
                    phoneCode: "+508",
                },
                {
                    name: "Saint Vincent and the Grenadines",
                    code: "VC",
                    phoneCode: "+1",
                },
                { name: "Samoa", code: "WS", phoneCode: "+685" },
                { name: "San Marino", code: "SM", phoneCode: "+378" },
                {
                    name: "Sao Tome and Principe",
                    code: "ST",
                    phoneCode: "+239",
                },
                { name: "Saudi Arabia", code: "SA", phoneCode: "+966" },
                { name: "Senegal", code: "SN", phoneCode: "+221" },
                { name: "Serbia", code: "RS", phoneCode: "+381" },
                {
                    name: "Serbia and Montenegro",
                    code: "CS",
                    phoneCode: "+381",
                },
                { name: "Seychelles", code: "SC", phoneCode: "+248" },
                { name: "Sierra Leone", code: "SL", phoneCode: "+232" },
                { name: "Singapore", code: "SG", phoneCode: "+65" },
                { name: "St Martin", code: "SX", phoneCode: "+590" },
                { name: "Slovakia", code: "SK", phoneCode: "+421" },
                { name: "Slovenia", code: "SI", phoneCode: "+386" },
                { name: "Solomon Islands", code: "SB", phoneCode: "+677" },
                { name: "Somalia", code: "SO", phoneCode: "+252" },
                { name: "South Africa", code: "ZA", phoneCode: "+27" },
                {
                    name: "South Georgia and the South Sandwich Islands",
                    code: "GS",
                    phoneCode: "",
                },
                { name: "South Sudan", code: "SS", phoneCode: "+211" },
                { name: "Spain", code: "ES", phoneCode: "+34" },
                { name: "Sri Lanka", code: "LK", phoneCode: "+94" },
                { name: "Sudan", code: "SD", phoneCode: "+249" },
                { name: "Suriname", code: "SR", phoneCode: "+597" },
                {
                    name: "Svalbard and Jan Mayen",
                    code: "SJ",
                    phoneCode: "+47",
                },
                { name: "Swaziland", code: "SZ", phoneCode: "+268" },
                { name: "Sweden", code: "SE", phoneCode: "+46" },
                { name: "Switzerland", code: "CH", phoneCode: "+41" },
                { name: "Syrian Arab Republic", code: "SY", phoneCode: "+963" },
                {
                    name: "Taiwan, Province of China",
                    code: "TW",
                    phoneCode: "+886",
                },
                { name: "Tajikistan", code: "TJ", phoneCode: "+992" },
                {
                    name: "Tanzania, United Republic of",
                    code: "TZ",
                    phoneCode: "+255",
                },
                { name: "Thailand", code: "TH", phoneCode: "+66" },
                { name: "Timor-Leste", code: "TL", phoneCode: "+670" },
                { name: "Togo", code: "TG", phoneCode: "+228" },
                { name: "Tokelau", code: "TK", phoneCode: "+690" },
                { name: "Tonga", code: "TO", phoneCode: "+676" },
                { name: "Trinidad and Tobago", code: "TT", phoneCode: "+1" },
                { name: "Tunisia", code: "TN", phoneCode: "+216" },
                { name: "Turkey", code: "TR", phoneCode: "+90" },
                { name: "Turkmenistan", code: "TM", phoneCode: "+993" },
                {
                    name: "Turks and Caicos Islands",
                    code: "TC",
                    phoneCode: "+1",
                },
                { name: "Tuvalu", code: "TV", phoneCode: "+688" },
                { name: "Uganda", code: "UG", phoneCode: "+256" },
                { name: "Ukraine", code: "UA", phoneCode: "+380" },
                { name: "United Arab Emirates", code: "AE", phoneCode: "+971" },
                { name: "United Kingdom", code: "GB", phoneCode: "+44" },
                { name: "United States", code: "US", phoneCode: "+1" },
                {
                    name: "United States Minor Outlying Islands",
                    code: "UM",
                    phoneCode: "+1",
                },
                { name: "Uruguay", code: "UY", phoneCode: "+598" },
                { name: "Uzbekistan", code: "UZ", phoneCode: "+998" },
                { name: "Vanuatu", code: "VU", phoneCode: "+678" },
                { name: "Venezuela", code: "VE", phoneCode: "+58" },
                { name: "Viet Nam", code: "VN", phoneCode: "+84" },
                {
                    name: "Virgin Islands, British",
                    code: "VG",
                    phoneCode: "+1",
                },
                { name: "Virgin Islands, U.s.", code: "VI", phoneCode: "+1" },
                { name: "Wallis and Futuna", code: "WF", phoneCode: "+681" },
                { name: "Western Sahara", code: "EH", phoneCode: "+212" },
                { name: "Yemen", code: "YE", phoneCode: "+967" },
                { name: "Zambia", code: "ZM", phoneCode: "+260" },
                { name: "Zimbabwe", code: "ZW", phoneCode: "+263" },
            ],
        };
    },
    methods: {
        hasOtherTests() {
        for (let i = 1; i <= 5; i++) {
            if (this.form['other_test_'+i+'_score'] > 0) return true
        }
        return false
    },
        getProgramName(program) {
            console.log(program)
            const matchedProgram = this.local_programs.find(p => p.id === program);
            return matchedProgram ? matchedProgram.text : 'Program not found'; // Fallback if no match is found
        },
        getCountryName(code) {
            const country = this.countries.find(c => c.code === code);
            return country ? country.name : code; // Show name if found, else show code
        },
        handleInput(value, key) {
            this.$store.commit("master_applications/setState", { key, value });
        },
        handleMultipleInput(key, value, language) {
            this.$store.commit("master_applications/updateState", {
                value: value,
                id: language.id,
                key,
            });
        },
        addUpdateForm() {
            this.$store.dispatch("master_applications/addUpdateForm").then(() =>
                this.$router.push({
                    name: "admin.master_applications.index",
                })
            );
        },
        changeLanguageTab(language) {
            this.activeTab = language.id;
        },
        fetchMasterApplications() {
            if (this.$route.params.id) {
                let id = this.$route.params.id;

                this.$store.commit("master_applications/setIsFormEdit", 1);
                this.$store
                    .dispatch("master_applications/fetchMasterApplication", {
                        id: id,
                        url: `${process.env.MIX_ADMIN_API_URL}master_applications/${id}?q=1`,
                    })
                    .then((res) => {
                        console.log('admin master res', res)
                        let keys = [
                            "first_name",
                            "last_name",
                            "school",
                            "email",
                            "confirm_email",
                            "dob",
                            "gender",
                            "phone",
                            "can_school_text_you",
                            "messaging_app",
                            "messaging_app_username",
                            "currently_student_anywhere",
                            "letter_of_intent",
                            "for_demetra_or_master_app",
                            "where_want_to_study",
                            "country_of_citizenship",
                            "live_in_your_country_citizenship",
                            "current_residance",
                            "current_residance_status",
                            "mailing_address",
                            "high_school_name",
                            "high_school_cgpa",
                            "high_school_city",
                            "high_school_country",
                            "when_plan_to_start",
                            "interested_in",
                            "would_like_to_study",
                            "tuition_funding_source",
                            "test_taken",
                            "addtional",
                            "add_anything",
                            "currently_living_in_canada",
                            "study_permit_candian_embassy",
                            "meesaging_app",
                            "tests",
                            "other_test_1_name",
                            "other_test_1_score",
                            "other_test_2_name",
                            "other_test_2_score",
                            "other_test_3_name",
                            "other_test_3_score",
                            "other_test_4_name",
                            "other_test_4_score",
                            "other_test_5_name",
                            "other_test_5_score",
                            "statement_of_purpose",
                            "for_demetra_or_master_app",
                            "student_type",
                        ];
                        this.$store.commit("master_applications/setState", {
                            key: "id",
                            value: id,
                        });
                        for (var i = 0; i < keys.length; i++) {
                            this.$store.commit("master_applications/setState", {
                                key: keys[i],
                                value: res.data.data[keys[i]],
                            });
                        }
                        this.where_want_to_study = JSON.parse(res.data.data.where_want_to_study);
                        this.country_of_citizenship = JSON.parse(res.data.data.country_of_citizenship);
                        this.tuition_funding_source = JSON.parse(res.data.data.tuition_funding_source);
                        // this.where_want_to_study = JSON.parse(this.where_want_to_study );
                        // console.log(res.data.data.where_want_to_study)
                        // console.log(this.where_want_to_study)

                    });
            }
        },
        isJSONString(value) {
            try {
                newVal = JSON.parse(value);
                return newVal;
            } catch (error) {
                return false;
            }
        },
    },
    created() {
        console.log("Countries Loaded:", this.countries);
        this.$store.commit("master_applications/resetForm");
        this.fetchMasterApplications();
    },
    mounted() {
        this.$store.commit("programs/setLimit", 20000);
    this.$store.commit("programs/setSortBy", "id");
    this.$store.commit("programs/setSortType", "desc");
        this.$store.dispatch("programs/fetchPrograms").then((res) => {
            console.log(res.data.data, "response");
            this.local_programs = [];
            res.data.data.map((program) => {
                this.local_programs.push({
                    id: program.id,
                    text: program?.program_detail[0]?.name,
                });
            });
            console.log('console logging... ', this.local_programs)
        });
    },
};
</script>

<style scoped>
/**
 * FilePond Custom Styles
 */
.filepond--drop-label {
    color: #4c4e53;
}

.filepond--label-action {
    text-decoration-color: #babdc0;
}

.filepond--panel-root {
    border-radius: 2em;
    background-color: #edf0f4;
    height: 1em;
}

.filepond--item-panel {
    background-color: #595e68;
}

.filepond--drip-blob {
    background-color: #7f8a9a;
}
</style>
