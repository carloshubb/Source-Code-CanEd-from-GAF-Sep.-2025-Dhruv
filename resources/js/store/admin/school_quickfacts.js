import ErrorHandling from "../../ErrorHandling";

const school_quickfacts = {
    namespaced: true,
    state: {
        errors: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            customer_id: "",
            school_id: "",
            title_2_image: "",
            school_quick_facts_apply_button_link: "",
            school_quick_facts_apply_button_title: "",
            school_quick_facts_blue_bar_button_title: "",
            school_quick_facts_blue_bar_button_link: "",
            school_quick_facts_red_bar_button_title: "",
            school_quick_facts_red_bar_button_link: "",
            title_2_button_link: "",
            title_1: {},
            title_1_paragraph: {},
            title_2: {},
            title_2_subtitle: {},
            title_2_paragraph: {},
            title_2_button_title: {},
        },
        languages: [],
        school_quickfacts: null,
        loading: false,
        sortBy: "id",
        sortType: "desc",
        searchParam: null,
        pagination: {},
        limit: 10,
        param: "withFlagIcon=1",
        isFormEdit: false,
        showModal: false,
        is_featured_array: [],
    },
    mutations: {
        setIsFeatured(state, payload) {
            if (payload.checked) {
                if (state.is_featured_array.indexOf(payload.key) == -1) {
                    state.is_featured_array.push(payload.key);
                }
            } else {
                var index = state.is_featured_array.indexOf(payload.key);
                state.is_featured_array.splice(index, 1);
            }
            state.form.marked_facts = state.is_featured_array.toString();
        },
        setIsFeaturedArray(state, payload) {
            state.is_featured_array = payload.split(",");
        },
        setLanguages(state, payload) {
            state.languages = payload;
        },
        setForData(state, payload) {
            if (payload?.language?.abbreviation) {
                state.form[payload?.key][
                    payload?.key + "_" + payload?.language?.abbreviation
                ] = payload?.value;
            } else {
                state.form[payload?.key] = payload?.value;
            }
        },
        updateFormData(state, payload) {
            state.form[payload?.key][
                payload?.key + "_" + payload?.id
            ] = payload?.value;
        },
        setIsFormEdit(state, payload) {
            state.isFormEdit = payload;
        },
        setShowModal(state, payload) {
            state.showModal = payload;
        },
        setSchoolQuickFact(state, payload) {
            const {
                id,
                customer_id,
                title_2_image,
                title_2_button_link,
                school_quick_facts_apply_button_title,
                school_quick_facts_apply_button_link,
                school_quick_facts_blue_bar_button_title,
                school_quick_facts_blue_bar_button_link,
                school_quick_facts_red_bar_button_title,
                school_quick_facts_red_bar_button_link,
                school_location,
                school_type,
                languages,
                total_undergraduates,
                entrance_dates,
                canidian_tuition_fee,
                international_tuition_fee,
                telephone,
                fax,
                school_address,
                start_date,
                online_or_distance_education,
                minimum_gpa,
                conditional_admission,
                number_of_graduate_programs,
                number_of_undergraduate_programs,
                number_of_students,
                number_of_graduate_students,
                number_of_undergraduate_students,
                study_method,
                delivery_mode,
                accomodation,
                work_on_campus,
                work_during_holidays,
                internship,
                co_op_education,
                job_placement,
                financial_aid_programs_for_domastic_students,
                financial_aid_programs_for_province_students,
                financial_aid_programs_for_international_students,
                research_and_dissertaion,
                exchange_program,
                degree_modifier,
                daycare_for_students_with_kids,
                elementary_school_for_students_with_kids,
                immigration_office_on_campus,
                career_planing,
                pathway_programs,
                employeement_rates,
                class_size_undergraduate,
                class_size_masters,
                service_and_guidance_new_students,
                service_and_guidance_to_new_arrivals_in_canada,
                marked_facts,
                program_type_greduates,
                program_type_undergreduates,
                years_before_elegible_for_pr,
                quick_fact_1,
                quick_fact_2,
                quick_fact_3,
                quick_fact_4,
                quick_fact_5,
                quick_fact_6,
                quick_fact_7,
                quick_fact_8,
                quick_fact_9,
                quick_fact_10,
                work_off_campus,
            } = payload;
            state.form["program_type_greduates"] = program_type_greduates;
            state.form["program_type_undergreduates"] =
                program_type_undergreduates;
            state.form["years_before_elegible_for_pr"] =
                years_before_elegible_for_pr;
                state.form["quick_fact_1"] =
                quick_fact_1;
            state.form["quick_fact_2"] =
                quick_fact_2;
            state.form["quick_fact_3"] =
                quick_fact_3;
            state.form["quick_fact_4"] =
                quick_fact_4;
            state.form["quick_fact_5"] =
                quick_fact_5;
            state.form["quick_fact_6"] =
                quick_fact_6;
            state.form["quick_fact_7"] =
                quick_fact_7;
            state.form["quick_fact_8"] =
                quick_fact_8;
            state.form["quick_fact_9"] =
                quick_fact_9;
            state.form["quick_fact_10"] =
                quick_fact_10;
            state.form["work_off_campus"] = work_off_campus;
            state.form["title_2_image"] = title_2_image;
            state.form["title_2_button_link"] = title_2_button_link;
            state.form["school_quick_facts_apply_button_link"] = school_quick_facts_apply_button_link;
            state.form["school_quick_facts_apply_button_title"] = school_quick_facts_apply_button_title;
            state.form["school_quick_facts_blue_bar_button_title"] = school_quick_facts_blue_bar_button_title;
            state.form["school_quick_facts_blue_bar_button_link"] = school_quick_facts_blue_bar_button_link;
            state.form["school_quick_facts_red_bar_button_title"] = school_quick_facts_red_bar_button_title;
            state.form["school_quick_facts_red_bar_button_link"] = school_quick_facts_red_bar_button_link;
            state.form["school_location"] = school_location;
            state.form["school_type"] = school_type;
            state.form["languages"] = languages;
            state.form["total_undergraduates"] = total_undergraduates;
            state.form["entrance_dates"] = entrance_dates;
            state.form["canidian_tuition_fee"] = canidian_tuition_fee;
            state.form["international_tuition_fee"] = international_tuition_fee;
            state.form["telephone"] = telephone;
            state.form["fax"] = fax;
            state.form["school_address"] = school_address;
            state.form["start_date"] = start_date;
            state.form["online_or_distance_education"] =
                online_or_distance_education;
            state.form["minimum_gpa"] = minimum_gpa;
            state.form["conditional_admission"] = conditional_admission;
            state.form["number_of_graduate_programs"] =
                number_of_graduate_programs;
            state.form["number_of_undergraduate_programs"] =
                number_of_undergraduate_programs;
            state.form["number_of_students"] = number_of_students;
            state.form["number_of_graduate_students"] =
                number_of_graduate_students;
            state.form["number_of_undergraduate_students"] =
                number_of_undergraduate_students;
            state.form["study_method"] = study_method;
            state.form["delivery_mode"] = delivery_mode;
            state.form["accomodation"] = accomodation;
            state.form["work_on_campus"] = work_on_campus;
            state.form["work_during_holidays"] = work_during_holidays;
            state.form["internship"] = internship;
            state.form["co_op_education"] = co_op_education;
            state.form["job_placement"] = job_placement;
            state.form["financial_aid_programs_for_domastic_students"] =
                financial_aid_programs_for_domastic_students;
            state.form["financial_aid_programs_for_province_students"] =
                financial_aid_programs_for_province_students;
            state.form["financial_aid_programs_for_international_students"] =
                financial_aid_programs_for_international_students;
            state.form["research_and_dissertaion"] = research_and_dissertaion;
            state.form["exchange_program"] = exchange_program;
            state.form["degree_modifier"] = degree_modifier;
            state.form["daycare_for_students_with_kids"] =
                daycare_for_students_with_kids;
            state.form["elementary_school_for_students_with_kids"] =
                elementary_school_for_students_with_kids;
            state.form["immigration_office_on_campus"] =
                immigration_office_on_campus;
            state.form["career_planing"] = career_planing;
            state.form["pathway_programs"] = pathway_programs;
            state.form["employeement_rates"] = employeement_rates;
            state.form["class_size_undergraduate"] = class_size_undergraduate;
            state.form["class_size_masters"] = class_size_masters;
            state.form["service_and_guidance_new_students"] =
                service_and_guidance_new_students;
            state.form["service_and_guidance_to_new_arrivals_in_canada"] =
                service_and_guidance_to_new_arrivals_in_canada;
            state.form["marked_facts"] = marked_facts;

            for (
                let i = 0;
                i < payload?.school_information_detail?.length;
                i++
            ) {
                if (
                    payload?.school_information_detail[i] &&
                    payload?.school_information_detail[i]?.language_code
                ) {
                    state.form["title_1"][
                        "title_1" +
                            "_" +
                            payload?.school_information_detail[i]?.language_code
                    ] = payload?.school_information_detail[i]?.title_1;
                    state.form["title_1_paragraph"][
                        "title_1_paragraph" +
                            "_" +
                            payload?.school_information_detail[i]?.language_code
                    ] =
                        payload?.school_information_detail[
                            i
                        ]?.title_1_paragraph;

                    state.form["title_2"][
                        "title_2" +
                            "_" +
                            payload?.school_information_detail[i]?.language_code
                    ] = payload?.school_information_detail[i]?.title_2;

                    state.form["title_2_subtitle"][
                        "title_2_subtitle" +
                            "_" +
                            payload?.school_information_detail[i]?.language_code
                    ] = payload?.school_information_detail[i]?.title_2_subtitle;

                    state.form["title_2_paragraph"][
                        "title_2_paragraph" +
                            "_" +
                            payload?.school_information_detail[i]?.language_code
                    ] =
                        payload?.school_information_detail[
                            i
                        ]?.title_2_paragraph;

                    state.form["title_2_button_title"][
                        "title_2_button_title" +
                            "_" +
                            payload?.school_information_detail[i]?.language_code
                    ] =
                        payload?.school_information_detail[
                            i
                        ]?.title_2_button_title;
                }
            }
            state.isFormEdit = true;
            state.showModal = true;

            // state.school_quickfacts = payload;
        },
        setSchoolQuickFacts(state, payload) {
            state.school_quickfacts = payload;
        },
        setPagination(state, pagination) {
            if (pagination.meta) {
                state.pagination = {
                    current_page: pagination.meta.current_page,
                    last_page: pagination.meta.last_page,
                    next_page_url: pagination.links
                        ? pagination.links.next
                        : null,
                    prev_page_url: pagination.links
                        ? pagination.links.prev
                        : null,
                };
            }
        },
        setSearchParam(state, payload) {
            state.searchParam = payload;
            state.param = helper.updateUrlParameter(
                state.param,
                "searchParam",
                payload
            );
        },
        setLimit(state, payload) {
            state.limit = payload;
            state.param = helper.updateUrlParameter(
                state.param,
                "limit",
                payload
            );
        },
        setSortBy(state, payload) {
            state.sortBy = payload;
            state.param = helper.updateUrlParameter(
                state.param,
                "sortBy",
                payload
            );
        },
        setSortType(state, payload) {
            state.sortType = payload;
            state.param = helper.updateUrlParameter(
                state.param,
                "sortType",
                payload
            );
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
        resetForm(state) {
            state.form = {
                id: null,
                customer_id: "",
                school_id: "",
                title_2_image: "",
                title_2_button_link: "",
                school_location: "",
                school_type: "",
                languages: "",
                total_undergraduates: "",
                entrance_dates: "",
                canidian_tuition_fee: "",
                school_quick_facts_blue_bar_button_title: "",
                school_quick_facts_blue_bar_button_link: "",
                school_quick_facts_red_bar_button_title: "",
                school_quick_facts_red_bar_button_link: "",
                school_quick_facts_apply_button_link: "",
                school_quick_facts_apply_button_title: "",
                international_tuition_fee: "",
                telephone: "",
                fax: "",
                school_address: "",
                start_date: "",
                online_or_distance_education: "",
                minimum_gpa: "",
                conditional_admission: "",
                number_of_graduate_programs: "",
                number_of_undergraduate_programs: "",
                number_of_students: "",
                number_of_graduate_students: "",
                number_of_undergraduate_students: "",
                study_method: "",
                delivery_mode: "",
                accomodation: "",
                work_on_campus: "",
                work_during_holidays: "",
                internship: "",
                co_op_education: "",
                job_placement: "",
                financial_aid_programs_for_domastic_students: "",
                financial_aid_programs_for_province_students: "",
                financial_aid_programs_for_international_students: "",
                research_and_dissertaion: "",
                exchange_program: "",
                degree_modifier: "",
                daycare_for_students_with_kids: "",
                elementary_school_for_students_with_kids: "",
                immigration_office_on_campus: "",
                career_planing: "",
                pathway_programs: "",
                employeement_rates: "",
                class_size_undergraduate: "",
                class_size_masters: "",
                service_and_guidance_new_students: "",
                service_and_guidance_to_new_arrivals_in_canada: "",
                marked_facts: "",
                program_type_greduates: "",
                program_type_undergreduates: "",
                years_before_elegible_for_pr: "",
                quick_fact_1: "",
                quick_fact_2: "",
                quick_fact_3: "",
                quick_fact_4: "",
                quick_fact_5: "",
                quick_fact_6: "",
                quick_fact_7: "",
                quick_fact_8: "",
                quick_fact_9: "",
                quick_fact_10: "",
                work_off_campus: "",
                field_of_study: "",
                title_1: {},
                title_1_paragraph: {},
                title_2: {},
                title_2_subtitle: {},
                title_2_paragraph: {},
                title_2_button_title: {},
            };
            state.errors = new ErrorHandling();
            state.error = null;
            state.isFormEdit = false;
            state.showModal = false;
            is_featured_array = [];
        },
        setUrl(state, payload) {
            state.form.url = payload;
        },
        setForm(state, payload) {
            state.form.id = payload?.id || null;
        },
        setValidationErros(state, payload) {
            state.errors.record(payload);
        },
        setEmptyError(state) {
            state.errors = new ErrorHandling();
        },
        setError(state, payload) {
            state.error = payload;
        },
    },
    actions: {
        addUpdateForm({ commit, state }) {
            let method = state.isFormEdit ? "put" : "post";
            let url = state.isFormEdit
                ? `${process.env.MIX_WEB_API_URL}school-quick-facts/${state.form.id}`
                : `${process.env.MIX_WEB_API_URL}school-quick-facts`;
            commit("setLoading");

            return new Promise(function (resolve, reject) {
                axios[method](url, state.form)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            // commit("resetForm");
                            resolve(res);
                        } else {
                            helper.swalErrorMessage(res.data.message);
                        }
                    })
                    .catch((error) => {
                        commit("setEmptyError");
                        if (error.response && error.response.status == 422) {
                            commit(
                                "setValidationErros",
                                error.response.data.errors
                            );
                        } else if (
                            error.response &&
                            error.response.data &&
                            error.response.data.status == "Error"
                        ) {
                            helper.swalErrorMessage(
                                error.response.data.message
                            );
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchSchoolQuickFacts({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-quick-facts?withSchoolQuickFactDetail=1&type=${payload?.type}`;
            url = `${url}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setSchoolQuickFacts", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchSchoolQuickFact({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-quick-facts/${payload.id}?withSchoolQuickFactDetail=1`;
            url = `${url}&${state.param}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setForm", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        deleteSchoolQuickFact({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-quick-facts/${payload.id}`;
            return new Promise(function (resolve, reject) {
                axios
                    .delete(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            resolve(res);
                        } else if (res.data.status == "Error") {
                            helper.swalErrorMessage(res.data.message);
                            resolve(res);
                        }
                    })
                    .finally(() => commit("setLoading"));
            });
        },
    },
};

export default school_quickfacts;
