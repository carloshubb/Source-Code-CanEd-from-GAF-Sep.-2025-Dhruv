import ErrorHandling from "../../ErrorHandling";

const school_financials = {
    namespaced: true,
    state: {
        errors: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            customer_id: "",
            school_id: "",
            video_url: "",
            school_financials_apply_button_link: "",
            school_financials_apply_button_title: "",
            school_financials_blue_bar_button_title: "",
            school_financials_blue_bar_button_link: "",
            school_financials_red_bar_button_title: "",
            school_financials_red_bar_button_link: "",
            tabs_pre_description: {},
            tabs_post_description: {},
            tab1_name: {},
            tab2_name: {},
            tab3_name: {},
            tab1_description: {},
            tab2_description: {},
            tab3_description: {},
            scholarship_pre_description: {},
            scholarship_post_description: {},
            programs_pre_description: {},
            programs_post_description: {},
            faq_pre_description: {},
            faq_post_description: {},
        },
        languages: [],
        school_financials: null,
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
                state.is_featured_array.push(payload.key);
            } else {
                var index = state.is_featured_array.indexOf(payload.key);
                state.is_featured_array.splice(index, 1);
            }
            state.form.marked_facts = state.is_featured_array.toString();
        },
        setIsFeaturedArray(state, payload) {
            state.is_featured_array = payload;
        },
        setLanguages(state, payload) {
            state.languages = payload;
        },
        setForData(state, payload) {
            if (payload?.language?.language_code) {
                state.form[payload?.key][
                    payload?.key + "_" + payload?.language?.language_code
                ] = payload?.value;
            } else {
                state.form[payload?.key] = payload?.value;
            }
        },
        updateFormData(state, payload) {
            state.form[payload?.key][payload?.key + "_" + payload?.id] = payload?.value;
        },
        setIsFormEdit(state, payload) {
            state.isFormEdit = payload;
        },
        setShowModal(state, payload) {
            state.showModal = payload;
        },
        setSchoolFinancial(state, payload) {
            const {
                id,
                tab_1_subtitle_1_bps_1_price,
                tab_1_subtitle_3_bps_1_price,
                tab_1_subtitle_3_bps_2_price,
                tab_1_subtitle_3_bps_3_price,
                tab_2_subtitle_1_bps_1_price,
                tab_2_subtitle_3_bps_1_price,
                tab_2_subtitle_3_bps_2_price,
                tab_2_subtitle_3_bps_3_price,
                tab_3_subtitle_1_bps_1_price,
                tab_3_subtitle_3_bps_1_price,
                tab_3_subtitle_3_bps_2_price,
                tab_3_subtitle_3_bps_3_price,
            } = payload;
            state.form["tab_1_subtitle_1_bps_1_price"] = tab_1_subtitle_1_bps_1_price;
            state.form["tab_1_subtitle_3_bps_1_price"] = tab_1_subtitle_3_bps_1_price;
            state.form["tab_1_subtitle_3_bps_2_price"] = tab_1_subtitle_3_bps_2_price;
            state.form["tab_1_subtitle_3_bps_3_price"] = tab_1_subtitle_3_bps_3_price;
            state.form["tab_2_subtitle_1_bps_1_price"] = tab_2_subtitle_1_bps_1_price;
            state.form["tab_2_subtitle_3_bps_1_price"] = tab_2_subtitle_3_bps_1_price;
            state.form["tab_2_subtitle_3_bps_2_price"] = tab_2_subtitle_3_bps_2_price;
            state.form["tab_2_subtitle_3_bps_3_price"] = tab_2_subtitle_3_bps_3_price;
            state.form["tab_3_subtitle_1_bps_1_price"] = tab_3_subtitle_1_bps_1_price;
            state.form["tab_3_subtitle_3_bps_1_price"] = tab_3_subtitle_3_bps_1_price;
            state.form["tab_3_subtitle_3_bps_2_price"] = tab_3_subtitle_3_bps_2_price;
            state.form["tab_3_subtitle_3_bps_3_price"] = tab_3_subtitle_3_bps_3_price;

            for (let i = 0; i < payload?.school_overview_detail?.length; i++) {
                if (
                    payload?.school_overview_detail[i] &&
                    payload?.school_overview_detail[i]?.language_code
                ) {
                    state.form["tabs_pre_description"][
                        "tabs_pre_description" +
                            "_" +
                            payload?.school_overview_detail[i]?.language_code
                    ] = payload?.school_overview_detail[i]?.tabs_pre_description;
                    state.form["tabs_post_description"][
                        "tabs_post_description" +
                            "_" +
                            payload?.school_overview_detail[i]?.language_code
                    ] = payload?.school_overview_detail[i]?.tabs_post_description;

                    state.form["tab1_name"][
                        "tab1_name" +
                            "_" +
                            payload?.school_overview_detail[i]?.language_code
                    ] = payload?.school_overview_detail[i]?.tab1_name;


                    state.form["tab2_name"][
                        "tab2_name" +
                            "_" +
                            payload?.school_overview_detail[i]?.language_code
                    ] = payload?.school_overview_detail[i]?.tab2_name;

                    state.form["tab3_name"][
                        "tab3_name" +
                            "_" +
                            payload?.school_overview_detail[i]?.language_code
                    ] = payload?.school_overview_detail[i]?.tab3_name;


                    state.form["tab1_description"][
                        "tab1_description" +
                            "_" +
                            payload?.school_overview_detail[i]?.language_code
                    ] = payload?.school_overview_detail[i]?.tab1_description;

                    state.form["tab2_description"][
                        "tab2_description" +
                            "_" +
                            payload?.school_overview_detail[i]?.language_code
                    ] = payload?.school_overview_detail[i]?.tab2_description;

                    state.form["tab3_description"][
                        "tab3_description" +
                            "_" +
                            payload?.school_overview_detail[i]?.language_code
                    ] = payload?.school_overview_detail[i]?.tab3_description;

                    state.form["scholarship_pre_description"][
                        "scholarship_pre_description" +
                            "_" +
                            payload?.school_overview_detail[i]?.language_code
                    ] = payload?.school_overview_detail[i]?.scholarship_pre_description;

                    state.form["scholarship_post_description"][
                        "scholarship_post_description" +
                            "_" +
                            payload?.school_overview_detail[i]?.language_code
                    ] = payload?.school_overview_detail[i]?.scholarship_post_description;

                    state.form["programs_pre_description"][
                        "programs_pre_description" +
                            "_" +
                            payload?.school_overview_detail[i]?.language_code
                    ] = payload?.school_overview_detail[i]?.programs_pre_description;

                    state.form["programs_post_description"][
                        "programs_post_description" +
                            "_" +
                            payload?.school_overview_detail[i]?.language_code
                    ] = payload?.school_overview_detail[i]?.programs_post_description;

                    state.form["faq_pre_description"][
                        "faq_pre_description" +
                            "_" +
                            payload?.school_overview_detail[i]?.language_code
                    ] = payload?.school_overview_detail[i]?.faq_pre_description;



                    state.form["faq_post_description"][
                        "faq_post_description" +
                            "_" +
                            payload?.school_overview_detail[i]?.language_code
                    ] = payload?.school_overview_detail[i]?.faq_post_description;

                }
            }
            state.isFormEdit = true;
            state.showModal = true;

            // state.school_financials = payload;
        },
        setSchoolFinancials(state, payload) {
            state.school_financials = payload;
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
                video_url: "",
                school_financials_blue_bar_button_title: "",
                school_financials_blue_bar_button_link: "",
                school_financials_red_bar_button_title: "",
                school_financials_red_bar_button_link: "",
                school_financials_apply_button_link: "",
                school_financials_apply_button_title: "",
                tabs_pre_description: {},
                tabs_post_description: {},
                tab1_name: {},
                tab2_name: {},
                tab3_name: {},
                tab1_description: {},
                tab2_description: {},
                tab3_description: {},
                scholarship_pre_description: {},
                scholarship_post_description: {},
                programs_pre_description: {},
                programs_post_description: {},
                faq_pre_description: {},
                faq_post_description: {},
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
            state.form.id = payload.id;
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
                ? `${process.env.MIX_WEB_API_URL}school-financials/${state.form.id}`
                : `${process.env.MIX_WEB_API_URL}school-financials`;
            commit("setLoading");

            return new Promise(function (resolve, reject) {
                axios[method](url, state.form)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            // helper.swalSuccessMessage(res.data.message);
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
        fetchSchoolFinancials({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-financials?withSchoolFinancialDetail=1&type=${payload?.type}`;
            url = `${url}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setSchoolFinancials", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchSchoolFinancial({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-financials/${payload.id}?withSchoolFinancialDetail=1`;
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
        deleteSchoolFinancial({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}school-financials/${payload.id}`;
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

export default school_financials;
