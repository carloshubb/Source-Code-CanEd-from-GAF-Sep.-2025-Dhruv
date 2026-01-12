import ErrorHandling from "../../ErrorHandling";

const scholarship_settings = {
    namespaced: true,
    state: {
        errors: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            customer_id: "",
            video_url: "",
            top_page_video_url: "",
            scholarship_settings_apply_button_link: "",
            scholarship_settings_apply_button_title: "",
            scholarship_settings_blue_bar_button_title: "",
            scholarship_settings_blue_bar_button_link: "",
            scholarship_settings_red_bar_button_link: "",
            scholarship_settings_red_bar_button_title: "",
            scholarship_pre_description: {},
            scholarship_post_description: {},
            programs_pre_description: {},
            programs_post_description: {},
            faq_pre_description: {},
            faq_post_description: {},
        },
        languages: [],
        scholarship_settings: null,
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
        setScholarshipSetting(state, payload) {
            for (
                let i = 0;
                i < payload?.scolarship_setting_detail?.length;
                i++
            ) {
                const {
                    video_url,
                    scholarship_settings_blue_bar_button_title,
                    scholarship_settings_blue_bar_button_link,
                    scholarship_settings_red_bar_button_link,
                    scholarship_settings_red_bar_button_title,
                } = payload;
                state.form["video_url"] = video_url;
                state.form["scholarship_settings_blue_bar_button_title"] = scholarship_settings_blue_bar_button_title;
                state.form["scholarship_settings_blue_bar_button_link"] = scholarship_settings_blue_bar_button_link;
                state.form["scholarship_settings_red_bar_button_link"] = scholarship_settings_red_bar_button_link;
                state.form["scholarship_settings_red_bar_button_title"] = scholarship_settings_red_bar_button_title;
                

                if (
                    payload?.scolarship_setting_detail[i] &&
                    payload?.scolarship_setting_detail[i]?.language_code
                ) {
                    state.form["scholarship_pre_description"][
                        "scholarship_pre_description" +
                            "_" +
                            payload?.scolarship_setting_detail[i]?.language_code
                    ] = payload?.scolarship_setting_detail[i]?.scholarship_pre_description;
                    state.form["scholarship_post_description"][
                        "scholarship_post_description" +
                            "_" +
                            payload?.scolarship_setting_detail[i]?.language_code
                    ] =
                        payload?.scolarship_setting_detail[
                            i
                        ]?.scholarship_post_description;

                    state.form["programs_pre_description"][
                        "programs_pre_description" +
                            "_" +
                            payload?.scolarship_setting_detail[i]?.language_code
                    ] = payload?.scolarship_setting_detail[i]?.programs_pre_description;

                    state.form["programs_post_description"][
                        "programs_post_description" +
                            "_" +
                            payload?.scolarship_setting_detail[i]?.language_code
                    ] = payload?.scolarship_setting_detail[i]?.programs_post_description;

                    state.form["faq_pre_description"][
                        "faq_pre_description" +
                            "_" +
                            payload?.scolarship_setting_detail[i]?.language_code
                    ] = payload?.scolarship_setting_detail[i]?.faq_pre_description;

                    state.form["faq_post_description"][
                        "faq_post_description" +
                            "_" +
                            payload?.scolarship_setting_detail[i]?.language_code
                    ] = payload?.scolarship_setting_detail[i]?.faq_post_description;

                }
            }
            state.isFormEdit = true;
            state.showModal = true;

            // state.scholarship_settings = payload;
        },
        setScholarshipSettings(state, payload) {
            state.scholarship_settings = payload;
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
                video_url: "",
                title_2_image: "",
            top_page_video_url: "",

                scholarship_settings_apply_button_link: "",
                scholarship_settings_apply_button_title: "",
                scholarship_settings_blue_bar_button_title: "",
                scholarship_settings_blue_bar_button_link: "",
                scholarship_settings_red_bar_button_link: "",
                scholarship_settings_red_bar_button_title: "",
                title_4_button_link: "",
                title_4_image: "",
                scholarship_pre_description: {},
                scholarship_post_description: {},
                programs_pre_description: {},
                programs_post_description: {},
                faq_pre_description: {},
                faq_post_description: {},
                title_2_paragraph: {},
                title_2_button_title: {},
                title_2_image_name: {},
                title_3: {},
                title_3_paragraph: {},
                text_3_content: {},
                title_4: {},
                title_4_subtitle: {},
                title_4_paragraph: {},
                title_4_button_title: {},
                title_4_image_name: {},
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
                ? `${process.env.MIX_WEB_API_URL}scholarship-settings/${state.form.id}`
                : `${process.env.MIX_WEB_API_URL}scholarship-settings`;
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
        fetchScholarshipSettings({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}scholarship-settings?withScholarshipSettingDetail=1&type=${payload?.type}`;
            url = `${url}`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios
                    .get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setPagination", res.data);
                            commit("setScholarshipSettings", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchScholarshipSetting({ commit, state }, payload) {
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}scholarship-settings/${payload.id}?withScholarshipSettingDetail=1`;
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
        deleteScholarshipSetting({ commit }, payload) {
            commit("setLoading");
            let url =
                payload && payload.url
                    ? payload.url
                    : `${process.env.MIX_WEB_API_URL}scholarship-settings/${payload.id}`;
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

export default scholarship_settings;
